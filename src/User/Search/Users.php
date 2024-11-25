<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\User\Search;

class Users extends User {

	/**
	 * Whether the rule supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

}