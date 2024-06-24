<?php
/**
 * Plugin Name: Myour Plugin
 * Plugin URI: https://myour.bslthemes.com
 * Description: This plugin it's designed for Myour Theme
 * Version: 1.0.1
 * Author: beshleyua
 * Author URI: https://myour.bslthemes.com
 * Text Domain: myour-plugin
 * Domain Path: /language/
 * License: http://www.gnu.org/licenses/gpl.html
 */

/* Load plugin text-domain */
function myour_plugin_load_textdomain() {
	load_plugin_textdomain( 'myour-plugin', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'myour_plugin_load_textdomain' );

/* Custom Post Types */
require plugin_dir_path( __FILE__ ) . 'custom-post-types.php';

/* ACF myour fields extention */
require plugin_dir_path( __FILE__ ) . 'acf-ext/acf-ui-google-font/acf-ui-google-font.php';

/**
 * Include Elementor Functions
 */
require_once plugin_dir_path( __FILE__ ) . 'elementor/functions.php';

/* Social Share */
require plugin_dir_path( __FILE__ ) . '/social-share/social-share.php';

/**
 * Enabled Custom Post Type Elementor Supports
 */
function myour_elementor_cpt_support() {
    $cpt_support = get_option( 'elementor_cpt_support' );

	if( ! $cpt_support ) {
	    $cpt_support = [ 'page', 'post', 'portfolio' ];
	    update_option( 'elementor_cpt_support', $cpt_support );
	} else if( ! in_array( 'portfolio', $cpt_support ) ) {
	    $cpt_support[] = 'portfolio';
	    update_option( 'elementor_cpt_support', $cpt_support );
	}
}
function myour_elementor_disable_fonts_and_colors() {
	$color_schemes = get_option( 'elementor_disable_color_schemes' );
	$typography_schemes = get_option( 'elementor_disable_typography_schemes' );

	if( ! $color_schemes ) {
	    update_option( 'elementor_disable_color_schemes', 'yes' );
	}
	if( ! $typography_schemes ) {
	    update_option( 'elementor_disable_typography_schemes', 'yes' );
	}	
}

/* Update permalink structure when plugin is activated */
function myour_plugin_activate() {
	flush_rewrite_rules();
	myour_elementor_cpt_support();
	myour_elementor_disable_fonts_and_colors();
}
function myour_plugin_deactivate() {
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'myour_plugin_activate' );
register_deactivation_hook( __FILE__, 'myour_plugin_deactivate' );

?>