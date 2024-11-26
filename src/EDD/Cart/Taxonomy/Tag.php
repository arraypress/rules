<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Cart\Taxonomy;

use ArrayPress\Rules\EDD\Product\Taxonomy\Tag as BaseTag;
use ArrayPress\EDD\Cart\Cart;
use function esc_html__;

/**
 * Order Categories rule for checking categories in an order.
 */
class Tag extends BaseTag {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Cart Tag', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Cart', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [];
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array
	 */
	protected function get_compare_value( array $args ): array {
		return Cart::get_term_ids( $this->get_taxonomy() ) ?: [];
	}

}