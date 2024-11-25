<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Order;

use ArrayPress\Rules\Base\Text\Text;
use EDD\Orders\Order;
use function esc_html__;

/**
 * Base class for order field text comparison.
 */
abstract class Field extends Text {

	/**
	 * The field to retrieve from the order object
	 *
	 * @var string
	 */
	protected string $field_column = 'status';

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'order_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_order' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		$order = edd_get_order( $args['order_id'] );
		if ( ! $order ) {
			return '';
		}

		return (string) $this->get_order_field_value( $order );
	}

	/**
	 * Get the specific field value from the order.
	 * First checks for direct property, then falls back to meta field.
	 *
	 * @param Order $order The order object
	 *
	 * @return mixed The field value
	 */
	protected function get_order_field_value( Order $order ) {
		$column = $this->field_column;

		// First check if it's a direct property
		if ( isset( $order->$column ) ) {
			return $order->$column;
		}

		// Fall back to meta field
		$meta_value = edd_get_order_meta( $order->id, $column, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		// If neither exists, return empty string
		return '';
	}

}