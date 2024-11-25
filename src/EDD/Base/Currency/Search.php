<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Currency;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function edd_get_currencies;
use function html_entity_decode;
use function esc_html;
use function esc_attr;
use function strtoupper;

/**
 * Abstract base class for handling currency selection across different contexts.
 */
abstract class Search extends Options {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Currencies', 'arraypress' )
			: esc_html__( 'Currency', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'currency', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'currencies', 'arraypress' );
	}

	/**
	 * Get the available options.
	 */
	protected function get_options(): array {
		$default = [
			[
				'label' => esc_html__( 'No currencies found', 'arraypress' ),
				'value' => '',
			],
		];

		if ( ! function_exists( 'edd_get_currencies' ) ) {
			return $default;
		}

		$all_currencies = edd_get_currencies();

		if ( empty( $all_currencies ) ) {
			return $default;
		}

		$options = [];

		foreach ( $all_currencies as $key => $currency ) {
			$options[] = [
				'label' => esc_html( html_entity_decode( $currency ) ),
				'value' => esc_attr( $key ),
			];
		}

		usort( $options, static fn( $a, $b ) => strcmp( $a['label'], $b['label'] ) );

		return $options;
	}

	/**
	 * Format the user input value before comparison.
	 */
	protected function format_input_value( $value, array $args ): string {
		return strtoupper( (string) $value );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		return strtoupper( $this->get_currency( $args ) );
	}

	/**
	 * Get the currency value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The currency value
	 */
	abstract protected function get_currency( array $args ): string;

}