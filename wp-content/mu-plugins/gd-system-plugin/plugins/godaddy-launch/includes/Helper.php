<?php

namespace GoDaddy\WordPress\Plugins\Launch;

defined( 'ABSPATH' ) || exit;

trait Helper {
    /**
     * Retrieve the correct URL of the NUX API depending on the environment
     *
     * @return string
     */
    public static function wpnux_api_base() {
        $api_urls = [
            'local' => 'https://wpnux.test/v3/api',
            'dev'   => 'https://wpnux.dev-godaddy.com/v3/api',
            'test'  => 'https://wpnux.test-godaddy.com/v3/api',
            'prod'  => 'https://wpnux.godaddy.com/v3/api',
        ];

        $env = getenv( 'SERVER_ENV', true );

        $api_url = ! empty( $api_urls[ $env ] ) ? $api_urls[ $env ] : $api_urls['dev'];

        return untrailingslashit( (string) apply_filters( 'godaddy_launch_wpnux_api_url', $api_url ) );
    }

    /**
     * Determine if the RUM (Real User Metrics) is enabled
     *
     * @return bool
     */
    public static function is_rum_enabled() {
        return (bool) apply_filters( 'wpaas_rum_enabled', defined( 'GD_RUM_ENABLED' ) ? GD_RUM_ENABLED : false );
    }

    /**
     * Return the site domain.
     *
     * @return string
     */
    public static function domain() {
        return wp_parse_url( home_url(), PHP_URL_HOST );
    }
}
