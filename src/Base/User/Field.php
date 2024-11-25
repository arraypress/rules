<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\User;

use ArrayPress\Rules\Base\Text\Text;
use function esc_html__;

/**
 * Base class for user field text comparison.
 */
abstract class Field extends Text {

	/**
	 * The field to retrieve from the user object
	 */
	protected string $field_column = 'display_name';

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'User', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'user_id' ];
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$user = get_user_by( 'id', $args['user_id'] );
		if ( ! $user ) {
			return '';
		}

		return (string) $this->get_user_field_value( $user );
	}

	/**
	 * Get the specific field value from the user.
	 */
	protected function get_user_field_value( $user ) {
		$column = $this->field_column;

		if ( isset( $user->$column ) ) {
			return $user->$column;
		}

		$meta_value = get_user_meta( $user->ID, $column, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		return '';
	}

}