<?php
/**
 * Render callback for the Contact Block with Dynamic Map.
 */

$name = get_option('tilleuls_contact_name', 'Cabinet Ortego Sampedro');
$phone = get_option('tilleuls_contact_phone');
$email = get_option('tilleuls_contact_email');

$street = get_option('tilleuls_address_street');
$complement = get_option('tilleuls_address_complement');
$cp = get_option('tilleuls_address_zip');
$ville = get_option('tilleuls_address_city');
$pays = get_option('tilleuls_address_country');

$adresse_complete = trim($street . ' ' . $cp . ' ' . $ville . ' ' . $pays);


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
					<div class="item">
						<i class="fa-solid fa-location-dot"></i>
						<p class="info">
							<strong><?php
								echo esc_html($name); ?></strong><br>
							<?php
							if ($street) {
								echo esc_html($street);
							} ?>
							<?php
							if ($complement) echo ' - ' . esc_html($complement); ?>
							<br>
							<?php
							echo esc_html($cp . ' ' . $ville); ?>
						</p>
					</div>
					<div class="item">
						<i class="fa-solid fa-phone"></i>
						<a class="info" href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
							<?php echo esc_html($phone); ?>
						</a>
					</div>
					<div class="item">
						<i class="fa-solid fa-envelope"></i>
						<a class="info" href="mailto:<?php echo esc_attr(str_replace(' ', '', $email)); ?>">
							<?php echo esc_html($email); ?>
						</a>
					</div>
				</div>
				<div class="right">
					<?php tilleuls_ortego_blocks_render_map($adresse_complete); ?>
				</div>
			</div>
		</div>
	</div>
</section>
