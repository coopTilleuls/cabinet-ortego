<?php

declare(strict_types=1);

/**
 * Register Custom Post Type: Expertise
 */
function csr_register_expertise_cpt()
{
    register_post_type(
        'expertise',
        array(
            'labels' => array(
                'name' => 'Domaine d\'Expertise',
                'singular_name' => 'Domaine d\'Expertise',
                'add_new' => 'Ajouter un Domaine d\'Expertise',
                'add_new_item' => 'Ajouter un Domaine d\'Expertise',
                'edit_item' => 'Modifier une page Domaine d\'Expertise',
                'new_item' => 'Nouveau Domaine d\'Expertise',
                'view_item' => 'Voir le Domaine d\'Expertise',
                'search_items' => 'Rechercher un Domaine d\'Expertise',
                'not_found' => 'Aucun Domaine d\'Expertise trouvée',
                'not_found_in_trash' => 'Aucun Domaine d\'Expertise dans la corbeille',
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'domaine-expertise'),
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

add_action('init', 'csr_register_expertise_cpt');

