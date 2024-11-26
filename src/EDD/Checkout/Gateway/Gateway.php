<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Checkout\Gateway;

use ArrayPress\Rules\EDD\Base\Gateway\Search;
use function function_exists;

/**
 * Abstract base class for EDD country search rules.
 */
class Gateway extends Search {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Checkout Gateway', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Checkout', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'posted' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'edd_is_checkout' );
	}

	/**
	 * Get the country value for comparison.
	 *
	 * @param array $args Arguments passed to the check method
	 *
	 * @return string The country value
	 */
	protected function get_gateway( array $args ): string {
		if ( isset( $args['posted']['edd-gateway'] ) ) {
			return $args['posted']['edd-gateway'];
		}

		// If field doesn't exist, return empty string
		return '';
	}

}