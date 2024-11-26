<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Checkout\Address;

use ArrayPress\Rules\EDD\Base\Checkout\Field;

/**
 * Class for checkout email field comparison.
 */
class City extends Field {

	/**
	 * The field key to retrieve from the posted checkout data
	 *
	 * @var string
	 */
	protected string $field_key = 'card_city';

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Checkout Address City', 'arraypress' );
	}

	/**
	 * Get the name of the field for placeholders/tooltips.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'address city', 'arraypress' );
	}

}