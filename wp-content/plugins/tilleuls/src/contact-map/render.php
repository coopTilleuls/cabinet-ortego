<?php
/**
 * Render callback for the Contact Block with Dynamic Map.
 */

$contact = tilleuls_ortego_blocks_contact();

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'section-contact-map',
]);

?>

<section <?php
echo $wrapper_attributes; ?>>
	<div class="container contact-container">
		<div class="container">
			<div class="contact-map-grid">
				<div class="left">
					<?php
					echo $content;
					?>
					<?php if ($contact['name'] || $contact['address']) : ?>
						<div class="item">
							<i aria-hidden="true" class="fa-solid fa-location-dot"></i>
							<p class="info">
								<?php if ($contact['name']) : ?>
									<strong><?php echo esc_html($contact['name']); ?></strong><br>
								<?php endif; ?>
								<?php tilleuls_ortego_blocks_render_address($contact); ?>
							</p>
						</div>
					<?php endif; ?>
					<?php if ($contact['phone']) : ?>
						<div class="item">
							<i aria-hidden="true" class="fa-solid fa-phone"></i>
							<a class="info" href="tel:<?php echo esc_attr(str_replace(' ', '', $contact['phone'])); ?>">
								<?php echo esc_html($contact['phone']); ?>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($contact['email']) : ?>
						<div class="item">
							<i aria-hidden="true" class="fa-solid fa-envelope"></i>
							<a class="info" href="mailto:<?php echo esc_attr($contact['email']); ?>">
								<?php echo esc_html($contact['email']); ?>
							</a>
						</div>
					<?php endif; ?>
					<?php if ($contact['hours']) : ?>
						<div class="item">
							<i aria-hidden="true" class="fa-solid fa-clock"></i>
							<p class="info"><?php tilleuls_ortego_blocks_render_hours($contact['hours']); ?></p>
						</div>
					<?php endif; ?>
				</div>
				<div class="right">
					<?php tilleuls_ortego_blocks_render_map($contact['address']); ?>
				</div>
			</div>
		</div>
	</div>
</section>
