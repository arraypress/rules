<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Checkout;

use ArrayPress\Rules\Base\Text\Text;
use function esc_html__;

/**
 * Base class for checkout field text comparison.
 */
abstract class Field extends Text {

	/**
	 * The field key to retrieve from the posted checkout data
	 *
	 * @var string
	 */
	protected string $field_key = 'edd_email';

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Checkout', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'posted' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_is_checkout' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		if ( empty( $args['posted'] ) ) {
			return '';
		}

		return (string) $this->get_checkout_field_value( $args['posted'] );
	}

	/**
	 * Get the specific field value from the checkout data.
	 *
	 * @param array $posted The posted checkout data
	 *
	 * @return mixed The field value
	 */
	protected function get_checkout_field_value( array $posted ) {
		$field_key = $this->field_key;

		// Check if the field exists in posted data
		if ( isset( $posted[ $field_key ] ) ) {
			return $posted[ $field_key ];
		}

		// If field doesn't exist, return empty string
		return '';
	}

}