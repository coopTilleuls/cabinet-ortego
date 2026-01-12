import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, TextControl, SelectControl } from '@wordpress/components';

export default function Edit({ attributes, setAttributes }) {
	const { title, subtitle, blockPosition } = attributes;

	const blockProps = useBlockProps({
		className: `title-section ${blockPosition}`,
	});

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={__('Paramètres du titre', 'tilleuls')}
					initialOpen={true}
				>
					<TextControl
						label={__('Titre', 'tilleuls')}
						value={title}
						onChange={(value) =>
							setAttributes({ title: value })
						}
					/>

					<TextControl
						label={__('Sous-titre', 'tilleuls')}
						value={subtitle}
						onChange={(value) =>
							setAttributes({ subtitle: value })
						}
					/>

					<SelectControl
						label={__('Position du block', 'tilleuls')}
						value={blockPosition}
						options={[
							{ label: __('Gauche', 'tilleuls'), value: 'left' },
							{ label: __('Centre', 'tilleuls'), value: 'center' },
						]}
						onChange={(value) =>
							setAttributes({ blockPosition: value })
						}
					/>

				</PanelBody>
			</InspectorControls>

			<div {...blockProps}>
				<h2>{title}</h2>
				<span className="subtitle">{subtitle}</span>
				<div className="separator" />
			</div>
		</>
	);
}
