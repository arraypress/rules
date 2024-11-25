<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\PostType;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function get_post_types;
use function get_post_type;

class PostType extends Options {

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
			? esc_html__( 'Post Types', 'arraypress' )
			: esc_html__( 'Post Type', 'arraypress' );
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
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'post type', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'post types', 'arraypress' );
	}

	/**
	 * Get the available options.
	 *
	 * @return array Array of options in [value => label] format
	 */
	protected function get_options(): array {
		$post_types = get_post_types( [ 'public' => true ], 'objects' );
		$options    = [];

		foreach ( $post_types as $post_type ) {
			$options[] = [
				'value' => $post_type->name,
				'label' => $post_type->labels->singular_name
			];
		}

		return $options;
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
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		return get_post_type( $args['post_id'] );
	}

}