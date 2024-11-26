<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Commission\Field;

/**
 * The Post Author field.
 */
class Statuses extends Currency {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

}