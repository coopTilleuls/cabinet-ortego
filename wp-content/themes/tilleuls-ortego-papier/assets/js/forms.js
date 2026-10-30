/**
 * Contact Form 7: after a failed submission, turn the response message into an error summary
 * ("2 champs à corriger") whose links lead to each invalid field, and move focus to it.
 */
( () => {
	const SUMMARY_CLASSES = [ 'notice', 'notice--erreur', 'resume-erreurs' ];

	const formOf = ( event ) =>
		event.target.querySelector( 'form' ) || event.target;

	// A new submission starts from a plain response area: CF7 only resets its text.
	document.addEventListener( 'wpcf7beforesubmit', ( event ) => {
		const output = formOf( event ).querySelector(
			'.wpcf7-response-output'
		);
		if ( output ) {
			output.classList.remove( ...SUMMARY_CLASSES );
			output.removeAttribute( 'tabindex' );
		}
	} );

	document.addEventListener( 'wpcf7invalid', ( event ) => {
		const form = formOf( event );

		// CF7 fires "invalid" before it flags the fields and writes their tips: read them on the next frame.
		window.requestAnimationFrame( () => {
			const output = form.querySelector( '.wpcf7-response-output' );
			const invalid = [ ...form.querySelectorAll( '.wpcf7-not-valid' ) ];
			if ( ! output || ! invalid.length ) {
				return;
			}

			const title = document.createElement( 'p' );
			title.className = 'notice__title';
			title.textContent =
				invalid.length === 1
					? '1 champ à corriger'
					: `${ invalid.length } champs à corriger`;

			const list = document.createElement( 'ul' );
			invalid.forEach( ( field ) => {
				if ( ! field.id ) {
					field.id = `champ-${ field.name }`;
				}
				const label = field.closest( 'label' );
				const name = label
					? label.firstChild.textContent.trim()
					: field.name;
				const tip = field.parentElement.querySelector(
					'.wpcf7-not-valid-tip'
				);
				const item = document.createElement( 'li' );
				const link = document.createElement( 'a' );
				link.href = `#${ field.id }`;
				link.textContent = tip
					? `${ name } : ${ tip.textContent.trim() }`
					: name;
				link.addEventListener( 'click', ( clickEvent ) => {
					clickEvent.preventDefault();
					field.focus();
				} );
				item.append( link );
				list.append( item );
			} );

			output.replaceChildren( title, list );
			output.classList.add( ...SUMMARY_CLASSES );
			output.setAttribute( 'tabindex', '-1' );
			output.focus();
		} );
	} );
} )();
