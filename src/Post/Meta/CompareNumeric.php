<?php

declare(strict_types=1);

namespace ArrayPress\Rules\Post\Meta;

use function esc_html__;

/**
 * Post Meta Numeric Field class for number-based meta comparisons.
 */
class CompareNumeric extends Compare {

	/**
	 * Whether this meta field handles numeric values.
	 *
	 * @var bool
	 */
	protected bool $is_numeric = true;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__('Post Meta (Numeric)', 'arraypress');
	}

}