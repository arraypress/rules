<?php

declare(strict_types=1);

namespace ArrayPress\Rules\EDD\Customer;

use ArrayPress\Rules\EDD\Base\Customer\Field;
use function esc_html__;

/**
 * Class Name
 * Handles customer name field comparison.
 */
class Name extends Field {

	/**
	 * The field to retrieve from the customer object
	 *
	 * @var string
	 */
	protected string $field_column = 'name';

	/**
	 * Get the rule name.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__('Customer Name', 'arraypress');
	}

	/**
	 * Get the rule description.
	 *
	 * @return string
	 */
	public function get_description(): string {
		return esc_html__('Compare against the customer\'s name', 'arraypress');
	}

	/**
	 * Get the field name for placeholders/tooltips.
	 *
	 * @return string
	 */
	public function get_field_name(): string {
		return esc_html__( 'customer name', 'arraypress' );
	}

}

