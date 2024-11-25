<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Discount;

use ArrayPress\Rules\Base\Text\Text;
use EDD_Discount;
use function esc_html__;

/**
 * Base class for discount field text comparison.
 */
abstract class Field extends Text {

	/**
	 * The field to retrieve from the discount object
	 *
	 * @var string
	 */
	protected string $field_column = 'type';

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Discount', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'discount_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_discount' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		$discount = edd_get_discount( $args['discount_id'] );
		if ( ! $discount ) {
			return '';
		}

		return (string) $this->get_discount_field_value( $discount );
	}

	/**
	 * Get the specific field value from the discount.
	 * First checks for direct property, then falls back to meta field.
	 *
	 * @param EDD_Discount $discount The discount object
	 *
	 * @return mixed The field value
	 */
	protected function get_discount_field_value( EDD_Discount $discount ) {
		$column = $this->field_column;

		// First check if it's a direct property
		if ( isset( $discount->$column ) ) {
			return $discount->$column;
		}

		// Fall back to meta field
		$meta_value = $discount->get_meta( $column, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		// If neither exists, return empty string
		return '';
	}
}