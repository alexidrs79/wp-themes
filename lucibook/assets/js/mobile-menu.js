/**
 * Mobile header menu — hamburger toggle, slide-in panel, backdrop.
 * All actual open/closed styling is CSS (see .mobile-menu-panel /
 * .mobile-menu-backdrop in style.css); this only ever toggles the
 * .is-open class plus the aria-expanded/aria-hidden attributes the CSS
 * and screen readers both key off of.
 *
 * Background scroll lock: `overflow: hidden` on html/body (the
 * .mobile-menu-lock class in style.css) blocks the scrollbar and most
 * scroll input, but not every wheel/touch event in every browser, since
 * overflow:hidden clips content rather than removing the scrollable
 * range outright. The usual fix for that (pinning <body> with
 * position:fixed at the current scroll offset) was tried and reverted
 * here — it actively breaks .site-header's position:sticky, which
 * calculates its stuck position relative to the scrolling ancestor, and
 * making body position:fixed changes what that ancestor even is. So
 * instead this blocks scroll input directly at the event level
 * (wheel/touchmove/the keys that scroll: arrows, space, page up/down,
 * home/end) without touching any element's layout or position, which
 * leaves the sticky header completely undisturbed. Scrolling inside the
 * panel itself (if its content is taller than the viewport) still needs
 * to work, so events that originate inside the panel are left alone.
 */
( function () {
	var toggle = document.querySelector( '.site-header__menu-toggle' );
	var panel = document.querySelector( '.mobile-menu-panel' );
	var backdrop = document.querySelector( '.mobile-menu-backdrop' );

	if ( ! toggle || ! panel || ! backdrop ) {
		return;
	}

	var closeButton = panel.querySelector( '.mobile-menu-panel__close' );
	var panelLinks = panel.querySelectorAll( 'a' );
	var SCROLL_KEYS = [ 'ArrowUp', 'ArrowDown', 'PageUp', 'PageDown', 'Home', 'End', ' ' ];

	function isOpen() {
		return panel.classList.contains( 'is-open' );
	}

	function preventBackgroundScroll( event ) {
		if ( ! panel.contains( event.target ) ) {
			event.preventDefault();
		}
	}

	function preventScrollKeys( event ) {
		if ( SCROLL_KEYS.indexOf( event.key ) !== -1 && ! panel.contains( event.target ) ) {
			event.preventDefault();
		}
	}

	function openMenu() {
		panel.classList.add( 'is-open' );
		backdrop.classList.add( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'true' );
		panel.setAttribute( 'aria-hidden', 'false' );

		document.documentElement.classList.add( 'mobile-menu-lock' );
		document.body.classList.add( 'mobile-menu-lock' );
		document.addEventListener( 'wheel', preventBackgroundScroll, { passive: false } );
		document.addEventListener( 'touchmove', preventBackgroundScroll, { passive: false } );
		document.addEventListener( 'keydown', preventScrollKeys, false );
	}

	function closeMenu() {
		panel.classList.remove( 'is-open' );
		backdrop.classList.remove( 'is-open' );
		toggle.setAttribute( 'aria-expanded', 'false' );
		panel.setAttribute( 'aria-hidden', 'true' );

		document.documentElement.classList.remove( 'mobile-menu-lock' );
		document.body.classList.remove( 'mobile-menu-lock' );
		document.removeEventListener( 'wheel', preventBackgroundScroll );
		document.removeEventListener( 'touchmove', preventBackgroundScroll );
		document.removeEventListener( 'keydown', preventScrollKeys );
	}

	toggle.addEventListener( 'click', function () {
		if ( isOpen() ) {
			closeMenu();
		} else {
			openMenu();
		}
	} );

	if ( closeButton ) {
		closeButton.addEventListener( 'click', closeMenu );
	}

	backdrop.addEventListener( 'click', closeMenu );

	panelLinks.forEach( function ( link ) {
		link.addEventListener( 'click', closeMenu );
	} );

	document.addEventListener( 'keydown', function ( event ) {
		if ( 'Escape' === event.key && isOpen() ) {
			closeMenu();
		}
	} );

	// Crossing back above the mobile breakpoint (a tablet rotated to
	// landscape, a resize while testing) shouldn't leave the panel
	// stuck open behind the now-visible desktop nav.
	var aboveMobileBreakpoint = window.matchMedia( '(min-width: 769px)' );

	function handleBreakpointChange( event ) {
		if ( event.matches && isOpen() ) {
			closeMenu();
		}
	}

	if ( aboveMobileBreakpoint.addEventListener ) {
		aboveMobileBreakpoint.addEventListener( 'change', handleBreakpointChange );
	} else if ( aboveMobileBreakpoint.addListener ) {
		// Safari < 14 fallback.
		aboveMobileBreakpoint.addListener( handleBreakpointChange );
	}
} )();
