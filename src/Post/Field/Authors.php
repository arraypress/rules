<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

/**
 * The Post Authors rule.
 */
class Authors extends Author {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

}