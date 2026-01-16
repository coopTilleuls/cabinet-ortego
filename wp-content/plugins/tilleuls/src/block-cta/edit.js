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
	const {
		color,
		title,
		description,
		link,
		linkBis,
		textBtn,
		textBtnBis,
	} = attributes;

	const contactPhone = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_contact_phone,
		[]
	);

	console.log(textBtn, textBtnBis)

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Apparence', 'tilleuls')}>
					<TextControl
						label={__('Lien (URL)', 'tilleuls')}
						value={link || ''}
						onChange={(value) => setAttributes({link: value})}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>
					<TextControl
						label={__('Label du bouton', 'tilleuls')}
						value={textBtn || ''}
						onChange={(value) => setAttributes({textBtn: value})}
						help={__('Si vide, numero de téléphone mis par défaut.', 'tilleuls')}
						placeholder="Prendre rendez-vous"
					/>

					<TextControl
						label={__('Lien (URL)', 'tilleuls')}
						value={linkBis || ''}
						onChange={(value) => setAttributes({linkBis: value})}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>

					<TextControl
						label={__('Label du bouton secondaire', 'tilleuls')}
						value={textBtnBis || ''}
						onChange={(value) => setAttributes({textBtnBis: value})}
						placeholder="Prendre rendez-vous"
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
							<a href={link} className="cta-link">
								{
									!textBtn || textBtn.trim() === '' ?
										(
											<>
												<i className="fa-solid fa-phone"></i>
												{contactPhone}
											</>
										) :
										textBtn
								}
							</a>
							<a href={linkBis} className="cta-link-bis">{textBtnBis}</a>
						</div>
					</div>
				</div>
			</section>
		</>

	);
}
