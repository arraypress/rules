<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Field;

use ArrayPress\Rules\Base\Options\Creatable;
use function esc_html__;

/**
 * The User Emails rule.
 */
class Emails extends Creatable {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'User Emails', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'user_id' ];
	}

	/**
	 * Get the field name.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'emails', 'arraypress' );
	}

	/**
	 * Get the name of what we're searching in.
	 */
	protected function get_search_target(): string {
		return esc_html__( 'user email list', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 */
	public function get_placeholder(): string {
		return esc_html__( 'Search user emails...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Select or enter user email addresses to match', 'arraypress' );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$user = get_user_by( 'id', $args['user_id'] );

		return $user ? $user->user_email : '';
	}

}