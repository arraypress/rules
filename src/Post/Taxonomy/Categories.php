<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Taxonomy;

/**
 * The Post Categories rule.
 */
class Categories extends Category {

	/**
	 * Whether the rule supports multiple selection.
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
		return esc_html__( 'Post Categories', 'arraypress' );
	}

}