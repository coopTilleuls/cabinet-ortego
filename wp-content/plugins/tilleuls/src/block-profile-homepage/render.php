<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

$blockWrapper = get_block_wrapper_attributes([
	'class' => 'profile-home',
])

?>
<section <?php
echo $blockWrapper; ?>>
	<div class="profile-home-grid">
		<div class="profile-home-img"></div>
		<div class="profile-home-content">
			<span class="profile-surtitle">À propos de l'avocate</span>
			<?php
			echo $content;
			?>
			<div class="value-list">
				<div class="value-item">
					<i class="fa-regular fa-comments"></i>
					<span>Écoute</span>
				</div>
				<div class="value-item">
					<i class="fa-solid fa-shield-halved"></i>
					<span>Combativité</span>
				</div>
				<div class="value-item">
					<i class="fa-solid fa-globe"></i>
					<span>Multilingue</span>
				</div>
			</div>
			<a href="" class="profile-cta"> En savoir plus sur mon parcours</a>
		</div>
	</div>
</section>
