<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Discount;

use ArrayPress\Rules\Base\Common\Date as BaseDate;
use function esc_html__;

/**
 * Abstract base class for discount date fields.
 */
abstract class Date extends BaseDate {

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Discount Dates', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'discount_id' ];
	}

	/**
	 * Validation check.
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_discount' );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$discount = edd_get_discount( $args['discount_id'] ?? 0 );
		if ( ! $discount ) {
			return '';
		}

		// Convert UTC date to site's timezone
		$discount_date = edd_get_edd_timezone_equivalent_date_from_utc(
			EDD()->utils->date( $this->get_discount_date( $discount ), 'utc', true )
		);

		return $discount_date->format( 'Y-m-d' );
	}

	/**
	 * Get the specific date field from the discount.
	 */
	abstract protected function get_discount_date( $discount ): string;
}