<?php

declare(strict_types=1);

/**
 * Split the site title into its first word and the rest, used by the header to style them differently.
 *
 * @return array{first: string, last: string}
 */
function tilleuls_split_title(string $title): array
{
    $words = explode(' ', $title);

    return [
        'first' => (string) array_shift($words),
        'last' => implode(' ', $words),
    ];
}

/**
 * Pages declared in pages.json (also used by `castor pages` to create them).
 *
 * @return array<int, array{slug: string, title: string, front?: bool, menu?: bool}>
 */
function tilleuls_site_pages(): array
{
    $pages = wp_json_file_decode(get_template_directory() . '/pages.json', ['associative' => true]);

    return is_array($pages) ? $pages : [];
}

/**
 * Serialized navigation-link blocks for the pages flagged "menu" that exist in the database.
 * Missing pages are skipped so the header never shows a broken link.
 */
function tilleuls_navigation_links(): string
{
    $links = '';

    foreach (tilleuls_site_pages() as $page) {
        if (empty($page['menu'])) {
            continue;
        }

        $post = get_page_by_path($page['slug']);
        if (!$post instanceof WP_Post || $post->post_status !== 'publish') {
            continue;
        }

        $links .= get_comment_delimited_block_content(
            'core/navigation-link',
            [
                'label' => get_the_title($post),
                'type' => 'page',
                'id' => $post->ID,
                'url' => get_permalink($post),
                'kind' => 'post-type',
            ],
            ''
        ) . "\n";
    }

    return $links;
}
