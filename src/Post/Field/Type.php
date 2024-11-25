<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function get_post_types;
use function esc_attr;
use function esc_html;

/**
 * Post Type comparison rule base class.
 *
 * Implements comparison functionality for post types with option-based selection.
 * Used to compare post types against values from registered post types in WordPress.
 *
 * @package ArrayPress\Conditions\Rules\Base
 */
class Type extends Options {

	/**
	 * Get the rule label for display.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Post Type', 'arraypress' );
	}

	/**
	 * Get the option group for organizing rules.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get default value for the field.
	 *
	 * @return string
	 */
	protected function get_default_value(): string {
		return 'post';
	}

	/**
	 * Get the field name in singular form for UI elements.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'post type', 'arraypress' );
	}

	/**
	 * Get the field name in plural form for UI elements.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'post types', 'arraypress' );
	}

	/**
	 * Get the available post type options.
	 *
	 * Retrieves all registered post types with show_ui enabled and formats them
	 * for use in select fields.
	 *
	 * @return array Array of post type options with value and label pairs.
	 */
	protected function get_options(): array {
		$post_types = get_post_types( [ 'show_ui' => true ], 'objects' );
		$options    = [];

		foreach ( $post_types as $type => $details ) {
			$options[] = [
				'value' => esc_attr( $type ),
				'label' => esc_html( $details->label ?? $type ),
			];
		}

		return $options;
	}

	/**
	 * Get required arguments for the rule.
	 *
	 * @return array Array containing required argument keys.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the value to compare against user input.
	 *
	 * @param array $args Arguments containing the post_id to check.
	 *
	 * @return string The post type of the given post.
	 */
	protected function get_compare_value( array $args ): string {
		return get_post_type( $args['post_id'] ) ?: '';
	}

}