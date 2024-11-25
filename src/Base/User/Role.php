<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\User;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function function_exists;
use function get_editable_roles;
use const ABSPATH;

class Role extends Options {

	/**
	 * Whether comparisons should be case-sensitive.
	 *
	 * @var bool
	 */
	protected bool $case_sensitive = false;

	/**
	 * Whether to remove all whitespace before comparison.
	 *
	 * @var bool
	 */
	protected bool $strip_spaces = false;

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
		return $this->multiple
			? esc_html__( 'User Roles', 'arraypress' )
			: esc_html__( 'User Role', 'arraypress' );
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
	 * Get default value for the field.
	 *
	 * @return string
	 */
	protected function get_default_value(): string {
		return 'administrator';
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'role', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'roles', 'arraypress' );
	}

	/**
	 * Get the available options.
	 *
	 * @return array Array of options in [value => label] format
	 */
	protected function get_options(): array {
		if ( ! function_exists( 'get_editable_roles' ) ) {
			require_once ABSPATH . '/wp-admin/includes/user.php';
		}

		$roles   = get_editable_roles();
		$options = [];

		// Add guest user option
		$options[] = [
			'value' => 'guest',
			'label' => esc_html__( 'Guest', 'arraypress' ),
		];

		foreach ( $roles as $role => $details ) {
			$options[] = [
				'value' => esc_attr( $role ),
				'label' => esc_html( $details['name'] ?? $role ),
			];
		}

		return $options;
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'user_id' ];
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array|string
	 */
	protected function get_compare_value( array $args ) {
		$user = get_user_by( 'id', $args['user_id'] );

		if ( empty( $user ) || empty( $user->roles ) ) {
			return 'guest';
		}

		return $this->multiple ? $user->roles : $user->roles[0];
	}

}