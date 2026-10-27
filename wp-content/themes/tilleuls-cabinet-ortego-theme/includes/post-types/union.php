<?php

declare(strict_types=1);

/**
 * Register Custom Post Type: Union
 */
add_action('init', function () {
    tilleuls_register_cpt(
        'union',
        [
            'name' => __('Syndicats d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'singular_name' => __('Syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'add_new' => __('Ajouter un syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'add_new_item' => __('Ajouter un syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'edit_item' => __('Modifier le syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'new_item' => __('Nouveau syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'view_item' => __('Voir le syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'search_items' => __('Rechercher un syndicat d\'affiliation', 'tilleuls-cabinet-ortego-theme'),
            'not_found' => __('Aucun syndicat d\'affiliation trouvé', 'tilleuls-cabinet-ortego-theme'),
            'not_found_in_trash' => __('Aucun syndicat d\'affiliation dans la corbeille', 'tilleuls-cabinet-ortego-theme'),
        ],
        'syndicat'
    );
});
