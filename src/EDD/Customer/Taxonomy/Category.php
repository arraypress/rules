<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Customer\Taxonomy;

use ArrayPress\Rules\EDD\Product\Taxonomy\Category as BaseCategory;
use ArrayPress\EDD\Customers\Customer;
use function esc_html__;

/**
 * Order Categories rule for checking categories in an order.
 */
class Category extends BaseCategory {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Customer Category', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Customer', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'customer_id' ];
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array
	 */
	protected function get_compare_value( array $args ): array {
		return Customer::get_term_ids( $args['customer_id'] ) ?: [];
	}

}