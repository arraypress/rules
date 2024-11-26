<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Customer\Field;

use ArrayPress\Rules\EDD\Base\Customer\Field;
use function esc_html__;

/**
 * Class Email
 * Handles customer email field comparison.
 */
class Email extends Field {

	/**
	 * The field to retrieve from the customer object
	 *
	 * @var string
	 */
	protected string $field_column = 'email';

	/**
	 * Get the rule name.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Customer Email', 'arraypress' );
	}

	/**
	 * Get the rule description.
	 *
	 * @return string
	 */
	public function get_description(): string {
		return esc_html__( 'Compare against the customer\'s email address', 'arraypress' );
	}

	/**
	 * Get the field name for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'customer email', 'arraypress' );
	}

}