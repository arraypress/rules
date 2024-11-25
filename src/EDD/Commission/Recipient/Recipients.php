<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Recipient;

/**
 * The Post Author field.
 */
class Recipients extends Recipient {

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
		return esc_html__( 'Recipients', 'arraypress' );
	}

}