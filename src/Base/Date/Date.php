<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Date;

use ArrayPress\Conditions\Rules\Rule;
use ArrayPress\Utils\Common\Compare;
use ArrayPress\Utils\I18n\Operators;
use function esc_html__;
use function current_time;
use function date_i18n;
use function strtotime;
use function sprintf;

/**
 * Base class for date fields.
 */
abstract class Date extends Rule {

	/**
	 * Date format for display.
	 *
	 * @var string
	 */
	protected string $date_format = 'Y-m-d';

	/**
	 * Display format for readable dates.
	 *
	 * @var string
	 */
	protected string $display_format = 'F j, Y';

	/**
	 * Get the option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Date', 'arraypress' );
	}

	/**
	 * Get the operators.
	 *
	 * @return array
	 */
	public function get_operators(): array {
		return Operators::get_numeric();
	}

	/**
	 * Get field args.
	 *
	 * @param array $args The field arguments.
	 *
	 * @return array
	 */
	public function get_field_args( array $args ): array {
		$args['type']             = 'date';
		$args['tooltip']          = $this->get_tooltip();
		$args['placeholder']      = $this->get_placeholder();
		$args['sanitizeCallback'] = $this->get_sanitize_callback();

		return $args;
	}

	/**
	 * Get the sanitization callback.
	 *
	 * @return callable
	 */
	protected function get_sanitize_callback(): callable {
		return 'sanitize_text_field';
	}

	/**
	 * Check the rule.
	 *
	 * @param string $operator The operator.
	 * @param mixed  $value    The user input value.
	 * @param array  $args     The arguments.
	 *
	 * @return bool
	 */
	public function check( string $operator, $value, array $args ): bool {
		$pre_check = $this->pre_check_validation( $value, $args );
		if ( $pre_check !== null ) {
			return $pre_check;
		}

		$user_date    = $this->get_timestamp( $this->format_input_value( $value, $args ) );
		$compare_date = $this->get_timestamp( $this->get_compare_value( $args ) );

		return Compare::numeric(
			$operator,
			$user_date,
			$compare_date
		);
	}

	/**
	 * Convert a date value to timestamp.
	 *
	 * @param mixed $value The date value to convert.
	 *
	 * @return int The timestamp.
	 */
	protected function get_timestamp( $value ): int {
		if ( is_numeric( $value ) ) {
			return (int) $value;
		}

		return strtotime( (string) $value );
	}

	/**
	 * Get the current timestamp.
	 *
	 * @return int
	 */
	protected function get_current_timestamp(): int {
		return current_time( 'timestamp' );
	}

	/**
	 * Pre-check validation before date comparison.
	 *
	 * @param mixed $value The user input value.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return bool|null Returns true/false to short-circuit, null to continue with comparison
	 */
	protected function pre_check_validation( $value, array $args ): ?bool {
		return null;
	}

	/**
	 * Format the user input value before comparison.
	 *
	 * @param mixed $value The user input value to format.
	 * @param array $args  The arguments passed to the check method.
	 *
	 * @return mixed
	 */
	protected function format_input_value( $value, array $args ) {
		return $value;
	}

	/**
	 * Get placeholder text.
	 *
	 * @return string
	 */
	public function get_placeholder(): string {
		return date_i18n( $this->date_format, $this->get_current_timestamp() );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		$current_date = date_i18n( $this->display_format, $this->get_current_timestamp() );

		return sprintf(
			esc_html__( 'Enter the %s you want to check (current time: %s)', 'arraypress' ),
			$this->get_field_name(),
			$current_date
		);
	}


	/**
	 * Get the name of the field for placeholders/tooltips.
	 *
	 * @return string
	 */
	abstract protected function get_field_name(): string;

	/**
	 * Get the value to compare against the user input.
	 * Must be implemented by child classes to provide the system value for comparison.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return mixed Date string or timestamp
	 */
	abstract protected function get_compare_value( array $args );

}