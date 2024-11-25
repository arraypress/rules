<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Date;

use ArrayPress\Rules\EDD\Base\Order\Date;
use function esc_html__;

/**
 * Order Date Refundable.
 */
class Refundable extends Date {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Order Date Refundable', 'arraypress' );
	}

	/**
	 * Get the field name for placeholders/tooltips.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'order date refunded', 'arraypress' );
	}

	/**
	 * Get the specific date field from the order.
	 */
	protected function get_order_date( $order ): string {
		return $order->date_refunded;
	}

}
