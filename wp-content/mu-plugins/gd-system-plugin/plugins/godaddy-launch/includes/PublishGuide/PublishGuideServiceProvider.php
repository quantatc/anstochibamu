<?php
/**
 * The PublishGuideServiceProvider class.
 *
 * @package GoDaddy
 */

namespace GoDaddy\WordPress\Plugins\Launch\PublishGuide;

use GoDaddy\WordPress\Plugins\Launch\ServiceProvider;

include_once ABSPATH . 'wp-admin/includes/plugin.php';

/**
 * The PublishGuideServiceProvider class.
 */
class PublishGuideServiceProvider extends ServiceProvider {
	const APP_CONTAINER_CLASS     = 'gdl-publish-guide';
	const PUBLISH_GUIDE_BTN_CLASS = 'gdl-publish-guide-btn';

	/**
	 * This method will be used for hooking into WordPress with actions/filters.
	 *
	 * @return void
	 */
	public function boot() {
		if ( ! current_user_can( 'activate_plugins' ) ) {
			return;
		}

		$build_file_slug = 'publish-guide';
		$build_file_path = $this->app->basePath( 'build/' . $build_file_slug . '.asset.php' );

		$asset_file = file_exists( $build_file_path )
		? include $build_file_path
		: array(
			'dependencies' => array(),
			'version'      => $this->app->version(),
		);

		$enqueue_handle = __NAMESPACE__ . $build_file_slug;

		add_action(
			is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts',
			function( $hook_suffix ) use ( $build_file_slug, $asset_file, $enqueue_handle ) {
				wp_enqueue_script(
					$enqueue_handle . '-script',
					$this->app->baseUrl( 'build/' . $build_file_slug . '.js' ),
					$asset_file['dependencies'],
					$asset_file['version'],
					$build_file_slug,
					true
				);

				wp_enqueue_style(
					$enqueue_handle,
					$this->app->baseUrl( 'build/' . $build_file_slug . '.css' ),
					[ 'wp-components' ],
					$asset_file['version']
				);

				wp_localize_script(
					$enqueue_handle . '-script',
					'gdvPublishGuideDefaults',
					array_merge(
						array(
							'appContainerClass' => self::APP_CONTAINER_CLASS,
							'page'              => $hook_suffix,
							'userId'            => get_current_user_id(),
						)
					)
				);

				// Localize state of conditions used for GuideItems.
				wp_localize_script(
					$enqueue_handle . '-script',
					'gdlConditions',
					array(
						'isWooActive'   => is_plugin_active( 'woocommerce/woocommerce.php' ),
						'newProductUri' => admin_url( 'post-new.php?post_type=product' ),
					)
				);

				wp_localize_script(
					$enqueue_handle . '-script',
					'gdvLinks',
					(array) apply_filters(
						'gdv_admin_links',
						array(
							'admin'        => get_admin_url(),
							'changeDomain' => $this->get_change_domain_uri(),
							'editorRedirectUrl' => $this->editor_redirect_url(),
						)
					)
				);

				wp_set_script_translations(
					$enqueue_handle . '-script',
					'godaddy-launch',
					$this->app->basePath( 'languages' )
				);

				add_action( is_admin() ? 'admin_footer' : 'wp_footer', function() {
					printf( '<div id="%s"></div>', self::APP_CONTAINER_CLASS );
				} );
			}
		);

		// Register PublishGuide/GuideItems and their completed state.
		$guide_items = array(
			GuideItems\SiteInfo::class,
			GuideItems\SiteMedia::class,
			GuideItems\SiteContent::class,
			GuideItems\SiteDesign::class,
			GuideItems\AddProduct::class,
			GuideItems\AddDomain::class,
		);
		$guide_items_localized = array();

		foreach( $guide_items as $guide_item ) {
			/** @var \GoDaddy\WordPress\Plugins\Launch\PublishGuide\GuideItems\GuideItemInterface */
			$guide_item_object = $this->app->make( $guide_item );

			// Check if option has timestamp of completion before additional conditions.
			$option_value = ! empty( get_option( $guide_item_object->option_name() ) );
			$is_complete = $option_value ? $option_value : $guide_item_object->is_complete();

			$class_name_parts = explode( '\\', $guide_item );
			$guide_items_localized[ end( $class_name_parts ) ] = array(
				'default' => $is_complete,
				'enabled' => $guide_item_object->is_enabled(),
				'propName' => $guide_item_object->option_name(),
			);

			// Register the setting so we can use useEntityProps.
			add_action( 'init', function() use ( $guide_item_object ) {
				register_setting(
					$guide_item_object->option_name(),
					$guide_item_object->option_name(),
					[
						'show_in_rest'      => true,
						'default'           => false,
						'type'              => 'boolean',
					]
				);

				// Initialize the option.
				if ( $guide_item_object->is_enabled() ) {
					add_option(
						$guide_item_object->option_name(),
						$guide_item_object->is_complete() ? time() : ''
					);
				}
			} );

			// If the value passed is boolean true, change the value to a timestamp before it's saved.
			add_filter( "pre_update_option_{$guide_item_object->option_name()}", function( $value ) {
				return ( true === $value ) ? time() : $value;
			} );
			// When pulling the value, convert back to boolean true.
			add_filter( "option_{$guide_item_object->option_name()}", function( $value ) {
				return ! empty( $value );
			} );
		}

		// Localize GuideItems.
		add_action(
			is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts',
			function() use ( $enqueue_handle, $guide_items_localized ) {
				wp_localize_script(
					$enqueue_handle . '-script',
					'gdlPublishGuideItems',
					$guide_items_localized
				);
			}
		);

		// Evaluate the guide items completion status.
		add_action( 'init', function() use ( $guide_items_localized ) {
			// Count 'enabled' items for total.
			$total = count( array_filter( $guide_items_localized, function( $guide_item ) {
				return $guide_item['enabled'];
			} ) );

			// The 'default' takes into account is_complete or existance of option with timestampe value,
			$completed = count( array_filter( $guide_items_localized, function( $guide_item ) {
				return $guide_item['default'];
			} ) );

			if ( $total === $completed ) {
				add_option( 'gdl_all_tasks_completed', time() );
			}
		} );

		add_filter( 'pre_set_theme_mod_custom_logo', array( $this, 'sync_site_logo_to_theme_mod' ) );
		add_filter( 'theme_mod_custom_logo', array( $this, 'override_custom_logo_theme_mod' ) );
		add_action( 'rest_api_init', array( $this, 'register_site_logo_setting' ), 10 );
	}

