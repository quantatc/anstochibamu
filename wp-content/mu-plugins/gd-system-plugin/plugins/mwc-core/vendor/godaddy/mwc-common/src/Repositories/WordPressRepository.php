<?php

namespace GoDaddy\WordPress\MWC\Common\Repositories;

use Exception;
use GoDaddy\WordPress\MWC\Common\Configuration\Configuration;
use GoDaddy\WordPress\MWC\Common\Content\Context\Screen;
use GoDaddy\WordPress\MWC\Common\DataSources\WordPress\Adapters\WordPressScreenAdapter;
use GoDaddy\WordPress\MWC\Common\Helpers\ArrayHelper;
use GoDaddy\WordPress\MWC\Common\Helpers\StringHelper;
use GoDaddy\WordPress\MWC\Common\Models\User;
use WP;
use WP_Comment;
use WP_Screen;

/**
 * WordPress repository handler.
 */
class WordPressRepository
{
    /**
     * Gets the main WordPress environment setup class.
     *
     * @return WP
     * @throws Exception
     */
    public static function getInstance() : WP
    {
        global $wp;

        if (! $wp || ! is_a($wp, 'WP')) {
            throw new Exception('WordPress environment not initialized.');
        }

        return $wp;
    }

    /**
     * Gets the plugin's assets URL.
     *
     * @param string $path optional path
     * @return string URL
     */
    public static function getAssetsUrl(string $path = '') : string
    {
        $config = Configuration::get('mwc.url');

        if (! $config) {
            return '';
        }

        $url = StringHelper::trailingSlash($config);

        return "{$url}assets/{$path}";
    }

    /**
     * Gets the current blog ID.
     *
     * @see \get_current_blog_id()
     *
     * @return int
     */
    public static function getCurrentBlogId() : int
    {
        return get_current_blog_id();
    }

    /**
     * Gets the WordPress Filesystem instance.
     *
     * @throws Exception
     */
    public static function getFilesystem()
    {
        if (! $wp_filesystem = ArrayHelper::get($GLOBALS, 'wp_filesystem')) {
            throw new Exception('Unable to connect to the WordPress filesystem -- wp_filesystem global not found');
        }

        if (is_a($wp_filesystem, 'WP_Filesystem_Base') && is_wp_error($wp_filesystem->errors) && $wp_filesystem->errors->has_errors()) {
            throw new Exception(sprintf('Unable to connect to the WordPress filesystem with error: %s', $wp_filesystem->errors->get_error_message()));
        }

        return $wp_filesystem;
    }

    /**
     * Gets the current WordPress Version.
     *
     * @return string|null
     */
    public static function getVersion()
    {
        return Configuration::get('wordpress.version');
    }

    /**
     * Determines that a WordPress instance can be found.
     *
     * @return bool
     */
    public static function hasWordPressInstance() : bool
    {
        return (bool) Configuration::get('wordpress.absolute_path');
    }

    /**
     * Determines if the current instance is in CLI mode.
     *
     * @return bool
     */
    public static function isCliMode() : bool
    {
        return 'cli' === Configuration::get('mwc.mode');
    }

    /**
     * Determines whether WordPress is in debug mode.
     *
     * @return bool
     */
    public static function isDebugMode() : bool
    {
        return (bool) Configuration::get('wordpress.debug');
    }

    /**
     * Determines if the current request is for a WC REST API endpoint.
     *
     * @see WooCommerce::is_rest_api_request()
     *
     * @return bool
     */
    public static function isApiRequest() : bool
    {
        if (! $_SERVER['REQUEST_URI'] || ! function_exists('rest_get_url_prefix')) {
            return false;
        }

        $is_rest_api_request = StringHelper::contains($_SERVER['REQUEST_URI'], StringHelper::trailingSlash(rest_get_url_prefix()));

        /* applies WooCommerce core filter */
        return (bool) apply_filters('woocommerce_is_rest_api_request', $is_rest_api_request);
    }

    /**
     * Determines whether the current WordPress thread is a request for a WordPress admin page.
     *
     * @return bool
     */
    public static function isAdmin() : bool
    {
        return static::hasWordPressInstance() && is_admin();
    }

    /**
     * Determines whether the current WordPress thread is executing an AJAX callback.
     *
     * @return bool
     */
    public static function isAjax() : bool
    {
        return function_exists('wp_doing_ajax') && is_callable('wp_doing_ajax')
            ? wp_doing_ajax()
            : defined('DOING_AJAX') && DOING_AJAX;
    }

    /**
     * Requires the absolute path to the WordPress directory.
     *
     * @throws Exception
     */
    public static function requireWordPressInstance()
    {
        if (! self::hasWordPressInstance()) {
            // @TODO setting to throw an exception for now, may have to be revisited later (or possibly with a less generic exception) {FN 2020-12-18}
            throw new Exception('Unable to find the required WordPress instance');
        }
    }

