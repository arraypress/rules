<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Taxonomy;

use ArrayPress\Rules\Base\Options\Searchable;
use ArrayPress\Utils\Terms\Raw as TermsRaw;
use function esc_html__;
use function get_terms;
use function is_wp_error;
use function esc_html;
use function esc_attr;

/**
 * Abstract class for taxonomy term field comparison.
 */
abstract class Search extends Searchable {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = false;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Taxonomy Terms', 'arraypress' )
			: esc_html__( 'Taxonomy Term', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get tooltip text with popular terms.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		$taxonomy_name = $this->get_taxonomy();
		$field_name    = $this->get_field_name_singular();

		// Main description
		$tooltip = sprintf(
			esc_html__( 'Select one or more %1$s to check against the current post.', 'arraypress' ),
			esc_html( $field_name )
		);

		// Get popular terms
		$popular_terms = TermsRaw::get_popular_terms( $taxonomy_name, [
			'limit' => 5
		] );

		if ( ! empty( $popular_terms ) ) {
			$tooltip .= '<br><br>';
			$tooltip .= '<strong>' . esc_html__( 'Popular terms:', 'arraypress' ) . '</strong>';
			$tooltip .= '<ul style="margin: 5px 0 5px 15px; list-style-type: disc;">';

			// Build terms list
			$tooltip .= implode( '', array_map( function ( $term ) {
				return sprintf(
					'<li style="margin: 3px 0;">%s (%d items)</li>',
					esc_html( $term->name ),
					esc_attr( $term->count )
				);
			}, $popular_terms ) );

			$tooltip .= '</ul>';
		}

		// Multiple selection note
		if ( $this->multiple ) {
			$tooltip .= '<br>' . esc_html__( 'You can select multiple terms.', 'arraypress' );
		}

		return $tooltip;
	}

	/**
	 * Get the required arguments.
	 *
	 * @return array
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

	/**
	 * Get the taxonomy for this field.
	 * Must be implemented by child classes.
	 *
	 * @return string
	 */
	abstract protected function get_taxonomy(): string;

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'term', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'terms', 'arraypress' );
	}

	/**
	 * Get the route for the endpoint.
	 *
	 * @return string
	 */
	protected function get_route(): string {
		return $this->get_taxonomy() . '_search';
	}

	/**
	 * Get the capability required for the endpoint.
	 *
	 * @return string
	 */
	protected function get_capability(): string {
		return 'manage_options';
	}

	/**
	 * Get the search description.
	 *
	 * @return string
	 */
	protected function get_search_description(): string {
		return sprintf(
			esc_html__( 'Search for %s terms', 'arraypress' ),
			$this->get_taxonomy()
		);
	}

	/**
	 * Get the base search arguments.
	 *
	 * @param string $search The search term
	 *
	 * @return array The base search arguments
	 */
	protected function get_base_search_args( string $search ): array {
		return [
			'taxonomy'   => $this->get_taxonomy(),
			'search'     => $search,
			'hide_empty' => false,
			'orderby'    => 'name',
			'order'      => 'ASC',
		];
	}

	/**
	 * Execute the search with the given arguments.
	 *
	 * @param array $args The search arguments
	 *
	 * @return array The search results
	 */
	protected function execute_search( array $args ): array {
		$options = [];
		$terms   = get_terms( $args );

		if ( is_wp_error( $terms ) ) {
			return $options;
		}

		foreach ( $terms as $term ) {
			$options[] = [
				'label' => esc_html( $term->name ),
				'value' => esc_attr( $term->term_id ),
			];
		}

		return $options;
	}


	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format
	 * @param array $args  The arguments passed to the check method
	 *
	 * @return array
	 */
	protected function format_input_value( $value, array $args ): array {
		if ( $this->multiple ) {
			return (array) $value;
		}

		return [ (string) $value ]; // Single term value becomes single-item array
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return array Post's term IDs
	 */
	protected function get_compare_value( array $args ): array {
		$terms = wp_get_post_terms(
			$args['post_id'],
			$this->get_taxonomy(),
			[ 'fields' => 'ids' ]
		);

		return is_wp_error( $terms ) ? [] : $terms;
	}

}