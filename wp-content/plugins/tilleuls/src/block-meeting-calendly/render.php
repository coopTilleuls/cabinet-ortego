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
	'class' => 'section-meeting-calendly',
]);

$attributes = $attributes ?? [];
$calendly = $attributes['calendly'] ?? null;

?>

<section <?php echo $wrapper_attributes; ?>>
	<div class="container meeting-grid">
		<div class="meeting-info">
			<?php echo $content; ?>
		</div>
		<div class="meeting-calendar">
			<?php if ( $calendly ) : ?>
				<!-- Début de widget en ligne Calendly -->
				<div class="calendly-inline-widget" data-url="<?php echo esc_url( $calendly ); ?>" style="min-width:320px;height:700px;"></div>
				<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
				<!-- Fin de widget en ligne Calendly -->
			<?php else: ?>
				<h3>Oops une Erreur c'est produite</h3>
			<?php endif; ?>
		</div>
	</div>
</section>
