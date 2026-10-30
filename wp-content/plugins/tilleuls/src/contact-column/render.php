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

$blockWrapper = get_block_wrapper_attributes(
	[
		'class' => 'section-contact-map-column',
	]
);

$contact = tilleuls_ortego_blocks_contact();

?>
<div <?php
echo $blockWrapper; ?>>
	<div class="contact-details">
		<h2><?php esc_html_e('Nos coordonnées', 'tilleuls'); ?></h2>
		<div class="info-card">
			<?php if ($contact['name'] || $contact['address']) : ?>
				<div class="info-item">
					<i aria-hidden="true" class="fa-solid fa-location-dot"></i>
					<div>
						<h3><?php esc_html_e('Adresse', 'tilleuls'); ?></h3>
						<p>
							<?php if ($contact['name']) : ?>
								<strong><?php echo esc_html($contact['name']); ?></strong><br>
							<?php endif; ?>
							<?php tilleuls_ortego_blocks_render_address($contact); ?>
						</p>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($contact['phone']) : ?>
				<div class="info-item">
					<i aria-hidden="true" class="fa-solid fa-phone"></i>
					<div>
						<h3><?php esc_html_e('Téléphone', 'tilleuls'); ?></h3>
						<p>
							<a href="tel:<?php echo esc_attr(str_replace(' ', '', $contact['phone'])); ?>">
								<?php echo esc_html($contact['phone']); ?>
							</a>
						</p>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($contact['email']) : ?>
				<div class="info-item">
					<i aria-hidden="true" class="fa-solid fa-envelope"></i>
					<div>
						<h3><?php esc_html_e('Email', 'tilleuls'); ?></h3>
						<p>
							<a href="mailto:<?php echo esc_attr($contact['email']); ?>">
								<?php echo esc_html($contact['email']); ?>
							</a>
						</p>
					</div>
				</div>
			<?php endif; ?>
			<?php if ($contact['hours']) : ?>
				<div class="info-item">
					<i aria-hidden="true" class="fa-solid fa-clock"></i>
					<div>
						<h3><?php esc_html_e('Horaires d\'ouverture', 'tilleuls'); ?></h3>
						<p><?php tilleuls_ortego_blocks_render_hours($contact['hours']); ?></p>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="map-container">
		<?php tilleuls_ortego_blocks_render_map($contact['address']); ?>
	</div>
</div>
