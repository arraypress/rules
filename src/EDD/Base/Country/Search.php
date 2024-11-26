<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Country;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function edd_get_country_list;
use function html_entity_decode;
use function esc_html;
use function esc_attr;
use function strtoupper;

/**
 * Abstract base class for handling country selection across different contexts.
 */
abstract class Search extends Options {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Countries', 'arraypress' )
			: esc_html__( 'Country', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'country', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'countries', 'arraypress' );
	}

	/**
	 * Get the available options.
	 */
	protected function get_options(): array {
		$default = [
			[
				'label' => esc_html__( 'No countries found', 'arraypress' ),
				'value' => '',
			],
		];

		if ( ! function_exists( 'edd_get_country_list' ) ) {
			return $default;
		}

		$all_countries = edd_get_country_list();

		if ( empty( $all_countries ) ) {
			return $default;
		}

		$options = [];

		foreach ( $all_countries as $key => $label ) {
			$options[] = [
				'label' => esc_html( html_entity_decode( $label ) ),
				'value' => esc_attr( $key ),
			];
		}

		usort( $options, static fn( $a, $b ) => strcmp( $a['label'], $b['label'] ) );

		return $options;
	}

	/**
	 * Format the user input value before comparison.
	 */
	protected function format_input_value( $value, array $args ) {
		if ( is_array( $value ) ) {
			return array_map( 'strtoupper', $value );
		}

		return strtoupper( (string) $value );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		return strtoupper( $this->get_country( $args ) );
	}

	/**
	 * Get the country value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The country value
	 */
	abstract protected function get_country( array $args ): string;

}