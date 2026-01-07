<?php
/**
 * Functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since tilleuls-cabinet-ortego-theme 1.0
 */

/**
 * Enqueue the CSS files.
 *
 * @since 1.0.0
 *
 * @return void
 */

function tilleuls_cabinet_ortego_theme_register_blocks(): void
{
    // On définit le chemin vers le DOSSIER qui contient block.json
    $block_path = __DIR__ . '/includes/blocks/hero-homepage';

    // On tente d'enregistrer
    $result = register_block_type($block_path);

    // DÉBOGAGE : Si cela échoue, on l'écrit dans le debug.log ou on affiche une erreur admin
    if ( ! $result ) {
        error_log( 'ERREUR : Impossible d\'enregistrer le bloc au chemin : ' . $block_path );
        // Si le fichier block.json est introuvable ou invalide, register_block_type renvoie false
    }
}
add_action('init', 'tilleuls_cabinet_ortego_theme_register_blocks');

/**
 *Custom Post Type
 */

require_once realpath(__DIR__ . '/includes/post-types/expertise.php');
require_once realpath(__DIR__ . '/includes/post-types/union.php');

function tilleuls_cabinet_ortego_theme_styles(): void
{
	wp_enqueue_style(
		'tilleuls-cabinet-ortego-theme-style',
		get_stylesheet_uri(),
		[],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'tilleuls_cabinet_ortego_theme_styles' );
