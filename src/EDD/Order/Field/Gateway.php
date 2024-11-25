<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Field;

use ArrayPress\Rules\EDD\Base\Gateway\Search;
use function esc_html__;

/**
 * Order Payment Gateway rule.
 */
class Gateway extends Search {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Order Payment Gateway', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the required arguments.
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
	 * Get the gateway value for comparison.
	 */
	protected function get_gateway( array $args ): string {
		$order = edd_get_order( $args['order_id'] ?? 0 );

		return $order ? $order->gateway : '';
	}

}