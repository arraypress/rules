<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart;

use ArrayPress\Rules\Base\Numeric\Number;

/**
 * Cart total field rule class.
 */
class Total extends Number {

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Total', 'arraypress' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Cart', 'arraypress' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'cart total', 'arraypress' );
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_cart_total' );
	}

	/**
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return float
	 */
	protected function get_compare_value( array $args ): float {
		return edd_get_cart_total();
	}

	/**
	 * Get minimum value for the field.
	 *
	 * @return float
	 */
	protected function get_min_value(): float {
		return 0.0;
	}
}