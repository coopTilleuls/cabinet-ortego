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
$ctaLabel = $attributes['ctaLabel'] ?? '';
$ctaBisLabel = $attributes['ctaBisLabel'] ?? '';

?>
<section <?php
echo get_block_wrapper_attributes([
	'class' => 'section-hero-homepage'
]); ?>>

	<div class="container">
		<div class="hero-content">
			<?php if ($surtitle) : ?>
				<span class="surtitle"><?php echo wp_kses_post($surtitle); ?></span>
			<?php endif; ?>
			<?php
			echo $content;
			?>
			<?php if ($cta || $ctaBis) : ?>
				<div class="cta-container">
					<?php if ($cta) : ?>
						<a href="<?php echo esc_url($cta); ?>" class="cta-first"><?php echo esc_html($ctaLabel ?: __('Prendre rendez-vous', 'tilleuls')); ?></a>
					<?php endif; ?>
					<?php if ($ctaBis) : ?>
						<a href="<?php echo esc_url($ctaBis); ?>" class="cta-second"><?php echo esc_html($ctaBisLabel ?: __('Découvrir le cabinet', 'tilleuls')); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
