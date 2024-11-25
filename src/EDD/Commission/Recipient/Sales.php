<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Recipient;

use ArrayPress\Rules\Base\Numeric\Unit;
use ArrayPress\Utils\Common\Extract;
use ArrayPress\EDD\Common\Statuses;
use ArrayPress\EDD\Extensions\Commissions;

/**
 * Commission sales field rule class.
 */
class Sales extends Unit {

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Recipient Sales', 'arraypress' );
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
		return esc_html__( 'Enter recipient sales count...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Enter a number to check against the recipient\'s total sales count.', 'arraypress' );
	}

	/**
	 * Get available units for the sales count.
	 *
	 * @return array
	 */
	protected function get_available_units(): array {
		return Statuses::get_date_ranges( 'sales' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'sales count', 'arraypress' );
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
	 * @return int
	 */
	protected function format_input_value( $value, array $args ): int {
		$components = Extract::unit_components( (string) $value );

		return (int) $components['number'];
	}

	/**
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return int
	 */
	protected function get_compare_value( array $args ): int {
		$commission = eddc_get_commission( $args['commission_id'] );
		if ( ! $commission || empty( $commission->user_id ) ) {
			return 0;
		}

		// Extract the time period from the unit if provided
		$components = Extract::unit_components( (string) $args['value'] );
		$period     = $components['unit'] ?? 'all_time';

		// Get count for the specific user within the specified time period
		return Commissions::get_count(
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

		// Ensure we're working with whole numbers
		if ( floor( (float) $components['number'] ) !== (float) $components['number'] ) {
			return false;
		}

		return null;
	}

}