<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Discount\Field;

use ArrayPress\Rules\Base\Numeric\Unit;
use ArrayPress\Utils\Common\Extract;
use function edd_get_discount;
use function esc_html__;

/**
 * Class for handling discount amount type checks.
 */
class Rate extends Unit {

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Discount Rate', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Discount', 'arraypress' );
	}

	/**
	 * Get available units for the discount amount.
	 *
	 * @return array{array{label: string, value: string}}
	 */
	protected function get_available_units(): array {
		return [
			[
				'label' => esc_html__( 'Percentage', 'arraypress' ),
				'value' => 'percentage'
			],
			[
				'label' => esc_html__( 'Flat', 'arraypress' ),
				'value' => 'flat'
			]
		];
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'discount_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_get_discount' );
	}

	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return float
	 */
	protected function format_input_value( $value, array $args ): float {
		$components = Extract::unit_components( (string) $value );

		if ( $components['unit'] === 'percentage' && $components['number'] > 100 ) {
			return 100.0;
		}

		return $components['number'];
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return float
	 */
	protected function get_compare_value( array $args ): float {
		$discount = edd_get_discount( $args['discount_id'] );

		if ( ! $discount ) {
			return 0.0;
		}

		return (float) $discount->amount;
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'discount rate', 'arraypress' );
	}

}