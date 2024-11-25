<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Field;

/**
 * The Post Types rule for multiple selection.
 */
class Types extends Type {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = True;

}