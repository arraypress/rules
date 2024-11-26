<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Options;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Compare;
use ArrayPress\Utils\I18n\Operators;
use function esc_html__;

/**
 * Base class for creatable fields (keywords, tags, etc.).
 */
abstract class Creatable extends Rule {

	/**
	 * Whether the field supports multiple selection.
	 */
	protected bool $multiple = true;

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
	 * Get field args.
	 */
	public function get_field_args( array $args ): array {
		$args['type']             = 'select';
		$args['multiple']         = $this->multiple;
		$args['creatable']        = true;
		$args['tooltip']          = $this->get_tooltip();
		$args['placeholder']      = $this->get_placeholder();
		$args['sanitizeCallback'] = [ $this, 'sanitize_value' ];

		// Optional predefined options
		if ( $options = $this->get_options() ) {
			$args['options'] = $options;
		}

		return $args;
	}

	/**
	 * Get the operators.
	 */
	public function get_operators(): array {
		return Operators::get_array_multi();
	}

	/**
	 * Sanitize the field value.
	 */
	public function sanitize_value( $value ): array {
		if ( ! is_array( $value ) ) {
			$value = [ $value ];
		}

		return array_map( 'sanitize_text_field', $value );
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

		// Format input value
		$input = $this->format_input_value( $value, $args );
		if ( ! is_array( $input ) ) {
			$input = [ $input ];
		}

		// Get comparison value
		$compare = $this->get_compare_value( $args );
		if ( ! is_array( $compare ) ) {
			$compare = [ $compare ];
		}

		// Always use array_multi as it handles both single and multiple values
		return Compare::array_multi(
			$operator,
			$input,
			$compare,
			$this->case_sensitive,
			$this->strip_spaces
		);
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
	 * Must be implemented by child classes to provide the system value for comparison.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return mixed
	 */
	abstract protected function get_compare_value( array $args );

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return sprintf(
			esc_html__( 'Enter %s to search...', 'arraypress' ),
			$this->get_field_name()
		);
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return sprintf(
			esc_html__( 'Enter %s to search for in the %s. You can add custom values or select from existing options.', 'arraypress' ),
			$this->get_field_name(),
			$this->get_search_target()
		);
	}

	/**
	 * Get the name of what we're searching in (e.g. "post title", "content").
	 *
	 * @return string
	 */
	abstract protected function get_search_target(): string;

	/**
	 * Get the field name.
	 *
	 * @return string
	 */
	abstract protected function get_field_name(): string;

	/**
	 * Get predefined options for the field.
	 * Can return an empty array if no predefined options are needed.
	 */
	protected function get_options(): array {
		return [];
	}
	
}