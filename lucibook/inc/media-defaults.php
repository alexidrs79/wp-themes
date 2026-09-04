<?php
/**
 * Default media-library filename stems for decorative icons/illustrations
 * used via `lucibook_print_icon()` (see theme-setup.php).
 *
 * Unlike Snap's original build, these were written as filename stems
 * (e.g. "hero-orb") from day one, not numeric attachment IDs — a numeric
 * ID is only valid on the exact install it was captured against, and
 * silently breaks the moment this code deploys anywhere else. See
 * `lucibook_get_attachment_id_by_filename()`'s docblock for the full
 * story (it happened to Snap's hero icons, twice).
 *
 * ACF image fields (the site logo, the hero/character photos editors
 * might actually want to swap) still use real ACF fields with a numeric
 * `default_value` — that's fine, because ACF's own value (once saved)
 * is per-post-per-install already; it's only the *default* shown before
 * anything is saved that's environment-specific, and worst case that
 * just means re-picking the image once in wp-admin, not a silently
 * broken front end.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ---- Header ----
define( 'LUCIBOOK_LOGO_ID', 'logo' );

// ---- Section 01 — Hero ----
// Single flattened illustration image (634x713) — replaces the earlier
// layered-SVG recreation (orb, product workspace card, photo, floating
// status labels, stars).
define( 'LUCIBOOK_HERO_IMAGE_ID', 'Frame-65' );

// ---- Section 03 — Reconciliation ----
// Single flattened mockup image (668x647) — replaces the earlier
// layered-SVG recreation of the LuciCore card.
define( 'LUCIBOOK_RC_MOCKUP_IMAGE_ID', 'LuciCore-Reconciliation' );

// ---- Section 04 — Luci AI ----
// Single flattened stage image (620x678) — replaces the earlier
// layered-SVG recreation (glow, photo, knowledge pills, badge).
define( 'LUCIBOOK_LUCI_STAGE_IMAGE_ID', 'Luci-Character-Stage' );
define( 'LUCIBOOK_LUCI_SEND_ICON_ID', 'luci-send-icon' );

// ---- Section 05 — One Connected Workspace ----
// Single flattened diagram image (791x735) — replaces the earlier
// layered-SVG recreation (orbit, Snap/dashboard/Luci cards, connectors).
define( 'LUCIBOOK_WS_DIAGRAM_IMAGE_ID', 'Frame-9' );

// ---- Section 06 — Pricing ----
define( 'LUCIBOOK_PRICING_CHECK_BLUE_ID', 'pricing-check-blue' );
define( 'LUCIBOOK_PRICING_CHECK_WHITE_ID', 'pricing-check-white' );

// ---- Section 07 — Founding Offer ----
define( 'LUCIBOOK_FO_SUNBURST_ID', 'founding-offer-sunburst' );
define( 'LUCIBOOK_FO_LOGO_WHITE_ID', 'founding-offer-logo-white' );
