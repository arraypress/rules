<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Field;

/**
 * Order Payment Gateways rule.
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
		return esc_html__( 'Order Payment Gateways', 'arraypress' );
	}


}