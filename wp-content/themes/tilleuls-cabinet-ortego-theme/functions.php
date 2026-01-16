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
 * Settings
 */
require_once realpath(__DIR__ . '/includes/settings/function.php');


function fontawesome_global(): void
{
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        array('global'),
        '6.5.1'
    );
}

add_action('wp_enqueue_scripts', 'fontawesome_global');
add_action('enqueue_block_editor_assets', 'fontawesome_global');

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'global',
        get_template_directory_uri() . '/style.css',
        [],
        '1.0'
    );

    if ( is_page('contact') ) {
        wp_enqueue_style(
            'contact-page',
            get_template_directory_uri() . '/assets/style/contact.css',
            array('global'),
        );
    }
});


