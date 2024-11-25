<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

use ArrayPress\Rules\Base\Text\Text;
use function esc_html__;

class Content extends Text {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Post Content', 'arraypress' );
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
	 * Get the field name for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'post content', 'arraypress' );
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
	 * @return string The post content or empty string if post not found.
	 */
	protected function get_compare_value( array $args ): string {
		$post = get_post( $args['post_id'] );

		return $post ? $post->post_content : '';
	}

}