<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Order\Amount;

use ArrayPress\Rules\EDD\Base\Order\Amount;
use function esc_html__;

/**
 * Order Tax rule.
 */
class Tax extends Amount {

	/**
	 * The column to use for average earnings calculation and order value retrieval.
	 *
	 * @var string
	 */
	protected string $amount_column = 'tax';

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Order Tax', 'arraypress' );
	}

	/**
	 * Get the field name.
	 *
	 * @return string
	 */
	protected function get_field_name(): string {
		return esc_html__( 'tax amount', 'arraypress' );
	}

}