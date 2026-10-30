<?php
/**
 * Functions and definitions
 *
 * @package tilleuls-ortego-papier
 * @since tilleuls-ortego-papier 1.0
 */

declare(strict_types=1);

/**
 * Sibling theme that owns pages.json (read by `castor pages`) and the cabinet contact settings.
 */
define('TILLEULS_PAPIER_BASE_THEME_DIR', get_theme_root() . '/tilleuls-cabinet-ortego-theme');

// Contact fields (Réglages > Général): same options as the base theme, so switching themes keeps the data.
if (is_readable(TILLEULS_PAPIER_BASE_THEME_DIR . '/includes/settings/function.php')) {
    require_once TILLEULS_PAPIER_BASE_THEME_DIR . '/includes/settings/function.php';
}

require_once __DIR__ . '/includes/icons.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/blocks.php';
require_once __DIR__ . '/includes/third-party.php';

/**
 * Version a theme asset with its modification time so browsers drop stale caches.
 */
function tilleuls_papier_asset_version(string $relative_path): string
{
    $file = get_stylesheet_directory() . $relative_path;

    return file_exists($file) ? (string) filemtime($file) : (string) wp_get_theme()->get('Version');
}

add_action('after_setup_theme', function (): void {
    add_theme_support('editor-styles');
    add_editor_style(['assets/css/global.css', 'assets/css/components.css', 'assets/css/chrome.css']);
});

add_action('wp_enqueue_scripts', function (): void {
    foreach (['global', 'components', 'chrome'] as $handle) {
        $path = "/assets/css/{$handle}.css";
        wp_enqueue_style(
            "tilleuls-papier-{$handle}",
            get_stylesheet_directory_uri() . $path,
            'global' === $handle ? [] : ['tilleuls-papier-global'],
            tilleuls_papier_asset_version($path)
        );
    }

    wp_enqueue_script(
        'tilleuls-papier-consent',
        get_stylesheet_directory_uri() . '/assets/js/consent.js',
        [],
        tilleuls_papier_asset_version('/assets/js/consent.js'),
        ['strategy' => 'defer', 'in_footer' => true]
    );

    if (wp_script_is('contact-form-7', 'registered')) {
        wp_enqueue_script(
            'tilleuls-papier-forms',
            get_stylesheet_directory_uri() . '/assets/js/forms.js',
            ['contact-form-7'],
            tilleuls_papier_asset_version('/assets/js/forms.js'),
            ['strategy' => 'defer', 'in_footer' => true]
        );
    }
});

// Font Awesome is still needed by the icons the "tilleuls" plugin blocks render (solid and regular only).
// Self-hosted so no third party is contacted before consent.
add_action('enqueue_block_assets', function (): void {
    $base = get_stylesheet_directory_uri() . '/assets/icons/fontawesome/css/';
    wp_enqueue_style('font-awesome', $base . 'fontawesome.min.css', [], '6.5.1');
    wp_enqueue_style('font-awesome-solid', $base . 'solid.min.css', ['font-awesome'], '6.5.1');
    wp_enqueue_style('font-awesome-regular', $base . 'regular.min.css', ['font-awesome'], '6.5.1');
});

// The header block prints its own skip links (content, navigation, footer); drop core's single one.
remove_action('wp_enqueue_scripts', 'wp_enqueue_block_template_skip_link');
remove_action('wp_footer', 'the_block_template_skip_link');

// Monogram favicon when no site icon is configured.
add_action('wp_head', function (): void {
    if (has_site_icon()) {
        return;
    }
    printf(
        '<link rel="icon" href="%s" type="image/svg+xml">' . "\n",
        esc_url(get_stylesheet_directory_uri() . '/assets/images/monogramme.svg')
    );
});
