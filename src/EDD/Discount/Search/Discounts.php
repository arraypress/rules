<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Discount\Search;

class Discounts extends Discount {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'Discounts', 'arraypress' );
	}

}