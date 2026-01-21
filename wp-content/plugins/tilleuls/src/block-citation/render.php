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
$citation = $attributes['citation'] ?? null;
$author = $attributes['author'] ?? null;

$blockWrapper = get_block_wrapper_attributes([
	'class' => 'section-citation',
]);

?>
<section <?php
echo $blockWrapper; ?>>
	<div class="container">
		<div class="quote">
			<div class="quote-icon">“</div>
			<?php if ( ! empty( $citation ) ) : ?>
			<blockquote class="blockquote">
				<?php
				echo wp_kses_post( $citation );
				?>
			</blockquote>
			<?php endif; ?>

			<?php
			if ($author) : ?>
				<span class="quote-author">
			<?php
			echo wp_kses_post($author); ?>
		</span>
			<?php
			endif; ?>
		</div>
	</div>
</section>
