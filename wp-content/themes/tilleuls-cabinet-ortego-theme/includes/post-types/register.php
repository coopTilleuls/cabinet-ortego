<?php

declare(strict_types=1);

/**
 * Register a public custom post type.
 *
 * Labels are passed whole (not built by concatenation) so each one can be translated with the right gender and agreement.
 *
 * @param string                $post_type Post type key.
 * @param array<string, string> $labels    Translated labels (see get_post_type_labels()).
 * @param string                $slug      Rewrite slug.
 */
function tilleuls_register_cpt(string $post_type, array $labels, string $slug): void
{
    register_post_type(
        $post_type,
        [
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => $slug],
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'menu_icon' => 'dashicons-gavel',
            'show_in_rest' => true,
            'menu_position' => 20,
        ]
    );
}
