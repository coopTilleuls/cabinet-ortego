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
	'class' => 'profile-home',
]);

$attributes = $attributes ?? [];

$img_url = $attributes['imgUrl'] ?? '';
$languages = $attributes['languages'] ?? [];
$buttonLink = $attributes['buttonLink'] ?? '';
$buttonText = $attributes['buttonText'] ?? '';

?>

<section <?php echo $blockWrapper; ?>>
	<div class="container profile-home-grid">
		<div class="profile-home-img">
			<?php
			if (!empty($img_url)) : ?>
				<img src="<?php echo esc_url($img_url); ?>"
					 alt="<?php esc_attr_e('Photo de profil', 'tilleuls'); ?>">
			<?php
			endif; ?>
		</div>
		<div class="profile-home-content">
			<span class="profile-surtitle">À propos de l'avocate</span>
			<?php echo $content; ?>

			<div class="languages-list">
				<?php
				foreach ($languages as $lang) : ?>
					<?php
					if (!empty($lang['name'])) : ?>
						<span class="lang-badge">
                            <?php
							echo wp_kses_post($lang['name']); ?>
                         </span>
					<?php
					endif; ?>
				<?php
				endforeach; ?>
			</div>

			<a href="<?php echo esc_url($buttonLink); ?>" class="profile-cta"> <?php echo $buttonText; ?></a>
		</div>
	</div>
</section>
