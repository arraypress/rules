<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart\Discount;

use ArrayPress\EDD\Cart\Cart;
use ArrayPress\Rules\EDD\Base\Discount\Search;
use function esc_html__;

/**
 * Order Discount rule for checking discounts used in orders.
 */
class Code extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Discount Code', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Cart', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [];
	}

	/**
	 * Validation check.
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_order' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array
	 */
	protected function get_compare_value( array $args ): array {
		return Cart::get_discount_ids();
	}

}