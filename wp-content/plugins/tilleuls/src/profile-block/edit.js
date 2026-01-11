import {__} from '@wordpress/i18n';
import {
	useBlockProps,
	RichText,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	InnerBlocks
} from '@wordpress/block-editor';
import {Button, PanelBody} from '@wordpress/components';

export default function Edit({attributes, setAttributes}) {
	const {
		bio,
		imgId,
		imgUrl,
		languages,
		diplomas
	} = attributes;

	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}]
	];

	const blockProps = useBlockProps({
		className: 'profile-section',
	});

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Image de profil', 'tilleuls')}>
					<MediaUploadCheck>
						<MediaUpload
							onSelect={(media) =>
								setAttributes({
									imgId: media.id,
									imgUrl: media.url
								})
							}
							allowedTypes={['image']}
							value={imgId}
							render={({open}) => (
								<Button onClick={open} isPrimary>
									{imgUrl
										? __('Changer l’image', 'tilleuls')
										: __('Choisir une image', 'tilleuls')}
								</Button>
							)}
						/>
					</MediaUploadCheck>
				</PanelBody>
			</InspectorControls>

			<section {...blockProps}>
				<div className="container profile-grid">
					<div className="profile-img-container">
						{imgUrl ? (
							<img
								src={imgUrl}
								alt={__('Photo de profil', 'tilleuls')}
							/>
						) : (
							<div className="placeholder-image" style={{
								background: '#f0f0f0',
								height: '300px',
								display: 'flex',
								alignItems: 'center',
								justifyContent: 'center',
								color: '#ccc'
							}}>
								{__('Ajouter une image', 'tilleuls')}
							</div>
						)}

						<div className="languages-bar">
							<RichText
								tagName="div"
								className="languages-editor"
								value={languages}
								allowedFormats={['core/bold', 'core/italic']}
								placeholder={__('Langues parlées (ex: Français, Anglais...)', 'tilleuls')}
								onChange={(value) => setAttributes({languages: value})}
							/>
						</div>
					</div>
					<div className="bio-text">
						<InnerBlocks
							template={INNER_BLOCKS}
						/>
						<RichText
							tagName="div"
							className="bio-content"
							multiline="p"
							value={bio}
							onChange={(value) => setAttributes({bio: value})}
							placeholder={__('Rédigez la biographie ici...', 'tilleuls')}
						/>
						<div className="diploma-list">
							<RichText
								tagName="div"
								value={diplomas}
								onChange={(value) => setAttributes({diplomas: value})}
								placeholder={__('Liste des diplômes et engagements...', 'tilleuls')}
							/>
						</div>
					</div>
				</div>
			</section>
		</>
	);
}
