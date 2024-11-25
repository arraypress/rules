<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Base\Customer;

use ArrayPress\Rules\Base\Options\Searchable;
use ArrayPress\EDD\Customers\Search as CustomerSearch;
use function esc_html__;

/**
 * Abstract base class for handling customer selection across different contexts.
 */
abstract class Search extends Searchable {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Customers', 'arraypress' )
			: esc_html__( 'Customer', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 */
	public function get_option_group(): string {
		return esc_html__( 'Customer', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'customer_id' ];
	}

	/**
	 * Get the field name in singular form.
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'customer', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'customers', 'arraypress' );
	}

	/**
	 * Get the route for the endpoint.
	 */
	protected function get_route(): string {
		return 'customers';
	}

	/**
	 * Get the capability required for the endpoint.
	 */
	protected function get_capability(): string {
		return 'view_shop_reports';
	}

	/**
	 * Get the search description.
	 */
	protected function get_search_description(): string {
		return sprintf(
			esc_html__( 'Search for %s', 'arraypress' ),
			$this->get_field_name_singular()
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
		$search_query = new CustomerSearch();

		return $search_query->get_results( $args['search'] );
	}

	/**
	 * Get the value to compare against the user input.
	 */
	protected function get_compare_value( array $args ) {
		if ( $this->multiple ) {
			return (array) ( $args['customer_id'] ?? [] );
		}

		return (string) ( $args['customer_id'] ?? '' );
	}

}