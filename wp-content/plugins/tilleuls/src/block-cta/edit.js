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
import {Button, PanelBody, SelectControl, TextControl} from "@wordpress/components";
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
		cta
	} = attributes;

	const contactPhone = useSelect(
		(select) =>
			select('core').getEntityRecord(
				'root',
				'site'
			)?.tilleuls_contact_phone,
		[]
	);

	const updateCTA = (index, field, value, cta, setAttributes) => {
		const newCTA = [...cta];
		newCTA[index] = {
			...newCTA[index],
			[field]: value
		};
		setAttributes({cta: newCTA});
	};

	const addCTA = (cta, setAttributes) => {
		setAttributes({
			cta: [
				...cta,
				{
					text: '',
					linkType: 'url',
					url: '',
					style: 'primary'
				}
			]
		});
	};

	const removeCTA = (index, cta, setAttributes) => {
		const newCTA = cta.filter((_, i) => i !== index);
		setAttributes({cta: newCTA});
	};

	console.log(cta)

	return (
		<>
			<InspectorControls>
				<PanelBody title="Boutons (CTA)" initialOpen={true}>
					{cta.map((button, index) => (
						<div key={index} style={{marginBottom: '20px', paddingBottom: '20px', borderBottom: '1px solid #ddd'}}>
							<SelectControl
								label="Type de lien"
								value={button.linkType}
								options={[
									{label: 'Lien classique', value: 'url'},
									{label: 'Email (mailto)', value: 'mailto'},
									{label: 'Téléphone (tel)', value: 'tel'}
								]}
								onChange={value =>
									updateCTA(index, 'linkType', value, cta, setAttributes)
								}
							/>

							<TextControl
								label="Lien"
								help={
									button.linkType === 'mailto'
										? 'ex: contact@site.com'
										: button.linkType === 'tel'
											? 'ex: +33612345678'
											: 'ex: https://monsite.com'
								}
								value={button.url}
								onChange={value =>
									updateCTA(index, 'url', value, cta, setAttributes)
								}
							/>
							<TextControl
								label="Texte du bouton"
								value={button.text}
								onChange={value =>
									updateCTA(index, 'text', value, cta, setAttributes)
								}
							/>

							<SelectControl
								label="Style du bouton"
								value={button.style}
								options={[
									{label: 'Primaire', value: 'primary'},
									{label: 'Secondaire', value: 'secondary'},
									{label: 'Outline', value: 'outline'}
								]}
								onChange={value =>
									updateCTA(index, 'style', value, cta, setAttributes)
								}
							/>

							<Button
								isDestructive
								onClick={() => removeCTA(index, cta, setAttributes)}
							>
								Supprimer ce bouton
							</Button>

						</div>
					))}

					<Button
						variant="primary"
						onClick={() => addCTA(cta, setAttributes)}
					>
						+ Ajouter un bouton
					</Button>

				</PanelBody>
			</InspectorControls>
			<section {...useBlockProps({
				className: `section-cta ${color}`
			})}>
				<div className="container cta-body">
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
						{
							cta.map((button, index) => {
								const href = button.linkType === 'tel' ? `tel:${contactPhone}` : button.linkType === 'mailto' ? `mailto:${button.url}` : button.url;
								return (
									<a href={href}  key={index} className={`cta-link ${button.style}`}>
										{
											button.linkType === 'tel' &&
											<i className="fa-solid fa-phone"></i>
										}
										{
											button.linkType === 'mailto' &&
											<i className="fa-solid fa-envelope"></i>
										}
										{
											button.linkType === 'url' &&
											<i className="fa-solid fa-address-book"></i>
										}
										<strong>{button.text}</strong>
									</a>
								)
							})
						}
					</div>
				</div>
			</section>
		</>
	);
}
