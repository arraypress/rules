<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Recipient;

use ArrayPress\Rules\Base\Numeric\Unit;
use ArrayPress\Utils\Common\Extract;
use ArrayPress\EDD\Common\Statuses;
use ArrayPress\EDD\Extensions\Commissions;

/**
 * Commission earnings field rule class.
 */
class Earnings extends Unit {

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Recipient Earnings', 'arraypress' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Commissions', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return esc_html__( 'Enter earnings amount...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Enter an amount to check against the recipient\'s total earnings.', 'arraypress' );
	}

	/**
	 * Get available units for the earnings amount.
	 *
	 * @return array
	 */
	protected function get_available_units(): array {
		return Statuses::get_date_ranges( 'earnings' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'earnings', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'commission_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'eddc_get_commission' );
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
		$components = Extract::unit_components( (string) $value );

		return (float) $components['number'];
	}

	/**
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return float
	 */
	protected function get_compare_value( array $args ): float {
		$commission = eddc_get_commission( $args['commission_id'] );
		if ( ! $commission || empty( $commission->user_id ) ) {
			return 0.0;
		}

		// Extract the time period from the unit if provided
		$components = Extract::unit_components( (string) $args['value'] );
		$period     = $components['unit'] ?? 'all_time';

		// Get earnings for the specific user within the specified time period
		return Commissions::get_earnings(
			[
				'user_id' => $commission->user_id,
				'status'  => [ 'unpaid', 'paid' ],
			],
			$period
		);
	}

	/**
	 * Pre-check validation before numeric comparison.
	 *
	 * @param mixed $value The user input value.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return bool|null Returns true/false to short-circuit, null to continue with numeric comparison
	 */
	protected function pre_check_validation( $value, array $args ): ?bool {
		$components = Extract::unit_components( (string) $value );

		// If no unit is specified, assume all_time
		if ( empty( $components['unit'] ) ) {
			$components['unit'] = 'all_time';
		}

		// Validate that the provided time period is valid
		if ( ! in_array( $components['unit'], Commissions::get_periods(), true ) ) {
			return false;
		}

		return null;
	}

}