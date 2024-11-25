<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Date;

use ArrayPress\Rules\Base\Date\Date;
use function esc_html__;

class Published extends Date {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Post Published Date', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'published', 'arraypress' );
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

		return $post ? $post->post_date : '';
	}

}