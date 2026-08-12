/**
 * Auto-dismisses the CF7 success message on the CTA demo form a few
 * seconds after it appears, instead of leaving it on the page forever.
 * CF7 dispatches `wpcf7mailsent` on the <form> element itself once mail
 * sends successfully.
 *
 * Also suppresses the browser's native constraint-validation tooltip on
 * this form. Without `novalidate`, submitting with an empty/invalid
 * required field triggers BOTH the browser's own native "Please fill
 * out this field" bubble AND, once CF7's AJAX validation responds,
 * CF7's own .wpcf7-not-valid-tip + .wpcf7-response-output message —
 * two overlapping validation messages fighting for the same space.
 * `novalidate` removes the native one, leaving CF7's own (already
 * carefully positioned, see .cta-demo .wpcf7-not-valid-tip in style.css)
 * as the single source of validation messaging.
 */
( function () {
	var HIDE_AFTER_MS = 5000;
	var FADE_MS = 400;

	var ctaForm = document.querySelector( '.cta-demo .wpcf7-form' );
	if ( ctaForm ) {
		ctaForm.setAttribute( 'novalidate', 'novalidate' );
	}

	document.addEventListener( 'wpcf7mailsent', function ( event ) {
		var form = event.target;
		if ( ! form.closest( '.cta-demo' ) ) {
			return;
		}

		var output = form.querySelector( '.wpcf7-response-output' );
		if ( ! output ) {
			return;
		}

		setTimeout( function () {
			output.classList.add( 'is-dismissing' );
			setTimeout( function () {
				output.classList.add( 'is-dismissed' );
			}, FADE_MS );
		}, HIDE_AFTER_MS );
	}, false );
} )();
