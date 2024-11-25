<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Recipient;

use ArrayPress\Rules\Base\User\Role as BaseRole;
use function esc_html__;

/**
 * Class for handling recipient role checks.
 */
class Role extends BaseRole {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Recipient Roles', 'arraypress' )
			: esc_html__( 'Recipient Role', 'arraypress' );
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
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'recipient role', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'recipient roles', 'arraypress' );
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
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array|string
	 */
	protected function get_compare_value( array $args ) {
		$commission = eddc_get_commission( $args['commission_id'] );
		if ( ! $commission || empty( $commission->user_id ) ) {
			return 'guest';
		}

		$user = get_user_by( 'id', $commission->user_id );
		if ( empty( $user ) || empty( $user->roles ) ) {
			return 'guest';
		}

		return $this->multiple ? $user->roles : $user->roles[0];
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return $this->multiple
			? esc_html__( 'Select the roles to check against the recipient\'s roles', 'arraypress' )
			: esc_html__( 'Select a role to check against the recipient\'s role', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return $this->multiple
			? esc_html__( 'Select recipient roles...', 'arraypress' )
			: esc_html__( 'Select recipient role...', 'arraypress' );
	}
}