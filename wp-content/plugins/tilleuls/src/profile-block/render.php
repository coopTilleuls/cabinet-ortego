<?php
/**
 * Render callback for the block.
 *
 * @var array $attributes Block attributes.
 * @var string $content Block content
 * @var WP_Block $block Block instance.
 */

declare(strict_types=1);

$attributes = $attributes ?? [];

$bio = $attributes['bio'] ?? '';
$img_id = $attributes['imgId'] ?? '';
$img_url = $attributes['imgUrl'] ?? '';
$languages = $attributes['languages'] ?? '';
$diplomas = $attributes['diplomas'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'profile-section',
]);

var_dump(wp_kses_post( $content ));

?>

<section <?php
echo $wrapper_attributes; ?>>
	<div class="container profile-grid">

		<div class="profile-img-container">
			<?php
			if (!empty($img_url)) : ?>
				<img src="<?php
				echo esc_url($img_url); ?>" alt="<?php
				esc_attr_e('Photo de profil', 'tilleuls'); ?>">
			<?php
			endif; ?>

			<?php
			if (!empty($languages)) : ?>
				<div class="languages-bar">
					<?php
					echo $languages; ?>
				</div>
			<?php
			endif; ?>
		</div>

		<div class="bio-text">
			<div class="bio-text">
				<?php echo wp_kses_post( $content ); ?>
			</div>

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
					<?php
					echo $diplomas; ?>
				</div>
			<?php
			endif; ?>

		</div>
	</div>
</section>
