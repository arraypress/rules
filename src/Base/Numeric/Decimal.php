<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Numeric;

/**
 * Base class for decimal number fields.
 */
abstract class Decimal extends Number {

	/**
	 * Whether to only allow whole numbers.
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = false;

	/**
	 * Get step value for the field.
	 *
	 * @return float
	 */
	protected function get_step_value(): float {
		return 0.01;
	}

	/**
	 * Get minimum value for the field.
	 *
	 * @return float
	 */
	protected function get_min_value(): float {
		return 0.0;
	}

	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return float
	 */
	protected function format_input_value( $value, array $args ): float {
		return (float) $value;
	}

}