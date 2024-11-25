<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Post\Meta;

use ArrayPress\Rules\Base\Meta\Compare as MetaCompare;
use function esc_html__;

class Compare extends MetaCompare {

	/**
	 * The type of meta being checked.
	 *
	 * @var string
	 */
	protected string $meta_type = 'post';

	/**
	 * The argument key that contains the object ID.
	 *
	 * @var string
	 */
	protected string $object_id_key = 'post_id';

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Post Meta', 'arraypress' );
	}

	/**
	 * Get the rule option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Post', 'arraypress' );
	}

	/**
	 * Get the required arguments.
	 */
	public function get_required_args(): array {
		return [ 'post_id' ];
	}

}