/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import {__} from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {InspectorControls, RichText, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
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
	const {
		color,
		title,
		description,
		link,
		linkBis
	} = attributes;

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Apparence', 'tilleuls')}>
					<TextControl
						label={__('Lien (URL)', 'tilleuls')}
						value={link || ''}
						onChange={(value) => setAttributes({ link: value })}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>
					<TextControl
						label={__('Lien (URL)', 'tilleuls')}
						value={linkBis || ''}
						onChange={(value) => setAttributes({ linkBis: value })}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>
				</PanelBody>
			</InspectorControls>
			<section {...useBlockProps({
				className: `section-cta ${color}`
			})}>
				<div className="container">
					<div className="cta-body">
						<RichText
							tagName="h2"
							value={title}
							onChange={(value) => setAttributes({title: value})}
							placeholder={__('Titre...', 'tilleuls')}
							allowedFormats={[]}
						/>
						<RichText
							tagName="p"
							value={description}
							onChange={(value) => setAttributes({description: value})}
							placeholder={__('Description...', 'tilleuls')}
							allowedFormats={[]}
						/>
						<div className="cta-container">
							<a href={link} className="cta-link"> Prendre rendez-vous</a>
							{
								linkBis !== '' ??
								<a href={linkBis} className="cta-link-bis">Nous écrire</a>
							}
						</div>
					</div>
				</div>
			</section>
		</>

	);
}
