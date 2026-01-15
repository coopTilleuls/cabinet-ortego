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
import {InnerBlocks, InspectorControls, MediaUpload, MediaUploadCheck, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {Button, PanelBody} from "@wordpress/components"; // ResponsiveWrapper optionnel pour image

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { imgId, imgUrl } = attributes;

	const blockProps = useBlockProps({
		className: 'profile-home'
	});

	const CONTENT_TEMPLATE = [
		['core/paragraph', { placeholder: 'Description de l\'expertise...' }],
		['core/list', { placeholder: 'Liste des points clés' }]
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

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Image de profil', 'block-profile-homepage')}>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={(media) =>
								setAttributes({
								imgId: media.id,
								imgUrl: media.url
							})}
							allowedTypes={['image']}
							value={imgId}
							render={({ open }) => (
								<>
									{imgId ? (
										<>
											<Button onClick={open} isSecondary style={{ marginBottom: '10px', width: '100%' }}>
												{__('Changer l’image', 'block-profile-homepage')}
											</Button>
											<Button onClick={removeImage} isDestructive style={{ width: '100%' }}>
												{__('Supprimer l’image', 'block-profile-homepage')}
											</Button>
										</>
									) : (
										<Button onClick={open} isPrimary style={{ width: '100%' }}>
											{__('Choisir une image', 'block-profile-homepage')}
										</Button>
									)}
								</>
							)}
						/>
					</MediaUploadCheck>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="profile-home-grid">
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
									render={({ open }) => (
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
						<div className="value-list">
							<div className="value-item">
								<i className="fa-regular fa-comments"></i>
								<span>Écoute</span>
							</div>
							<div className="value-item">
								<i className="fa-solid fa-shield-halved"></i>
								<span>Combativité</span>
							</div>
							<div className="value-item">
								<i className="fa-solid fa-globe"></i>
								<span>Multilingue</span>
							</div>
						</div>
						<a href="#" className="profile-cta"> En savoir plus sur mon parcours</a>
					</div>
				</div>
			</section>
		</>
	);
}
