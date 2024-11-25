<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Field;

use ArrayPress\Rules\EDD\Base\Order\Status as StatusBase;
use function esc_html__;

/**
 * Order Status rule.
 */
class Status extends StatusBase {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Order Status', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'order_id' ];
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'order status', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'order statuses', 'arraypress' );
	}

	/**
	 * Get the status value for comparison.
	 */
	protected function get_status( array $args ): string {
		$order = edd_get_order( $args['order_id'] ?? 0 );

		return $order ? $order->status : '';
	}

}