<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Date;

use ArrayPress\Rules\Base\Date\Age as BaseAge;
use function esc_html__;

/**
 * The Post Duration (age) rule.
 */
class Age extends BaseAge {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Post Age', 'arraypress' );
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
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'post age', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the date to compare.
	 */
	protected function get_date_value( array $args ): string {
		$post = get_post( $args['post_id'] );

		return $post ? $post->post_date : '';
	}

}