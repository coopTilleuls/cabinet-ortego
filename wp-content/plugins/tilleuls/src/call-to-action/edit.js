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
import {
	InspectorControls,
	RichText,
	useBlockProps,
} from '@wordpress/block-editor';

import {
	Button,
	PanelBody,
	SelectControl,
	TextControl,
} from '@wordpress/components';
import { useSelect } from '@wordpress/data';

const LINK_HELP = {
	mailto: 'ex: contact@site.com',
	tel: 'ex: +33612345678',
};

const getHref = ( button, phone ) => {
	if ( button.linkType === 'tel' ) {
		return `tel:${ phone }`;
	}
	if ( button.linkType === 'mailto' ) {
		return `mailto:${ button.url }`;
	}
	return button.url;
};

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   root0
 * @param {Object}   root0.attributes    Block attributes.
 * @param {Function} root0.setAttributes Block attributes setter.
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { title, description, cta } = attributes;

	const contactPhone = useSelect(
		( select ) =>
			select( 'core' ).getEntityRecord( 'root', 'site' )
				?.tilleuls_contact_phone,
		[]
	);

	const updateCTA = ( index, field, value ) => {
		const newCTA = [ ...cta ];
		newCTA[ index ] = {
			...newCTA[ index ],
			[ field ]: value,
		};
		setAttributes( { cta: newCTA } );
	};

	const addCTA = () => {
		setAttributes( {
			cta: [
				...cta,
				{
					text: '',
					linkType: 'url',
					url: '',
					style: 'primary',
				},
			],
		} );
	};

	const removeCTA = ( index ) => {
		const newCTA = cta.filter( ( _, i ) => i !== index );
		setAttributes( { cta: newCTA } );
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title="Boutons (CTA)" initialOpen={ true }>
					{ cta.map( ( button, index ) => (
						<div
							key={ index }
							style={ {
								marginBottom: '20px',
								paddingBottom: '20px',
								borderBottom: '1px solid #ddd',
							} }
						>
							<SelectControl
								label="Type de lien"
								value={ button.linkType }
								options={ [
									{ label: 'Lien classique', value: 'url' },
									{
										label: 'Email (mailto)',
										value: 'mailto',
									},
									{ label: 'Téléphone (tel)', value: 'tel' },
								] }
								onChange={ ( value ) =>
									updateCTA( index, 'linkType', value )
								}
							/>

							<TextControl
								label="Lien"
								help={
									LINK_HELP[ button.linkType ] ??
									'ex: https://monsite.com'
								}
								value={ button.url }
								onChange={ ( value ) =>
									updateCTA( index, 'url', value )
								}
							/>
							<TextControl
								label="Texte du bouton"
								value={ button.text }
								onChange={ ( value ) =>
									updateCTA( index, 'text', value )
								}
							/>

							<SelectControl
								label="Style du bouton"
								value={ button.style }
								options={ [
									{ label: 'Primaire', value: 'primary' },
									{ label: 'Secondaire', value: 'secondary' },
									{ label: 'Outline', value: 'outline' },
								] }
								onChange={ ( value ) =>
									updateCTA( index, 'style', value )
								}
							/>

							<Button
								isDestructive
								onClick={ () => removeCTA( index ) }
							>
								Supprimer ce bouton
							</Button>
						</div>
					) ) }

					<Button variant="primary" onClick={ () => addCTA() }>
						+ Ajouter un bouton
					</Button>
				</PanelBody>
			</InspectorControls>
			<section
				{ ...useBlockProps( {
					className: 'section-cta',
				} ) }
			>
				<div className="container cta-body">
					<RichText
						tagName="h2"
						value={ title }
						onChange={ ( value ) =>
							setAttributes( { title: value } )
						}
						placeholder={ __( 'Titre…', 'tilleuls' ) }
						allowedFormats={ [] }
					/>
					<RichText
						tagName="p"
						value={ description }
						onChange={ ( value ) =>
							setAttributes( { description: value } )
						}
						placeholder={ __( 'Description…', 'tilleuls' ) }
						allowedFormats={ [] }
					/>
					<div className="cta-container">
						{ cta.map( ( button, index ) => {
							const href = getHref( button, contactPhone );
							return (
								<a
									href={ href }
									key={ index }
									className={ `cta-link ${ button.style }` }
								>
									{ button.linkType === 'tel' && (
										<i className="fa-solid fa-phone"></i>
									) }
									{ button.linkType === 'mailto' && (
										<i className="fa-solid fa-envelope"></i>
									) }
									{ button.linkType === 'url' && (
										<i className="fa-solid fa-address-book"></i>
									) }
									<strong>{ button.text }</strong>
								</a>
							);
						} ) }
					</div>
				</div>
			</section>
		</>
	);
}
