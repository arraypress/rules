<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Order;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function edd_get_payment_statuses;

/**
 * Abstract base class for handling status selection across different contexts.
 */
abstract class Status extends Options {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Order Statuses', 'arraypress' )
			: esc_html__( 'Order Status', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Order', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'status', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'statuses', 'arraypress' );
	}

	/**
	 * Get default value for the field.
	 */
	protected function get_default_value(): ?string {
		return '';
	}

	/**
	 * Get the available options.
	 */
	protected function get_options(): array {
		$default = [
			[
				'label' => esc_html__( 'No statuses found', 'arraypress' ),
				'value' => '',
			],
		];

		if ( ! function_exists( 'edd_get_payment_statuses' ) ) {
			return $default;
		}

		$statuses = edd_get_payment_statuses();

		if ( empty( $statuses ) ) {
			return $default;
		}

		$options = [];

		foreach ( $statuses as $key => $label ) {
			$options[] = [
				'label' => $label,
				'value' => $key,
			];
		}

		return $options;
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		return $this->get_status( $args );
	}

	/**
	 * Get the status value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The status value
	 */
	abstract protected function get_status( array $args ): string;

}