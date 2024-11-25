<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Field;

use ArrayPress\Rules\Base\User\Field;
use function esc_html__;

/**
 * The User Description rule.
 */
class Description extends Field {

	/**
	 * The field to retrieve from the user object
	 */
	protected string $field_column = 'description';

	/**
	 * Get the rule label.
	 */
	public function get_label(): string {
		return esc_html__( 'User Description', 'arraypress' );
	}

	/**
	 * Get the field name.
	 */
	protected function get_field_name(): string {
		return esc_html__( 'description', 'arraypress' );
	}

}