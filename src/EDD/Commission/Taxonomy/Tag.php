<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Taxonomy;

use ArrayPress\Rules\EDD\Product\Tag as BaseTag;
use function esc_html__;

/**
 * Commission Product Categories rule for checking categories of the commission's product.
 */
class Tag extends BaseTag {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Commission Product Tag', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Commissions', 'arraypress' );
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return esc_html__( 'Search product tags...', 'arraypress' );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return esc_html__( 'Select tags to check against the commission product.', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'commission_id' ];
	}

	/**
	 * Validation check.
	 *
	 * @param array $args The arguments.
	 *
	 * @return bool
	 */
	public function validate( array $args ): bool {
		return function_exists( 'eddc_get_commission' );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array
	 */
	protected function get_compare_value( array $args ): array {
		$commission = eddc_get_commission( $args['commission_id'] );
		if ( ! $commission || empty( $commission->product_id ) ) {
			return [];
		}

		return wp_get_post_terms( $commission->product_id, $this->get_taxonomy(), [ 'fields' => 'ids' ] ) ?: [];
	}

}