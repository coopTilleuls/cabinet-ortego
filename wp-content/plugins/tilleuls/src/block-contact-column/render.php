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

$name = get_option('tilleuls_contact_name', 'Cabinet Ortego Sampedro');
$phone = get_option('tilleuls_contact_phone');
$email = get_option('tilleuls_contact_email');

$street = get_option('tilleuls_address_street');
$complement = get_option('tilleuls_address_complement');
$cp = get_option('tilleuls_address_zip');
$ville = get_option('tilleuls_address_city');
$pays = get_option('tilleuls_address_country');

$adresse_complete = trim($street . ' ' . $cp . ' ' . $ville . ' ' . $pays);

$adresse_encoded = urlencode($adresse_complete);

?>
<div <?php
echo $blockWrapper; ?>>
	<div class="contact-details">
		<h2>Nos Coordonées</h2>
		<div class="info-card">
			<div class="info-item">
				<i class="fa-solid fa-location-dot"></i>
				<div>
					<h4>Adresse</h4>
					<p>
						<?php
						if ($street) {
							echo esc_html($street);
						} ?>
						<?php
						if ($complement) {
							echo ' - ' . esc_html($complement);
						} ?>
						<br>
						<?php
						echo esc_html($cp . ' ' . $ville); ?>
					</p>
				</div>
			</div>
			<div class="info-item">
				<i class="fa-solid fa-phone"></i>
				<div>
					<h4>Téléphone</h4>
					<p>
						<a href="tel:<?php
						echo esc_attr(str_replace(' ', '', $phone)); ?>">
							<?php
							echo esc_html($phone); ?>
						</a>
					</p>
				</div>
			</div>
			<div class="info-item">
				<i class="fa-solid fa-envelope"></i>
				<div>
					<h4>Email</h4>
					<p>
						<a href="mailto:<?php
						echo esc_attr(str_replace(' ', '', $email)); ?>">
							<?php
							echo esc_html($email); ?>
						</a>
					</p>
				</div>
			</div>
			<div class="info-item">
				<i class="fa-solid fa-clock"></i>
				<div>
					<h4>Horaires d'ouverture</h4>
					<p></p>
				</div>
			</div>
		</div>
	</div>
	<div class="map-container">
		<?php
		if (!empty($adresse_complete) && strlen($adresse_complete) > 5) : ?>
			<iframe
				width="100%"
				height="100%"
				style="border:0; width: 100%; height: 100%; min-height: 300px;"
				loading="lazy"
				allowfullscreen
				src="https://maps.google.com/maps?q=<?php
				echo $adresse_encoded; ?>&t=m&z=15&output=embed&iwloc=near">
			</iframe>
		<?php
		else : ?>
			<div
				style="background-color: #eee; height: 100%; min-height: 300px; display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column;">
				<i class="fa-solid fa-map-slash" style="font-size: 2rem; margin-bottom: 10px;"></i>
				<span>Adresse non configurée</span>
			</div>
		<?php
		endif; ?>
	</div>
</div>
