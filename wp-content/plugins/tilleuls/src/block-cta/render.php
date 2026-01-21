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
	'class' => 'section-cta'
]);

$attributes = $attributes ?? [];
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$ctas = $attributes['cta'] ?? [];

$phone = get_option('tilleuls_contact_phone');

?>


<section <?php echo $blockWrapper ?>>
	<div class="container cta-body">
		<h2><?php echo wp_kses_post($title); ?></h2>
		<p><?php echo wp_kses_post($description); ?></p>
		<div class="cta-container">
			<?php if ( ! empty( $ctas ) ) : ?>
				<?php foreach ( $ctas as $index => $link ) : ?>
					<?php
					if ( $link['linkType'] === 'tel' ) {
						$href = 'tel:' . $phone;
					} elseif ( $link['linkType'] === 'mailto' ) {
						$href = 'mailto:' . $link['url'];
					} else {
						$href = $link['url'];
					}
					if ( $link['linkType'] === 'tel' ) {
						$icon = 'fa-phone';
					} elseif ( $link['linkType'] === 'mailto' ) {
						$icon = 'fa-envelope';
					} else {
						$icon = 'fa-address-book';
					}
					?>

					<a
						href="<?php echo esc_url( $href ); ?>"
						class="cta-link <?php echo esc_attr( $link['style'] ); ?>"
					>
						<i class="fa-solid <?php echo esc_attr( $icon ); ?>"></i>
						<strong><?php echo esc_html( $link['text'] ); ?></strong>
					</a>

				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>
