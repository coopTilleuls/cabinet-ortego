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
 * @return void
 * @since 1.0.0
 *
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

/**
 * Settings
 */
require_once realpath(__DIR__ . '/includes/settings/function.php');


add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'hero-home',
        get_template_directory_uri() . '/assets/style/hero.css',
        [],
        '1.0'
    );
});

function fontawesome_global(): void
{
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array(),
        '6.5.1'
    );
}

add_action('wp_enqueue_scripts', 'fontawesome_global');
add_action('enqueue_block_editor_assets', 'fontawesome_global');

