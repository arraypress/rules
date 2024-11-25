<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Customer;

use ArrayPress\Rules\Base\Numeric\Number;
use EDD_Customer;
use function esc_html__;

/**
 * Base class for customer amount numeric comparison.
 */
abstract class Amount extends Number {

	/**
	 * The column to use for customer value retrieval.
	 *
	 * @var string
	 */
	protected string $amount_column = 'purchase_value';

	/**
	 * Whether to only allow whole numbers
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = false;

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Customer', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'customer_id' ];
	}

	/**
	 * Validation check.
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_customer' );
	}

	/**
	 * Get the tooltip text.
	 */
	public function get_tooltip(): string {
		return sprintf(
			esc_html__( 'Enter the %s value to check', 'arraypress' ),
			$this->get_field_name()
		);
	}

	/**
	 * Get minimum value for the field.
	 */
	protected function get_min_value(): float {
		return 0;
	}

	/**
	 * Get step value for the field.
	 */
	protected function get_step_value(): float {
		return 0.01;
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		$customer = edd_get_customer( $args['customer_id'] );
		if ( ! $customer instanceof EDD_Customer ) {
			return 0;
		}

		return (float) $this->get_customer_amount_value( $customer );
	}

	/**
	 * Get the specific amount value from the customer.
	 * First checks for direct property, then falls back to meta field.
	 *
	 * @param EDD_Customer $customer The customer object
	 *
	 * @return mixed The amount value
	 */
	protected function get_customer_amount_value( EDD_Customer $customer ) {
		$column = $this->amount_column;

		// First check if it's a direct property
		if ( isset( $customer->$column ) ) {
			return $customer->$column;
		}

		// Fall back to meta field
		$meta_value = edd_get_customer_meta( $customer->id, $column, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		// If neither exists, return 0
		return 0;
	}

}