/**
 * Progressive enhancement for the header disclosures (<details>): they already work without JS.
 * Adds: Escape closes the open disclosure and returns focus to its toggle; a click outside closes it;
 * opening one closes the others.
 */
( () => {
	const disclosures = [
		...document.querySelectorAll( 'details.disclosure' ),
	];

	const close = ( details, focusToggle = false ) => {
		if ( ! details.open ) {
			return;
		}
		details.open = false;
		if ( focusToggle ) {
			details.querySelector( 'summary' )?.focus();
		}
	};

	disclosures.forEach( ( details ) => {
		details.addEventListener( 'toggle', () => {
			if ( details.open ) {
				disclosures
					.filter( ( other ) => other !== details )
					.forEach( ( other ) => close( other ) );
			}
		} );
		details.addEventListener( 'keydown', ( event ) => {
			if ( event.key === 'Escape' ) {
				close( details, true );
			}
		} );
	} );

	document.addEventListener( 'click', ( event ) => {
		disclosures
			.filter( ( details ) => ! details.contains( event.target ) )
			.forEach( ( details ) => close( details ) );
	} );
} )();
