<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Page\Search;

use ArrayPress\Rules\Base\Post\Search;
use function esc_html__;

/**
 * Class for post field comparison.
 */
class Page extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Page', 'arraypress' );
	}

	/**
	 * Get the rule group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Page', 'arraypress' );
	}

	/**
	 * Get the post type for queries.
	 *
	 * @return string
	 */
	protected function get_query_post_type(): string {
		return 'page';
	}

}