<?php
/**
 * Title: Page · Accueil
 * Slug: tilleuls-ortego-papier/page-accueil
 * Categories: tilleuls-papier-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Héros (image de fond facultative), domaines d'intervention, présentation de l'avocate, bandeau d'appel.
 *
 * @package tilleuls-ortego-papier
 */

$domaines = [
    ['icone' => 'penal', 'titre' => 'Droit pénal', 'texte' => 'Assistance en garde à vue, instruction, tribunal correctionnel. Défense des auteurs et des victimes.', 'contexte' => 'sur le droit pénal'],
    ['icone' => 'etrangers', 'titre' => 'Droit des étrangers', 'texte' => 'OQTF, titres de séjour, asile, nationalité. Accompagnement juridique multilingue complet.', 'contexte' => 'sur le droit des étrangers'],
    ['icone' => 'penitentiaire', 'titre' => 'Droit pénitentiaire', 'texte' => 'Aménagement de peine, commissions de discipline, conditions de détention et droits des détenus.', 'contexte' => 'sur le droit pénitentiaire'],
    ['icone' => 'libertes', 'titre' => 'Libertés fondamentales', 'texte' => "Protection contre les abus de l'administration. Droit public et défense des libertés individuelles.", 'contexte' => 'sur les libertés fondamentales'],
];
$competences = esc_url(tilleuls_papier_page_url('competences'));
?>
<!-- wp:cover {"dimRatio":90,"overlayColor":"nuit","isUserOverlayColor":true,"align":"full","className":"hero-accueil","layout":{"type":"default"}} -->
<div class="wp-block-cover alignfull hero-accueil"><span aria-hidden="true" class="wp-block-cover__background has-nuit-background-color has-background-dim-90 has-background-dim"></span><div class="wp-block-cover__inner-container">
	<!-- wp:paragraph {"className":"eyebrow"} -->
	<p class="eyebrow">Barreau de Pau &amp; Pays Basque</p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"className":"filet-titre"} -->
	<h1 class="wp-block-heading filet-titre">Défendre vos droits. <em>Protéger vos libertés.</em></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"chapeau"} -->
	<p class="chapeau">Une expertise juridique rigoureuse en droit pénal, droit des étrangers et libertés fondamentales. Parce que chaque situation mérite une défense combative et humaine.</p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(tilleuls_papier_page_url('tarifs-rendez-vous')); ?>">Prendre rendez-vous</a></div>
		<!-- /wp:button -->
		<!-- wp:button {"className":"is-style-secondaire"} -->
		<div class="wp-block-button is-style-secondaire"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(tilleuls_papier_page_url('le-cabinet')); ?>">Découvrir le cabinet</a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

</div></div>
<!-- /wp:cover -->

<!-- wp:group {"align":"full","className":"section section--blanc","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section section--blanc">
	<!-- wp:group {"className":"section-head","layout":{"type":"default"}} -->
	<div class="wp-block-group section-head">
		<!-- wp:paragraph {"className":"eyebrow"} -->
		<p class="eyebrow">Compétences</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading -->
		<h2 class="wp-block-heading">Domaines d'intervention</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:group {"className":"cartes","layout":{"type":"default"}} -->
	<div class="wp-block-group cartes">
		<?php foreach ($domaines as $domaine) : ?>
		<!-- wp:group {"className":"carte icone-<?php echo esc_attr($domaine['icone']); ?>","layout":{"type":"default"}} -->
		<div class="wp-block-group carte icone-<?php echo esc_attr($domaine['icone']); ?>">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php echo esc_html($domaine['titre']); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html($domaine['texte']); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph {"className":"lien-suite"} -->
			<p class="lien-suite"><a href="<?php echo $competences; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above. ?>">En savoir plus<span class="screen-reader-text"> <?php echo esc_html($domaine['contexte']); ?></span></a></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"section section--sable","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section section--sable">
	<!-- wp:columns {"className":"apropos"} -->
	<div class="wp-block-columns apropos">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:group {"className":"emplacement","layout":{"type":"default"}} -->
			<div class="wp-block-group emplacement">
				<!-- wp:paragraph -->
				<p><strong>Portrait · 4:5</strong><br>Remplacez ce cadre par une image : Me Ortego Sampedro au cabinet, lumière naturelle. Texte alternatif : « Maître Ilazki Ortego Sampedro ».</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"60%"} -->
		<div class="wp-block-column" style="flex-basis:60%">
			<!-- wp:paragraph {"className":"eyebrow"} -->
			<p class="eyebrow">À propos de l'avocate</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"className":"filet-titre"} -->
			<h2 class="wp-block-heading filet-titre">Maître Ilazki Ortego Sampedro</h2>
			<!-- /wp:heading -->
			<!-- wp:quote {"className":"citation-courte"} -->
			<blockquote class="wp-block-quote citation-courte">
				<!-- wp:paragraph -->
				<p>La défense n'est pas un métier de confort, c'est une exigence de justice.</p>
				<!-- /wp:paragraph -->
			</blockquote>
			<!-- /wp:quote -->
			<!-- wp:paragraph -->
			<p>Engagée pour la défense des droits fondamentaux, je mets mon expertise technique et ma combativité au service de votre dossier. Mon parcours associatif et judiciaire me permet d'appréhender chaque situation avec humanité et rigueur.</p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"atouts"} -->
			<ul class="wp-block-list atouts">
				<!-- wp:list-item {"className":"icone-ecoute"} -->
				<li class="icone-ecoute">Écoute</li>
				<!-- /wp:list-item -->
				<!-- wp:list-item {"className":"icone-combativite"} -->
				<li class="icone-combativite">Combativité</li>
				<!-- /wp:list-item -->
				<!-- wp:list-item {"className":"icone-multilingue"} -->
				<li class="icone-multilingue">Multilingue</li>
				<!-- /wp:list-item -->
			</ul>
			<!-- /wp:list -->
			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"className":"is-style-secondaire"} -->
				<div class="wp-block-button is-style-secondaire"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url(tilleuls_papier_page_url('le-cabinet')); ?>">En savoir plus sur mon parcours</a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"tilleuls-ortego-papier/section-appel"} /-->
