<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Options;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Arr;
use ArrayPress\Utils\Common\Compare;
use ArrayPress\Utils\I18n\Operators;
use ArrayPress\Rules\Traits\Sanitize;
use Blockify\Hooks\Hookable;
use Blockify\Hooks\HookAnnotations;
use WP_REST_Request;
use WP_REST_Server;
use function current_user_can;
use function esc_html__;
use function register_rest_route;

/**
 * Base class for searchable fields.
 */
abstract class Searchable extends Rule implements Hookable {
	use HookAnnotations;
	use Sanitize;

	/**
	 * The namespace for the REST API routes.
	 *
	 * @var string
	 */
	protected const ROUTE_NAMESPACE = 'arraypress/v1';

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = false;

	/**
	 * Whether the field supports creatable.
	 *
	 * @var bool
	 */
	protected bool $creatable = false;

	/**
	 * Whether to allow resetting the field.
	 *
	 * @var bool
	 */
	protected bool $allow_reset = true;

	/**
	 * Whether comparisons should be case-sensitive.
	 *
	 * @var bool
	 */
	protected bool $case_sensitive = false;

	/**
	 * Whether to remove all whitespace before comparison.
	 *
	 * @var bool
	 */
	protected bool $strip_spaces = false;

	/**
	 * Get the operators.
	 *
	 * @return array
	 */
	public function get_operators(): array {
		return $this->multiple
			? Operators::get_array_multi()
			: Operators::get_array();
	}

	/**
	 * Get field args.
	 *
	 * @param array $args The field arguments.
	 *
	 * @return array
	 */
	public function get_field_args( array $args ): array {
		$args['type']             = 'select';
		$args['dynamicSearch']    = true;
		$args['multiple']         = $this->multiple;
		$args['creatable']        = $this->creatable;
		$args['allowReset']       = $this->allow_reset;
		$args['placeholder']      = $this->get_placeholder();
		$args['tooltip']          = $this->get_tooltip();
		$args['endpoint']         = $this->get_endpoint();
		$args['sanitizeCallback'] = $this->get_sanitize_callback();

		return $args;
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return $this->multiple
			? sprintf( esc_html__( 'Search %s...', 'arraypress' ), $this->get_field_name_plural() )
			: sprintf( esc_html__( 'Search %s...', 'arraypress' ), $this->get_field_name_singular() );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return $this->multiple
			? sprintf( esc_html__( 'Select %s to check', 'arraypress' ), $this->get_field_name_plural() )
			: sprintf( esc_html__( 'Select %s to check', 'arraypress' ), $this->get_field_name_singular() );
	}

	/**
	 * Get the endpoint for dynamic search.
	 *
	 * @return string
	 */
	protected function get_endpoint(): string {
		return self::ROUTE_NAMESPACE . '/' . $this->get_route();
	}

	/**
	 * Get the sanitization callback.
	 *
	 * @return callable
	 */
	protected function get_sanitize_callback(): callable {
		return function ( $value ) {
			if ( is_array( $value ) ) {
				return array_map( [ $this, 'get_sanitize_callback' ], $value );
			}

			return sanitize_text_field( $value );
		};
	}

	/**
	 * Registers rest endpoint.
	 *
	 * @hook  rest_api_init
	 * @return void
	 */
	public function register_endpoint(): void {
		register_rest_route( self::ROUTE_NAMESPACE, '/' . $this->get_route(), [
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => fn() => current_user_can( $this->get_capability() ),
			'callback'            => [ $this, 'search_items' ],
			'args'                => [
				'search' => [
					'type'              => 'string',
					'required'          => false,
					'description'       => $this->get_search_description(),
					'sanitize_callback' => [ $this, 'sanitize_search' ],
				],
			],
		] );
	}

	/**
	 * Search items based on the request.
	 *
	 * @param WP_REST_Request $request The request object.
	 *
	 * @return array
	 */
	public function search_items( WP_REST_Request $request ): array {
		$search = $request->get_param( 'search' );

		if ( empty( $search ) ) {
			return [];
		}

		return $this->perform_search( $search );
	}

	/**
	 * Perform the search.
	 *
	 * @param string $search The search term.
	 *
	 * @return array
	 */
	protected function perform_search( string $search ): array {
		$args = $this->get_base_search_args( $search );
		$args = $this->modify_search_args( $args );

		return $this->execute_search( $args );
	}

	/**
	 * Get the base search arguments.
	 *
	 * @param string $search The search term
	 *
	 * @return array The base search arguments
	 */
	protected function get_base_search_args( string $search ): array {
		return [];
	}

	/**
	 * Modify the search arguments.
	 *
	 * @param array $args The default search arguments
	 *
	 * @return array The modified search arguments
	 */
	protected function modify_search_args( array $args ): array {
		return $args;
	}

	/**
	 * Execute the search with the given arguments.
	 *
	 * @param array $args The search arguments
	 *
	 * @return array The search results
	 */
	abstract protected function execute_search( array $args ): array;

	/**
	 * Check the rule.
	 *
	 * @param string $operator The operator.
	 * @param mixed  $value    The user input value.
	 * @param array  $args     The arguments.
	 *
	 * @return bool
	 */
	public function check( string $operator, $value, array $args ): bool {
		$pre_check = $this->pre_check_validation( $value, $args );
		if ( $pre_check !== null ) {
			return $pre_check;
		}

		$items = $this->get_compare_value( $args );
		$input = $this->format_input_value( $value, $args );

		// Use array_multi if both sides can have multiple values
		if ( $this->multiple ) {
			return Compare::array_multi( $operator, $input, $items, $this->case_sensitive, $this->strip_spaces );
		}

		// Default to regular array comparison
		return Compare::array( $operator, $input, $items, $this->case_sensitive, $this->strip_spaces );
	}

	/**
	 * Pre-check validation before numeric comparison.
	 * Can be used to validate units match or other conditions before comparison.
	 *
	 * @param mixed $value The user input value.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return bool|null Returns true/false to short-circuit, null to continue with numeric comparison
	 */
	protected function pre_check_validation( $value, array $args ): ?bool {
		return null;
	}

	/**
	 * Format the user input value before comparison.
	 * Can be overridden by child classes to modify how user input is formatted.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return mixed
	 */
	protected function format_input_value( $value, array $args ) {
		return $value;
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array|string
	 */
	abstract protected function get_compare_value( array $args );

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	abstract protected function get_field_name_singular(): string;

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	abstract protected function get_field_name_plural(): string;

	/**
	 * Get the route for the endpoint.
	 *
	 * @return string
	 */
	abstract protected function get_route(): string;

	/**
	 * Get the capability required for the endpoint.
	 *
	 * @return string
	 */
	abstract protected function get_capability(): string;

	/**
	 * Get the search description.
	 *
	 * @return string
	 */
	abstract protected function get_search_description(): string;


}