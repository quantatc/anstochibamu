<?php
/**
 * The LiveSiteControlProvider class.
 *
 * @package GoDaddy
 */

namespace GoDaddy\WordPress\Plugins\Launch\LiveSiteControl;

use GoDaddy\WordPress\Plugins\Launch\ServiceProvider;
use GoDaddy\WordPress\Plugins\Launch\Helper;

/**
 * The LiveSiteControlProvider class.
 */
class LiveSiteControlProvider extends ServiceProvider {
	const ASSET_SLUG = 'live-site-control';

	const APP_CONTAINER_CLASS      = 'gdl-live-site-control';
	const PORTAL_CONTAINER_CLASS   = 'gdl-live-site-control-portal';
	const LIVE_CONTROL_PREVIEW_ARG = 'gdl-live-control-preview';
	const LIVE_CONTROL_EVENT_NAME  = 'gdl-live-control-go-live';

	const SETTINGS = [
		'publishState'    => 'gdl_site_published',
		'liveSiteDismiss' => 'gdl_live_site_dismiss',
		'blogPublic'      => 'blog_public',
	];

	public function milestone_published_nux_api( $value ) {
		if ( ! $value || ! Helper::is_rum_enabled()) {
			return $value;
		}

		$domain = defined('GD_TEMP_DOMAIN') ? GD_TEMP_DOMAIN : Helper::domain();
		$url =  Helper::wpnux_api_base() . '/milestones/site-publish?domain=' . $domain;

		wp_remote_post( $url, [
			'method' => 'POST',
			'blocking' => false,
			'body' => [
				'coblocks_version' => defined( 'COBLOCKS_VERSION' ) ? COBLOCKS_VERSION : null,
				'go_theme_version' => defined( 'GO_VERSION' ) ?  GO_VERSION : null,
				'hostname' => gethostname(),
				'language' => get_user_locale(),
				'website_id' => defined( 'GD_ACCOUNT_UID' ) ? GD_ACCOUNT_UID : null,
				'wp_user_id' => get_current_user_id(),
				'wp_version' => get_bloginfo( 'version' ),
			]
		] );

		return $value;
	}

	const SETTINGS_OVERRIDE = [
		'publishState' => [
			'default' => false,
			'true_as_timestamp' => true,
			'sanitize_callback' => 'milestone_published_nux_api',
		],
		'liveSiteDismiss' => [
			'default' => false,
			'true_as_timestamp' => true,
		],
	];

	public function boot() {
		// We need the settings registered to use with the REST API.
		foreach( self::SETTINGS as $key => $settings_key ) {
			register_setting(
				$settings_key,
				$settings_key,
				[
					'show_in_rest'      => true,
					'default'           => self::SETTINGS_OVERRIDE[ $key ]['default'] ?? true,
					'type'              => 'boolean',
					'sanitize_callback' => ! empty( self::SETTINGS_OVERRIDE[ $key ]['sanitize_callback'] )
						? [$this, self::SETTINGS_OVERRIDE[$key]['sanitize_callback']]
						: null,
				]
			);

			// Initialize the option.
			add_option( $settings_key );

			if ( ! empty( self::SETTINGS_OVERRIDE[ $key ]['true_as_timestamp'] ) ) {
				// If the value passed is boolean true, change the value to a timestamp before it's saved.
				add_filter( "pre_update_option_{$settings_key}", function( $value ) {
					return ( true === $value ) ? time() : $value;
				} );
				// When pulling the value, convert back to boolean true.
				add_filter( "option_{$settings_key}", function( $value ) {
					return ! empty( $value );
				} );
			}
		}

		if ( ! $this->is_restricted() ) {
			return;
		}

		/**
		 * This is to remove the toobar when previewing the website.
		 */
		if ( isset( $_GET[ self::LIVE_CONTROL_PREVIEW_ARG ] ) ) {
			add_action('after_setup_theme', function() {
				show_admin_bar(false);
			});

			return;
		}

		add_action(
			is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts',
			function( $hook_suffix ) {
				$build_file_path = $this->app->basePath( 'build/' . self::ASSET_SLUG . '.asset.php' );

				$asset_file = file_exists( $build_file_path )
					? include $build_file_path
					: array(
						'dependencies' => array(),
						'version'      => $this->app->version(),
					);

				wp_enqueue_script(
					self::ASSET_SLUG,
					$this->app->baseUrl( 'build/' . self::ASSET_SLUG . '.js' ),
					$asset_file['dependencies'],
					$asset_file['version'],
					true
				);

				wp_localize_script(
					self::ASSET_SLUG,
					'gdlLiveSiteControlData',
					[
						'page'                 => $hook_suffix,
						'appContainerClass'    => self::APP_CONTAINER_CLASS,
						'portalContainerClass' => self::PORTAL_CONTAINER_CLASS,
						'settings'             => self::SETTINGS,
						'previewArg'           => self::LIVE_CONTROL_PREVIEW_ARG,
						'eventName'            => self::LIVE_CONTROL_EVENT_NAME,
					]
				);

				wp_set_script_translations(
					self::ASSET_SLUG,
					'godaddy-launch',
					$this->app->basePath( 'languages' )
				);

				wp_enqueue_style(
					self::ASSET_SLUG,
					$this->app->baseUrl( 'build/' . self::ASSET_SLUG . '.css' ),
					[ 'wp-components' ],
					$asset_file['version']
				);

				if ( is_admin() ) {
					add_action( 'all_admin_notices', function() {
						printf( '<div id="%s"></div>', self::PORTAL_CONTAINER_CLASS );
					} );
				}


				add_action( is_admin() ? 'admin_footer' : 'wp_footer', function() {
					printf( '<div id="%s"></div>', self::APP_CONTAINER_CLASS );
				} );
			}
		);

		/**
		 * Show coming soon template if site is restricted.
		 */
		add_action( 'parse_request', function() {
			if ( $this->is_restricted() && ! $this->user_can_access() ) {
				include __DIR__ . '/template-coming-soon.php';
				status_header( 403 );
				nocache_headers();
				die();
			}
		}, 1 );

		add_action( 'wp_before_admin_bar_render', array( $this, 'wp_before_admin_bar_render' ) );
	}

	/**
	 * Determine if site should be restricted
	 *
	 * @return bool
	 */
	public function is_restricted() {
		return ! get_option( self::SETTINGS['publishState'], false );
	}

	/**
	 * Determine if the current user has access.
	 *
	 * @return bool
	 */
	public function user_can_access() {
		return is_user_logged_in() || is_admin();
	}

	/**
	 * Render a simple notice in the admin bar when viewing the site as an admin when the site is restricted.
	 */
	public function wp_before_admin_bar_render() {
		global $wp_admin_bar;

		// Only show notice when viewing the website normally.
		if ( is_admin() ) {
			return;
		}

		$wp_admin_bar->add_menu( array(
			'parent' => 'top-secondary',
			'id' => 'gdl-live-site',
			'title' => __( 'Your site is not live to the public', 'godaddy-launch' ),
		) );
	}
}
