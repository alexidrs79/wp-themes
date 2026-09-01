/**
 * Toggles .is-stuck on .site-header once the page has scrolled past its
 * resting position, so style.css can swap in a more pronounced shadow
 * only while the sticky header is actually pinned (see --shadow-header-
 * stuck) — CSS position:sticky has no native "is this stuck right now"
 * selector, so this is the minimal JS needed to drive that state.
 *
 * Two different thresholds (not one) on purpose: with a single cutoff,
 * scrollY oscillating by a pixel or two right at that value (a trackpad
 * micro-scroll, a rubber-band bounce) would toggle the class — and
 * restart the CSS shadow transition — many times a second, reading as a
 * flicker. Entering at 12px and only exiting once back below 4px creates
 * a dead zone in between, so hovering near the boundary can't retrigger
 * either direction.
 */
( function () {
	var header = document.querySelector( '.site-header' );
	if ( ! header ) {
		return;
	}

	var ENTER_THRESHOLD = 12;
	var EXIT_THRESHOLD = 4;

	function update() {
		var isStuck = header.classList.contains( 'is-stuck' );

		if ( ! isStuck && window.scrollY > ENTER_THRESHOLD ) {
			header.classList.add( 'is-stuck' );
		} else if ( isStuck && window.scrollY < EXIT_THRESHOLD ) {
			header.classList.remove( 'is-stuck' );
		}
	}

	update();
	window.addEventListener( 'scroll', update, { passive: true } );
} )();
