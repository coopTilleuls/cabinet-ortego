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

$imgPosition = $attributes['imgPosition'] ?? '';
$icon = $attributes['icon'] ?? '';
$title = $attributes['title'] ?? '';
$titleIcon = $attributes['titleIcon'] ?? '';

$classWrapper = get_block_wrapper_attributes([
	'class' => 'section-expertise-page has-img-' . $imgPosition,
]);



?>
<section <?php echo $classWrapper; ?>>
	<div class="container">
		<div class="expertises-grid">
			<div class="expertise-content">
				<h2>
					<?php if (!empty($titleIcon)) : ?>
						<i class="<?php
							echo wp_kses_post($titleIcon); ?>"></i>
					<?php
					endif; ?>
					<?php echo wp_kses_post($title); ?>
				</h2>
				<?php
				echo $content;
				?>
			</div>
			<div class="expertise-visual">
				<i class="<?php
				echo wp_kses_post($icon); ?>"></i>
			</div>
		</div>
	</div>
</section>
