<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart;

class Products extends Product {

	/**
	 * Whether the rule supports multiple product selection.
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Contains Products', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [];
	}

}