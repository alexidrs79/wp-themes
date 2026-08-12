<?php
/**
 * Template part: Contact page content.
 *
 * Rebuilt from an earlier two-form layout to a single unified form +
 * contact-details column. No Figma design exists for this page — reuses
 * patterns already established across the site rather than inventing a
 * new visual language:
 * - eyebrow + headline: same treatment as every other section heading.
 * - card style: the hard-shadow "neubrutalist" treatment (1.702px black
 *   border + a non-blurred -2px/-2px offset shadow), same as the
 *   Pricing page's cards.
 * - contact-detail rows and the map placeholder reuse that same card
 *   style. Each row's icon badge is the scaled-down Real Usecases icon-
 *   badge treatment (orange fill, black border, offset shadow) with a
 *   white line icon inside — mail / phone / pin / clock, one per row
 *   (see inc/media-defaults.php's SNAP_CONTACT_ICON_* block for why
 *   these are 4 new hand-authored glyphs rather than the checkmark
 *   asset used elsewhere: the checkmark is solid-orange-fill and was
 *   invisible on this same-color badge background).
 * - buttons: .btn + .btn-stack-hover, the same component/hover-layer
 *   used everywhere else.
 * - entrance animation: [data-animate]/[data-animate-group] only.
 *
 * The form is a real Contact Form 7 form (id 106) — same
 * CF7 + Fluent SMTP stack as every other form on the site, routed to
 * the same dev placeholder inbox (dev-email@wpengine.local) pending a
 * real address, per explicit instruction. The "Reason for contact"
 * dropdown does NOT yet route to different recipients based on its
 * value — flagged, not built, until asked for.
 *
 * The map renders a real Google Maps iframe (embed-URL format, no API
 * key required) when contact_map_embed_url is set, falling back to a
 * static styled placeholder if it's ever left blank.
 *
 * Visual pass (no new content, no new patterns): the site-wide grid
 * background (printed once in header.php, behind every page) already
 * covers this page's header/hero — nothing added here. What IS new:
 * a small reassurance strip above the two-column layout (icon + label
 * items, same minimal language as the hero's proof line); each
 * contact-info row is now its own hard-shadow card with a small icon
 * badge (scaled-down version of the Real Usecases icon badges); the
 * form card already used this exact card style, so it needed no change.
 *
 * PLACEHOLDER CONTENT — flagged here and in the ACF admin UI, review
 * before launch: the email address, phone number, physical address,
 * and business hours (now on the Theme Settings page, Contact
 * Information tab — see inc/theme-settings-page.php), and the 4
 * reassurance-strip claims below (still page-specific) are all
 * placeholders, not real details.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$eyebrow  = get_field( 'contact_eyebrow' );
$headline = get_field( 'contact_headline' );
$intro    = get_field( 'contact_intro' );

// Contact details are a single source of truth on the Theme Settings
// page now, not this page's own fields — see inc/acf-fields-theme-
// settings.php.
$email   = get_field( 'theme_contact_email', SNAP_THEME_SETTINGS_PAGE_ID );
$phone   = get_field( 'theme_contact_phone', SNAP_THEME_SETTINGS_PAGE_ID );
$address = get_field( 'theme_contact_address', SNAP_THEME_SETTINGS_PAGE_ID );
$hours   = get_field( 'theme_contact_hours', SNAP_THEME_SETTINGS_PAGE_ID );
$map_embed_url = get_field( 'theme_contact_map_embed_url', SNAP_THEME_SETTINGS_PAGE_ID );

$response_note  = get_field( 'contact_response_note' );

$trust_items = array_filter( array(
	get_field( 'contact_trust_item_1' ),
	get_field( 'contact_trust_item_2' ),
	get_field( 'contact_trust_item_3' ),
	get_field( 'contact_trust_item_4' ),
) );
?>
<section class="contact-hero">
	<div class="contact-hero__inner container" data-animate-group>
		<?php if ( $eyebrow ) : ?>
			<p class="contact-hero__eyebrow" data-animate><?php echo esc_html( $eyebrow ); ?></p>
		<?php endif; ?>

		<h1 class="contact-hero__headline" data-animate><?php echo esc_html( $headline ); ?></h1>
	</div>
</section>

<?php if ( $trust_items ) : ?>
	<section class="contact-trust">
		<div class="contact-trust__inner container">
			<ul class="contact-trust__list" data-animate-group>
				<?php foreach ( $trust_items as $item ) : ?>
					<li class="contact-trust__item" data-animate>
						<?php snap_print_icon( 'SNAP_OCR_ICON_CHECK_ID', 'contact-trust__icon' ); ?>
						<span class="contact-trust__label"><?php echo esc_html( $item ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>

<section class="contact-columns">
	<div class="contact-columns__inner container" data-animate-group>
		<div class="contact-info" data-animate>
			<?php if ( $intro ) : ?>
				<p class="contact-info__intro"><?php echo esc_html( $intro ); ?></p>
			<?php endif; ?>

			<ul class="contact-info__list">
				<?php if ( $email ) : ?>
					<li class="contact-info__item">
						<span class="contact-info__icon-badge">
							<?php snap_print_icon( 'SNAP_CONTACT_ICON_EMAIL_ID', 'contact-info__icon' ); ?>
						</span>
						<span class="contact-info__text">
							<span class="contact-info__label">Email</span>
							<a class="contact-info__value" href="<?php echo esc_attr( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
						</span>
					</li>
				<?php endif; ?>

				<?php if ( $phone ) : ?>
					<li class="contact-info__item">
						<span class="contact-info__icon-badge">
							<?php snap_print_icon( 'SNAP_CONTACT_ICON_PHONE_ID', 'contact-info__icon' ); ?>
						</span>
						<span class="contact-info__text">
							<span class="contact-info__label">Phone</span>
							<a class="contact-info__value" href="<?php echo esc_attr( 'tel:' . preg_replace( '/[^+0-9]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
						</span>
					</li>
				<?php endif; ?>

				<?php if ( $address ) : ?>
					<li class="contact-info__item">
						<span class="contact-info__icon-badge">
							<?php snap_print_icon( 'SNAP_CONTACT_ICON_PIN_ID', 'contact-info__icon' ); ?>
						</span>
						<span class="contact-info__text">
							<span class="contact-info__label">Address</span>
							<span class="contact-info__value"><?php echo nl2br( esc_html( $address ) ); ?></span>
						</span>
					</li>
				<?php endif; ?>

				<?php if ( $hours ) : ?>
					<li class="contact-info__item">
						<span class="contact-info__icon-badge">
							<?php snap_print_icon( 'SNAP_CONTACT_ICON_CLOCK_ID', 'contact-info__icon' ); ?>
						</span>
						<span class="contact-info__text">
							<span class="contact-info__label">Business hours</span>
							<span class="contact-info__value"><?php echo esc_html( $hours ); ?></span>
						</span>
					</li>
				<?php endif; ?>
			</ul>

			<?php if ( $map_embed_url ) : ?>
				<div class="contact-info__map">
					<iframe
						src="<?php echo esc_url( $map_embed_url ); ?>"
						loading="lazy"
						referrerpolicy="strict-origin-when-cross-origin"
						allowfullscreen
						title="Map"
					></iframe>
				</div>
			<?php else : ?>
				<div class="contact-info__map" aria-hidden="true">
					<span class="contact-info__map-label">Map placeholder</span>
				</div>
			<?php endif; ?>
		</div>

		<div class="contact-form-card" id="contact-form" data-animate>
			<?php echo do_shortcode( '[contact-form-7 id="106" title="Contact Page — Unified"]' ); ?>
		</div>
	</div>
</section>

<?php if ( $response_note ) : ?>
	<p class="contact-response-note container" data-animate><?php echo esc_html( $response_note ); ?></p>
<?php endif; ?>
