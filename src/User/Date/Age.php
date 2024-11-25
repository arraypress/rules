<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Date;

use ArrayPress\Rules\Base\Date\Age as BaseAge;
use function esc_html__;

/**
 * The User Age rule.
 */
class Age extends BaseAge {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'User Age', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'User', 'arraypress' );
	}

	/**
	 * Get the field name.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'user age', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'user_id' ];
	}

	/**
	 * Get the date to compare.
	 */
	protected function get_date_value( array $args ): string {
		$user = get_user_by( 'id', $args['user_id'] );

		return $user ? $user->user_registered : '';
	}

}