	/**
	 * This method will be used to bind things to the container.
	 *
	 * @return void
	 */
	public function register() {}

	/**
	 * Overrides the custom logo with a site logo, if the option is set.
	 *
	 * @param string $custom_logo The custom logo set by a theme.
	 *
	 * @return string The site logo if set.
	 */
	public function override_custom_logo_theme_mod( $custom_logo ) {
		$sitelogo = get_option( 'sitelogo' );
		return false === $sitelogo ? $custom_logo : $sitelogo;
	}

	/**
	 * Syncs the site logo with the theme modified logo.
	 *
	 * @param string $custom_logo The custom logo set by a theme.
	 *
	 * @return string The custom logo.
	 */
	public function sync_site_logo_to_theme_mod( $custom_logo ) {
		if ( $custom_logo ) {
			update_option( 'sitelogo', $custom_logo );
		}
		return $custom_logo;
	}

	/**
	 * Register a core site setting for a site logo
	 */
	public function register_site_logo_setting() {
		register_setting(
			'general',
			'sitelogo',
			array(
				'show_in_rest' => array(
					'name' => 'sitelogo',
				),
				'type'         => 'string',
				'description'  => __( 'Site logo.', 'godaddy-launch' ),
			)
		);
	}

	/**
	 * Get the URI for change domain page in MYH. This solution requires a temp domain set from gd-config.php and will return '' without it.
	 *
	 * @return string The URI for the change domain page in MYH.
	 */
	public function get_change_domain_uri() {
		if ( ! defined( 'GD_TEMP_DOMAIN' ) ) {
			define( 'GD_TEMP_DOMAIN', false );
		}

		return GD_TEMP_DOMAIN
			? 'https://myh.godaddy.com/#/hosting/mwp/v1/sitelookup/?domain=' . GD_TEMP_DOMAIN . '&path=changedomain'
			: '';
	}

	/**
	 * Determine how to redirect to the editor screen to perform various tasks.
	 *
	 * @return string
	 */
	private function editor_redirect_url() {
		// Bail if we're on a block editor screen.
		if ( false !== strpos( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) || false !== strpos( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) ) {
			return;
		}

		// If page_on_front is set, return edit url to that page.
		if ( 'page' === get_option( 'show_on_front' ) ) {
			$page_on_front = get_option( 'page_on_front' );

			if ( ! empty( $page_on_front ) ) {
				return get_edit_post_link( $page_on_front );
			}
		}

		$wp_query = new \WP_Query();

		// If we have a published page, return edit url to that page.
		$first_published_page = $wp_query->query(
			array(
				'fields'         => 'ids',
				'order'          => 'ASC',
				'orderby'        => 'ID',
				'post_status'    => array( 'publish' ),
				'post_type'      => array( 'page' ),
				'posts_per_page' => 1,
			)
		);
		if ( ! empty ( $first_published_page ) ) {
			$edit_url = get_edit_post_link( end( $first_published_page ) );
			$wp_query->reset_postdata();
			return $edit_url;
		}

		// If we have a published post, return edit url to that post.
		$first_published_post = $wp_query->query(
			array(
				'fields'         => 'ids',
				'order'          => 'ASC',
				'orderby'        => 'ID',
				'post_status'    => array( 'publish' ),
				'post_type'      => array( 'post' ),
				'posts_per_page' => 1,
			)
		);
		if ( ! empty ( $first_published_post ) ) {
			$edit_url = get_edit_post_link( end( $first_published_post ) );
			$wp_query->reset_postdata();
			return $edit_url;
		}

		$wp_query->reset_postdata();

		// Return create new page url by default.
		return admin_url( '/post-new.php?post_type=page' );
	}
}
