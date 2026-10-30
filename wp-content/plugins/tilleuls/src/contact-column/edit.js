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
import { useBlockProps } from '@wordpress/block-editor';

import { __ } from '@wordpress/i18n';

import { addressLines, Lines, useContact } from '../lib/contact';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	const blockName = useBlockProps( {
		className: 'section-contact-map-column',
	} );

	const contact = useContact();
	const addressEncoded = encodeURIComponent( contact.address );

	return (
		<div { ...blockName }>
			<div className="contact-details">
				<h2>{ __( 'Nos coordonnées', 'tilleuls' ) }</h2>
				<div className="info-card">
					{ ( contact.name || contact.address ) && (
						<div className="info-item">
							<i
								aria-hidden="true"
								className="fa-solid fa-location-dot"
							></i>
							<div>
								<h3>{ __( 'Adresse', 'tilleuls' ) }</h3>
								<p>
									{ contact.name && (
										<>
											<strong>{ contact.name }</strong>
											<br />
										</>
									) }
									<Lines lines={ addressLines( contact ) } />
								</p>
							</div>
						</div>
					) }
					{ contact.phone && (
						<div className="info-item">
							<i
								aria-hidden="true"
								className="fa-solid fa-phone"
							></i>
							<div>
								<h3>{ __( 'Téléphone', 'tilleuls' ) }</h3>
								<p>{ contact.phone }</p>
							</div>
						</div>
					) }
					{ contact.email && (
						<div className="info-item">
							<i
								aria-hidden="true"
								className="fa-solid fa-envelope"
							></i>
							<div>
								<h3>{ __( 'Email', 'tilleuls' ) }</h3>
								<p>{ contact.email }</p>
							</div>
						</div>
					) }
					{ contact.hours && (
						<div className="info-item">
							<i
								aria-hidden="true"
								className="fa-solid fa-clock"
							></i>
							<div>
								<h3>
									{ __( "Horaires d'ouverture", 'tilleuls' ) }
								</h3>
								<p>
									<Lines
										lines={ contact.hours.split( '\n' ) }
									/>
								</p>
							</div>
						</div>
					) }
				</div>
			</div>
			<div className="map-container">
				<iframe
					title={ __( 'Aperçu Google Map', 'tilleuls' ) }
					width="100%"
					height="100%"
					style={ {
						border: 0,
						width: '100%',
						height: '100%',
						minHeight: '300px',
						filter: 'grayscale(100%)',
						pointerEvents: 'none',
					} }
					src={ `https://maps.google.com/maps?q=${ addressEncoded }&t=m&z=15&output=embed&iwloc=near&hl=fr` }
				></iframe>
			</div>
		</div>
	);
}
