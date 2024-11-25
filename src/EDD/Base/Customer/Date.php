<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Customer;

use ArrayPress\Rules\Base\Common\Date as BaseDate;
use EDD_Customer;
use function esc_html__;

/**
 * Abstract base class for customer date fields.
 */
abstract class Date extends BaseDate {
	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Customer Dates', 'arraypress' );
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
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$customer = edd_get_customer( $args['customer_id'] ?? 0 );
		if ( ! $customer instanceof EDD_Customer ) {
			return '';
		}

		// Convert UTC date to site's timezone
		$customer_date = edd_get_edd_timezone_equivalent_date_from_utc(
			EDD()->utils->date( $this->get_customer_date( $customer ), 'utc', true )
		);

		return $customer_date->format( 'Y-m-d' );
	}

	/**
	 * Get the specific date field from the customer.
	 *
	 * @param EDD_Customer $customer The customer object
	 *
	 * @return string The date value
	 */
	abstract protected function get_customer_date( EDD_Customer $customer ): string;
}