/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */

import {
	InnerBlocks,
	useBlockProps,
	RichText,
	InspectorControls
} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */

import './editor.scss';
import {
	Button,
	Tooltip,
	DropdownMenu,
	ToolbarGroup,
	ToolbarButton,
} from "@wordpress/components";

/**
 * Configuration des icônes
 */
const ICONS_CONFIG = {
	criminalLaw: {
		label: __('Droit Pénal', 'tilleuls'),
		className: 'fa-solid fa-scale-balanced'
	},
	immigrationLaw: {
		label: __('Droit des Étrangers', 'tilleuls'),
		className: 'fa-solid fa-earth-europe'
	},
	prisonLaw: {
		label: __('Droit Pénitentiaire', 'tilleuls'),
		className: 'fa-solid fa-lock'
	},
	fundamentalFreedoms: {
		label: __('Libertés Fondamentales', 'tilleuls'),
		className: 'fa-solid fa-hand-holding-heart'
	}
};

export default function Edit({ attributes, setAttributes }) {
	const { items = [] } = attributes;

	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}]
	];

	const blockProps = useBlockProps({
		className: 'section-expertise',
	});

	const addItem = () => {
		const defaultIcon = Object.keys(ICONS_CONFIG)[0] || 'criminalLaw'
		const newItems = [...items, { icon: defaultIcon, title: '', description: '' }];
		setAttributes({ items: newItems });
	};

	const removeItem = (index) => {
		const filteredItems = items.filter((_, i) => i !== index);
		setAttributes({ items: filteredItems });
	};

	const updateItem = (index, key, value) => {
		const newItems = [...items];
		newItems[index][key] = value;
		setAttributes({ items: newItems });
	};

	const renderIcon = (iconKey) => {
		const iconClass = ICONS_CONFIG[iconKey]?.className || 'fa-solid fa-question';
		return () => <i className={iconClass} style={{ fontSize: '20px' }}></i>;
	};

	return (
		<>
			<section {...blockProps}>
				<div className="container">
					<InnerBlocks
						template={INNER_BLOCKS}
					/>
					<div className="practices-grid" style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(300px, 1fr))', gap: '20px', marginTop: '40px' }}>

						{items.map((item, index) => (
							<div key={index} className="practice-card" style={{ position: 'relative', border: '1px dashed #ccc', padding: '20px', background: '#fff' }}>
								<Tooltip text={__('Supprimer cette expertise', 'tilleuls')}>
									<Button
										icon="trash"
										label={__('Supprimer', 'tilleuls')}
										isDestructive
										isSmall
										onClick={() => removeItem(index)}
										style={{ position: 'absolute', top: '5px', right: '5px', zIndex: 10 }}
									/>
								</Tooltip>
								<h3 style={{ display: 'flex', alignItems: 'center', gap: '10px', marginBottom: '15px' }}>
									<DropdownMenu
										icon={renderIcon(item.icon)}
										label={__('Choisir une icône', 'tilleuls')}
										toggleProps={{
											style: {
												padding: '5px',
												minWidth: 'auto',
												color: 'var(--wp--preset--color--accent, #b43636)'
											}
										}}
									>
										{({ onClose }) => (
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
									<RichText
										tagName="span"
										value={item.title}
										onChange={(value) => updateItem(index, 'title', value)}
										placeholder={__('Titre (ex: Droit Pénal)', 'tilleuls')}
										allowedFormats={[]}
										style={{ width: '100%' }}
									/>
								</h3>
								<RichText
									tagName="p"
									value={item.description}
									onChange={(value) => updateItem(index, 'description', value)}
									placeholder={__('Description de l\'expertise...', 'tilleuls')}
									style={{ fontSize: '0.95rem', lineHeight: '1.5' }}
								/>
							</div>
						))}
						<div className="add-item-container" style={{ display: 'flex', alignItems: 'center', justifyContent: 'center', minHeight: '150px', border: '2px dashed #ccc' }}>
							<Button
								isSecondary
								icon="plus"
								onClick={addItem}
							>
								{__('Ajouter une expertise', 'tilleuls')}
							</Button>
						</div>
					</div>
				</div>
			</section>
		</>
	);
}
