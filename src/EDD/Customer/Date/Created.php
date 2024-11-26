<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Customer\Date;

use ArrayPress\Rules\EDD\Base\Customer\Date as BaseDate;
use EDD_Customer;
use function esc_html__;

/**
 * Rule for checking EDD customer creation date.
 */
class Created extends BaseDate {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Customer Date Created', 'arraypress' );
	}

	/**
	 * Get the field name for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'customer date created', 'arraypress' );
	}

	/**
	 * Get the customer's creation date.
	 *
	 * @param EDD_Customer $customer The customer object
	 *
	 * @return string The date value
	 */
	protected function get_customer_date( EDD_Customer $customer ): string {
		return $customer->date_created;
	}

}