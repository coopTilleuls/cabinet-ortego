/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {InnerBlocks, useBlockProps} from '@wordpress/block-editor';

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
export default function Edit() {
	const blockName = useBlockProps({
		className: 'section-contact-map'
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
		<section { ...blockName }>
			<div className="container">
				<div className="contact-map-grid">
					<div className="left">
						<InnerBlocks
							template={INNER_BLOCKS}
						/>
						<div className="item">
							<i className="fa-solid fa-location-dot"></i>
							<p>
								<span>{contactName}</span> <br/>
								{contactAddress} -  {contactAddressComplement}<br/>
								{contactZipcode} - {contactCity} <br/>
								{contactCountry}
							</p>
						</div>
						<div className="item">
							<i className="fa-solid fa-phone"></i>
							<p className="info">
								<strong>{contactPhone}</strong>
							</p>
						</div>
						<div className="item">
							<i className="fa-solid fa-envelope"></i>
							<p>
								<span>{contactEmail}</span>
							</p>
						</div>
					</div>
					<div className="right" style={{ minHeight: '300px', position: 'relative', backgroundColor: '#f0f0f0' }}>
						{addressComplete.length > 5 ? (
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
									pointerEvents: 'none' // Empêche de scroller la map dans l'éditeur (ergonomie)
								}}
								src={`https://maps.google.com/maps?q=${addressEncoded}&t=m&z=15&output=embed&iwloc=near&hl=fr`}
							>
							</iframe>
						) : (
							<div style={{
								height: '100%',
								minHeight: '300px',
								display: 'flex',
								flexDirection: 'column',
								alignItems: 'center',
								justifyContent: 'center',
								color: '#999'
							}}>
								<i className="fa-solid fa-map-slash" style={{ fontSize: '3rem', marginBottom: '15px' }}></i>
								<span>{__('Renseignez l\'adresse dans les réglages', 'tilleuls')}</span>
								<span>{__('pour voir la carte.', 'tilleuls')}</span>
							</div>
						)}
					</div>
				</div>
			</div>
		</section>
	);
}
