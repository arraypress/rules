<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Date;

/**
 * Class for comparing multiple quarters of year.
 */
class YearQuarters extends YearQuarter {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = true;

}