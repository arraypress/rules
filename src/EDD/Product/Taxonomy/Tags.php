<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Product\Taxonomy;

/**
 * The Download Tags rule.
 */
class Tags extends Category {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Product Tags', 'arraypress' );
	}

}