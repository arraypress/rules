<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Checkout\Address;

/**
 * Rule for validating multiple cart countries during checkout.
 */
class Regions extends Country {

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
		return esc_html__( 'Checkout Address Regions', 'arraypress' );
	}

}