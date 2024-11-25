<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Recipient;

use ArrayPress\Rules\Base\Date\Age as BaseAge;
use function esc_html__;

/**
 * The Recipient Age rule.
 */
class Age extends BaseAge {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Recipient Age', 'arraypress' );
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
	 * Get the field name.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'recipient age', 'arraypress' );
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
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Enter the age to check against the recipient\'s registration date.', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return esc_html__( 'Enter recipient age...', 'arraypress' );
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
	 * Get the date to compare.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_date_value( array $args ): string {
		$commission = eddc_get_commission( $args['commission_id'] );
		if ( ! $commission || empty( $commission->user_id ) ) {
			return '';
		}

		$user = get_user_by( 'id', $commission->user_id );

		return $user ? $user->user_registered : '';
	}

}