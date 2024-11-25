<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Numeric;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Compare;
use ArrayPress\Utils\I18n\Operators;
use function esc_html__;

/**
 * Base class for number fields.
 */
abstract class Number extends Rule {

	/**
	 * Whether to only allow whole numbers.
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = false;

	/**
	 * Get the operators.
	 *
	 * @return array
	 */
	public function get_operators(): array {
		return Operators::get_numeric();
	}

	/**
	 * Get field args.
	 *
	 * @param array $args The field arguments.
	 *
	 * @return array
	 */
	public function get_field_args( array $args ): array {
		$args['type']             = 'number';
		$args['tooltip']          = $this->get_tooltip();
		$args['placeholder']      = $this->get_placeholder();
		$args['sanitizeCallback'] = $this->get_sanitize_callback();

		if ( $min = $this->get_min_value() ) {
			$args['min'] = $min;
		}

		if ( $max = $this->get_max_value() ) {
			$args['max'] = $max;
		}

		if ( $step = $this->get_step_value() ) {
			$args['step'] = $step;
		}

		return $args;
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return sprintf(
			esc_html__( 'Enter the %s value to check', 'arraypress' ),
			$this->get_field_name()
		);
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
	 * Get the sanitization callback.
	 *
	 * @return callable
	 */
	protected function get_sanitize_callback(): callable {
		return function ( $value ) {
			if ( $this->whole_numbers ) {
				return (int) $value;
			}

			return (float) $value;
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

		return Compare::numeric(
			$operator,
			$this->format_input_value( $value, $args ),
			$this->get_compare_value( $args )
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
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return float|int
	 */
	protected function format_input_value( $value, array $args ) {
		return $this->whole_numbers ? (int) $value : (float) $value;
	}

	/**
	 * Get the value to compare against the user input.
	 * Must be implemented by child classes to provide the system value for comparison.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return float|int
	 */
	abstract protected function get_compare_value( array $args );

	/**
	 * Get minimum value for the field.
	 *
	 * @return float|int|null
	 */
	protected function get_min_value() {
		return null;
	}

	/**
	 * Get maximum value for the field.
	 *
	 * @return float|int|null
	 */
	protected function get_max_value() {
		return null;
	}

	/**
	 * Get step value for the field.
	 * Default is 1 for whole numbers, 0.01 for decimals.
	 *
	 * @return float|int|null
	 */
	protected function get_step_value() {
		return $this->whole_numbers ? 1 : 0.01;
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	abstract protected function get_field_name(): string;


}