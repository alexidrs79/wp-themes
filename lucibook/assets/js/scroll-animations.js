/**
 * Shared scroll-triggered entrance animations.
 *
 * One observer drives every section — template parts only add data
 * attributes (see README block below), no per-section JS.
 *
 * - [data-animate]        an element that fades/slides in.
 * - [data-animate-group]  a container observed as the trigger; when it
 *                         enters the viewport, every [data-animate]
 *                         descendant inside it is revealed together, each
 *                         offset by STAGGER_MS × its position among its
 *                         group siblings. Groups are siblings, never
 *                         nested, so each cascade has its own 0-based index.
 * - [data-animate-onload] same idea as a group, but revealed once on page
 *                         load instead of on scroll (used for the hero,
 *                         which is visible immediately).
 *
 * The actual hidden/visible CSS lives in style.css, scoped under
 * html.js-animate so a element only ever hides content once this script's
 * early inline-class script has already run — if JS is disabled or fails,
 * nothing gets stuck invisible.
 */
(function () {
	var STAGGER_MS = 90;
	var TRIGGER_ROOT_MARGIN = '0px 0px -10% 0px';
	var TRIGGER_THRESHOLD = 0.15;

	var prefersReducedMotion = window.matchMedia(
		'(prefers-reduced-motion: reduce)'
	).matches;

	function revealGroup( group ) {
		var items = group.querySelectorAll( '[data-animate]' );

		if ( ! items.length ) {
			return;
		}

		var stagger = group.hasAttribute( 'data-stagger' )
			? parseInt( group.getAttribute( 'data-stagger' ), 10 )
			: STAGGER_MS;

		items.forEach( function ( item, index ) {
			item.style.transitionDelay = index * stagger + 'ms';
			item.classList.add( 'is-visible' );
		} );
	}

	function revealStandalone( el ) {
		el.style.transitionDelay = '0ms';
		el.classList.add( 'is-visible' );
	}

	if ( prefersReducedMotion ) {
		document.querySelectorAll( '[data-animate]' ).forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
		return;
	}

	// Hero (and anything else marked onload) reveals immediately, staggered.
	document
		.querySelectorAll( '[data-animate-onload]' )
		.forEach( function ( group ) {
			revealGroup( group );
		} );

	if ( ! ( 'IntersectionObserver' in window ) ) {
		// No observer support: just show everything rather than leave it hidden.
		document.querySelectorAll( '[data-animate]' ).forEach( function ( el ) {
			el.classList.add( 'is-visible' );
		} );
		return;
	}

	var observer = new IntersectionObserver(
		function ( entries, obs ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}

				revealGroup( entry.target );
				obs.unobserve( entry.target );
			} );
		},
		{
			threshold: TRIGGER_THRESHOLD,
			rootMargin: TRIGGER_ROOT_MARGIN,
		}
	);

	document
		.querySelectorAll( '[data-animate-group]' )
		.forEach( function ( group ) {
			observer.observe( group );
		} );

	// Standalone [data-animate] elements with no group ancestor: observe
	// individually so they still fade in on their own scroll trigger.
	var standaloneObserver = new IntersectionObserver(
		function ( entries, obs ) {
			entries.forEach( function ( entry ) {
				if ( ! entry.isIntersecting ) {
					return;
				}

				revealStandalone( entry.target );
				obs.unobserve( entry.target );
			} );
		},
		{
			threshold: TRIGGER_THRESHOLD,
			rootMargin: TRIGGER_ROOT_MARGIN,
		}
	);

	document.querySelectorAll( '[data-animate]' ).forEach( function ( el ) {
		if ( ! el.closest( '[data-animate-group], [data-animate-onload]' ) ) {
			standaloneObserver.observe( el );
		}
	} );
} )();
