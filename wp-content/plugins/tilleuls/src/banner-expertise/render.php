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
$items = $attributes['items'] ?? [];

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'section-expertise',
]);

$icons_map = [
	'criminalLaw' => 'fa-solid fa-scale-balanced',
	'immigrationLaw' => 'fa-solid fa-earth-europe',
	'prisonLaw' => 'fa-solid fa-lock',
	'fundamentalFreedoms' => 'fa-solid fa-hand-holding-heart',
];


?>
<section <?php echo $wrapper_attributes; ?>>
	<div class="container">

		<?php
		echo $content;
		?>

		<?php if ( ! empty( $items ) ) : ?>
			<div class="expertises-grid">
				<?php foreach ( $items as $item ) : ?>
					<?php
					$title = $item['title'] ?? '';
					$description = $item['description'] ?? '';
					$icon_key = $item['icon'] ?? '';
					$icon_class = $icons_map[ $icon_key ] ?? 'fa-solid fa-question';
					?>

					<div class="expertise-card">
						<h3>
							<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
							<?php echo wp_kses_post( $title ); ?>
						</h3>
						<p><?php echo wp_kses_post( $description ); ?></p>
					</div>

				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
