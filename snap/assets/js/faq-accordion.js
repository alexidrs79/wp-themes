/**
 * Pricing page FAQ accordion. The open/close animation itself is pure CSS
 * (grid-template-rows on .pricing-faq__panel, see style.css) — this just
 * toggles the class + aria-expanded that CSS keys off of. Items are
 * independent (no shared `name`/exclusivity), matching the behavior of
 * the native <details>/<summary> markup this replaced.
 */
( function () {
	var items = document.querySelectorAll( '.pricing-faq__item' );

	items.forEach( function ( item ) {
		var button = item.querySelector( '.pricing-faq__question' );
		if ( ! button ) {
			return;
		}

		button.addEventListener( 'click', function () {
			var isOpen = item.classList.toggle( 'is-open' );
			button.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
		} );
	} );
} )();
