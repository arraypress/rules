<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Traits;

trait Sanitize {

	/**
	 * Sanitize the search string.
	 *
	 * This function sanitizes the search string by removing unwanted characters and escaping it for SQL queries.
	 *
	 * @param string $value The search string to sanitize.
	 *
	 * @return string The sanitized search string.
	 */
	public function sanitize_search( string $value ): string {
		return esc_sql( sanitize_text_field( $value ) );
	}

}