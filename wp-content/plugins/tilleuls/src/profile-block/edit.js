import {__} from '@wordpress/i18n';
import {
	InnerBlocks,
	InspectorControls,
	MediaUpload,
	MediaUploadCheck,
	RichText,
	useBlockProps
} from '@wordpress/block-editor';
import {Button, PanelBody, Tooltip} from '@wordpress/components';

export default function Edit({attributes, setAttributes}) {
	const {
		bio,
		imgId,
		imgUrl,
		languages,
		diplomas
	} = attributes;

	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}],
	];

	const blockProps = useBlockProps({
		className: 'profile-section',
	});

	const addTraining = () => {
		const newItems = [...diplomas, {text: ''}]
		setAttributes({diplomas: newItems})
	};

	const removeTraining = (index) => {
		const newItems = diplomas.filter((_, i) => i !== index);
		setAttributes({diplomas: newItems});
	};

	const updateTraining = (index, value) => {
		const newDiplomas = [...diplomas];
		newDiplomas[index] = {
			...newDiplomas[index],
			text: value
		};

		setAttributes({diplomas: newDiplomas});
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

						<div className="languages-container">
							<h4>
								{__('Langues parlées :', 'tilleuls')}
							</h4>

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
							<h4>
								{__('Formation Universitaire', 'tilleuls')}
							</h4>

							<ul>
								{diplomas.map((item, index) => (
									<li key={index}>
										<i className="fa-solid fa-graduation-cap"></i>
										<div style={{flexGrow: 1}}>
											<RichText
												tagName="span"
												value={item.text}
												onChange={(val) => updateTraining(index, val)}
												placeholder={__('Master 2 Droit Public...', 'tilleuls')}
												allowedFormats={['core/bold', 'core/italic']}
											/>
										</div>
										<Tooltip text={__('Supprimer', 'tilleuls')}>
											<Button
												icon="trash"
												isDestructive
												isSmall
												onClick={() => removeTraining(index)}
												className="remove-training-btn"
												style={{marginLeft: '10px'}}
											/>
										</Tooltip>
									</li>
								))}
							</ul>
							<Button
								isSecondary
								isSmall
								icon="plus"
								onClick={addTraining}
								style={{marginTop: '10px'}}
							>
								{__('Ajouter un diplôme', 'tilleuls')}
							</Button>

						</div>
					</div>
				</div>
			</section>
		</>
	);
}
