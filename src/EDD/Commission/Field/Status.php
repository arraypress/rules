<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function edd_get_payment_statuses;

/**
 * Abstract base class for handling status selection across different contexts.
 */
class Status extends Options {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Commission Statuses', 'arraypress' )
			: esc_html__( 'Commission Status', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Commissions', 'arraypress' );
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
		return [
			[
				'label' => esc_html__( 'Unpaid', 'eddc' ),
				'value' => 'unpaid',
			],
			[
				'label' => esc_html__( 'Paid', 'eddc' ),
				'value' => 'paid',
			],
			[
				'label' => esc_html__( 'Revoked', 'eddc' ),
				'value' => 'revoked',
			],
		];
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
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$commission = eddc_get_commission( $args['commission_id'] );

		return $commission ? $commission->status : '';
	}

}