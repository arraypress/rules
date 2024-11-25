<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Role;

class Roles extends Role {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

}