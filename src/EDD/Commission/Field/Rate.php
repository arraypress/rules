<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

use ArrayPress\Rules\Base\Numeric\Unit;
use ArrayPress\Utils\Common\Extract;
use function esc_html__;

/**
 * Class for handling commission rate type checks.
 */
class Rate extends Unit {

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Commission Rate', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Commissions', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return esc_html__( 'Enter commission rate...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Enter a rate to check against the commission rate.', 'arraypress' );
	}

	/**
	 * Get available units for the commission rate.
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
		return [ 'commission_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'eddc_get_commission' );
	}

	/**
	 * Pre-check validation before numeric comparison.
	 *
	 * @param mixed $value The user input value.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return bool|null
	 */
	protected function pre_check_validation( $value, array $args ): ?bool {
		$components = Extract::unit_components( (string) $value );
		$commission = eddc_get_commission( $args['commission_id'] );

		// If no commission found, fail the check
		if ( ! $commission ) {
			return false;
		}

		// If units don't match (percentage vs flat), fail the check
		if ( $components['unit'] !== $commission->type ) {
			return false;
		}

		return null;
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

		// At this point we know the units match, so we can just check for percentage cap
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
		$commission = eddc_get_commission( $args['commission_id'] );

		if ( ! $commission ) {
			return 0.0;
		}

		return (float) $commission->rate;
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'commission rate', 'arraypress' );
	}

}