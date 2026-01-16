import {__} from '@wordpress/i18n';
import {
	InspectorControls,
	useBlockProps,
	RichText, InnerBlocks
} from '@wordpress/block-editor';
import {
	PanelBody,
	SelectControl,
	Button,
	Tooltip,
	DropdownMenu,
	ToolbarGroup,
	ToolbarButton
} from "@wordpress/components";
import './editor.scss';

const ICONS_CONFIG = {
	gavel: {
		label: __('Justice', 'tilleuls'),
		className: 'fa-solid fa-gavel'
	},
	handcuffs: {
		label: __('Détention', 'tilleuls'),
		className: 'fa-solid fa-handcuffs'
	},
	passport: {
		label: __('Étrangers', 'tilleuls'),
		className: 'fa-solid fa-passport'
	},
	scale: {
		label: __('Balance', 'tilleuls'),
		className: 'fa-solid fa-scale-balanced'
	},
	star: {
		label: __('Étoile', 'tilleuls'),
		className: 'fa-solid fa-star'
	}
};

export default function Edit({attributes, setAttributes}) {
	const {color, items} = attributes;

	const blockProps = useBlockProps({
		className: `associations-banner ${color}`,
	});

	const addItem = () => {
		const defaultIcon = Object.keys(ICONS_CONFIG)[0] || 'gavel';
		const newItems = [...items, {icon: defaultIcon, text: ''}];
		setAttributes({items: newItems});
	};

	const removeItem = (index) => {
		const newItems = items.filter((_, i) => i !== index);
		setAttributes({items: newItems});
	};

	const updateItem = (index, key, value) => {
		const newItems = [...items];
		newItems[index][key] = value;
		setAttributes({items: newItems});
	};

	const renderIcon = (iconKey) => {
		const iconClass = ICONS_CONFIG[iconKey]?.className || 'fa-solid fa-question';
		return () => <i className={iconClass} style={{fontSize: '24px'}}></i>;
	};

	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}]
	];

	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Apparence', 'tilleuls')}>
					<SelectControl
						label={__('Couleur de fond', 'tilleuls')}
						value={color}
						options={[
							{label: __('Noir', 'tilleuls'), value: 'black'},
							{label: __('Rouge', 'tilleuls'), value: 'red'},
							{label: __('Crême', 'tilleuls'), value: 'blue'},
						]}
						onChange={(value) => setAttributes({color: value})}
					/>
				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<div className="container">
					<InnerBlocks
						template={INNER_BLOCKS}
					/>
					<div className="associations-flex">
						{items.map((item, index) => (
							<div key={index} className="asso-item-editor" style={{
								border: '1px dashed rgba(255,255,255,0.3)',
								padding: '15px',
								margin: '5px',
								position: 'relative',
								display: 'flex',
								flexDirection: 'column',
								alignItems: 'center',
								gap: '10px'
							}}>

								<Tooltip text={__('Supprimer cet élément', 'tilleuls')}>
									<Button
										icon="trash"
										isDestructive
										isSmall
										onClick={() => removeItem(index)}
										style={{
											position: 'absolute',
											top: '-10px',
											right: '-10px',
											background: 'white',
											borderRadius: '50%',
											boxShadow: '0 2px 4px rgba(0,0,0,0.1)',
											zIndex: 10
										}}
									/>
								</Tooltip>
								<div style={{textAlign: 'center', width: '100%', marginBottom: '5px'}}>
									<DropdownMenu
										icon={renderIcon(item.icon)}
										label={__('Choisir une icône', 'tilleuls')}
										toggleProps={{
											style: {
												width: '60px',
												height: '60px',
												padding: '0',
												display: 'flex',
												alignItems: 'center',
												justifyContent: 'center',
												color: 'white',
												border: '1px solid rgba(255,255,255,0.4)',
												borderRadius: '8px',
												background: 'rgba(0,0,0,0.2)'
											}
										}}
									>
										{({onClose}) => (
											<ToolbarGroup>
												{Object.entries(ICONS_CONFIG).map(([key, iconData]) => (
													<ToolbarButton
														key={key}
														icon={() => <i className={iconData.className}></i>}
														label={iconData.label}
														isActive={item.icon === key}
														onClick={() => {
															updateItem(index, 'icon', key);
															onClose();
														}}
													/>
												))}
											</ToolbarGroup>
										)}
									</DropdownMenu>
								</div>

								<RichText
									tagName="span"
									value={item.text}
									onChange={(val) => updateItem(index, 'text', val)}
									placeholder={__('Nom de l\'association...', 'tilleuls')}
									allowedFormats={['core/bold', 'core/italic']}
									style={{display: 'block', textAlign: 'center', width: '100%', color: 'white'}}
								/>
							</div>
						))}
						<div className="add-item-container"
								 style={{display: 'flex', alignItems: 'center', justifyContent: 'center', minHeight: '80px'}}>
							<Button
								isSecondary
								icon="plus"
								onClick={addItem}
							>
								{__('Ajouter un élément', 'tilleuls')}
							</Button>
						</div>
					</div>
				</div>
			</div>
		</>
	);
}
