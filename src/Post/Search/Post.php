<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Search;

use ArrayPress\Rules\Base\Post\Search as BaseSearch;
use function esc_html__;

/**
 * Class for post field comparison.
 */
class Post extends BaseSearch {

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
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get the post type for queries.
	 *
	 * @return string
	 */
	protected function get_query_post_type(): string {
		return 'post';
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

}