<?php
/**
 * Data helpers shared by the header, footer and breadcrumb blocks.
 */

declare(strict_types=1);

/**
 * Pages declared in the base theme's pages.json (also used by `castor pages` to create them).
 *
 * @return array<int, array{slug: string, title: string, front?: bool, menu?: bool}>
 */
function tilleuls_papier_site_pages(): array
{
    static $pages = null;
    if (null === $pages) {
        $file = TILLEULS_PAPIER_BASE_THEME_DIR . '/pages.json';
        $decoded = is_readable($file) ? wp_json_file_decode($file, ['associative' => true]) : null;
        $pages = is_array($decoded) ? $decoded : [];
    }

    return $pages;
}

/**
 * Published page for a slug, switched to the current Polylang language when a translation exists.
 */
function tilleuls_papier_page(string $slug): ?WP_Post
{
    // Header, footer and breadcrumb ask for the same pages on every request.
    static $cache = [];
    if (array_key_exists($slug, $cache)) {
        return $cache[$slug];
    }

    $post = get_page_by_path($slug);
    if (!$post instanceof WP_Post) {
        return $cache[$slug] = null;
    }

    if (function_exists('pll_get_post')) {
        $translated = pll_get_post($post->ID);
        if ($translated) {
            $post = get_post($translated) ?? $post;
        }
    }

    return $cache[$slug] = 'publish' === $post->post_status ? $post : null;
}

/**
 * Menu entries for the pages flagged "menu" that exist. Missing pages are skipped so no link is broken.
 *
 * @return array<int, array{title: string, url: string, current: bool}>
 */
function tilleuls_papier_menu_items(): array
{
    static $items = null;
    if (null !== $items) {
        return $items;
    }

    $current_id = (int) get_queried_object_id();
    $items = [];

    foreach (tilleuls_papier_site_pages() as $page) {
        if (empty($page['menu'])) {
            continue;
        }
        $post = tilleuls_papier_page($page['slug']);
        if (!$post) {
            continue;
        }
        $items[] = [
            'title' => get_the_title($post),
            'url' => (string) get_permalink($post),
            'current' => $post->ID === $current_id,
        ];
    }

    return $items;
}

/**
 * URL of the booking page, used by the header call to action.
 */
function tilleuls_papier_booking_url(): string
{
    $post = tilleuls_papier_page('tarifs-rendez-vous');

    return $post ? (string) get_permalink($post) : '';
}

/**
 * Cabinet contact options (Réglages > Général), read through the "tilleuls" plugin helper so the
 * option keys live in one place. Empty values stay empty: templates hide the line.
 *
 * @return array{name: string, street: string, complement: string, zip: string, city: string, country: string, phone: string, email: string, hours: string, address: string}
 */
function tilleuls_papier_contact(): array
{
    $keys = ['name', 'street', 'complement', 'zip', 'city', 'country', 'phone', 'email', 'hours', 'address'];
    $contact = function_exists('tilleuls_ortego_blocks_contact') ? tilleuls_ortego_blocks_contact() : [];

    return array_map(static fn (string $key): string => trim((string) ($contact[$key] ?? '')), array_combine($keys, $keys));
}

/**
 * "tel:" href without spaces or dots, keeping the leading "+".
 */
function tilleuls_papier_tel_href(string $phone): string
{
    return 'tel:' . preg_replace('/[^\d+]/', '', $phone);
}

/**
 * Languages from Polylang, or an empty list when the plugin is not active.
 *
 * @return array<int, array{name: string, slug: string, locale: string, url: string, current: bool}>
 */
function tilleuls_papier_languages(): array
{
    if (!function_exists('pll_the_languages')) {
        return [];
    }

    $raw = pll_the_languages(['raw' => 1, 'hide_if_empty' => 0, 'hide_if_no_translation' => 0]);
    if (!is_array($raw)) {
        return [];
    }

    return array_values(array_map(static fn (array $lang): array => [
        'name' => (string) $lang['name'],
        'slug' => (string) $lang['slug'],
        'locale' => str_replace('_', '-', (string) ($lang['locale'] ?? $lang['slug'])),
        'url' => (string) $lang['url'],
        'current' => !empty($lang['current_lang']),
    ], $raw));
}

/**
 * Legal links of the footer "Informations" column; pages that don't exist are skipped.
 *
 * @return array<int, array{title: string, url: string}>
 */
