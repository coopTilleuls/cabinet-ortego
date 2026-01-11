<?php
/**
 * Render callback for the block.
 */

$attributes = $attributes ?? [];

// 1. Récupération des attributs
$bio = $attributes['bio'] ?? '';
$img_url = $attributes['imgUrl'] ?? '';
$languages = $attributes['languages'] ?? '';
$diplomas = $attributes['diplomas'] ?? '';

// 2. Gestion du wrapper (ajoute la classe 'profile-section' et l'ID)
$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'profile-section',
	'id'    => 'profil' // Comme dans votre edit.js
]);

?>

<section <?php echo $wrapper_attributes; ?>>
	<div class="container profile-grid">

		<!-- COLONNE GAUCHE : IMAGE + LANGUES -->
		<div class="profile-img-container">
			<?php if ( ! empty( $img_url ) ) : ?>
				<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php esc_attr_e('Photo de profil', 'tilleuls'); ?>">
			<?php endif; ?>

			<?php if ( ! empty( $languages ) ) : ?>
				<div class="languages-bar">
					<div class="languages-editor">
						<?php echo $languages; // RichText sauvegarde du HTML, on l'affiche tel quel ?>
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- COLONNE DROITE : TITRE + BIO + DIPLOMES -->
		<div class="bio-text">

			<?php
			// C'est ICI que s'affichent les InnerBlocks (votre Title Section)
			// Si save.js retourne <InnerBlocks.Content />, cette variable contient le HTML du titre.
			echo $content;
			?>

			<?php if ( ! empty( $bio ) ) : ?>
				<div class="bio-content">
					<?php echo $bio; ?>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $diplomas ) ) : ?>
				<div class="diploma-list">
					<?php echo $diplomas; ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
