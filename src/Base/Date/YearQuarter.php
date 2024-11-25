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
 * Abstract base class for quarter of year rules.
 */
abstract class YearQuarter extends Options {

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
			? esc_html__( 'Quarters Of Year', 'arraypress' )
			: esc_html__( 'Quarter Of Year', 'arraypress' );
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
		return TimeUnits::get_quarters_of_year();
	}

	/**
	 * Get the field name in singular form.
	 *
	 * @return string
	 */
	protected function get_field_name_singular(): string {
		return esc_html__( 'quarter', 'arraypress' );
	}

	/**
	 * Get the field name in plural form.
	 *
	 * @return string
	 */
	protected function get_field_name_plural(): string {
		return esc_html__( 'quarters', 'arraypress' );
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
	 * Get the current quarter.
	 *
	 * @param array $args Optional arguments.
	 *
	 * @return string
	 */
	protected function get_current_quarter( array $args = [] ): string {
		$current_month = (int) date_i18n( 'n', $this->get_current_timestamp( $args ) );

		if ( $current_month >= 1 && $current_month <= 3 ) {
			return 'Q1';
		} elseif ( $current_month >= 4 && $current_month <= 6 ) {
			return 'Q2';
		} elseif ( $current_month >= 7 && $current_month <= 9 ) {
			return 'Q3';
		} else {
			return 'Q4';
		}
	}

	/**
	 * Get the value to compare against the user input.
	 *
	 * @param array $args Arguments passed to the check method.
	 *
	 * @return string
	 */
	protected function get_compare_value( array $args ): string {
		return $this->get_current_quarter( $args );
	}

	/**
	 * Get tooltip text.
	 *
	 * @return string
	 */
	public function get_tooltip(): string {
		$current_month   = date_i18n( 'F', $this->get_current_timestamp() );
		$current_quarter = $this->get_current_quarter();

		return sprintf(
			esc_html__( 'Current month is: %s. Current quarter is: %s.', 'arraypress' ),
			$current_month,
			$current_quarter
		);
	}
}