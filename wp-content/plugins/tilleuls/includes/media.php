<?php
/**
 * Shared media helpers for block render callbacks.
 *
 * @package TilleulsOrtegoBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Alternative text of an attachment, as entered in the media library, with a fallback.
 *
 * @param int    $attachment_id Attachment ID (0 when no image is selected).
 * @param string $fallback      Text used when the attachment has no alt text.
 * @return string Alternative text.
 */
function tilleuls_ortego_blocks_image_alt( int $attachment_id, string $fallback ): string {
	$alt = $attachment_id ? (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) : '';

	return '' === $alt ? $fallback : $alt;
}
