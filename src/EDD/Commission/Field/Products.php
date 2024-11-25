<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

use function esc_html__;

/**
 * Order Products rule for checking multiple products in an order.
 */
class Products extends Product {

	/**
	 * Whether the field supports multiple selection.
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
		return esc_html__( 'Commission Products', 'arraypress' );
	}

}