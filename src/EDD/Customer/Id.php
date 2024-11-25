<?php

declare(strict_types=1);

namespace ArrayPress\Rules\EDD\Customer;

use ArrayPress\Rules\Base\Numeric\Number;
use function esc_html__;

/**
 * Rule for checking EDD customer ID.
 */
class Id extends Number {

	/**
	 * Whether to only allow whole numbers
	 *
	 * @var bool
	 */
	protected bool $whole_numbers = true;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__('Customer ID', 'arraypress');
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__('Customer', 'arraypress');
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return ['customer_id'];
	}

	/**
	 * Get the field name for placeholders/tooltips.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__('customer ID', 'arraypress');
	}

	/**
	 * Get the value to compare against (customer's ID).
	 *
	 * @param array $args The arguments containing customer_id.
	 *
	 * @return int
	 */
	protected function get_compare_value(array $args): int {
		return (int)($args['customer_id'] ?? 0);
	}

	/**
	 * Get minimum value for the field.
	 *
	 * @return int
	 */
	protected function get_min_value(): int {
		return 1;
	}
}