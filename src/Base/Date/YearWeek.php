<?php

declare( strict_types=1 );

namespace ArrayPress\Rules\Base\Date;

use ArrayPress\Rules\Base\Options\Options;
use ArrayPress\Utils\I18n\TimeUnits;
use function esc_html__;
use function date_i18n;
use function current_time;
use function strtotime;
use function sprintf;

/**
 * Abstract base class for week of year rules.
 */
abstract class YearWeek extends Options {

	/**
	 * Whether the field supports multiple selection.
	 *
	 * @var bool
	 */
	protected bool $multiple = false;

	/**
	 * Get the rule label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return $this->multiple
			? esc_html__( 'Weeks Of Year', 'arraypress' )
			: esc_html__( 'Week Of Year', 'arraypress' );
	}

	/**
	 * Get the option group.
	 *
	 * @return string
	 */
	public function get_option_group(): string {
		return esc_html__( 'Date', 'arraypress' );
	}

	/**
	 * Get the available options.
	 *
	 * @return array Array of options in [value => label] format
	 */
	protected function get_options(): array {
		return TimeUnits::get_weeks_of_year();
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'week', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'weeks', 'arraypress' );
	}

	/**
	 * Get the current timestamp or timestamp from provided date.
	 *
	 * @param array $args Optional arguments.
	 *
	 * @return int
	 */
	protected function get_current_timestamp( array $args = [] ): int {
		$date = $args['date'] ?? date_i18n( 'Y-m-d H:i:s', current_time( 'timestamp' ) );

		return strtotime( $date );
	}

	/**
	 * Get the current week number.
	 *
	 * @param array $args Optional arguments.
	 *
	 * @return string
	 */
	protected function get_current_week( array $args = [] ): string {
		return date_i18n( 'W', $this->get_current_timestamp( $args ) );
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		return $this->get_current_week( $args );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		$current_month = date_i18n( 'F', $this->get_current_timestamp() );
		$current_week  = $this->get_current_week();

		return sprintf(
			esc_html__( 'Current month is: %s. Current week is: %s.', 'arraypress' ),
			$current_month,
			$current_week
		);
	}

}