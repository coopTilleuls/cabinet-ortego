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

$attributes = $attributes ?? [];
$surtitle = $attributes['surtitle'] ?? '';
$cta = $attributes['cta'] ?? '';
$ctaBis = $attributes['ctaBis'] ?? '';

?>
<section <?php
echo get_block_wrapper_attributes([
	'class' => 'section-hero-homepage'
]); ?>>

	<div class="container">
		<div class="hero-content">
			<span class="surtitle"><?php echo wp_kses_post($surtitle); ?></span>
			<?php
			echo $content;
			?>
			<div class="cta-container">
				<a href="<?php echo esc_url($cta); ?>" class="cta-first">Prendre rendez-vous</a>
				<a href="<?php echo esc_url($ctaBis); ?>" class="cta-second">Decouvrir le cabinet</a>
			</div>
		</div>
	</div>
</section>
