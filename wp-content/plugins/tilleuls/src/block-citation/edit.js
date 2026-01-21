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
import {RichText, useBlockProps} from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';
import {TextControl} from "@wordpress/components";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit({attributes, setAttributes}) {
	const {citation, author} = attributes;

	const blockName = useBlockProps({
		className: 'section-citation'
	});

	return (
		<section {...blockName}>
			<div className="container">
				<div className="quote">
					<div className="quote-icon">“</div>
					<RichText
						tagName="blockquote"
						value={citation}
						onChange={(value) => setAttributes({ citation: value })}
						placeholder={__('Saisissez votre citation ici...', 'tilleuls')}
						style={{

						}}
					/>

					<RichText
						tagName="span"
						className="quote-author"
						value={author}
						onChange={(value) => setAttributes({ author: value })}
						placeholder={__('Auteur de la citation', 'tilleuls')}
						style={{
							display: 'block',
							fontWeight: '700',
							color: '#8C1818',
							textTransform: 'uppercase',
							fontSize: '0.9rem',
							fontFamily: 'Montserrat, sans-serif'
						}}
					/>
				</div>
			</div>
		</section>
	);
}
