<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Customer\Field;

use ArrayPress\Rules\Base\Numeric\Number;
use ArrayPress\EDD\Customers\Customer;
use function esc_html__;

/**
 * Rule for checking EDD customer spending amount.
 */
class PurchaseTotal extends Number {

	/**
	 * Whether to only allow whole numbers
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = false;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Customer Purchase Total', 'arraypress' );
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
	 * Get the field name for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'amount spent', 'arraypress' );
	}

	/**
	 * Get the value to compare against (customer's total spent).
	 *
	 * @param array $args The arguments containing customer_id.
	 *
	 * @return float
	 */
	protected function get_compare_value( array $args ): float {
		$customer_id = $args['customer_id'] ?? 0;
		$spent       = Customer::get_purchase_value( $customer_id );

		return (float) ( $spent ?? 0 );
	}

	/**
	 * Get minimum value for the field.
	 *
	 * @return float
	 */
	protected function get_min_value(): float {
		return 0;
	}
}

