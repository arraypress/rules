<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Numeric;

/**
 * Base class for integer number fields.
 */
abstract class Integer extends Number {

	/**
	 * Whether to only allow whole numbers.
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = true;

	/**
	 * Get step value for the field.
	 *
	 * @return float
	 */
	protected function get_step_value(): float {
		return 1.0;
	}

	/**
	 * Get minimum value for the field.
	 *
	 * @return int
	 */
	protected function get_min_value(): int {
		return 0;
	}

	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return int
	 */
	protected function format_input_value( $value, array $args ): int {
		return (int) $value;
	}

}