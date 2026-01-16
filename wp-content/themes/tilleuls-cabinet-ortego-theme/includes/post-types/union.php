<?php

declare(strict_types=1);

/**
 * Register Custom Post Type: Union
 */
function csr_register_union_cpt()
{
    register_post_type(
        'union',
        array(
            'labels' => array(
                'name' => 'Syndicat d\'affiliation',
                'singular_name' => 'Syndicat d\'affiliation',
                'add_new' => 'Ajouter un Syndicat d\'affiliation',
                'add_new_item' => 'Ajouter un Syndicat d\'affiliation',
                'edit_item' => 'Modifier une page Syndicat d\'affiliation',
                'new_item' => 'Nouveau Syndicat d\'affiliation',
                'view_item' => 'Voir le Syndicat d\'affiliation',
                'search_items' => 'Rechercher un Syndicat d\'affiliation',
                'not_found' => 'Aucun Syndicat d\'affiliation trouvée',
                'not_found_in_trash' => 'Aucun Syndicat d\'affiliation dans la corbeille',
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'syndicat'),
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'menu_icon' => 'dashicons-gavel',
            'publicly_queryable' => true,
            'exclude_from_search' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
        )
    );
}

add_action('init', 'csr_register_union_cpt');
