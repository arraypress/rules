<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart\Count;

use ArrayPress\Rules\Base\Numeric\Integer;

/**
 * Cart item count field rule class.
 */
class Quantity extends Integer {

	/**
	 * Whether to only allow whole numbers.
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = true;

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Item Count', 'arraypress' );
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
		return esc_html__( 'item count', 'arraypress' );
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_cart_quantity' );
	}

	/**
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return int
	 */
	protected function get_compare_value( array $args ): int {
		return edd_get_cart_quantity();
	}

}