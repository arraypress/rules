<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

/**
 * The Post Author field.
 */
class Currencies extends Currency {

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
		return esc_html__( 'Commission Currencies', 'arraypress' );
	}

}