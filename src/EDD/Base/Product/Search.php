<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Product;

use ArrayPress\Rules\Base\Options\Searchable;
use ArrayPress\EDD\Downloads\Search as ProductSearch;
use function esc_html__;

/**
 * Abstract base class for handling product selection across different contexts.
 */
abstract class Search extends Searchable {

	/**
	 * Whether to include variations in search results.
	 */
	protected bool $include_variations = true;

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
			? esc_html__( 'Products', 'arraypress' )
			: esc_html__( 'Product', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Product', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'product_id' ];
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'product', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'products', 'arraypress' );
	}

	/**
	 * Get the route for the endpoint.
	 */
	protected function get_route(): string {
		return 'edd_products';
	}

	/**
	 * Get the capability required for the endpoint.
	 */
	protected function get_capability(): string {
		return 'manage_options';
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
			'search'             => $search,
			'include_variations' => $this->include_variations,
		];
	}

	/**
	 * Execute the search with the given arguments.
	 */
	protected function execute_search( array $args ): array {
		$search_query = new ProductSearch( false, $args['include_variations'] );

		return $search_query->get_results( $args['search'] );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		if ( $this->multiple ) {
			return (array) ( $args['product_id'] ?? [] );
		}

		return (string) ( $args['product_id'] ?? '' );
	}

}