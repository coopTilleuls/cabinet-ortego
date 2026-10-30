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
import {
	InnerBlocks,
	InspectorControls,
	useBlockProps,
} from '@wordpress/block-editor';

import { __ } from '@wordpress/i18n';
import { PanelBody, TextControl } from '@wordpress/components';

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
	const { surtitle, cta, ctaLabel, ctaBis, ctaBisLabel } = attributes;
	const firstLabel = ctaLabel || __( 'Prendre rendez-vous', 'tilleuls' );
	const secondLabel = ctaBisLabel || __( 'Découvrir le cabinet', 'tilleuls' );

	const blockName = useBlockProps( {
		className: 'section-hero-homepage',
	} );

	const INNER_BLOCKS = [
		[ 'tilleuls-ortego-blocks/section-title', {} ],
		[ 'core/paragraph', { placeholder: 'Bienvenue ...' } ],
	];

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Paramètres du titre', 'tilleuls' ) }
					initialOpen={ true }
				>
					<TextControl
						label={ __( 'Surtitre', 'tilleuls' ) }
						value={ surtitle }
						onChange={ ( value ) =>
							setAttributes( { surtitle: value } )
						}
					/>
					<TextControl
						label={ __( 'Lien premier bouton', 'tilleuls' ) }
						value={ cta || '' }
						onChange={ ( value ) =>
							setAttributes( { cta: value } )
						}
						placeholder="https://..."
						help={ __(
							"Collez l'URL de la page interne ou du site externe.",
							'tilleuls'
						) }
					/>
					<TextControl
						label={ __( 'Texte du premier bouton', 'tilleuls' ) }
						value={ ctaLabel || '' }
						onChange={ ( value ) =>
							setAttributes( { ctaLabel: value } )
						}
						help={ __(
							'Laisser vide pour garder le texte par défaut.',
							'tilleuls'
						) }
					/>
					<TextControl
						label={ __( 'Lien second bouton', 'tilleuls' ) }
						value={ ctaBis || '' }
						onChange={ ( value ) =>
							setAttributes( { ctaBis: value } )
						}
						placeholder="https://..."
						help={ __(
							"Collez l'URL de la page interne ou du site externe.",
							'tilleuls'
						) }
					/>
					<TextControl
						label={ __( 'Texte du second bouton', 'tilleuls' ) }
						value={ ctaBisLabel || '' }
						onChange={ ( value ) =>
							setAttributes( { ctaBisLabel: value } )
						}
						help={ __(
							'Laisser vide pour garder le texte par défaut.',
							'tilleuls'
						) }
					/>
				</PanelBody>
			</InspectorControls>
			<div { ...blockName }>
				<div className="container">
					<div className="hero-content">
						<span className="surtitle">{ surtitle }</span>
						<InnerBlocks template={ INNER_BLOCKS } />
						<div className="cta-container">
							<a href={ cta } className="cta-first">
								{ firstLabel }
							</a>
							<a href={ ctaBis } className="cta-second">
								{ secondLabel }
							</a>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
