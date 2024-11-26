<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Checkout\Field;

use ArrayPress\Rules\EDD\Base\Checkout\Field;

/**
 * Class for checkout email field comparison.
 */
class FirstName extends Field {

	/**
	 * The field key to retrieve from the posted checkout data
	 *
	 * @var string
	 */
	protected string $field_key = 'edd_first';

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Checkout First Name', 'arraypress' );
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'first name', 'arraypress' );
	}

}