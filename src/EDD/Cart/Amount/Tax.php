<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart\Amount;

use ArrayPress\Rules\Base\Numeric\Decimal;

/**
 * Cart tax field rule class.
 */
class Tax extends Decimal {

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Tax', 'arraypress' );
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
		return esc_html__( 'cart tax', 'arraypress' );
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_cart_tax' );
	}

	/**
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return float
	 */
	protected function get_compare_value( array $args ): float {
		return edd_get_cart_tax();
	}

}
