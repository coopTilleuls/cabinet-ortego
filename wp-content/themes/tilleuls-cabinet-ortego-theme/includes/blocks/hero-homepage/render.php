<?php
/**
 * Dynamic Block: Hero Homepage
 * * @var array $attributes The block attributes.
 * @var array $block The block context.
 * @var string $content The block content.
 */

declare(strict_types=1);

// Cette fonction génère automatiquement les classes nécessaires (alignfull, etc.)
// et on y ajoute nos classes personnalisées 'hero' et l'ID.
$wrapper_attributes = get_block_wrapper_attributes([
    'class' => 'hero',
    'id' => 'accueil'
]);
?>

<section <?php
echo $wrapper_attributes; ?>>
    <div class="container hero-content">
        <h1>Maître Ilazki <strong>ORTEGO SAMPEDRO</strong></h1>
        <p>Défense des droits fondamentaux, Droit Pénal et Droit des Étrangers.<br>Un engagement sans faille pour la
            protection des libertés.</p>
        <a href="#contact" class="btn btn-primary">Prendre Rendez-vous</a>
    </div>
</section>
