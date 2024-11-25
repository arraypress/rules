<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Field;

use ArrayPress\Rules\Base\User\Field;
use function esc_html__;

/**
 * The User Full Name rule.
 */
class FullName extends Field {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'User Full Name', 'arraypress' );
	}

	/**
	 * Get the field name.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'full name', 'arraypress' );
	}

	/**
	 * Get the specific field value from the user.
	 */
	protected function get_user_field_value( $user ): string {
		$first_name = get_user_meta( $user->ID, 'first_name', true );
		$last_name  = get_user_meta( $user->ID, 'last_name', true );

		return trim( sprintf( '%s %s', $first_name, $last_name ) );
	}

}