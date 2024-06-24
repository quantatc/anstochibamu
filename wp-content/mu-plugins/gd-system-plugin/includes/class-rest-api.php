<?php

namespace WPaaS;

use WP_Application_Passwords;
use WP_Error;
use WP_Http_Cookie;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {

	exit;

}

final class REST_API {

	/**
	 * Instance of the API.
	 *
	 * @var API_Interface
	 */
	private $api;

	/**
	 * Array of REST API namespaces.
	 *
	 * @var array
	 */
	private $namespaces = [];

	public function __construct( API_Interface $api ) {

		if ( ! self::has_valid_account_uid() ) {

			return;

		}

		$this->api = $api;

		$this->namespaces['v1'] = 'wpaas/v1';

		add_action( 'rest_api_init', [ $this, 'flush_cache' ] );
		add_action( 'rest_api_init', [ $this, 'google_site_kit' ] );
		add_action( 'rest_api_init', [ $this, 'basic_auth_token' ] );
		add_action( 'rest_api_init', [ $this, 'yoast' ] );

	}

	public static function has_valid_account_uid() {

		return defined( 'GD_ACCOUNT_UID' ) && GD_ACCOUNT_UID && isset( $_SERVER['HTTP_X_ACCOUNT_UID'] ) && GD_ACCOUNT_UID === $_SERVER['HTTP_X_ACCOUNT_UID'];

	}

	public static function has_valid_site_token() {

		return defined( 'GD_SITE_TOKEN' ) && GD_SITE_TOKEN && isset( $_SERVER['HTTP_X_SITE_TOKEN'] ) && GD_SITE_TOKEN === $_SERVER['HTTP_X_SITE_TOKEN'];

	}

	public function has_valid_sso_hash() {

		$sso_hash = filter_input( INPUT_GET, 'wpaas_sso_hash' );

		return $sso_hash && $this->api->is_valid_sso_hash( $sso_hash );

	}

	private static function get_first_admin_user() {

		$users = get_users(
			[
				'role'   => 'administrator',
				'number' => 1,
			]
		);

		return empty( $users[0] ) ? new WP_Error( 'rest_site_missing_admin_user', 'Admin user not found.', [ 'status' => 500 ] ) : $users[0]->data;

	}

	/**
	 * GET route to retreive a basic auth token tied to the primary admin user.
	 */
	public function basic_auth_token() {

		register_rest_route( $this->namespaces['v1'], 'basic-auth-token', [
			'methods'             => 'GET',
			'permission_callback' => [ $this, 'has_valid_sso_hash' ],
			'callback'            => function ( WP_REST_Request $request ) {
				if ( ! $request['app_id'] ) {

					return new WP_Error( 'rest_missing_callback_param', 'Missing parameter(s): app_id', [ 'status' => 400, 'params' => [ 'app_id' ] ] );

				}

				$user = self::get_first_admin_user();

				if ( is_wp_error( $user ) ) {

					return $user;

				}

				$passwords = WP_Application_Passwords::get_user_application_passwords( $user->ID );

				if ( $passwords ) {

					foreach ( $passwords as $password ) {

						if ( $request['app_id'] === $password['app_id'] ) {

							WP_Application_Passwords::delete_application_password( $user->ID, $password['uuid'] );

						}

					}

				}

				$args = [
					'app_id' => $request['app_id'],
					'name' => $request['name'],
				];

				$created = WP_Application_Passwords::create_new_application_password( $user->ID, $args );

				if ( is_wp_error( $created ) ) {

					return $created;

				}

				$gd_system_application_passwords = (array) get_option( 'gd_system_application_passwords', [] );

				array_push( $gd_system_application_passwords, [
					'app_id' => $created[1]['app_id'],
					'created' => $created[1]['created'],
					'user_id' => $user->ID,
					'uuid' => $created[1]['uuid'],
				] );

				// Store these in an option and purge with a cron so they don't last forever.
				update_option( 'gd_system_application_passwords', $gd_system_application_passwords, false );

				// Schedule the cron event to cleanup application passwords.
				if ( ! wp_next_scheduled( 'wpaas_cleanup_application_passwords' ) ) {

					wp_schedule_event( time(), 'daily', 'wpaas_cleanup_application_passwords' );

				}

				$basic_auth = sprintf( '%s:%s', $user->user_login, $created[0] );

				return new WP_REST_Response( base64_encode( $basic_auth ) );

			},
		] );

	}

	/**
	 * POST route to flush cache.
	 */
	public function flush_cache() {

		register_rest_route( $this->namespaces['v1'], 'flush-cache', [
			'methods'             => 'POST',
			'permission_callback' => [ __CLASS__, 'has_valid_site_token' ],
			'callback'            => function () {
				add_action( 'shutdown', [ __NAMESPACE__ . '\Cache', 'flush_transients' ], PHP_INT_MAX );
				add_action( 'shutdown', [ __NAMESPACE__ . '\Cache', 'ban' ], PHP_INT_MAX );

				return [ 'success' => true ];
			},
		] );

	}

	/**
	 * GET route for Yoast SEO info.
	 */
	public function yoast() {

		register_rest_route( $this->namespaces['v1'], 'yoast', [
			'methods'             => 'GET',
			'permission_callback' => '__return_true',
			'callback'            => function () {
				$wpseo = (array) get_option( 'wpseo', [] );

				return [
					'active'                 => defined( 'WPSEO_VERSION' ),
					'environment_type'       => ! empty( $wpseo['environment_type'] ) ? $wpseo['environment_type'] : null,
					'first_activated_on'     => ! empty( $wpseo['first_activated_on'] ) ? $wpseo['first_activated_on'] : null,
					'show_onboarding_notice' => ! empty( $wpseo['show_onboarding_notice'] ),
					'site_type'              => ! empty( $wpseo['site_type'] ) ? $wpseo['site_type'] : null,
					'version'                => ! empty( $wpseo['version'] ) ? $wpseo['version'] : null,
				];
			},
		] );

	}

}
