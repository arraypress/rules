<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Text;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Compare;
use ArrayPress\Utils\I18n\Operators;
use function esc_html__;

/**
 * Base class for text field rules.
 */
abstract class Text extends Rule {

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
		return Operators::get_string();
	}

	/**
	 * Get field args.
	 *
	 * @param array $args The field arguments.
	 *
	 * @return array
	 */
	public function get_field_args( array $args ): array {
		$args['type']             = 'text';
		$args['tooltip']          = $this->get_tooltip();
		$args['placeholder']      = $this->get_placeholder();
		$args['sanitizeCallback'] = $this->get_sanitize_callback();

		return $args;
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return sprintf(
			esc_html__( 'Enter %s...', 'arraypress' ),
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
			esc_html__( 'Enter the %s you want to check', 'arraypress' ),
			$this->get_field_name()
		);
	}

	/**
	 * Get the sanitization callback.
	 *
	 * @return callable
	 */
	protected function get_sanitize_callback(): callable {
		return 'sanitize_text_field';
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

		return Compare::string(
			$operator,
			(string) $this->format_input_value( $value, $args ),
			(string) $this->get_compare_value( $args ),
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
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	abstract protected function get_field_name(): string;

}