<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Search;

use function esc_html__;

/**
 * Class for post field comparison.
 */
class Posts extends Post {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Posts', 'arraypress' );
	}

}