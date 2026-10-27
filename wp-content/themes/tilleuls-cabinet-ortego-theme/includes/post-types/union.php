<?php

declare(strict_types=1);

/**
 * Register Custom Post Type: Union
 */
add_action('init', function () {
    tilleuls_register_cpt('union', 'Syndicat d\'affiliation', 'syndicat', 'dashicons-gavel');
});
