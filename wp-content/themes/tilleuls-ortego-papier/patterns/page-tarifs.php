<?php
/**
 * Title: Page · Tarifs & Rendez-vous
 * Slug: tilleuls-ortego-papier/page-tarifs
 * Categories: tilleuls-papier-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Honoraires (3 cartes), aide juridictionnelle et protection juridique, réservation Calendly bloquée jusqu'au consentement.
 *
 * @package tilleuls-ortego-papier
 */

$contact_url = esc_url(tilleuls_papier_page_url('contact'));
$tarifs = [
    [
        'titre' => 'Consultation au cabinet',
        'montant' => '80 €',
        'unite' => 'par rendez-vous',
        'points' => ['Rendez-vous physique à Pau', 'Durée : 45 min à 1 h', 'Analyse juridique orale', 'Déductible si ouverture de dossier'],
        'bouton' => 'Réserver',
        'contexte' => 'une consultation au cabinet',
        'url' => '#reserver',
        'style' => '',
    ],
    [
        'titre' => 'Forfait procédure',
        'montant' => 'Devis',
        'unite' => 'sur mesure',
        'points' => ['Montant fixe et définitif', 'Idéal pour les procédures classiques', "Rédaction d'actes incluse", "Représentation à l'audience"],
        'bouton' => 'Me contacter',
        'contexte' => 'pour un forfait',
        'url' => $contact_url,
        'style' => 'is-style-secondaire',
    ],
    [
        'titre' => 'Taux horaire',
        'montant' => '180 €',
        'unite' => 'par heure',
        'points' => ['Pour dossiers complexes', 'Facturation détaillée des diligences', 'Transparence totale', "Possibilité d'honoraire de résultat"],
        'bouton' => 'Me contacter',
        'contexte' => 'pour une facturation au temps passé',
        'url' => $contact_url,
        'style' => 'is-style-secondaire',
    ],
];
$infos = [
    ['icon' => 'phone', 'title' => 'Consultation téléphonique', 'highlight' => '', 'content' => "Disponible sur demande via l'agenda."],
];
?>
<!-- wp:tilleuls-ortego-blocks/hero-page {"description":"Transparence et simplicité pour votre accompagnement juridique.","align":"full"} -->
<!-- wp:tilleuls-ortego-blocks/section-title {"title":"Tarifs & Rendez-vous","size":"xl"} /-->
<!-- /wp:tilleuls-ortego-blocks/hero-page -->

<!-- wp:group {"align":"full","className":"section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section">
	<!-- wp:heading {"className":"filet-titre"} -->
	<h2 class="wp-block-heading filet-titre">Honoraires</h2>
	<!-- /wp:heading -->

	<!-- wp:group {"className":"tarifs","layout":{"type":"default"}} -->
	<div class="wp-block-group tarifs">
		<?php foreach ($tarifs as $tarif) : ?>
		<!-- wp:group {"className":"tarif","layout":{"type":"default"}} -->
		<div class="wp-block-group tarif">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading"><?php echo esc_html($tarif['titre']); ?></h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph {"className":"tarif__montant"} -->
			<p class="tarif__montant"><strong><?php echo esc_html($tarif['montant']); ?></strong> <?php echo esc_html($tarif['unite']); ?></p>
			<!-- /wp:paragraph -->
			<!-- wp:list {"className":"is-style-coches"} -->
			<ul class="wp-block-list is-style-coches">
				<?php foreach ($tarif['points'] as $point) : ?>
				<!-- wp:list-item -->
				<li><?php echo esc_html($point); ?></li>
				<!-- /wp:list-item -->
				<?php endforeach; ?>
			</ul>
			<!-- /wp:list -->
			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button<?php echo $tarif['style'] ? ' {"className":"' . esc_attr($tarif['style']) . '"}' : ''; ?> -->
				<div class="wp-block-button<?php echo $tarif['style'] ? ' ' . esc_attr($tarif['style']) : ''; ?>"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_attr($tarif['url']); ?>"><?php echo esc_html($tarif['bouton']); ?><span class="screen-reader-text"> <?php echo esc_html($tarif['contexte']); ?></span></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
		<?php endforeach; ?>
	</div>
	<!-- /wp:group -->

	<!-- wp:columns {"className":"encarts"} -->
	<div class="wp-block-columns encarts">
		<!-- wp:column {"className":"encart"} -->
		<div class="wp-block-column encart">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Aide juridictionnelle</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Le cabinet accepte d'intervenir au titre de l'aide juridictionnelle (totale ou partielle) selon la nature du dossier et vos ressources. Nous vous accompagnons dans la constitution du dossier de demande.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
		<!-- wp:column {"className":"encart"} -->
		<div class="wp-block-column encart">
			<!-- wp:heading {"level":3} -->
			<h3 class="wp-block-heading">Protection juridique</h3>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Vos frais d'avocat peuvent être pris en charge, partiellement ou totalement, par votre assurance protection juridique (souvent incluse dans votre contrat habitation ou carte bancaire). Pensez à vérifier vos contrats.</p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->

<!-- wp:group {"align":"full","anchor":"reserver","className":"ancre-section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull ancre-section" id="reserver">
	<!-- wp:tilleuls-ortego-blocks/appointment {"align":"full"} -->
	<!-- wp:tilleuls-ortego-blocks/section-title {"title":"Réservez votre créneau","size":"lg"} /-->
	<!-- wp:paragraph -->
	<p>Sélectionnez un motif dans l'agenda en ligne.</p>
	<!-- /wp:paragraph -->
	<!-- wp:tilleuls-papier/contact-address /-->
	<!-- wp:tilleuls-ortego-blocks/info-box <?php echo wp_json_encode(['infoItems' => $infos], JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP); ?> /-->
	<!-- /wp:tilleuls-ortego-blocks/appointment -->
</div>
<!-- /wp:group -->
