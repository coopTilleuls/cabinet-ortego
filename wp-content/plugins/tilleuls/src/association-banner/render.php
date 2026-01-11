<?php
/**
 * Render callback for the block.
 */

$attributes = $attributes ?? [];
$color = $attributes['color'] ?? 'black';
$items = $attributes['items'] ?? [];

$wrapper_attributes = get_block_wrapper_attributes([
	'class' => 'associations-banner ' . esc_attr( $color ),
]);

$icons_map = [
	'gavel'     => 'fa-solid fa-gavel',
	'handcuffs' => 'fa-solid fa-handcuffs',
	'passport'  => 'fa-solid fa-passport',
	'scale'     => 'fa-solid fa-scale-balanced',
	'star'      => 'fa-solid fa-star',
];

?>

<section <?php echo $wrapper_attributes; ?>>
	<div class="container associations-flex">

		<?php if ( ! empty( $items ) ) : ?>
			<?php foreach ( $items as $item ) : ?>
				<div class="asso-item">
					<?php
					$icon_key = $item['icon'] ?? '';
					if ( ! empty( $icon_key ) && isset( $icons_map[ $icon_key ] ) ) :
						$icon_class = $icons_map[ $icon_key ];
						?>
						<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
					<?php
					elseif ( ! empty( $icon_key ) ) :
						?>
						<i class="<?php echo esc_attr( $icon_key ); ?>"></i>
					<?php endif; ?>
					<?php if ( ! empty( $item['text'] ) ) : ?>
						<span><?php echo wp_kses_post( $item['text'] ); ?></span>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</section>
