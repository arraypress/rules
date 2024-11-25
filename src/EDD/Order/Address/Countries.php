<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Address;

/**
 * Multiple country selection support.
 */
class Countries extends Country {

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
		return esc_html__( 'Order Address Countries', 'arraypress' );
	}

}