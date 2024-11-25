<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Meta;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Compare as CoreCompare;
use ArrayPress\Utils\I18n\Operators;
use function esc_html__;

/**
 * Abstract base class for meta field comparisons.
 */
abstract class Compare extends Rule {

	/**
	 * Whether this meta field handles numeric values.
	 *
	 * @var bool
	 */
	protected bool $is_numeric = false;

	/**
	 * The type of meta being checked (post, user, term, comment).
	 *
	 * @var string
	 */
	protected string $meta_type = 'post';

	/**
	 * The argument key that contains the object ID.
	 *
	 * @var string
	 */
	protected string $object_id_key = 'post_id';

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
		return $this->is_numeric
			? Operators::get_numeric()
			: Operators::get_string();
	}

	/**
	 * Get field args.
	 *
	 * @param array $args The field args.
	 *
	 * @return array
	 */
	public function get_field_args( array $args ): array {
		$args['tooltip']     = $this->get_tooltip();
		$args['placeholder'] = $this->get_placeholder();

		return $args;
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return sprintf(
			esc_html__( 'Enter %s meta_key:value...', 'arraypress' ),
			$this->meta_type
		);
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		if ( $this->is_numeric ) {
			return sprintf(
				esc_html__( 'Compare numeric %1$s meta values using meta_key:value format (e.g., price:10). Perfect for comparing quantities, prices, or any numerical data stored in %1$s meta fields. Use operators like greater than, less than to create ranges or exact matches.', 'arraypress' ),
				$this->meta_type
			);
		}

		return sprintf(
			esc_html__( 'Search %1$s meta content using meta_key:value format (e.g., color:blue). Useful for finding specific meta values, partial matches, or checking if content starts or ends with certain text. Great for filtering by custom fields, categories, or any text-based meta data.', 'arraypress' ),
			$this->meta_type
		);
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ $this->object_id_key ];
	}

	/**
	 * Check the rule.
	 *
	 * @param string $operator The operator.
	 * @param mixed  $value    The value.
	 * @param array  $args     The arguments.
	 *
	 * @return bool
	 */
	public function check( string $operator, $value, array $args ): bool {
		$meta_info = $this->parse_meta_input( $value );
		if ( $meta_info === null ) {
			return false;
		}

		$object_id    = $args[ $this->object_id_key ] ?? 0;
		$actual_value = get_metadata( $this->meta_type, $object_id, $meta_info['meta_key'], true );

		if ( $this->is_numeric ) {
			return CoreCompare::numeric(
				$operator,
				$meta_info['meta_value'],
				$actual_value
			);
		}

		return CoreCompare::string(
			$operator,
			$meta_info['meta_value'],
			(string) $actual_value,
			$this->case_sensitive,
			$this->strip_spaces
		);
	}

	/**
	 * Parse the meta input string.
	 *
	 * @param string $input The input string in format meta_key:value
	 *
	 * @return array|null Array with meta_key and meta_value, or null if invalid
	 */
	protected function parse_meta_input( string $input ): ?array {
		$parts = explode( ':', $input, 2 );
		if ( count( $parts ) !== 2 ) {
			return null;
		}

		$meta_key   = trim( $parts[0] );
		$meta_value = trim( $parts[1] );

		if ( empty( $meta_key ) ) {
			return null;
		}

		if ( $this->is_numeric && ! is_numeric( $meta_value ) ) {
			return null;
		}

		return [
			'meta_key'   => $meta_key,
			'meta_value' => $meta_value,
		];
	}

}