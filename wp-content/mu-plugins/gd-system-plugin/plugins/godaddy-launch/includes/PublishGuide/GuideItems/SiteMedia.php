<?php
/**
 * The SiteMedia class.
 *
 * @package GoDaddy
 */

namespace GoDaddy\WordPress\Plugins\Launch\PublishGuide\GuideItems;

/**
 * The SiteMedia class.
 */
class SiteMedia implements GuideItemInterface {
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
			$this->has_site_logo(),
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
		return 'gdl_pgi_site_media';
	}

	/**
	 * Determine if the site has a logo.
	 *
	 * @return bool
	 */
	private function has_site_logo() {
		return ! empty( get_option( 'sitelogo' ) );
	}
}
