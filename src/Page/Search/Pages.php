<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Page\Search;

use function esc_html__;

/**
 * The Pages rule.
 */
class Pages extends Page {

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Pages', 'arraypress' );
	}

}
