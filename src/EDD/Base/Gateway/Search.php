<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Gateway;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function edd_get_payment_gateways;

/**
 * Abstract base class for handling payment gateway selection across different contexts.
 */
abstract class Search extends Options {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Payment Gateways', 'arraypress' )
			: esc_html__( 'Payment Gateway', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'payment gateway', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'payment gateways', 'arraypress' );
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
			'label' => esc_html__( 'No payment gateways found', 'arraypress' ),
			'value' => '',
		];

		if ( ! function_exists( 'edd_get_payment_gateways' ) ) {
			return [ $default ];
		}

		$all_gateways = edd_get_payment_gateways();

		if ( empty( $all_gateways ) ) {
			return [ $default ];
		}

		return array_map( function ( $key, $gateway ) {
			return [
				'label' => $gateway['admin_label'],
				'value' => $key,
			];
		}, array_keys( $all_gateways ), $all_gateways );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		return $this->get_gateway( $args );
	}

	/**
	 * Get the gateway value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The gateway value
	 */
	abstract protected function get_gateway( array $args ): string;

}