<?php
/**
 * Render callback for the block.
 */

$attributes = $attributes ?? [];

$bio = $attributes['bio'] ?? '';
$img_url = $attributes['imgUrl'] ?? '';
$languages = $attributes['languages'] ?? [];
$diplomas = $attributes['diplomas'] ?? [];

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'profile-section',
	'id' => 'profil'
]);

?>

<section <?php
echo $wrapper_attributes; ?>>
	<div class="container">
		<div class="profile-grid">
			<div class="profile-img-container">
				<?php
				if (!empty($img_url)) : ?>
					<img src="<?php
					echo esc_url($img_url); ?>" alt="<?php
					esc_attr_e('Photo de profil', 'tilleuls'); ?>">
				<?php
				endif; ?>

				<div class="languages-container">
					<h4><?php
						esc_html_e('Langues parlées :', 'tilleuls'); ?></h4>
					<div>
						<?php
						foreach ($languages as $lang) : ?>
							<?php
							if (!empty($lang['name'])) : ?>
								<span class="lang-tag">
                            <?php
							echo wp_kses_post($lang['name']); ?>
                         </span>
							<?php
							endif; ?>
						<?php
						endforeach; ?>
					</div>
				</div>
			</div>
			<div class="bio-text">

				<?php
				echo $content;
				?>

				<?php
				if (!empty($bio)) : ?>
					<div class="bio-content">
						<?php
						echo $bio; ?>
					</div>
				<?php
				endif; ?>

				<?php
				if (!empty($diplomas)) : ?>
					<div class="diploma-list">
						<h4>Formation Universitaire</h4>
						<ul>
							<?php
							foreach ($diplomas as $item) : ?>
								<li>
									<i class="fa-solid fa-graduation-cap"></i>
									<?php
									if (!empty($item['text'])) : ?>
										<span>
								<?php
								echo wp_kses_post($item['text']); ?>
							 </span>
									<?php
									endif; ?>
								</li>
							<?php
							endforeach; ?>
						</ul>
					</div>
				<?php
				endif; ?>
			</div>
		</div>
	</div>
</section>
