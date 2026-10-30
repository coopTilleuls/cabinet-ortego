<?php

declare(strict_types=1);

/**
 * Register Custom Post Type: Expertise
 */
add_action('init', function () {
    tilleuls_register_cpt(
        'expertise',
        [
            'name' => __('Domaines d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'singular_name' => __('Domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'add_new' => __('Ajouter un domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'add_new_item' => __('Ajouter un domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'edit_item' => __('Modifier le domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'new_item' => __('Nouveau domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'view_item' => __('Voir le domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'search_items' => __('Rechercher un domaine d\'expertise', 'tilleuls-cabinet-ortego-theme'),
            'not_found' => __('Aucun domaine d\'expertise trouvé', 'tilleuls-cabinet-ortego-theme'),
            'not_found_in_trash' => __('Aucun domaine d\'expertise dans la corbeille', 'tilleuls-cabinet-ortego-theme'),
        ],
        'domaine-expertise',
        'dashicons-awards'
    );
});
