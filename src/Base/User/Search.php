<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\User;

use ArrayPress\Rules\Base\Options\Searchable;
use function esc_html__;
use function get_users;
use function esc_html;
use function esc_attr;

class Search extends Searchable {

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
			? esc_html__( 'Users', 'arraypress' )
			: esc_html__( 'User', 'arraypress' );
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
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'user_id' ];
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'user', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'users', 'arraypress' );
	}

	/**
	 * Get the route for the endpoint.
	 *
	 * @return string
	 */
	protected function get_route(): string {
		return 'users';
	}

	/**
	 * Get the capability required for the endpoint.
	 *
	 * @return string
	 */
	protected function get_capability(): string {
		return 'manage_options';
	}

	/**
	 * Get the search description.
	 *
	 * @return string
	 */
	protected function get_search_description(): string {
		return sprintf(
			esc_html__( 'Search for %s', 'arraypress' ),
			$this->get_field_name_plural()
		);
	}

	/**
	 * Get the base search arguments.
	 *
	 * @param string $search The search term
	 *
	 * @return array The base search arguments
	 */
	protected function get_base_search_args( string $search ): array {
		return [
			'search'         => $search . '*',
			'search_columns' => [ 'display_name' ],
			'fields'         => [ 'ID', 'display_name' ],
			'orderby'        => 'display_name',
			'order'          => 'ASC',
		];
	}

	/**
	 * Execute the search with the given arguments.
	 *
	 * @param array $args The search arguments
	 *
	 * @return array The search results
	 */
	protected function execute_search( array $args ): array {
		$users   = get_users( $args );
		$options = [];

		foreach ( $users as $user ) {
			$options[] = [
				'label' => esc_html( $user->display_name ),
				'value' => esc_attr( $user->ID ),
			];
		}

		return $options;
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array|string
	 */
	protected function get_compare_value( array $args ) {
		if ( $this->multiple ) {
			return (array) ( $args['user_id'] ?? [] );
		}

		return (string) ( $args['user_id'] ?? '' );
	}

}