<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Order;

use ArrayPress\Rules\Base\Common\Date as BaseDate;
use function esc_html__;

/**
 * Abstract base class for order date fields.
 */
abstract class Date extends BaseDate {

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'order_id' ];
	}

	/**
	 * Validation check.
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_order' );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$order = edd_get_order( $args['order_id'] );
		if ( ! $order ) {
			return '';
		}

		// Convert UTC date to site's timezone
		$order_date = edd_get_edd_timezone_equivalent_date_from_utc(
			EDD()->utils->date( $this->get_order_date( $order ), 'utc', true )
		);

		return $order_date->format( 'Y-m-d' );
	}

	/**
	 * Get the specific date field from the order.
	 */
	abstract protected function get_order_date( $order ): string;

}