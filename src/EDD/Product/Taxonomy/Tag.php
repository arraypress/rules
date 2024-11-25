<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Product\Taxonomy;

use ArrayPress\Rules\Base\Taxonomy\Search;
use function esc_html__;

/**
 * The Download Tag rule.
 */
class Tag extends Search {

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Product Tag', 'arraypress' );
	}

	/**
	 * Get the taxonomy for this field.
	 *
	 * @return string
	 */
	protected function get_taxonomy(): string {
		return 'download_tag';
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Product', 'arraypress' );
	}

	/**
	 * Get the capability required for the endpoint.
	 *
	 * @return string
	 */
	protected function get_capability(): string {
		return 'edit_posts';
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'product tag', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'product tags', 'arraypress' );
	}

}