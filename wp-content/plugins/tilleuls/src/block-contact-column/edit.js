/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {useSelect} from "@wordpress/data";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	const {} = attributes;

	const blockName = useBlockProps({
		className: 'section-contact-map-column'
	})


	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}]
	];

	const contactName = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_contact_name,
		[]
	);

	const contactAddress = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_address_street,
		[]
	);

	const contactAddressComplement = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_address_complement,
		[]
	);

	const contactZipcode = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_address_zip,
		[]
	);


	const contactCity = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_address_city,
		[]
	);

	const contactCountry = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_address_country,
		[]
	);

	const contactPhone = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_contact_phone,
		[]
	);

	const contactEmail = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_contact_email,
		[]
	);

	const addressParts = [
		contactAddress,
		contactZipcode,
		contactCity,
		contactCountry
	].filter(Boolean);

	const addressComplete = addressParts.join(' ');
	const addressEncoded = encodeURIComponent(addressComplete);

	return (
		<div {...blockName}>
			<div className="contact-details">
				<h2>Nos Coordonnées</h2>
				<div className="info-card">
					<div className="info-item">
						<i className="fa-solid fa-location-dot"></i>
						<div>
							<h4>Adresse</h4>
							<p>
								{contactAddress} <br/>
								{contactAddressComplement ?
									(<>
										{contactAddressComplement} <br/>
									</>) : null
								}
								{contactZipcode} - {contactCity} <br/>
								{contactCountry}
							</p>
						</div>
					</div>
					<div className="info-item">
						<i className="fa-solid fa-phone"></i>
						<div>
							<h4>Téléphone</h4>
							<p>
								<a href={`tel:${contactPhone}`}></a>
							</p>
						</div>
					</div>
					<div className="info-item">
						<i className="fa-solid fa-envelope"></i>
						<div>
							<h4>Email</h4>
							<p>
								<a href={`mailto:${contactEmail}`}></a>
							</p>
						</div>
					</div>
					<div className="info-item">
						<i className="fa-solid fa-clock"></i>
						<div>
							<h4>Horaires d'ouverture</h4>
							<p>
								{contactName} <br/>
								Sur rendez-vous uniquement.
							</p>
						</div>
					</div>
				</div>
			</div>
			<div className="map-container">
				<iframe
					title="Aperçu Google Map"
					width="100%"
					height="100%"
					style={{
						border: 0,
						width: '100%',
						height: '100%',
						minHeight: '300px',
						filter: 'grayscale(100%)',
						pointerEvents: 'none'
					}}
					src={`https://maps.google.com/maps?q=${addressEncoded}&t=m&z=15&output=embed&iwloc=near&hl=fr`}
				>
				</iframe>
			</div>
		</div>
	);
}
