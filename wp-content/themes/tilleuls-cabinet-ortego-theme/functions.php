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

/**
 * Theme Block
 */

require_once realpath(__DIR__ . '/includes/blocks/register.php');

/**
 *Custom Post Type
 */

require_once realpath(__DIR__ . '/includes/post-types/expertise.php');
require_once realpath(__DIR__ . '/includes/post-types/union.php');

add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'hero-home',
        get_template_directory_uri() . '/assets/style/hero.css',
        [],
        '1.0'
    );
});

