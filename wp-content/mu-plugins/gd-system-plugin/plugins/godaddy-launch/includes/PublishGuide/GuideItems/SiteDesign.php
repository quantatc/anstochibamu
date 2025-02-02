<?php
/**
 * The SiteDesign class.
 *
 * @package GoDaddy
 */

namespace GoDaddy\WordPress\Plugins\Launch\PublishGuide\GuideItems;

/**
 * The SiteDesign class.
 */
class SiteDesign implements GuideItemInterface {
	/**
	 * Determins if the guide item should be enabled.
	 *
	 * @return bool
	 */
	public function is_enabled() {
		return ! empty( get_option( 'coblocks_site_design_controls_enabled' ) ) && $this->has_go_active();
	}

	/**
	 * Return if the guide item has been completed.
	 *
	 * @return bool
	 */
	public function is_complete() {
		$conditions = array(
			$this->has_theme_mods(),
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
		return 'gdl_pgi_site_design';
	}

	/**
	 * Determine if the Go theme has been customized.
	 *
	 * @return bool
	 */
	private function has_theme_mods() {
		$theme_mods = array_keys( get_theme_mods() );

		$check_keys = array(
			'design_style',
			'color_scheme',
			'fonts',
			'font_size',
			'type_ratio',
			'primary_color',
			'secondary_color',
			'tertiary_color',
			'background_color',
		);

		return ! empty( array_intersect( $check_keys, $theme_mods ) );
	}

	/**
	 * Determine if the Go theme is active.
	 *
	 * @return bool
	 */
	private function has_go_active() {
		return 'Go' === wp_get_theme()->get( 'Name' );
	}
}
