<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart;

/**
 * The Download Categories rule.
 */
class Categories extends Category {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Categories', 'arraypress' );
	}

}


namespace ArrayPress\Rules;

/**
 * The Download Categories rule.
 */
class EDD_Order_Categories extends Categories {}