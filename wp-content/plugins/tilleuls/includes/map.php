<?php
/**
 * Shared rendering helpers for blocks displaying the firm's address on a map.
 *
 * @package TilleulsOrtegoBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Print a Google Maps embed for the given address, or a placeholder when the address is not configured.
 *
 * @param string $address Full postal address.
 */
function tilleuls_ortego_blocks_render_map( string $address ): void {
	if ( strlen( $address ) <= 5 ) : ?>
		<div style="background-color: #eee; height: 100%; min-height: 300px; display: flex; align-items: center; justify-content: center; color: #999; flex-direction: column;">
			<i class="fa-solid fa-map-slash" style="font-size: 2rem; margin-bottom: 10px;" aria-hidden="true"></i>
			<span>Adresse non configurée</span>
		</div>
		<?php
		return;
	endif;

	$src = add_query_arg(
		array(
			'q'      => rawurlencode( $address ),
			't'      => 'm',
			'z'      => 15,
			'output' => 'embed',
			'iwloc'  => 'near',
		),
		'https://maps.google.com/maps'
	);
	?>
	<iframe
		title="<?php echo esc_attr( sprintf( 'Plan d\'accès : %s', $address ) ); ?>"
		width="100%"
		height="100%"
		style="border:0; width: 100%; height: 100%; min-height: 300px;"
		loading="lazy"
		referrerpolicy="no-referrer-when-downgrade"
		allowfullscreen
		src="<?php echo esc_url( $src ); ?>">
	</iframe>
	<?php
}
