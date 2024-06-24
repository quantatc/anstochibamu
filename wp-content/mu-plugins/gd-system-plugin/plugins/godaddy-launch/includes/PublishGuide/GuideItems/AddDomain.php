<?php
/**
 * The AddDomain class.
 *
 * @package GoDaddy
 */

namespace GoDaddy\WordPress\Plugins\Launch\PublishGuide\GuideItems;

/**
 * The AddDomain class.
 */
class AddDomain implements GuideItemInterface {
	/**
	 * Determins if the guide item should be enabled.
	 *
	 * @return bool
	 */
	public function is_enabled() {
		return true;
	}

	/**
	 * Return if the guide item has been completed.
	 *
	 * @return bool
	 */
	public function is_complete() {
		$conditions = array(
			$this->has_temp_domain(),
		);

		$has_incomplete = array_filter( $conditions, function( $val ) {
			return empty( $val );
		} );

		return empty( $has_incomplete );
	}

	/**
	 * Returns the option_name of the GuideItem used in the wp_options table.
	 *
	 * @return string
	 */
	public function option_name() {
		return 'gdl_pgi_add_domain';
	}

	/**
	 * Determine if the site has a logo.
	 *
	 * @return bool
	 */
	private function has_temp_domain() {
		$temp_domain = defined( 'GD_TEMP_DOMAIN' ) ? GD_TEMP_DOMAIN : false;

		if ( ! $temp_domain ) {
			return false;
		}

		return home_url() === $temp_domain;
	}
}
