<?php
/**
 * Theme blocks (server-rendered chrome), plugin block restyling and block style variations.
 */

declare(strict_types=1);

/**
 * Theme blocks live in blocks/<name>/ (block.json + render.php). They have no build step: the editor
 * shows them through ServerSideRender (assets/js/editor.js).
 */
add_action('init', function (): void {
    wp_register_script(
        'tilleuls-papier-editor',
        get_stylesheet_directory_uri() . '/assets/js/editor.js',
        ['wp-blocks', 'wp-element', 'wp-server-side-render', 'wp-block-editor'],
        tilleuls_papier_asset_version('/assets/js/editor.js'),
        true
    );

    // Card style shared with the plugin's info-box (used by the contact-address block).
    wp_register_style(
        'tilleuls-papier-info-box',
        get_stylesheet_directory_uri() . '/assets/css/blocks/info-box.css',
        ['tilleuls-papier-global'],
        tilleuls_papier_asset_version('/assets/css/blocks/info-box.css')
    );

    foreach (glob(get_stylesheet_directory() . '/blocks/*/block.json') ?: [] as $metadata) {
        register_block_type(dirname($metadata));
    }
});

/**
 * Swap the stylesheet of each "tilleuls-ortego-blocks/*" block for the theme's version when one exists
 * (assets/css/blocks/<block>.css). Keeps the plugin untouched and avoids specificity overrides.
 */
add_action('init', function (): void {
    $registry = WP_Block_Type_Registry::get_instance();
    $styles = wp_styles();

    foreach ($registry->get_all_registered() as $name => $type) {
        if (!str_starts_with($name, 'tilleuls-ortego-blocks/')) {
            continue;
        }
        $slug = substr($name, strlen('tilleuls-ortego-blocks/'));
        $path = "/assets/css/blocks/{$slug}.css";
        if (!file_exists(get_stylesheet_directory() . $path)) {
            continue;
        }
        foreach ($type->style_handles as $handle) {
            if (isset($styles->registered[$handle])) {
                $styles->registered[$handle]->src = get_stylesheet_directory_uri() . $path;
                $styles->registered[$handle]->ver = tilleuls_papier_asset_version($path);
                $styles->registered[$handle]->extra['path'] = get_stylesheet_directory() . $path;
            }
        }
    }
}, 99);

/**
 * Plugin blocks this theme replaces with its own sections (see the page patterns). They stay
 * registered so any existing content still renders, but no longer show up in the inserter.
 */
add_filter('register_block_type_args', function (array $args, string $name): array {
    $replaced = [
        'tilleuls-ortego-blocks/hero-home',
        'tilleuls-ortego-blocks/cards',
        'tilleuls-ortego-blocks/call-to-action',
        'tilleuls-ortego-blocks/pricing',
        'tilleuls-ortego-blocks/profile',
        'tilleuls-ortego-blocks/profile-home',
        'tilleuls-ortego-blocks/association-banner',
        'tilleuls-ortego-blocks/text-image',
        'tilleuls-ortego-blocks/contact-map',
    ];
    if (in_array($name, $replaced, true)) {
        $args['supports'] = array_merge($args['supports'] ?? [], ['inserter' => false]);
    }

    return $args;
}, 10, 2);

/**
 * Button styles of the design system (planche 3). "Principal" is the default style.
 */
add_action('init', function (): void {
    $button_styles = [
        'secondaire' => __('Secondaire', 'tilleuls-ortego-papier'),
        'tertiaire' => __('Tertiaire (lien)', 'tilleuls-ortego-papier'),
        'clair' => __('Clair (sur fond nuit ou rouge)', 'tilleuls-ortego-papier'),
        'contour-clair' => __('Contour clair (sur fond nuit ou rouge)', 'tilleuls-ortego-papier'),
    ];
    foreach ($button_styles as $slug => $label) {
        register_block_style('core/button', ['name' => $slug, 'label' => $label]);
    }

    $notice_styles = [
        'notice-info' => __('Notice · information', 'tilleuls-ortego-papier'),
        'notice-succes' => __('Notice · succès', 'tilleuls-ortego-papier'),
        'notice-erreur' => __('Notice · erreur', 'tilleuls-ortego-papier'),
    ];
    foreach ($notice_styles as $slug => $label) {
        register_block_style('core/group', ['name' => $slug, 'label' => $label]);
    }

    register_block_style('core/list', ['name' => 'coches', 'label' => __('Liste à coches', 'tilleuls-ortego-papier')]);
    register_block_style('core/details', ['name' => 'faq', 'label' => __('Accordéon · FAQ', 'tilleuls-ortego-papier')]);
    register_block_style('core/group', ['name' => 'nuit', 'label' => __('Section nuit', 'tilleuls-ortego-papier')]);
});

/**
 * Success notices are announced to screen readers without moving focus.
 */
add_filter('render_block_core/group', function (string $content, array $block): string {
    $class = (string) ($block['attrs']['className'] ?? '');
    if (str_contains($class, 'is-style-notice-succes') || str_contains($class, 'is-style-notice-info')) {
        $processor = new WP_HTML_Tag_Processor($content);
        if ($processor->next_tag() && null === $processor->get_attribute('role')) {
            $processor->set_attribute('role', 'status');
        }
        return $processor->get_updated_html();
    }

    return $content;
}, 10, 2);

/**
 * Buttons written with href="/" (404 template) lead to the home page of the current language and of
 * the actual install path (Polylang prefix, subdirectory install), not to the domain root.
 */
add_filter('render_block_core/button', function (string $content): string {
    $processor = new WP_HTML_Tag_Processor($content);
    if ($processor->next_tag('a') && '/' === $processor->get_attribute('href')) {
        $processor->set_attribute('href', tilleuls_papier_home_url());

        return $processor->get_updated_html();
    }

    return $content;
});

add_action('init', function (): void {
    register_block_pattern_category('tilleuls-papier-pages', [
        'label' => __('Cabinet · pages', 'tilleuls-ortego-papier'),
        'description' => __('Pages complètes du cabinet, selon les maquettes « Papier & encre ».', 'tilleuls-ortego-papier'),
    ]);
    register_block_pattern_category('tilleuls-papier-sections', [
        'label' => __('Cabinet · sections', 'tilleuls-ortego-papier'),
    ]);
});
