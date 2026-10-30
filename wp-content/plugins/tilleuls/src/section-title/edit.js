import { __ } from '@wordpress/i18n';
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';
import { PanelBody, SelectControl, TextControl } from '@wordpress/components';

export default function Edit( { attributes, setAttributes } ) {
	const { title, subtitle, blockPosition, size, color } = attributes;

	const blockProps = useBlockProps( {
		className: `title-section ${ blockPosition } ${ size } ${ color }`,
	} );

	let HeadingTag = 'h2';
	if ( size === 'sm' ) {
		HeadingTag = 'h3';
	} else if ( size === 'xl' ) {
		HeadingTag = 'h1';
	}

	return (
		<>
			<InspectorControls>
				<PanelBody
					title={ __( 'Paramètres du titre', 'tilleuls' ) }
					initialOpen={ true }
				>
					<TextControl
						label={ __( 'Titre', 'tilleuls' ) }
						value={ title }
						onChange={ ( value ) =>
							setAttributes( { title: value } )
						}
					/>

					<TextControl
						label={ __( 'Sous-titre', 'tilleuls' ) }
						value={ subtitle }
						onChange={ ( value ) =>
							setAttributes( { subtitle: value } )
						}
					/>

					<SelectControl
						label={ __( 'Position du block', 'tilleuls' ) }
						value={ blockPosition }
						options={ [
							{
								label: __( 'Gauche', 'tilleuls' ),
								value: 'left',
							},
							{
								label: __( 'Centre', 'tilleuls' ),
								value: 'center',
							},
						] }
						onChange={ ( value ) =>
							setAttributes( { blockPosition: value } )
						}
					/>
					<SelectControl
						label={ __( 'Taille du block', 'tilleuls' ) }
						value={ size }
						options={ [
							{ label: __( 'Petit', 'tilleuls' ), value: 'sm' },
							{ label: __( 'Grand', 'tilleuls' ), value: 'lg' },
							{ label: __( 'Big', 'tilleuls' ), value: 'xl' },
						] }
						onChange={ ( value ) =>
							setAttributes( { size: value } )
						}
					/>
					<SelectControl
						label={ __( 'Theme du block', 'tilleuls' ) }
						value={ color }
						options={ [
							{ label: __( 'Classique', 'tilleuls' ), value: '' },
							{
								label: __( 'Blanc', 'tilleuls' ),
								value: 'white',
							},
						] }
						onChange={ ( value ) =>
							setAttributes( { color: value } )
						}
					/>
				</PanelBody>
			</InspectorControls>

			<div { ...blockProps }>
				<HeadingTag>{ title }</HeadingTag>
				<span className="subtitle">{ subtitle }</span>
				<div className="separator" />
			</div>
		</>
	);
}
