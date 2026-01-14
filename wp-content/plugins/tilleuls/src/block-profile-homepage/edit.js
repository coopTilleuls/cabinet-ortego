/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import {InnerBlocks, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit() {
	const blockName = useBlockProps({
		className: 'profile-home'
	});

	const CONTENT_TEMPLATE = [
		['core/paragraph', {placeholder: 'Description de l\'expertise...'}],
		['core/list', {placeholder: 'Liste des points clés'}]
	];

	return (
		<>
			<section {...blockName}>
				<div className="profile-home-grid">
					<div className="profile-home-img"></div>
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
						<a href="" className="profile-cta"> En savoir plus sur mon parcours</a>
					</div>
				</div>
			</section>
		</>
	);
}
