<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Date;

use ArrayPress\Rules\Base\Date\Date;

/**
 * Commission date field rule class.
 */
class Paid extends Date {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Commission Date Paid', 'arraypress' );
	}

	/**
	 * Get the rule option group.
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
		return current_time( 'Y-m-d' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Select a date to check against the commission creation date.', 'arraypress' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'creation date', 'arraypress' );
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
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string Date string
	 */
	protected function get_compare_value( array $args ): string {
		$commission = eddc_get_commission( $args['commission_id'] );

		return $commission ? date( 'Y-m-d', strtotime( $commission->date_paid ) ) : '';
	}

}