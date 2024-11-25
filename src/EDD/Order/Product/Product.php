<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Product;

use ArrayPress\Rules\EDD\Product\Search\Product as BaseProduct;
use ArrayPress\EDD\Orders\Order;
use function esc_html__;

/**
 * Order Product rule for checking products in an order.
 */
class Product extends BaseProduct {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Product', 'arraypress' );
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
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array
	 */
	protected function get_compare_value( array $args ): array {
		return Order::get_product_ids( $args['order_id'] ) ?: [];
	}

}