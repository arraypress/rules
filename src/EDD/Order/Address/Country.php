<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Address;

use ArrayPress\Rules\EDD\Base\Country\Search;
use function esc_html__;

/**
 * Class for country selection in order addresses.
 */
class Country extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Address Country', 'arraypress' );
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
	 * Get the country value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The country value
	 */
	protected function get_country( array $args ): string {
		$order = edd_get_order( $args['order_id'] );
		if ( ! $order ) {
			return '';
		}

		$address = $order->get_address();

		return $address->country ?? '';
	}

}