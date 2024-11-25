<?php

namespace ArrayPress\Rules\EDD\Order\Customer;

/**
 * Multiple discount selection support.
 */
class Customers extends Customer {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Customers', 'arraypress' );
	}

}