<?php

namespace ArrayPress\Rules\EDD\Cart\Discount;

/**
 * Multiple discount selection support.
 */
class Codes extends Code {

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
		return esc_html__( 'Cart Discount Codes', 'arraypress' );
	}

}