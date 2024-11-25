<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

use ArrayPress\Rules\EDD\Base\Currency\Search;

/**
 * Commission currency search rule.
 */
class Currency extends Search {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = false;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Commission Currency', 'arraypress' );
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
		return esc_html__( 'Search currencies...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Select a currency to check against the current commission.', 'arraypress' );
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
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'commission_id' ];
	}

	/**
	 * Get the currency value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The currency value
	 */
	protected function get_currency( array $args ): string {
		$commission = eddc_get_commission( $args['commission_id'] );

		return $commission ? $commission->currency : '';
	}

}