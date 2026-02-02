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

<div <?php
echo $wrapper_attributes; ?>>
	<?php
	if ($size === 'sm')  : ?>
		<h2><?php
			echo esc_html($title); ?></h2>
	<?php
	elseif ($size === 'xl')  : ?>
		<h1><?php
			echo esc_html($title); ?></h1>
	<?php
	else : ?>
		<h2><?php
			echo esc_html($title); ?></h2>
	<?php
	endif; ?>

	<?php
	if ($subtitle) : ?>
		<span class="subtitle">
			<?php
			echo esc_html($subtitle); ?>
		</span>
	<?php
	endif; ?>

	<div class="separator"></div>
</div>
