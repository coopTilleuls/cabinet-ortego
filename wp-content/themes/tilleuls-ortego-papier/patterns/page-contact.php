<?php
/**
 * Title: Page · Contact & Accès
 * Slug: tilleuls-ortego-papier/page-contact
 * Categories: tilleuls-papier-pages
 * Post Types: page
 * Block Types: core/post-content
 * Description: Coordonnées (Réglages > Général), carte bloquée jusqu'au consentement, formulaire Contact Form 7.
 *
 * @package tilleuls-ortego-papier
 */

$forms = post_type_exists('wpcf7_contact_form')
    ? get_posts(['post_type' => 'wpcf7_contact_form', 'numberposts' => 1, 'orderby' => 'ID', 'order' => 'ASC'])
    : [];
$form = $forms[0] ?? null;
?>
<!-- wp:tilleuls-ortego-blocks/hero-page {"description":"Le cabinet vous reçoit sur rendez-vous à Pau et au Pays Basque.","align":"full"} -->
<!-- wp:tilleuls-ortego-blocks/section-title {"title":"Contact & Accès","size":"xl"} /-->
<!-- /wp:tilleuls-ortego-blocks/hero-page -->

<!-- wp:group {"align":"full","className":"section","layout":{"type":"default"}} -->
<div class="wp-block-group alignfull section">
	<!-- wp:columns {"className":"contact-grille"} -->
	<div class="wp-block-columns contact-grille">
		<!-- wp:column {"width":"38%"} -->
		<div class="wp-block-column" style="flex-basis:38%">
			<!-- wp:tilleuls-ortego-blocks/contact-column /-->
		</div>
		<!-- /wp:column -->

		<!-- wp:column {"width":"62%"} -->
		<div class="wp-block-column" style="flex-basis:62%">
			<!-- wp:heading -->
			<h2 class="wp-block-heading">Envoyer un message</h2>
			<!-- /wp:heading -->
			<!-- wp:paragraph -->
			<p>Pour toute demande de consultation ou d'information, vous pouvez utiliser le formulaire ci-dessous. Le cabinet s'engage à vous répondre dans les meilleurs délais.</p>
			<!-- /wp:paragraph -->
			<?php if ($form) : ?>
			<!-- wp:shortcode -->
			[contact-form-7 id="<?php echo (int) $form->ID; ?>" title="<?php echo esc_attr($form->post_title); ?>"]
			<!-- /wp:shortcode -->
			<?php else : ?>
			<!-- wp:paragraph {"className":"mention"} -->
			<p class="mention">Ajoutez ici le formulaire Contact Form 7 (modèle : cf7-formulaire-contact.txt dans le thème).</p>
			<!-- /wp:paragraph -->
			<?php endif; ?>
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->
</div>
<!-- /wp:group -->
