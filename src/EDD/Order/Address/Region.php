<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Address;

use ArrayPress\Rules\EDD\Base\Region\Search;
use function esc_html__;

/**
 * Field for handling state/province selection in order addresses.
 */
class Region extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Address Region', 'arraypress' );
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
	 *
	 * @param array $args
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_order' );
	}

	/**
	 * Get the region value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string
	 */
	protected function get_region( array $args ): string {
		$order = edd_get_order( $args['order_id'] ?? 0 );
		if ( ! $order ) {
			return '';
		}

		$address = $order->get_address();

		return $address->region ?? '';
	}
}