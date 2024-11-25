<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\EDD\Product\Search;

class Products extends Product {

	/**
	 * Whether the field supports multiple selection.
	 */
	protected bool $multiple = true;

}