function tilleuls_papier_legal_links(): array
{
    $links = [];

    $legal = tilleuls_papier_page('mentions-legales');
    if ($legal) {
        $links[] = ['title' => get_the_title($legal), 'url' => (string) get_permalink($legal)];
    }

    $privacy = get_privacy_policy_url();
    if ($privacy) {
        $links[] = ['title' => __('Politique de confidentialité', 'tilleuls-ortego-papier'), 'url' => $privacy];
    }

    $a11y = tilleuls_papier_page('accessibilite');
    if ($a11y) {
        // RGAA wording: "non conforme" until an audit says otherwise ("partiellement" / "totalement conforme").
        $status = (string) apply_filters('tilleuls_papier_accessibility_status', __('non conforme', 'tilleuls-ortego-papier'));
        $links[] = [
            /* translators: %s: RGAA compliance status. */
            'title' => sprintf(__('Accessibilité : %s', 'tilleuls-ortego-papier'), $status),
            'url' => (string) get_permalink($a11y),
        ];
    }

    return $links;
}

/**
 * Home URL in the current language.
 */
function tilleuls_papier_home_url(): string
{
    return function_exists('pll_home_url') ? (string) pll_home_url() : home_url('/');
}

/**
 * Title of the current listing (posts page, search, archive), shared by its H1 and the breadcrumb.
 */
function tilleuls_papier_listing_title(): string
{
    if (is_search()) {
        /* translators: %s: search terms. */
        return sprintf(__('Résultats pour « %s »', 'tilleuls-ortego-papier'), get_search_query(false));
    }
    if (is_home()) {
        $posts_page = (int) get_option('page_for_posts');

        return $posts_page ? get_the_title($posts_page) : __('Actualités', 'tilleuls-ortego-papier');
    }
    if (is_archive()) {
        return wp_strip_all_tags(get_the_archive_title());
    }

    return __('Contenus', 'tilleuls-ortego-papier');
}

/**
 * Breadcrumb items for the current request; empty on the front page.
 *
 * @return array<int, array{title: string, url: string}>
 */
function tilleuls_papier_breadcrumb_trail(): array
{
    if (is_front_page()) {
        return [];
    }

    $front_id = (int) get_option('page_on_front');
    if (function_exists('pll_get_post') && $front_id) {
        $front_id = (int) (pll_get_post($front_id) ?: $front_id);
    }
    $trail = [[
        'title' => $front_id ? get_the_title($front_id) : __('Accueil', 'tilleuls-ortego-papier'),
        'url' => tilleuls_papier_home_url(),
    ]];

    if (is_singular()) {
        $post = get_queried_object();
        foreach (array_reverse(get_post_ancestors($post)) as $ancestor) {
            $trail[] = ['title' => get_the_title($ancestor), 'url' => (string) get_permalink($ancestor)];
        }
        $trail[] = ['title' => get_the_title($post), 'url' => ''];
    } elseif (is_404()) {
        $trail[] = ['title' => __('Page introuvable', 'tilleuls-ortego-papier'), 'url' => ''];
    } elseif (is_search()) {
        $trail[] = ['title' => __('Recherche', 'tilleuls-ortego-papier'), 'url' => ''];
    } elseif (is_home() || is_archive()) {
        $trail[] = ['title' => tilleuls_papier_listing_title(), 'url' => ''];
    }

    return $trail;
}

/**
 * Breadcrumb markup; the last item is the current page (aria-current, not a link).
 *
 * @param array<int, array{title: string, url: string}> $trail
 */
function tilleuls_papier_breadcrumb_markup(array $trail, string $wrapper_attributes = 'class="breadcrumb-nav"'): string
{
    $html = '<nav ' . $wrapper_attributes . ' aria-label="' . esc_attr__("Fil d'Ariane", 'tilleuls-ortego-papier') . '"><ol class="breadcrumb">';
    foreach ($trail as $item) {
        $html .= '' === $item['url']
            ? '<li><span aria-current="page">' . esc_html($item['title']) . '</span></li>'
            : '<li><a href="' . esc_url($item['url']) . '">' . esc_html($item['title']) . '</a></li>';
    }

    return $html . '</ol></nav>';
}

/**
 * Permalink of a pages.json page, for links written in patterns. A page that doesn't exist yet gets
 * the URL it will have once created (`castor pages`), rather than the home page.
 */
function tilleuls_papier_page_url(string $slug): string
{
    $post = tilleuls_papier_page($slug);

    return $post ? (string) get_permalink($post) : home_url(user_trailingslashit($slug));
}
