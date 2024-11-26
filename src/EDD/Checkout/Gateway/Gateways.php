<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Checkout\Gateway;

/**
 * Rule for validating multiple cart countries during checkout.
 */
class Gateways extends Gateway {

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
		return esc_html__( 'Checkout Gateways', 'arraypress' );
	}

}