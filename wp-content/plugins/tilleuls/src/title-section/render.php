<?php
/**
 * Dynamic Block: Title Section
 */

declare(strict_types=1);

$attributes = $attributes ?? [];

$title = $attributes['title'] ?? 'Engagement & Expertise';
$subtitle = $attributes['subtitle'] ?? '';
$blockPosition = $attributes['blockPosition'] ?? 'left';
$size = $attributes['size'] ?? '';
$color = $attributes['color'] ?? 'left';

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'title-section ' . $blockPosition . ' ' . $size . ' ' . $color,
]);
?>

<section <?php echo $wrapper_attributes; ?>>
	<h2><?php echo esc_html( $title ); ?></h2>

	<?php if ( $subtitle ) : ?>
		<span class="subtitle">
			<?php echo esc_html( $subtitle ); ?>
		</span>
	<?php endif; ?>

	<div class="separator" ></div>
</section>
