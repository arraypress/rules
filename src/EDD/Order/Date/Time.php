<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Date;

use ArrayPress\Rules\Base\Common\Time as BaseTime;
use function esc_html__;
use function function_exists;

/**
 * Order Time rule.
 */
class Time extends BaseTime {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Time', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the required arguments for the rule.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'order_id' ];
	}

	/**
	 * Validation check.
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_order' );
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'order', 'arraypress' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string Time string in H:i format
	 */
	protected function get_compare_value( array $args ): string {
		$order = edd_get_order( $args['order_id'] );

		return $order ? date( 'H:i', strtotime( $order->date_created ) ) : '';
	}

	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function format_input_value( $value, array $args ): string {
		return date( 'H:i', strtotime( $value ) );
	}

}