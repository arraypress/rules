<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

use ArrayPress\Rules\EDD\Product\Search\Product as BaseProduct;
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
		return esc_html__( 'Commission Product', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Commissions', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'commission_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'eddc_get_commission' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		$commission = eddc_get_commission( $args['commission_id'] );

		if ( ! $commission || empty( $commission->product_id ) ) {
			return '';
		}

		$product_id = (string) $commission->product_id;

		// Only append price_id if it's not null/empty
		if ( ! empty( $commission->price_id ) || $commission->price_id === 0 ) {
			$product_id .= '_' . $commission->price_id;
		}

		return $product_id;
	}

}