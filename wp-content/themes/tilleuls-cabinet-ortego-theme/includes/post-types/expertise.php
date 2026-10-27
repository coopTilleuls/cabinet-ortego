<?php

declare(strict_types=1);

/**
 * Register Custom Post Type: Expertise
 */
add_action('init', function () {
    tilleuls_register_cpt('expertise', 'Domaine d\'Expertise', 'domaine-expertise', 'dashicons-gavel');
});
