<?php
/**
 * License renewal count rule class.
 *
 * This class handles validation and comparison of license renewal counts in the EDD cart.
 *
 * @package     ArrayPress\Rules\EDD\Cart\Count
 * @since       1.0.0
 * @author      David Sherlock
 * @copyright   Copyright (c) 2024, ArrayPress Limited
 * @license     GPL-2.0-or-later
 */

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart\Count;

use ArrayPress\Rules\Base\Numeric\Integer;
use ArrayPress\EDD\Cart\Cart;


class LicenseRenewal extends Integer {

	/**
	 * Get the label of the field.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'License Renewals Count', 'arraypress' );
	}

	/**
	 * Get the option group name.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Cart', 'arraypress' );
	}

	/**
	 * Get the name of the field.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'license renewal count', 'arraypress' );
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return class_exists( 'EDD_Software_Licensing' );
	}

	/**
	 * Get the value to compare against.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return int
	 */
	protected function get_compare_value( array $args ): int {
		return Cart::get_license_renewal_count();
	}

}