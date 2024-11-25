<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Date;

use ArrayPress\Rules\Base\Numeric\Unit;
use ArrayPress\Utils\Common\Extract;
use ArrayPress\Utils\I18n\TimeUnits;

abstract class Age extends Unit {

	/**
	 * Get the option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Date', 'arraypress' );
	}

	/**
	 * Get available units for the field.
	 */
	protected function get_available_units(): array {
		return TimeUnits::get_time_units( true );
	}

	/**
	 * Format the input value for comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return int
	 */
	protected function format_input_value( $value, array $args ): int {
		$components   = Extract::unit_components( (string) $value );
		$current_time = current_time( 'timestamp' );

		return strtotime( "+{$components['number']} {$components['unit']}", $current_time );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		$date = $this->get_date_value( $args );

		return strtotime( $date );
	}

	/**
	 * Get the date to compare.
	 */
	abstract protected function get_date_value( array $args ): string;

}