<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Customer;

use ArrayPress\Rules\Base\Text\Text;
use EDD_Customer;
use function esc_html__;

/**
 * Base class for customer field text comparison.
 */
abstract class Field extends Text {

	/**
	 * The field to retrieve from the customer object
	 *
	 * @var string
	 */
	protected string $field_column = 'email';

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
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_customer' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		$customer = edd_get_customer( $args['customer_id'] );
		if ( ! $customer instanceof EDD_Customer ) {
			return '';
		}

		return (string) $this->get_customer_field_value( $customer );
	}

	/**
	 * Get the specific field value from the customer.
	 * First checks for direct property, then falls back to meta field.
	 *
	 * @param EDD_Customer $customer The customer object
	 *
	 * @return mixed The field value
	 */
	protected function get_customer_field_value( EDD_Customer $customer ) {
		$column = $this->field_column;

		// First check if it's a direct property
		if ( isset( $customer->$column ) ) {
			return $customer->$column;
		}

		// Fall back to meta field
		$meta_value = $customer->get_meta( $column, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		// If neither exists, return empty string
		return '';
	}

}