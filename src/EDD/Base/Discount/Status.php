<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Discount;

use ArrayPress\Rules\Base\Options\Options;
use ArrayPress\EDD\Common\Statuses;
use function esc_html__;

/**
 * Class for handling discount status selection.
 */
abstract class Status extends Options {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Discount Statuses', 'arraypress' )
			: esc_html__( 'Discount Status', 'arraypress' );
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'status', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'statuses', 'arraypress' );
	}

	/**
	 * Get default value for the field.
	 */
	protected function get_default_value(): ?string {
		return '';
	}

	/**
	 * Get the available options.
	 */
	protected function get_options(): array {
		return Statuses::get_discount_statuses();
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ): string {
		return $this->get_status( $args );
	}

	/**
	 * Get the status value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The status value
	 */
	abstract protected function get_status( array $args ): string;

}