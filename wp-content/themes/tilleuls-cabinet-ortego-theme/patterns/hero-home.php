<?php
/**
 * Title: Hero – Accueil
 * Slug: tilleuls-ortego/hero-home
 * Categories: featured
 */

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'class' => 'hero alignfull',
        'id' => 'accueil',
    ]
);
?>
<section <?php
echo $wrapper_attributes; ?>>
    <div class="hero__overlay"></div>
    <div class="container hero__content">

        <!-- wp:tilleuls-ortego/hero-home -->
        <!-- wp:heading {"level":1} -->
        <h1>
            Maître Ilazki <strong>ORTEGO SAMPEDRO</strong>
        </h1>
        <!-- /wp:heading -->

        <!-- wp:paragraph -->
        <p>
            Défense des droits fondamentaux, Droit pénal et Droit des étrangers.<br>
            Un engagement sans faille pour la protection des libertés.
        </p>
        <!-- /wp:paragraph -->

        <!-- wp:buttons -->
        <!-- wp:button -->
        <a class="wp-block-button__link">Prendre rendez-vous</a>
        <!-- /wp:button -->
        <!-- /wp:buttons -->
        <!-- /wp:tilleuls-ortego/hero-home -->

    </div>
</section>
