<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Discount;

use ArrayPress\Rules\Base\Options\Searchable;
use ArrayPress\EDD\Discounts\Search as DiscountSearch;
use function esc_html__;

/**
 * Abstract base class for handling discount selection across different contexts.
 */
abstract class Search extends Searchable {

	/**
	 * Whether the field supports multiple selection.
	 */
	protected bool $multiple = false;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Discounts', 'arraypress' )
			: esc_html__( 'Discount', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Discount', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'discount_id' ];
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'discount', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'discounts', 'arraypress' );
	}

	/**
	 * Get the route for the endpoint.
	 */
	protected function get_route(): string {
		return 'discounts';
	}

	/**
	 * Get the capability required for the endpoint.
	 */
	protected function get_capability(): string {
		return 'manage_shop_discounts';
	}

	/**
	 * Get the search description.
	 */
	protected function get_search_description(): string {
		return sprintf(
			esc_html__( 'Search for %s', 'arraypress' ),
			$this->get_field_name_plural()
		);
	}

	/**
	 * Get the base search arguments.
	 */
	protected function get_base_search_args( string $search ): array {
		return [
			'search' => $search
		];
	}

	/**
	 * Execute the search with the given arguments.
	 */
	protected function execute_search( array $args ): array {
		$search_query = new DiscountSearch();

		return $search_query->get_results( $args['search'] );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		if ( $this->multiple ) {
			return (array) ( $args['discount_id'] ?? [] );
		}

		return (string) ( $args['discount_id'] ?? '' );
	}

}