import { useSelect } from '@wordpress/data';

/**
 * Firm contact details from Réglages > Général (options registered by the theme), for the editor preview.
 *
 * @return {Object} Contact details; empty strings for fields not filled in.
 */
export function useContact() {
	const site = useSelect(
		( select ) => select( 'core' ).getEntityRecord( 'root', 'site' ),
		[]
	);

	const contact = {
		name: site?.tilleuls_contact_name ?? '',
		street: site?.tilleuls_address_street ?? '',
		complement: site?.tilleuls_address_complement ?? '',
		zip: site?.tilleuls_address_zip ?? '',
		city: site?.tilleuls_address_city ?? '',
		country: site?.tilleuls_address_country ?? '',
		phone: site?.tilleuls_contact_phone ?? '',
		email: site?.tilleuls_contact_email ?? '',
		hours: site?.tilleuls_opening_hours ?? '',
	};

	contact.address = [
		contact.street,
		contact.zip,
		contact.city,
		contact.country,
	]
		.filter( Boolean )
		.join( ' ' );

	return contact;
}

/**
 * Text lines with a <br /> between them; empty lines are skipped.
 *
 * @param {Object}   props
 * @param {string[]} props.lines Lines to display.
 * @return {Element[]} Lines separated by line breaks.
 */
export function Lines( { lines } ) {
	return lines.filter( Boolean ).map( ( line, index ) => (
		<span key={ index }>
			{ index > 0 && <br /> }
			{ line }
		</span>
	) );
}

/**
 * Postal address lines (street - complement, then zip and city).
 *
 * @param {Object} contact Contact details from useContact().
 * @return {string[]} Address lines.
 */
export function addressLines( contact ) {
	return [
		[ contact.street, contact.complement ].filter( Boolean ).join( ' - ' ),
		[ contact.zip, contact.city ].filter( Boolean ).join( ' ' ),
	];
}
