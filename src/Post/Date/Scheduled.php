<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Date;

use ArrayPress\Rules\Base\Date\Date;
use function esc_html__;

class Scheduled extends Date {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Post Scheduled Date', 'arraypress' );
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
		return esc_html__( 'scheduled', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the value to compare against the user input.
	 * Only returns a date for posts with 'future' status.
	 */
	protected function get_compare_value( array $args ): string {
		$post = get_post( $args['post_id'] );
		if ( ! $post ) {
			return '';
		}

		return $post->post_status === 'future' ? $post->post_date : '';
	}

}
