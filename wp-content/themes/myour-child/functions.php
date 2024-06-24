<?php
/**
 * myour-child functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package myour-child
 */

/**
 * Enqueue styles.
 */
function myour_child_stylesheets() {
	wp_enqueue_style( 'myour-child-style', get_template_directory_uri() . '/style.css', array( 'myour-style' ), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'myour_child_stylesheets' );