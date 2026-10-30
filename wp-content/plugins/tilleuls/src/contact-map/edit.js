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
import { InnerBlocks, useBlockProps } from '@wordpress/block-editor';

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
		className: 'section-contact-map',
	} );

	const INNER_BLOCKS = [ [ 'tilleuls-ortego-blocks/section-title', {} ] ];

	const contact = useContact();
	const addressComplete = contact.address;
	const addressEncoded = encodeURIComponent( addressComplete );

	return (
		<section { ...blockName }>
			<div className="container">
				<div className="contact-map-grid">
					<div className="left">
						<InnerBlocks template={ INNER_BLOCKS } />
						{ ( contact.name || contact.address ) && (
							<div className="item">
								<i
									aria-hidden="true"
									className="fa-solid fa-location-dot"
								></i>
								<p className="info">
									{ contact.name && (
										<>
											<strong>{ contact.name }</strong>
											<br />
										</>
									) }
									<Lines lines={ addressLines( contact ) } />
								</p>
							</div>
						) }
						{ contact.phone && (
							<div className="item">
								<i
									aria-hidden="true"
									className="fa-solid fa-phone"
								></i>
								<p className="info">{ contact.phone }</p>
							</div>
						) }
						{ contact.email && (
							<div className="item">
								<i
									aria-hidden="true"
									className="fa-solid fa-envelope"
								></i>
								<p className="info">{ contact.email }</p>
							</div>
						) }
						{ contact.hours && (
							<div className="item">
								<i
									aria-hidden="true"
									className="fa-solid fa-clock"
								></i>
								<p className="info">
									<Lines
										lines={ contact.hours.split( '\n' ) }
									/>
								</p>
							</div>
						) }
					</div>
					<div
						className="right"
						style={ {
							minHeight: '300px',
							position: 'relative',
							backgroundColor: '#f0f0f0',
						} }
					>
						{ addressComplete.length > 5 ? (
							<iframe
								title="Aperçu Google Map"
								width="100%"
								height="100%"
								style={ {
									border: 0,
									width: '100%',
									height: '100%',
									minHeight: '300px',
									filter: 'grayscale(100%)',
									pointerEvents: 'none', // Empêche de scroller la map dans l'éditeur (ergonomie)
								} }
								src={ `https://maps.google.com/maps?q=${ addressEncoded }&t=m&z=15&output=embed&iwloc=near&hl=fr` }
							></iframe>
						) : (
							<div
								style={ {
									height: '100%',
									minHeight: '300px',
									display: 'flex',
									flexDirection: 'column',
									alignItems: 'center',
									justifyContent: 'center',
									color: '#999',
								} }
							>
								<i
									className="fa-solid fa-map-slash"
									style={ {
										fontSize: '3rem',
										marginBottom: '15px',
									} }
								></i>
								<span>
									{ __(
										"Renseignez l'adresse dans les réglages",
										'tilleuls'
									) }
								</span>
								<span>
									{ __( 'pour voir la carte.', 'tilleuls' ) }
								</span>
							</div>
						) }
					</div>
				</div>
			</div>
		</section>
	);
}
