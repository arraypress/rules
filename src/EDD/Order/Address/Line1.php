<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Address;

use ArrayPress\Rules\EDD\Base\Order\Field;
use function esc_html__;

/**
 * Order Address Line 1 field.
 */
class Line1 extends Field {

	/**
	 * Whether comparisons should be case-sensitive.
	 */
	protected bool $case_sensitive = false;

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Order Address Line 1', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'address line 1', 'arraypress' );
	}

	/**
	 * Get the specific field value from the order.
	 */
	protected function get_order_field_value( $order ): string {
		$address = $order->get_address();

		return $address->address ?? '';
	}

}