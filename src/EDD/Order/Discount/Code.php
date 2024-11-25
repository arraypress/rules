<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Discount;

use ArrayPress\Rules\EDD\Base\Discount\Search;
use ArrayPress\EDD\Orders\Order;
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
		return esc_html__( 'Order Discount Code', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'order_id' ];
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
	 * @return array|string
	 */
	protected function get_compare_value( array $args ) {
		$order_id = $args['order_id'] ?? 0;
		$discount_ids = Order::get_discount_ids( $order_id );

		if ( $this->multiple ) {
			return $discount_ids;
		}

		return (string) ( $discount_ids[0] ?? '' );
	}

}