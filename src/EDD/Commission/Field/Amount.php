<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

use ArrayPress\Rules\Base\Numeric\Decimal;

/**
 * Commission amount field rule class.
 */
class Amount extends Decimal {

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Commission Amount', 'arraypress' );
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
		return esc_html__( 'Enter commission amount...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Enter an amount to check against the current commission.', 'arraypress' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'commission_amount', 'arraypress' );
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
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return float|int
	 */
	protected function get_compare_value( array $args ) {
		$commission = eddc_get_commission( $args['commission_id'] );

		return $commission ? (float) $commission->amount : 0;
	}

}