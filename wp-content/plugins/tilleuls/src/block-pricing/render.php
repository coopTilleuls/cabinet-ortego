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
	'class' => 'section-pricing'
]);


$attributes = $attributes ?? [];
$pricingCards = $attributes['pricingCards'] ?? [];

?>
<section <?php echo $blockWrapper; ?>>
	<div class="container">
		<?php echo $content; ?>
		<div class="pricing-grid">
			<?php foreach( $pricingCards as $card ): ?>
				<div class="price-card <?php if ($card['isFeatured']): ?>featured<?php endif; ?>">
					<div class="price-header">
						<h3 class="price-title">
							<?php echo wp_kses_post($card['title']); ?>
						</h3>
						<div class="price-amount">
							<span>
								<?php echo wp_kses_post($card['price']); ?>
							</span>
							<span class="price-unit">
								<?php echo wp_kses_post($card['unit']); ?>
							</span>
						</div>
					</div>
					<div class="price-features">
						<ul>
							<?php foreach( $card['features'] as $feature ): ?>
								<li>
									<i class="fa-solid fa-check"></i>
									<span><?php echo wp_kses_post($feature); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
