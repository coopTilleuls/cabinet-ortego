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
	'class' => 'section-cta'
]);

$attributes = $attributes ?? [];
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$link = $attributes['link'] ?? '';
$linkBis = $attributes['linkBis'] ?? '';

?>


<section <?php echo $blockWrapper ?>>
	<div class="container">
		<div class="cta-body">
			<h2><?php echo wp_kses_post($title); ?></h2>
			<p><?php echo wp_kses_post($description); ?></p>
			<div class="cta-container">
				<a href="<?php echo esc_url($link); ?>" class="cta-link">Prendre rendez-vous</a>
				<?php if ( $linkBis )  : ?>
				<a href="<?php echo esc_url($link); ?>" class="cta-link-bis">Nous écrire</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
