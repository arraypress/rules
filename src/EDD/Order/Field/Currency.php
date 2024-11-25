<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Field;

use ArrayPress\Rules\EDD\Base\Currency\Search;
use function esc_html__;

/**
 * Field for handling currency selection in order context.
 */
class Currency extends Search {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Order Currency', 'arraypress' );
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
	 * Get the currency value for comparison.
	 */
	protected function get_currency( array $args ): string {
		$order = edd_get_order( $args['order_id'] ?? 0 );

		return $order ? $order->currency : '';
	}

}