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
	InspectorControls,
	useBlockProps,
	InnerBlocks, RichText
} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import { PanelBody, SelectControl, TextControl } from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({ attributes, setAttributes }) {
	const { imgPosition, icon, titleIcon, title } = attributes;

	const blockProps = useBlockProps({
		className: `section-expertise-page has-img-${imgPosition}`
	});

	const CONTENT_TEMPLATE = [
		['core/paragraph', { placeholder: 'Description de l\'expertise...' }],
		['core/list', { placeholder: 'Liste des points clés' }]
	];

	const ICONS_CONFIG = {
		criminalLaw: {
			label: __('Droit Pénal', 'tilleuls'),
			className: 'fa-solid fa-scale-balanced',
			associated: 'fa-solid fa-gavel'
		},

		immigrationLaw: {
			label: __('Droit des Étrangers', 'tilleuls'),
			className: 'fa-solid fa-earth-europe',
			associated: 'fa-solid fa-passport'
		},
		prisonLaw: {
			label: __('Droit Pénitentiaire', 'tilleuls'),
			className: 'fa-solid fa-lock',
			associated: 'fa-solid fa-door-open'
		},
		fundamentalFreedoms: {
			label: __('Libertés Fondamentales', 'tilleuls'),
			className: 'fa-solid fa-hand-holding-heart'
		},
		activeListening: {
			label: __('Écoute Active', 'tilleuls'),
			className: 'fa-solid fa-ear-listen'
		},
		fightingSpirit: {
			label: __('Combativité', 'tilleuls'),
			className: 'fa-solid fa-shield-halved'
		},
		transparency: {
			label: __('Transparence', 'tilleuls'),
			className: 'fa-regular fa-eye'
		}
	};

	const iconOptions = [
		{ label: __('Sélectionner une icône', 'tilleuls'), value: '' },
		...Object.entries(ICONS_CONFIG).map(([key, value]) => ({
			label: value.label,
			value: key,
			titleIcon: value.associated
		}))
	];
	const currentIconClass = (key) => ICONS_CONFIG[key]?.className || 'fa-solid fa-gavel';
	const currentIconTitleClass = (key) => ICONS_CONFIG[key]?.associated || 'fa-solid fa-gavel';
	const handleChange = (value) => {
		setAttributes({icon: currentIconTitleClass(value)})
		setAttributes({titleIcon: currentIconClass(value)})
	}
	console.log(titleIcon)
	return (
		<>
			<InspectorControls>
				<PanelBody title={__('Apparence', 'tilleuls')}>
					<SelectControl
						label={__('Position de l\'image latérale', 'tilleuls')}
						value={imgPosition}
						options={[
							{ label: __('Gauche', 'tilleuls'), value: 'left' },
							{ label: __('Droite', 'tilleuls'), value: 'right' },
						]}
						onChange={(value) => setAttributes({ imgPosition: value })}
					/>
					<hr />
					<SelectControl
						label={__('Choix des icones', 'tilleuls')}
						value={icon}
						options={iconOptions}
						onChange={(value) => handleChange(value)}
						help="L'icône affichée en grand sur le côté."
					/>
				</PanelBody>
			</InspectorControls>

			<section { ...blockProps }>
				<div className="container">
							<div className="expertises-grid">
								<div className="expertise-content">
									<h2 style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
										{titleIcon && (
											<i className={titleIcon}></i>
										)}

										<RichText
											tagName="span"
											value={title}
											onChange={(value) => setAttributes({ title: value })}
											placeholder={__('Titre de l\'expertise...', 'tilleuls')}
											allowedFormats={[]}
										/>
									</h2>
									<InnerBlocks
										template={CONTENT_TEMPLATE}
										templateLock={false}
									/>
								</div>
								<div className="expertise-visual">
									{icon ? (
										<i className={icon} style={{ fontSize: '3rem' }}></i>
									) : (
										<span style={{ fontSize: '3rem', opacity: 0.2 }}>?</span>
									)}
								</div>
							</div>
				</div>
			</section>
		</>
	);
}
