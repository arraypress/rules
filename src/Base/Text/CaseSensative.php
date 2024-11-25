<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Text;

/**
 * Abstract base class for case-sensitive text field rules.
 */
abstract class CaseSensitive extends Text {

	/**
	 * Whether comparisons should be case-sensitive.
	 *
	 * @var bool
	 */
	protected bool $case_sensitive = true;

	/**
	 * Get tooltip text with case sensitivity notice.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return sprintf(
			esc_html__( 'Enter the %s you want to check (case-sensitive)', 'arraypress' ),
			$this->get_field_name()
		);
	}

}



