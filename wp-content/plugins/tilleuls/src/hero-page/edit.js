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
import { InnerBlocks, RichText, useBlockProps } from '@wordpress/block-editor';

import { useSelect } from '@wordpress/data';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @param {Object}   root0
 * @param {Object}   root0.attributes    Block attributes.
 * @param {Function} root0.setAttributes Block attributes setter.
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { description } = attributes;

	const blockName = useBlockProps( {
		className: 'hero-page',
	} );

	const postTitle = useSelect( ( select ) => {
		return select( 'core/editor' ).getEditedPostAttribute( 'title' );
	}, [] );

	const INNER_BLOCKS = [
		[
			'tilleuls-ortego-blocks/section-title',
			{ title: postTitle, blockPosition: 'center', subtitle: '' },
		],
	];

	return (
		<div { ...blockName }>
			<InnerBlocks template={ INNER_BLOCKS } />
			<RichText
				tagName="p"
				className="description"
				value={ description }
				allowedFormats={ [ 'core/bold', 'core/italic' ] }
				placeholder={ __(
					'Courte phrase d’introduction…',
					'tilleuls'
				) }
				onChange={ ( value ) =>
					setAttributes( { description: value } )
				}
			/>
		</div>
	);
}
