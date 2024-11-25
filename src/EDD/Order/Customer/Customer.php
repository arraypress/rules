<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Customer;

use ArrayPress\Rules\EDD\Base\Customer\Search;
use function esc_html__;

/**
 * Order Customer rule for checking the customer of an order.
 */
class Customer extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Customer', 'arraypress' );
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
	 * Get the required arguments for the rule.
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
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		$order = edd_get_order( $args['order_id'] );

		return $order ? (string) $order->customer_id : '';
	}

}