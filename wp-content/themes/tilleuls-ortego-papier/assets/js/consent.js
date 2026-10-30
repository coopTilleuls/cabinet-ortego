/**
 * Consent for the two external services (Calendly, Google Maps) and loading of their embeds.
 * Nothing external is requested before the visitor accepts, either globally (banner) or for one
 * service (the "Afficher …" button of its placeholder, which also records that choice).
 * The choice is stored in localStorage only: no cookie is set by the site itself.
 */
( () => {
	const STORAGE_KEY = 'tilleuls-consent';
	const SERVICES = [ 'calendly', 'map' ];
	const CALENDLY_SCRIPT =
		'https://assets.calendly.com/assets/external/widget.js';
	// Past this delay the embed is considered unreachable and the fallback message is shown.
	const TIMEOUT = 20000;

	const banner = document.getElementById( 'consentement' );
	const form = banner?.querySelector( '[data-consent-form]' );
	const choices = banner?.querySelector( '#consentement-choix' );
	const customize = banner?.querySelector( '[data-consent-customize]' );
	const status = banner?.querySelector( '[data-consent-status]' );

	const read = () => {
		try {
			return (
				JSON.parse( window.localStorage.getItem( STORAGE_KEY ) ) || null
			);
		} catch {
			return null;
		}
	};

	const write = ( consent ) => {
		try {
			window.localStorage.setItem(
				STORAGE_KEY,
				JSON.stringify( consent )
			);
		} catch {
			// Private mode or storage disabled: the choice lasts for this page only.
		}
	};

	let consent = read();

	/* Embeds ---------------------------------------------------------- */

	const loadScript = ( src ) =>
		new Promise( ( resolve, reject ) => {
			const existing = document.querySelector( `script[src="${ src }"]` );
			if ( existing ) {
				if ( window.Calendly ) {
					resolve();
				} else {
					existing.addEventListener( 'load', resolve );
					existing.addEventListener( 'error', reject );
				}
				return;
			}
			const script = document.createElement( 'script' );
			script.src = src;
			script.async = true;
			script.onload = resolve;
			script.onerror = reject;
			document.head.append( script );
		} );

	// Focus moves to the error only when the visitor asked for this embed (its "Afficher" button):
	// an embed loaded from a stored consent must not pull focus from wherever the visitor is.
	const showError = ( placeholder, { moveFocus = false } = {} ) => {
		if ( placeholder.dataset.embedState === 'loaded' ) {
			return;
		}
		placeholder.dataset.embedState = 'error';
		placeholder.querySelector( '[data-embed-loading]' ).hidden = true;
		placeholder.querySelector( '[data-embed-frame]' ).hidden = true;
		const error = placeholder.querySelector( '[data-embed-error]' );
		error.hidden = false;
		if ( moveFocus ) {
			error.focus();
		} else {
			// Announced politely, without moving focus.
			error.setAttribute( 'role', 'status' );
		}
	};

	const loadEmbed = ( placeholder, { moveFocus = false } = {} ) => {
		if ( placeholder.dataset.embedState ) {
			return;
		}
		placeholder.dataset.embedState = 'loading';

		const service = placeholder.dataset.embed;
		const src = placeholder.dataset.src;
		const frame = placeholder.querySelector( '[data-embed-frame]' );
		const loading = placeholder.querySelector( '[data-embed-loading]' );
		const intro = placeholder.querySelector( '[data-embed-intro]' );

		loading.hidden = false;
		loading.setAttribute( 'role', 'status' );
		placeholder.querySelector( '[data-embed-load]' ).hidden = true;

		const fail = () => showError( placeholder, { moveFocus } );
		const timer = window.setTimeout( fail, TIMEOUT );

		const done = () => {
			window.clearTimeout( timer );
			if ( placeholder.dataset.embedState !== 'loading' ) {
				return;
			}
			placeholder.dataset.embedState = 'loaded';
			loading.hidden = true;
			frame.hidden = false;
			intro.classList.add( 'is-loaded' );
			if ( moveFocus ) {
				frame.focus();
			}
		};

		frame.tabIndex = -1;

		if ( service === 'calendly' ) {
			loadScript( CALENDLY_SCRIPT )
				.then( () => {
					frame.hidden = false;
					window.Calendly.initInlineWidget( {
						url: src,
						parentElement: frame,
					} );
					const iframe = frame.querySelector( 'iframe' );
					if ( iframe ) {
						iframe.title = 'Agenda de réservation (Calendly)';
						iframe.addEventListener( 'load', done, { once: true } );
					} else {
						done();
					}
				} )
				.catch( () => {
					window.clearTimeout( timer );
					fail();
				} );
			return;
		}

		const iframe = document.createElement( 'iframe' );
		iframe.src = src;
		iframe.title = placeholder.dataset.title || 'Carte';
		// No lazy loading: the frame stays hidden until it has loaded, and a hidden lazy frame never loads.
		iframe.referrerPolicy = 'no-referrer-when-downgrade';
		iframe.addEventListener( 'load', done, { once: true } );
		iframe.addEventListener( 'error', fail, { once: true } );
		frame.append( iframe );
	};

	const placeholders = [ ...document.querySelectorAll( '[data-embed]' ) ];

	placeholders.forEach( ( placeholder ) => {
		const button = placeholder.querySelector( '[data-embed-load]' );
		button.hidden = false;
		button.addEventListener( 'click', () => {
			consent = {
				...( consent || { calendly: false, map: false } ),
				[ placeholder.dataset.embed ]: true,
			};
			write( consent );
			syncForm();
			hideBanner();
			loadEmbed( placeholder, { moveFocus: true } );
		} );
	} );

	const applyConsent = () => {
		placeholders
			.filter( ( placeholder ) => consent?.[ placeholder.dataset.embed ] )
			.forEach( ( placeholder ) => loadEmbed( placeholder ) );
	};

	/* Banner ---------------------------------------------------------- */

	const syncForm = () => {
		if ( ! form ) {
			return;
		}
		SERVICES.forEach( ( service ) => {
			form.elements[ service ].checked = Boolean( consent?.[ service ] );
		} );
	};

	const hideBanner = () => {
		if ( banner ) {
			banner.hidden = true;
		}
	};

	const showBanner = ( { focus = false } = {} ) => {
		if ( ! banner ) {
			return;
		}
		syncForm();
		banner.hidden = false;
		if ( focus ) {
			banner.focus();
		}
	};

	if ( form ) {
		form.addEventListener( 'submit', ( event ) => {
			event.preventDefault();
			const choice = event.submitter?.value;
			consent = Object.fromEntries(
				SERVICES.map( ( service ) => [
					service,
					choice === 'accept' ||
						( choice === 'custom' &&
							form.elements[ service ].checked ),
				] )
			);
			write( consent );
			status.textContent = 'Vos choix sont enregistrés.';
			applyConsent();
			window.setTimeout( () => {
				const hadFocus = banner.contains(
					banner.ownerDocument.activeElement
				);
				hideBanner();
				if ( hadFocus ) {
					document.querySelector( '.js-consent-open' )?.focus();
				}
			}, 1500 );
		} );

		customize.addEventListener( 'click', () => {
			const expanded =
				customize.getAttribute( 'aria-expanded' ) === 'true';
			customize.setAttribute( 'aria-expanded', String( ! expanded ) );
			choices.hidden = expanded;
			if ( ! expanded ) {
				choices.querySelector( 'input' ).focus();
			}
		} );
	}

	document.querySelectorAll( '.js-consent-open' ).forEach( ( link ) => {
		link.addEventListener( 'click', ( event ) => {
			event.preventDefault();
			showBanner( { focus: true } );
		} );
	} );

	if ( consent === null ) {
		showBanner();
	}
	applyConsent();
} )();
