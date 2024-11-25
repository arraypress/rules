<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Post;

use ArrayPress\Rules\Base\Options\Searchable;
use function esc_html__;
use function get_posts;
use function esc_html;
use function esc_attr;

/**
 * Abstract class for post field comparison.
 */
abstract class Search extends Searchable {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Posts', 'arraypress' )
			: esc_html__( 'Post', 'arraypress' );
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
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the post type for queries.
	 * Must be implemented by child classes.
	 *
	 * @return string
	 */
	abstract protected function get_query_post_type(): string;

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'post', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'posts', 'arraypress' );
	}

	/**
	 * Get the route for the endpoint.
	 *
	 * @return string
	 */
	protected function get_route(): string {
		return $this->get_query_post_type() . '_search';
	}

	/**
	 * Get the capability required for the endpoint.
	 *
	 * @return string
	 */
	protected function get_capability(): string {
		return 'edit_posts';
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
			's'           => $search,
			'post_type'   => $this->get_query_post_type(),
			'numberposts' => - 1,
			'orderby'     => 'title',
			'order'       => 'ASC',
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
		$posts   = get_posts( $args );
		$options = [];

		if ( empty( $posts ) ) {
			return $options;
		}

		foreach ( $posts as $post ) {
			$options[] = [
				'label' => esc_html( $post->post_title ),
				'value' => esc_attr( $post->ID ),
			];
		}

		return $options;
	}


	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value (rule value) to format
	 * @param array $args  The arguments passed to the check method
	 *
	 * @return array|string
	 */
	protected function format_input_value( $value, array $args ) {
		if ( $this->multiple ) {
			return (array) $value;
		}

		return (string) $value;
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * For multiple selection rules:
	 * - The rule value (user input) can be multiple post IDs
	 * - We compare if the current post_id exists within those selected post IDs
	 *
	 * For single selection rules:
	 * - Both the rule value and current post_id are single values
	 * - We do a direct string comparison
	 *
	 * @param array $args Arguments passed to the check method, containing current post_id
	 *
	 * @return string The current post ID to check against the rule value
	 */
	protected function get_compare_value( array $args ): string {
		return (string) ( $args['post_id'] ?? '' );
	}

}