    /**
     * Initializes and connect the WordPress Filesystem instance.
     *
     * Implementation adapted from {@see delete_plugins()}.
     *
     * @throws Exception
     */
    public static function requireWordPressFilesystem()
    {
        $base = Configuration::get('wordpress.absolute_path');

        require_once "{$base}wp-admin/includes/file.php";
        require_once "{$base}wp-admin/includes/plugin-install.php";
        require_once "{$base}wp-admin/includes/class-wp-upgrader.php";
        require_once "{$base}wp-admin/includes/plugin.php";

        // we are using an empty string as the value for the $form_post parameter because it is not relevant for our test.
        // If the function needs to show the form then the WordPress Filesystem is not currently configured for our needs.
        // We need to be able to access the filesystem without asking the user for credentials.
        ob_start();
        $credentials = request_filesystem_credentials('');
        ob_end_clean();

        if (false === $credentials || ! WP_Filesystem($credentials)) {
            static::getFilesystem();

            throw new Exception('Unable to connect to the WordPress filesystem');
        }
    }

    /**
     * Requires the WordPress Upgrade API.
     */
    public static function requireWordPressUpgradeAPI()
    {
        $base = Configuration::get('wordpress.absolute_path');

        require_once "{$base}wp-admin/includes/upgrade.php";
    }

    /**
     * Gets a Screen object using the data from the current WordPress screen object.
     *
     * @NOTE to reliably use this method, the screen should be grabbed past the `admin_init` hook or {@see \get_current_screen()} may not be available {unfulvio 2022-02-09}
     *
     * @return Screen|null
     */
    public static function getCurrentScreen()
    {
        $currentWPScreen = function_exists('get_current_screen') ? get_current_screen() : null;

        if (! $currentWPScreen instanceof WP_Screen) {
            return null;
        }

        return new Screen((new WordPressScreenAdapter($currentWPScreen))->convertFromSource());
    }

    /**
     * Determines if the current screen is a given WordPress admin screen for a given screen ID.
     *
     * @param string|string[] $screenId individual screen ID or list of IDs
     * @return bool
     * @throws Exception to use this method, the check should be executed past the `admin_init` hook
     */
    public static function isCurrentScreen($screenId) : bool
    {
        if (! function_exists('get_current_screen')) {
            throw new Exception('Unable to determine the current screen.');
        }

        $currentScreen = get_current_screen();

        return $currentScreen && ArrayHelper::contains(ArrayHelper::wrap($screenId), $currentScreen->id);
    }

    /**
     * Gets WordPress instance current locale setting.
     *
     * @return string
     */
    public static function getLocale() : string
    {
        return Configuration::get('wordpress.locale', '');
    }

    /**
     * Gets a WP_Comment object given a comment ID.
     *
     * @param int $commentId
     * @return WP_Comment
     */
    public static function getComment(int $commentId)
    {
        return get_comment($commentId);
    }

    /**
     * Returns all active plugins.
     *
     * @return array
     */
    public static function getActivePlugins() : array
    {
        return get_option('active_plugins', []);
    }

    /**
     * Gets the path to the must-use plugins directory.
     *
     * @return string
     */
    public static function getMustUsePluginsDirectoryPath() : string
    {
        return defined('WPMU_PLUGIN_DIR') ? StringHelper::trailingSlash(WPMU_PLUGIN_DIR) : '';
    }

    /**
     * Gets the URL to the must-use plugins directory.
     *
     * @return string
     */
    public static function getMustUsePluginsDirectoryUrl() : string
    {
        return defined('WPMU_PLUGIN_URL') ? StringHelper::trailingSlash(WPMU_PLUGIN_URL) : '';
    }

    /**
     * Retrieves the URL for an attachment.
     *
     * @param int $attachmentId
     *
     * @return string|false
     */
    public static function getAttachmentUrl(int $attachmentId)
    {
        return wp_get_attachment_url($attachmentId);
    }

    /**
     * Redirects the user to the given URL.
     *
     * @see \wp_safe_redirect()
     *
     * @param string $url URL to redirect to
     * @param bool $allowUnsafe default false, set to true to use {@see \wp_redirect()} instead of {@see \wp_safe_redirect()}
     * @param int $httpStatusCode optional HTTP status code to use for the redirection (default 302)
     * @param string $redirectedBy optional application prompting the redirect (default 'WordPress')
     * @return bool false if the redirect was cancelled, true otherwise
     */
    public static function redirectTo(string $url, bool $allowUnsafe = false, int $httpStatusCode = 302, string $redirectedBy = 'WordPress') : bool
    {
        $function = $allowUnsafe ? 'wp_redirect' : 'wp_safe_redirect';

        return (bool) $function($url, $httpStatusCode, $redirectedBy);
    }

    /*
     * Determines whether the request is Network admin request or not.
     *
     * @return bool
     */
    public static function isNetworkAdminRequest() : bool
    {
        return function_exists('is_network_admin') && is_network_admin();
    }

    /**
     * Determines if the multisite mode is enabled or not.
     *
     * @return bool
     */
    public static function isMultisite() : bool
    {
        return function_exists('is_multisite') && is_multisite();
    }
}
