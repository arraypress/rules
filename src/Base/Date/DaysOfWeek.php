<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Date;

/**
 * Class for comparing multiple days of week.
 */
class DaysOfWeek extends DayOfWeek {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

}