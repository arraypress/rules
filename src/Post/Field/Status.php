<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function get_post_stati;
use function esc_attr;
use function esc_html;

class Status extends Options {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Post Status', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get default value for the field.
	 */
	protected function get_default_value(): string {
		return 'publish';
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'post status', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'post statuses', 'arraypress' );
	}

	/**
	 * Get the available options.
	 */
	protected function get_options(): array {
		$post_stati = get_post_stati( [], 'objects' );
		$options    = [];

		foreach ( $post_stati as $status => $details ) {
			$options[] = [
				'value' => esc_attr( $status ),
				'label' => esc_html( $details->label ?? $status ),
			];
		}

		return $options;
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

		return $post ? $post->post_status : '';
	}

}