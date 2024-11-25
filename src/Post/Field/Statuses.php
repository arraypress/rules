<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

/**
 * The Post Statuses rule for multiple selection.
 */
class Statuses extends Status {

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
		return esc_html__( 'Post Statuses', 'arraypress' );
	}

}