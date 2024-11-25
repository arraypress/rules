<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Taxonomy;

use ArrayPress\Rules\Base\Taxonomy\Search;
use function esc_html__;

/**
 * The Post Category rule.
 */
class Category extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Post Category', 'arraypress' );
	}

	/**
	 * Get the taxonomy.
	 *
	 * @return string
	 */
	public function get_taxonomy(): string {
		return 'category';
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'category', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'categories', 'arraypress' );
	}

}