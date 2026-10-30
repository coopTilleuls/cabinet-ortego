<?php
/**
 * Title: Page · Compétences
 * Slug: tilleuls-ortego-papier/page-competences
 * Categories: tilleuls-papier-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Les trois domaines d'intervention, chacun avec ses points clés et un emplacement d'image facultatif.
 *
 * @package tilleuls-ortego-papier
 */

$domaines = [
    [
        'numero' => '01',
        'ancre' => 'droit-penal',
        'titre' => 'Droit pénal',
        'texte' => "Le droit pénal régit les rapports entre la société et les individus suspectés d'avoir commis une infraction. Maître Ortego Sampedro intervient à vos côtés pour garantir le respect de vos droits et vous défendre face à la machine judiciaire, que vous soyez auteur présumé ou victime cherchant réparation.",
        'points' => ["Défense d'urgence (garde à vue, comparution immédiate)", 'Instruction et tribunal correctionnel', "Cour d'assises", 'Assistance aux victimes (constitution de partie civile)'],
        'visuel' => 'Détail du cabinet ou de Pau, sans symbole de justice.',
    ],
    [
        'numero' => '02',
        'ancre' => 'droit-des-etrangers',
        'titre' => 'Droit des étrangers',
        'texte' => "Face à une administration complexe et une législation en constante évolution, l'assistance d'un avocat est souvent décisive. Ce domaine couvre l'ensemble des règles régissant l'entrée, le séjour et l'éloignement des ressortissants étrangers sur le territoire français, avec pour objectif la protection de votre droit à vivre en famille et en sécurité.",
        'points' => ['Contentieux du séjour (recours contre les OQTF, refus de titre)', "Demandes d'asile et protection subsidiaire", 'Procédures de régularisation', 'Contentieux de la nationalité française'],
        'visuel' => 'Éviter passeports, drapeaux, frontières.',
    ],
    [
        'numero' => '03',
        'ancre' => 'droit-penitentiaire',
        'titre' => 'Droit pénitentiaire',
        'texte' => "La condamnation ne signifie pas la perte de la dignité ni des droits fondamentaux. Ce domaine spécifique vise à défendre les personnes incarcérées face à l'administration pénitentiaire, à contester des conditions de détention indignes et à préparer activement la sortie pour favoriser la réinsertion.",
        'points' => ['Aménagement de peines (libération conditionnelle, semi-liberté, bracelet électronique)', 'Recours contre les conditions de détention', 'Procédures disciplinaires (commission de discipline)', 'Protection des libertés fondamentales en milieu carcéral'],
        'visuel' => 'Lumière, porte ouverte, sortie. Jamais de barreaux ni de menottes.',
    ],
];
?>
<!-- wp:tilleuls-ortego-blocks/hero-page {"description":"Une intervention rigoureuse dans les moments clés de la procédure.","align":"full"} -->
<!-- wp:tilleuls-ortego-blocks/section-title {"title":"Compétences","size":"xl"} /-->
<!-- /wp:tilleuls-ortego-blocks/hero-page -->

<!-- wp:group {"align":"full","className":"section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section">
	<!-- wp:paragraph {"className":"chapeau"} -->
	<p class="chapeau">Le cabinet intervient principalement dans trois domaines juridiques qui touchent directement aux libertés individuelles. Quelle que soit la nature du dossier, l'approche reste la même : technicité, écoute et combat pour le respect des droits.</p>
	<!-- /wp:paragraph -->

	<?php foreach ($domaines as $index => $domaine) : ?>
	<!-- wp:columns {"className":"domaine"} -->
	<div class="wp-block-columns domaine">
		<?php ob_start(); ?>
		<!-- wp:column {"width":"58%"} -->
		<div class="wp-block-column" style="flex-basis:58%">
			<!-- wp:paragraph {"className":"domaine__numero"} -->
			<p class="domaine__numero"><?php echo esc_html($domaine['numero']); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:heading {"className":"filet-titre","anchor":"<?php echo esc_attr($domaine['ancre']); ?>"} -->
			<h2 class="wp-block-heading filet-titre" id="<?php echo esc_attr($domaine['ancre']); ?>"><?php echo esc_html($domaine['titre']); ?></h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p><?php echo esc_html($domaine['texte']); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"is-style-coches"} -->
			<ul class="wp-block-list is-style-coches">
				<?php foreach ($domaine['points'] as $point) : ?>
				<!-- wp:list-item -->
				<li><?php echo esc_html($point); ?></li>
				<!-- /wp:list-item -->
				<?php endforeach; ?>
			</ul>
			<!-- /wp:list -->
		</div>
		<!-- /wp:column -->
		<?php $texte = ob_get_clean(); ob_start(); ?>
		<!-- wp:column {"width":"42%"} -->
		<div class="wp-block-column" style="flex-basis:42%">
			<!-- wp:group {"className":"emplacement emplacement--lieu","layout":{"type":"default"}} -->
			<div class="wp-block-group emplacement emplacement--lieu">
				<!-- wp:paragraph -->
				<p><strong>Visuel · 3:2 · facultatif</strong><br>Image décorative (texte alternatif vide). <?php echo esc_html($domaine['visuel']); ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->
		</div>
		<!-- /wp:column -->
		<?php
		$visuel = ob_get_clean();
		// Alternate sides on wide screens; on mobile the text always comes first.
		echo 1 === $index % 2 ? $visuel . $texte : $texte . $visuel; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block markup escaped above.
		?>
	</div>
	<!-- /wp:columns -->
	<?php endforeach; ?>
</div>
<!-- /wp:group -->

<!-- wp:pattern {"slug":"tilleuls-ortego-papier/section-appel"} /-->
