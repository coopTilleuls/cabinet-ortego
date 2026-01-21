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
import {
	InnerBlocks,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockProps
} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {Button, PanelBody, TextControl, Tooltip} from "@wordpress/components"; // ResponsiveWrapper optionnel pour image

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	const {imgId, imgUrl, languages, buttonText, buttonLink} = attributes;

	const blockProps = useBlockProps({
		className: 'profile-home'
	});

	const CONTENT_TEMPLATE = [
		['tilleuls-ortego-blocks/title-section', {}],
		['core/paragraph', {placeholder: 'Description...'}]
	];

	const onSelectImage = (media) => {
		setAttributes({
			imgId: media.id,
			imgUrl: media.url
		});
	};

	const removeImage = () => {
		setAttributes({
			imgId: 0,
			imgUrl: ''
		});
	};

	const addLanguage = () => {
		const newLangs = [...languages, {name: ''}];
		setAttributes({languages: newLangs});
	};

	const updateLanguage = (index, value) => {
		const newLangs = [...languages];
		newLangs[index] = {
			...newLangs[index],
			name: value
		};

		setAttributes({languages: newLangs});
	};

	const removeLanguage = (index) => {
		const newLangs = languages.filter((_, i) => i !== index);
		setAttributes({languages: newLangs});
	};

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Image de profil', 'block-profile-homepage')}>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={onSelectImage}
							allowedTypes={['image']}
							value={imgId}
							render={({open}) => (
								<>
									{imgId ? (
										<>
											<Button onClick={open} isSecondary style={{marginBottom: '10px', width: '100%'}}>
												{__('Changer l’image', 'block-profile-homepage')}
											</Button>
											<Button onClick={removeImage} isDestructive style={{width: '100%'}}>
												{__('Supprimer l’image', 'block-profile-homepage')}
											</Button>
										</>
									) : (
										<Button onClick={open} isPrimary style={{width: '100%'}}>
											{__('Choisir une image', 'block-profile-homepage')}
										</Button>
									)}
								</>
							)}
						/>
					</MediaUploadCheck>
					<TextControl
						label={__('Lien (URL)', 'tilleuls')}
						value={buttonLink || ''}
						onChange={(value) => setAttributes({buttonLink: value})}
						placeholder="https://..."
						help={__('Collez l\'URL de la page interne ou du site externe.', 'tilleuls')}
					/>
					<TextControl
						label={__('Label du bouton', 'tilleuls')}
						value={buttonText || ''}
						onChange={(value) => setAttributes({buttonText: value})}
						help={__('Si vide, numero de téléphone mis par défaut.', 'tilleuls')}
						placeholder="Prendre rendez-vous"
					/>
				</PanelBody>
			</InspectorControls>

			<section {...blockProps}>
				<div className="container profile-home-grid">
					<div className="profile-home-img">
						{imgUrl ? (
							<img
								src={imgUrl}
								alt={__('Photo de profil', 'block-profile-homepage')}
							/>
						) : (
							<MediaUploadCheck>
								<MediaUpload
									onSelect={onSelectImage}
									allowedTypes={['image']}
									value={imgId}
									render={({open}) => (
										<div
											className="placeholder-image"
											onClick={open}
											style={{
												background: '#f0f0f0',
												width: '100%',
												height: '100%',
												minHeight: '300px',
												display: 'flex',
												alignItems: 'center',
												justifyContent: 'center',
												color: '#ccc',
												cursor: 'pointer'
											}}
										>
											{__('Cliquer pour ajouter une image', 'block-profile-homepage')}
										</div>
									)}
								/>
							</MediaUploadCheck>
						)}
					</div>

					<div className="profile-home-content">
						<span className="profile-surtitle">À propos de l'avocate</span>
						<InnerBlocks
							template={CONTENT_TEMPLATE}
						/>

						<div className="languages-list">
							<div style={{display: 'flex', flexWrap: 'wrap', gap: '5px'}}>
								{languages.map((lang, index) => (
									<div key={index} className="lang-tag-editor" style={{
										display: 'flex',
										alignItems: 'center',
										background: '#f4f1ea',
										padding: '2px 8px',
										borderRadius: '2px',
										border: '1px solid #e0dcd0'
									}}>
										<RichText
											tagName="span"
											className="lang-tag"
											value={lang.name}
											onChange={(val) => updateLanguage(index, val)}
											placeholder={__('Langue...', 'tilleuls')}
											allowedFormats={[]}
										/>
										<Tooltip text={__('Retirer', 'tilleuls')}>
                        <span
													onClick={() => removeLanguage(index)}
													style={{
														cursor: 'pointer',
														marginLeft: '8px',
														color: '#cc0000',
														fontSize: '14px',
														fontWeight: 'bold'
													}}
												>
                            ×
                        </span>
										</Tooltip>
									</div>
								))}
								<Button
									isSmall
									isSecondary
									onClick={addLanguage}
									icon="plus"
									label={__('Ajouter une langue', 'tilleuls')}
									style={{minWidth: '30px', padding: '0 5px'}}
								/>
							</div>
						</div>
						<a href={buttonLink} className="profile-cta">{buttonText}</a>
					</div>
				</div>
			</section>
		</>
	);
}
