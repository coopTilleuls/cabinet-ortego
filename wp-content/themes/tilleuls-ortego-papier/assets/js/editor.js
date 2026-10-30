/**
 * Editor preview of the theme's server-rendered blocks (no build step).
 *
 * @param {Object} wp WordPress globals.
 */
( function ( wp ) {
	const { registerBlockType } = wp.blocks;
	const { createElement: el } = wp.element;
	const { useBlockProps } = wp.blockEditor;
	const ServerSideRender = wp.serverSideRender;

	[
		'tilleuls-papier/site-header',
		'tilleuls-papier/site-footer',
		'tilleuls-papier/breadcrumb',
		'tilleuls-papier/contact-actions',
		'tilleuls-papier/contact-address',
		'tilleuls-papier/archive-title',
	].forEach( ( name ) => {
		function Edit() {
			return el(
				'div',
				useBlockProps( { inert: '' } ),
				el( ServerSideRender, { block: name } )
			);
		}

		registerBlockType( name, {
			edit: Edit,
			save: () => null,
		} );
	} );
} )( window.wp );
