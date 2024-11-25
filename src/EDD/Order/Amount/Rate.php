<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Amount;

use ArrayPress\Rules\EDD\Base\Order\Amount;
use function esc_html__;

/**
 * Order Total rule.
 */
class Rate extends Amount {

	/**
	 * The column to use for average earnings calculation and order value retrieval.
	 *
	 * @var string
	 */
	protected string $amount_column = 'rate';

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Rate', 'arraypress' );
	}

	/**
	 * Get the field name.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'exchange rate', 'arraypress' );
	}

}