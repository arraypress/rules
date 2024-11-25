<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Post;

use ArrayPress\Rules\Base\Text\Text;
use function esc_html__;
use function get_post;
use function get_post_meta;

/**
 * Base class for post field text comparison.
 */
abstract class Field extends Text {

	/**
	 * The field to retrieve from the post object
	 */
	protected string $field_column = 'post_title';

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		$post = get_post( $args['post_id'] );
		if ( ! $post ) {
			return '';
		}

		return (string) $this->get_post_field_value( $post );
	}

	/**
	 * Get the specific field value from the post.
	 */
	protected function get_post_field_value( $post ) {
		$column = $this->field_column;

		// Check if the field is a direct post object property
		if ( isset( $post->$column ) ) {
			return $post->$column;
		}

		// Check if it's a post meta field
		$meta_value = get_post_meta( $post->ID, $column, true );
		if ( ! empty( $meta_value ) ) {
			return $meta_value;
		}

		return '';
	}

}