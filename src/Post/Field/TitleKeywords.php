<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

use ArrayPress\Rules\Base\Options\Creatable;
use function esc_html__;

class TitleKeywords extends Creatable {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Post Title Keywords', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'keywords', 'arraypress' );
	}

	/**
	 * Get the search target name.
	 */
	protected function get_search_target(): string {
		return esc_html__( 'post title', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the content to search within.
	 */
	protected function get_compare_value( array $args ): string {
		$post = get_post( $args['post_id'] );

		return $post ? $post->post_title : '';
	}

}