<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Address;

/**
 * Multiple regions selection support.
 */
class Regions extends Region {

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
		return esc_html__( 'Order Address Regions', 'arraypress' );
	}

}