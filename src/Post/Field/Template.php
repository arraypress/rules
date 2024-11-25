<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

use ArrayPress\Rules\Base\Options\Options;
use function esc_html__;
use function get_page_template_slug;
use function wp_get_theme;
use function esc_attr;
use function esc_html;

class Template extends Options {

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Post Template', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'template', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'templates', 'arraypress' );
	}

	/**
	 * Get default value for the field.
	 */
	protected function get_default_value(): string {
		return 'default';
	}

	/**
	 * Get the available options.
	 */
	protected function get_options(): array {
		$theme          = wp_get_theme();
		$page_templates = $theme->get_page_templates();

		$options = [
			[
				'value' => 'default',
				'label' => esc_html__( 'Default Template', 'arraypress' ),
			]
		];

		foreach ( $page_templates as $template_filename => $template_name ) {
			$options[] = [
				'value' => esc_attr( $template_filename ),
				'label' => esc_html( $template_name ),
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
		if ( ! $post ) {
			return '';
		}

		$template = get_page_template_slug( $post->ID );

		return $template ?: 'default';
	}

}