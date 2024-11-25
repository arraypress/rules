<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Order;

use ArrayPress\Rules\Base\Numeric\Number;
use function esc_html__;

/**
 * Base class for order amount numeric comparison.
 */
abstract class Amount extends Number {

	/**
	 * The column to use for average earnings calculation and order value retrieval.
	 *
	 * @var string
	 */
	protected string $amount_column = 'total';

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
	 * Validation check.
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_order' );
	}

	/**
	 * Get tooltip text with average earnings.
	 */
	public function get_tooltip(): string {
		$average = $this->get_average_earnings();

		return sprintf(
			esc_html__( 'Enter the %1$s value to check (Store average: %2$s)', 'arraypress' ),
			$this->get_field_name(),
			edd_currency_filter( edd_format_amount( $average ) )
		);
	}

	/**
	 * Get minimum value for the field.
	 */
	protected function get_min_value(): float {
		return 0;
	}

	/**
	 * Get step value for the field.
	 */
	protected function get_step_value(): float {
		return 0.01;
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		$order = edd_get_order( $args['order_id'] );
		if ( ! $order ) {
			return 0;
		}

		return (float) $this->get_order_amount_value( $order );
	}

	/**
	 * Get the specific amount value from the order.
	 */
	protected function get_order_amount_value( $order ) {
		$column = $this->amount_column;

		return $order->$column;
	}

	/**
	 * Get the average earnings from complete orders.
	 */
	protected function get_average_earnings(): float {
		global $wpdb;

		$statuses     = edd_get_complete_order_statuses();
		$placeholders = implode( ',', array_fill( 0, count( $statuses ), '%s' ) );

		$cache_key = 'edd_avg_' . $this->amount_column;
		$average   = wp_cache_get( $cache_key, 'edd_stats' );

		if ( false === $average ) {
			$query = $wpdb->prepare(
				"SELECT AVG({$this->amount_column}) as average
                FROM {$wpdb->prefix}edd_orders
                WHERE type = %s AND status IN ({$placeholders})",
				array_merge( [ 'sale' ], $statuses )
			);

			$average = $wpdb->get_var( $query );
			wp_cache_set( $cache_key, $average, 'edd_stats', HOUR_IN_SECONDS );
		}

		return (float) $average ?: 0.0;
	}

}