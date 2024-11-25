<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Text;

/**
 * Abstract base class for text field rules that are both case-sensitive and strip spaces.
 */
abstract class CaseSensitiveStripSpaces extends CaseSensitive {

	/**
	 * Whether to remove all whitespace before comparison.
	 *
	 * @var bool
	 */
	protected bool $strip_spaces = true;

	/**
	 * Get tooltip text with both notices.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		return sprintf(
			esc_html__( 'Enter the %s you want to check (case-sensitive, whitespace will be ignored)', 'arraypress' ),
			$this->get_field_name()
		);
	}

}