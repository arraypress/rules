<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

use ArrayPress\Rules\Base\User\Search;
use function esc_html__;

/**
 * The Post Author field.
 */
class Author extends Search {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = false;

	/**
	 * Array of roles that can author content.
	 *
	 * @var array
	 */
	protected array $author_roles = [
		'administrator',
		'editor',
		'author',
		'contributor'
	];

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Post Author', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return esc_html__( 'Search authors...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Select an author to check against the current post.', 'arraypress' );
	}

	/**
	 * Get the base search arguments.
	 *
	 * @param string $search The search term
	 *
	 * @return array The base search arguments
	 */
	protected function get_base_search_args( string $search ): array {
		$args             = parent::get_base_search_args( $search );
		$args['role__in'] = $this->author_roles;

		return $args;
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		$post = get_post( $args['post_id'] );

		return (string) ( $post->post_author ?? '' );
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'author', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'authors', 'arraypress' );
	}

}