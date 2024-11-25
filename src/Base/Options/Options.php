<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Options;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Compare;
use ArrayPress\Utils\Common\Arr;
use ArrayPress\Utils\I18n\Operators;
use function esc_html__;

/**
 * Base class for options-based fields (roles, statuses, types, etc.).
 */
abstract class Options extends Rule {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = false;

	/**
	 * Whether the field supports creatable elements.
	 *
	 * @var bool
	 */
	protected bool $creatable = false;

	/**
	 * Whether the field should be searchable.
	 *
	 * @var bool
	 */
	protected bool $searchable = true;

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
		$args['multiple']         = $this->multiple;
		$args['creatable']        = $this->creatable;
		$args['searchable']       = $this->searchable;
		$args['options']          = $this->get_options();
		$args['tooltip']          = $this->get_tooltip();
		$args['placeholder']      = $this->get_placeholder();
		$args['sanitizeCallback'] = $this->get_sanitize_callback();

		if ( $default = $this->get_default_value() ) {
			$args['default'] = $default;
		}

		return $args;
	}

	/**
	 * Get the available options.
	 *
	 * @return array Array of options in [value => label] format
	 */
	abstract protected function get_options(): array;

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return $this->multiple
			? sprintf( esc_html__( 'Select %s', 'arraypress' ), $this->get_field_name_plural() )
			: sprintf( esc_html__( 'Select %s', 'arraypress' ), $this->get_field_name_singular() );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return $this->multiple
			? sprintf( esc_html__( 'Select %s...', 'arraypress' ), $this->get_field_name_plural() )
			: sprintf( esc_html__( 'Select %s...', 'arraypress' ), $this->get_field_name_singular() );
	}

	/**
	 * Get the sanitization callback.
	 *
	 * @return callable
	 */
	protected function get_sanitize_callback(): callable {
		return function ( $value ) {
			if ( $this->multiple ) {
				return array_map( 'sanitize_text_field', (array) $value );
			}

			return sanitize_text_field( $value );
		};
	}

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
	 * @return mixed
	 */
	abstract protected function get_compare_value( array $args );

	/**
	 * Get default value for the field.
	 *
	 * @return string|array|null
	 */
	protected function get_default_value() {
		return null;
	}

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

}