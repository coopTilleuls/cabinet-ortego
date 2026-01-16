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

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'hero-page',
]);

$attributes = $attributes ?? [];
$description = $attributes['description'] ?? '';

?>
<div <?php echo $wrapper_attributes; ?>>
	<?php
	echo $content;
	?>
	<?php if ( ! empty( $description ) ) : ?>
		<p class="description"><?php echo wp_kses_post( $description ); ?></p>
	<?php endif; ?>
</div>
