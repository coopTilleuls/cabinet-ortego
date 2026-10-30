<?php
/**
 * Title: Page · Le Cabinet
 * Slug: tilleuls-ortego-papier/page-cabinet
 * Categories: tilleuls-papier-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Philosophie, parcours de l'avocate, formation, langues, engagements et citation.
 *
 * @package tilleuls-ortego-papier
 */

$principes = [
    ['Écoute active', "Comprendre votre histoire est la première étape d'une défense efficace. Une écoute sans jugement pour construire une stratégie adaptée."],
    ['Combativité', "Chaque dossier est analysé sous l'angle de la protection des droits fondamentaux (CEDH, Constitution) pour lutter contre l'arbitraire."],
    ['Transparence', 'Une clarté totale sur les enjeux de la procédure, les risques encourus et les honoraires pratiqués dès le premier rendez-vous.'],
];
$langues = ['Français', 'Euskara', 'Español', 'English', 'Italiano'];
$formation = [
    ['Master 2 Droit public, mention « Droits de l\'Homme »', 'Université Lumière Lyon 2'],
    ['Master 1 Droit pénal et sciences criminelles', 'Université Toulouse 1'],
    ['Diplôme universitaire en droit des étrangers', 'Université à préciser'],
];
$affiliations = [
    ['SAF', 'Syndicat des Avocats de France'],
    ['A3D', 'Association · défense des détenus'],
    ['ADEP', 'Association · défense des étrangers'],
];
?>
<!-- wp:tilleuls-ortego-blocks/hero-page {"description":"Une défense engagée et humaine, fondée sur la protection des libertés fondamentales.","align":"full"} -->
<!-- wp:tilleuls-ortego-blocks/section-title {"title":"Le Cabinet","size":"xl"} /-->
<!-- /wp:tilleuls-ortego-blocks/hero-page -->

<!-- wp:group {"align":"full","className":"section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section">
	<!-- wp:group {"className":"section-head","layout":{"type":"default"}} -->
	<div class="wp-block-group section-head">
		<!-- wp:paragraph {"className":"eyebrow"} -->
		<p class="eyebrow">Rigueur juridique et militantisme</p>
		<!-- /wp:paragraph -->
		<!-- wp:heading {"className":"filet-titre"} -->
		<h2 class="wp-block-heading filet-titre">Notre philosophie</h2>
		<!-- /wp:heading -->
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"principes"} -->
	<div class="wp-block-columns principes">
		<?php foreach ($principes as [$titre, $texte]) : ?>
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php echo esc_html($titre); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html($texte); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"section section--blanc section--filet","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section section--blanc section--filet">
	<!-- wp:columns {"className":"apropos"} -->
	<div class="wp-block-columns apropos">
		<!-- wp:column {"width":"40%"} -->
		<div class="wp-block-column" style="flex-basis:40%">
			<!-- wp:group {"className":"emplacement","layout":{"type":"default"}} -->
			<div class="wp-block-group emplacement">
				<!-- wp:paragraph -->
				<p><strong>Portrait · 4:5</strong><br>Plan buste, lumière naturelle, regard caméra. Ne pas réutiliser la photo de l'accueil.</p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
			<!-- wp:heading {"level":3,"className":"eyebrow"} -->
			<h3 class="wp-block-heading eyebrow">Langues parlées</h3>
			<!-- /wp:heading -->
			<!-- wp:list {"className":"etiquettes"} -->
			<ul class="wp-block-list etiquettes">
				<?php foreach ($langues as $langue) : ?>
				<!-- wp:list-item -->
				<li><?php echo esc_html($langue); ?></li>
				<!-- /wp:list-item -->
				<?php endforeach; ?>
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"60%"} -->
		<div class="wp-block-column" style="flex-basis:60%">
			<!-- wp:heading {"className":"filet-titre"} -->
			<h2 class="wp-block-heading filet-titre">Maître Ilazki Ortego Sampedro</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Maître Ilazki Ortego Sampedro a construit son parcours autour d'une conviction forte : la défense des droits fondamentaux pour tous. Avocate au Barreau, elle allie rigueur technique et militantisme juridique dans chacun de ses dossiers.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>Avant de prêter serment en 2022, elle a exercé en tant que juriste au sein d'associations dédiées à l'accès au droit pour les personnes détenues, ainsi qu'au sein d'un CIDFF (Centre d'information sur les droits des femmes et des familles). Cette double culture, associative et judiciaire, lui permet d'appréhender les dossiers avec une sensibilité sociale particulière et une connaissance fine du terrain.</p>
			<!-- /wp:paragraph -->
			<!-- wp:paragraph -->
			<p>Aujourd'hui, après avoir exercé au sein du cabinet de Me Pather, elle intervient principalement en droit pénal, droit des étrangers et droit pénitentiaire.</p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"level":3,"className":"formation__titre"} -->
			<h3 class="wp-block-heading formation__titre">Formation universitaire</h3>
			<!-- /wp:heading -->
			<!-- wp:list {"className":"formation"} -->
			<ul class="wp-block-list formation">
				<?php foreach ($formation as [$diplome, $lieu]) : ?>
				<!-- wp:list-item -->
				<li><strong><?php echo esc_html($diplome); ?></strong><br><?php echo esc_html($lieu); ?></li>
				<!-- /wp:list-item -->
				<?php endforeach; ?>
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","className":"section section--filet","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section section--filet">
	<!-- wp:heading {"className":"filet-titre"} -->
	<h2 class="wp-block-heading filet-titre">Engagements &amp; affiliations</h2>
	<!-- /wp:heading -->
	<!-- wp:group {"className":"affiliations","layout":{"type":"default"}} -->
	<div class="wp-block-group affiliations">
		<?php foreach ($affiliations as [$sigle, $nom]) : ?>
		<!-- wp:group {"className":"affiliation","layout":{"type":"default"}} -->
		<div class="wp-block-group affiliation">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php echo esc_html($sigle); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html($nom); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->

<!-- wp:tilleuls-ortego-blocks/quote {"citation":"La défense n'est pas un métier de confort, c'est une exigence de justice. Chaque voix mérite d'être portée avec force et dignité.","author":"Maître Ilazki Ortego Sampedro","align":"full"} /-->
