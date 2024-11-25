<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Region;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function edd_get_country_list;
use function edd_get_shop_states;
use function html_entity_decode;
use function esc_html;
use function esc_attr;
use function strtoupper;

/**
 * Abstract base class for handling region/state selection across different contexts.
 */
abstract class Search extends Options {

	/**
	 * Whether the field should be searchable.
	 *
	 * @var bool
	 */
	protected bool $searchable = true;

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'region', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'regions', 'arraypress' );
	}

	/**
	 * Get the available options.
	 *
	 * @return array Array of options in hierarchical format with countries and their regions
	 */
	protected function get_options(): array {
		$default = [
			[
				'label' => esc_html__( 'No regions found', 'arraypress' ),
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

		foreach ( $all_countries as $country_code => $country_name ) {
			if ( empty( $country_code ) || empty( $country_name ) ) {
				continue;
			}

			$states = edd_get_shop_states( $country_code );

			if ( ! empty( $states ) ) {
				$country_options = [
					'label'   => esc_html( html_entity_decode( $country_name ) ),
					'options' => [],
				];

				foreach ( $states as $state_code => $state_name ) {
					if ( empty( $state_code ) || empty( $state_name ) ) {
						continue;
					}

					$country_options['options'][] = [
						'label' => esc_html( html_entity_decode( $state_name ) ),
						'value' => esc_attr( $state_code ),
					];
				}

				// Only add countries with states
				if ( ! empty( $country_options['options'] ) ) {
					$options[] = $country_options;
				}
			}
		}

		// Sort countries and states alphabetically
		usort( $options, static fn( $a, $b ) => strcmp( $a['label'], $b['label'] ) );
		foreach ( $options as &$country ) {
			usort( $country['options'], static fn( $a, $b ) => strcmp( $a['label'], $b['label'] ) );
		}

		return $options;
	}

	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return mixed
	 */
	protected function format_input_value( $value, array $args ) {
		if ( is_array( $value ) ) {
			return array_map( 'strtoupper', $value );
		}

		return strtoupper( (string) $value );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		return strtoupper( $this->get_region( $args ) );
	}

	/**
	 * Get the region value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The region value
	 */
	abstract protected function get_region( array $args ): string;

}