<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since tilleuls-cabinet-ortego-theme 1.0
 */

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */


require_once realpath(__DIR__ . '/includes/post-types/expertise.php');
require_once realpath(__DIR__ . '/includes/post-types/union.php');

function tilleuls_cabinet_ortego_theme_styles() {
	wp_enqueue_style(
		'tilleuls-cabinet-ortego-theme-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'tilleuls_cabinet_ortego_theme_styles' );
