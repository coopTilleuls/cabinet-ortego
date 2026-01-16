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
import {InnerBlocks, InspectorControls, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {__} from "@wordpress/i18n";
import {PanelBody, TextControl} from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	const {surtitle, cta, ctaBis} = attributes;

	const blockName = useBlockProps({
		className: 'section-hero-homepage'
	})

	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}],
		['core/paragraph', {placeholder: 'Bienvenue ...'}]
	];


	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__('Paramètres du titre', 'tilleuls')}
					initialOpen={true}
				>
					<TextControl
						label={__('Surtitre', 'tilleuls')}
						value={surtitle}
						onChange={(value) =>
							setAttributes({surtitle: value})
						}
					/>
					<TextControl
						label={__('Lien premier bouton', 'tilleuls')}
						value={cta || ''}
						onChange={(value) => setAttributes({ cta: value })}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>

					<TextControl
						label={__('Lien second bouton', 'tilleuls')}
						value={ctaBis || ''}
						onChange={(value) => setAttributes({ ctaBis: value })}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...blockName}>
				<div className="container">
					<div className="hero-content">
						<span className="surtitle">{surtitle}</span>
						<InnerBlocks
							template={INNER_BLOCKS}
						/>
						<div className="cta-container">
							<a href={cta} className="cta-first">Prendre Rendez-vous</a>
							<a href={ctaBis} className="cta-second">Découvrir le cabinet</a>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
