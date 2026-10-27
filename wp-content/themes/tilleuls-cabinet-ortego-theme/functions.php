<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package tilleuls-cabinet-ortego-theme
 * @since tilleuls-cabinet-ortego-theme 1.0
 */

/**
 * Settings
 */
require_once __DIR__ . '/includes/settings/function.php';

/**
 * Helpers
 */
require_once __DIR__ . '/includes/helpers.php';

/**
 * Custom post types
 */
require_once __DIR__ . '/includes/post-types/register.php';
require_once __DIR__ . '/includes/post-types/expertise.php';
require_once __DIR__ . '/includes/post-types/union.php';

/**
 * Version a theme asset with its modification time so browsers drop stale caches.
 */
function tilleuls_asset_version(string $relative_path): string
{
    $file = get_template_directory() . $relative_path;

    return file_exists($file) ? (string) filemtime($file) : wp_get_theme()->get('Version');
}

function tilleuls_enqueue_fontawesome(): void
{
    wp_enqueue_style(
        'font-awesome',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );
}

add_action('enqueue_block_editor_assets', 'tilleuls_enqueue_fontawesome');

add_action('wp_enqueue_scripts', function () {
    tilleuls_enqueue_fontawesome();

    $styles = [
        'global' => '/style.css',
        'header' => '/assets/style/header.css',
        'footer' => '/assets/style/footer.css',
    ];

    foreach ($styles as $handle => $path) {
        wp_enqueue_style(
            $handle,
            get_template_directory_uri() . $path,
            $handle === 'global' ? [] : ['global'],
            tilleuls_asset_version($path)
        );
    }

    if (is_page('contact')) {
        wp_enqueue_style(
            'contact-page',
            get_template_directory_uri() . '/assets/style/contact.css',
            ['global'],
            tilleuls_asset_version('/assets/style/contact.css')
        );
    }
});
