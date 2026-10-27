<?php

declare(strict_types=1);

/**
 * Register a public custom post type with French labels.
 *
 * @param string $post_type Post type key.
 * @param string $label     Singular label, e.g. "Domaine d'Expertise".
 * @param string $slug      Rewrite slug.
 * @param string $icon      Dashicon used in the admin menu.
 */
function tilleuls_register_cpt(string $post_type, string $label, string $slug, string $icon): void
{
    register_post_type(
        $post_type,
        [
            'labels' => [
                'name' => $label,
                'singular_name' => $label,
                'add_new' => 'Ajouter un ' . $label,
                'add_new_item' => 'Ajouter un ' . $label,
                'edit_item' => 'Modifier un ' . $label,
                'new_item' => 'Nouveau ' . $label,
                'view_item' => 'Voir le ' . $label,
                'search_items' => 'Rechercher un ' . $label,
                'not_found' => 'Aucun ' . $label . ' trouvé',
                'not_found_in_trash' => 'Aucun ' . $label . ' dans la corbeille',
            ],
            'public' => true,
            'has_archive' => true,
            'rewrite' => ['slug' => $slug],
            'supports' => ['title', 'editor', 'thumbnail', 'custom-fields'],
            'menu_icon' => $icon,
            'show_in_rest' => true,
            'menu_position' => 20,
        ]
    );
}
