<?php
/**
 * This class defines the User Duration rule for ArrayPress Conditions.
 *
 * It provides functionality to interact with user registration durations, including defining rule groups, labels,
 * operators, and handling duration-related field arguments. The class is designed to be extended and customized for
 * specific user duration rules.
 *
 * @since       0.1.0 © ArrayPress Limited
 * @license     GPL2+
 * @package     ArrayPress/conditional-rules
 * @Author      David Sherlock
 */

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Date;

use ArrayPress\Rules\Base\Date\Date;
use function esc_html__;

/**
 * The User Registration Date rule.
 */
class Registered extends Date {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'User Registration Date', 'arraypress' );
	}

	/**
	 * Get the field name.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'registration date', 'arraypress' );
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

		return $user ? $user->user_registered : '';
	}

}