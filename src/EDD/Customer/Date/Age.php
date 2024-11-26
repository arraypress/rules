<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Customer\Date;

use ArrayPress\Rules\Base\Date\Age as BaseAge;
use function esc_html__;

/**
 * Rule for checking EDD customer age (time since registration).
 */
class Age extends BaseAge {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Customer Age', 'arraypress' );
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
		return esc_html__( 'customer age', 'arraypress' );
	}

	/**
	 * Get the date to compare against (customer registration date).
	 *
	 * @param array $args The arguments containing customer_id.
	 *
	 * @return string
	 */
	protected function get_date_value( array $args ): string {
		$customer = edd_get_customer( $args['customer_id'] );

		if ( ! $customer ) {
			return current_time( 'mysql' );
		}

		// Return the customer's registration date
		return $customer->date_created;
	}

}