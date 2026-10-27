<?php
/**
 * Firm contact details, read from the options registered by the theme (Réglages > Général).
 *
 * @package TilleulsOrtegoBlocks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Contact details of the firm. Empty strings when a field is not filled in.
 *
 * @return array{name: string, street: string, complement: string, zip: string, city: string, country: string, phone: string, email: string, hours: string, address: string}
 */
function tilleuls_ortego_blocks_contact(): array {
	$contact = array(
		'name'       => (string) get_option( 'tilleuls_contact_name', '' ),
		'street'     => (string) get_option( 'tilleuls_address_street', '' ),
		'complement' => (string) get_option( 'tilleuls_address_complement', '' ),
		'zip'        => (string) get_option( 'tilleuls_address_zip', '' ),
		'city'       => (string) get_option( 'tilleuls_address_city', '' ),
		'country'    => (string) get_option( 'tilleuls_address_country', '' ),
		'phone'      => (string) get_option( 'tilleuls_contact_phone', '' ),
		'email'      => (string) get_option( 'tilleuls_contact_email', '' ),
		'hours'      => (string) get_option( 'tilleuls_opening_hours', '' ),
	);

	// Full address used to locate the firm on the map.
	$contact['address'] = implode( ' ', array_filter( array( $contact['street'], $contact['zip'], $contact['city'], $contact['country'] ) ) );

	return $contact;
}

/**
 * Print the postal address lines (street - complement, then zip and city).
 *
 * @param array $contact Contact details from tilleuls_ortego_blocks_contact().
 */
function tilleuls_ortego_blocks_render_address( array $contact ): void {
	$street = implode( ' - ', array_filter( array( $contact['street'], $contact['complement'] ) ) );
	$city   = trim( $contact['zip'] . ' ' . $contact['city'] );

	echo implode( '<br>', array_map( 'esc_html', array_filter( array( $street, $city ) ) ) );
}

/**
 * Print the opening hours, one line per time slot as typed in the settings.
 *
 * @param string $hours Opening hours (multi-line text).
 */
function tilleuls_ortego_blocks_render_hours( string $hours ): void {
	echo nl2br( esc_html( $hours ) );
}
