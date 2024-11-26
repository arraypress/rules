<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Customer\Product;

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
		return esc_html__( 'Customer Products', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'product', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'products', 'arraypress' );
	}

}