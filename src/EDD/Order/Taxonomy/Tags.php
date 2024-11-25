<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Taxonomy;

/**
 * The Download Categories rule.
 */
class Tags extends Tag {

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
		return esc_html__( 'Order Tags', 'arraypress' );
	}

}