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
import {InnerBlocks, InspectorControls, RichText, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {PanelBody, TextControl} from "@wordpress/components";
import {__} from "@wordpress/i18n";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	const {calendly} = attributes

	const blockProps = useBlockProps({
		className: 'section-meeting-calendly',
	});


	const INNER_BLOCKS = [
		['tilleuls-ortego-blocks/title-section', {}],
		['core/paragraph', {}],
		['tilleuls-ortego-blocks/block-info-column', {}]
	];

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__('Paramètres du titre', 'tilleuls')}
					initialOpen={true}
				>
					<TextControl
						label={__('Lien Calendly', 'tilleuls')}
						value= {calendly}
						onChange={(value) => setAttributes({calendly: value})}
					/>
				</PanelBody>
			</InspectorControls>
			<section {...blockProps}>
				<div className="container meeting-grid">
					<div className="meeting-info">
						<InnerBlocks
							template={INNER_BLOCKS}
							templateLock={false}
						/>
					</div>
					<div className="meeting-calendar">
						Espace Calendly
					</div>
				</div>
			</section>
		</>
	);
}
