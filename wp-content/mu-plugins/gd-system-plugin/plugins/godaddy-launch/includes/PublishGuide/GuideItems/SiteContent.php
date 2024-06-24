<?php
/**
 * The SiteContent class.
 *
 * @package GoDaddy
 */

namespace GoDaddy\WordPress\Plugins\Launch\PublishGuide\GuideItems;

/**
 * The SiteContent class.
 */
class SiteContent implements GuideItemInterface {
	/**
	 * Post IDs for default pages of a new WP installation.
	 */
	const POST_ID_HELLO_WORLD = 1;
	const PAGE_ID_SAMPLE_PAGE = 2;
	const PAGE_ID_PRIVACY_POLICY = 3;
	const PAGE_ID_WOO_CART = 6;
	const PAGE_ID_WOO_CHECKOUT = 7;
	const PAGE_ID_WOO_ACCOUNT = 8;
	const PAGE_ID_WOO_REFUNDS_RETURNS = 9;
	const PAGE_ID_WOO_SHOP = 5;

	/**
	 * Determins if the guide item should be enabled.
	 *
	 * @return bool
	 */
	public function is_enabled() {
		return ! empty( get_option( 'coblocks_site_content_controls_enabled' ) );
	}

	/**
	 * Return if the guide item has been completed.
	 *
	 * @return bool
	 */
	public function is_complete() {
		$conditions = array(
			$this->has_new_content(),
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
		return 'gdl_pgi_site_content';
	}

	/**
	 * Determines if the site contains content beyond the default.
	 *
	 * @return bool
	 */
	private function has_new_content() {
		$wp_query = new \WP_Query();

		$content = $wp_query->query(
			array(
				'fields'         => 'ids',
				'post_type'      => 'any',
				'post_status'    => array( 'publish' ),
				'posts_per_page' => 1,
				'post__not_in'   => array(
					self::POST_ID_HELLO_WORLD,
					self::PAGE_ID_SAMPLE_PAGE,
					self::PAGE_ID_PRIVACY_POLICY,
					self::PAGE_ID_WOO_CART,
					self::PAGE_ID_WOO_CHECKOUT,
					self::PAGE_ID_WOO_ACCOUNT,
					self::PAGE_ID_WOO_REFUNDS_RETURNS,
					self::PAGE_ID_WOO_SHOP,
				),
			)
		);

		$wp_query->reset_postdata();

		return ! empty( $content );
	}
}
