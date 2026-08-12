<?php
/**
 * Default Media Library attachment IDs for local ACF image field defaults.
 *
 * These are environment-specific (attachment IDs aren't portable across
 * installs) — they only seed the "default_value" shown for a *new* page
 * using the Snap Landing template. The actual "Snap Landing" page has its
 * own explicit field values set independently of these defaults.
 *
 * Re-run `wp media import` and update these if the theme assets are
 * re-imported on a fresh environment.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SNAP_HERO_ILLUSTRATION_BACKGROUND_ID', 21 );
define( 'SNAP_HERO_ILLUSTRATION_CONNECTOR_1_ID', 31 );
define( 'SNAP_HERO_ILLUSTRATION_CONNECTOR_2_ID', 32 );
define( 'SNAP_HERO_ILLUSTRATION_DOT_1_ID', 33 );
define( 'SNAP_HERO_ILLUSTRATION_DOT_2_ID', 34 );

/**
 * The receipt/invoice preview cards, the Extracted Details card, the status
 * badge, and the scan icon (Figma nodes 15150:1527/1537/1505/1796/1792) were
 * previously flattened raster mockups (receipt-15x-noborder.png etc.) — real
 * text/lines/borders baked into pixels, which is why border-radius fixes on
 * them never held. They're now real HTML/CSS (see template-parts/hero.php
 * and the `.hero__receipt` / `.hero__invoice` / `.hero__card` / `.hero__badge`
 * rules in style.css), same technique as the Real Usecases row cards. Only
 * the small glyphs that those cards/badge/icon still need as real icon
 * assets are media-library attachments; everything else (backgrounds,
 * borders, text, the receipt/invoice line placeholders) is plain markup.
 */
/*
 * These 4 hold filename stems, not numeric attachment IDs, unlike every
 * other constant in this file — deliberately, after the numeric-ID version
 * of these 4 specifically kept going blank on live every time the theme's
 * code (this file included) redeployed there, overwriting whatever ID
 * live actually needed back to these local-only ones. See
 * `snap_get_attachment_id_by_filename()` in theme-setup.php for why a
 * filename stem survives that redeploy correctly and a numeric ID can't.
 * `snap_print_icon()` resolves either kind automatically.
 */
define( 'SNAP_HERO_SCAN_GLYPH_ID', 'hero-scan-glyph' );
define( 'SNAP_HERO_SPARKLES_ICON_ID', 'hero-sparkles-icon' );
define( 'SNAP_HERO_CONFIDENCE_CHECK_ID', 'hero-confidence-check' );
define( 'SNAP_HERO_SUCCESS_CHECK_ID', 'hero-success-check' );

/**
 * Site-wide decorative background (Figma node 15150:1496, "Frame 33") —
 * not page content, so it isn't an ACF field; just a theme asset constant
 * like the custom logo.
 */
define( 'SNAP_PAGE_BACKGROUND_GRID_ID', 29 );

/**
 * Trust strip placeholder logos — no real client logos exist yet, so these
 * are generic wordmark placeholders (text + simple geometric mark) generated
 * for this build. Swap the actual repeater rows in wp-admin once real client
 * logos are available; nothing in the template needs to change.
 */
define( 'SNAP_TRUST_LOGO_1_ID', 40 ); // Acme Co.
define( 'SNAP_TRUST_LOGO_2_ID', 41 ); // Nimbus
define( 'SNAP_TRUST_LOGO_3_ID', 42 ); // Ledger & Co
define( 'SNAP_TRUST_LOGO_4_ID', 43 ); // Northgate
define( 'SNAP_TRUST_LOGO_5_ID', 44 ); // Bramwell
define( 'SNAP_TRUST_LOGO_6_ID', 45 ); // Kestrel

/**
 * "The Problem" section (Figma node 15150:1708, "Frame 37").
 *
 * Node 15150:1712 (the orange backing peeking behind the photo) is a flat,
 * unshadowed color fill with no image content — same as the hero's
 * illustration backdrop and card backing — so it's a plain CSS div, not an
 * ACF image field; only the real photo (15150:1713) needs one. The X icon
 * (fi_1828666) is reused identically across all 4 pain-point rows (same
 * paths/color each time, confirmed via get_design_context), so one shared
 * default suffices for the repeater.
 */
define( 'SNAP_PROBLEM_PHOTO_ID', 46 );
define( 'SNAP_PROBLEM_ICON_X_ID', 47 );

/**
 * "Meet Snap" section (Figma node 15150:1666, "Frame 38").
 *
 * Node 15150:1669 (the orange card behind the illustration/steps) is a flat
 * unshadowed fill, no image content — same CSS-div pattern as the hero
 * backdrop and the Problem section's photo backing.
 */
define( 'SNAP_MEET_PHOTO_ID', 48 );
define( 'SNAP_MEET_ICON_CAPTURE_ID', 49 );
define( 'SNAP_MEET_ICON_EXTRACT_ID', 50 );
define( 'SNAP_MEET_ICON_REVIEW_ID', 51 );
define( 'SNAP_MEET_ICON_EXPORT_ID', 52 );

/**
 * "More Than OCR" section (Figma node 15150:1588, "04 / More Than OCR").
 *
 * The background grid (15150:1589) is a decorative full-bleed vector, not
 * page content — same theme-constant pattern as SNAP_PAGE_BACKGROUND_GRID_ID
 * above, not an ACF field. The minus/check icons ARE ACF fields (one per
 * repeater row) since they're real content icons, but each column reuses
 * the identical icon across all of its rows (confirmed via get_design_context
 * — every row in a column references the same Figma icon component), so one
 * shared default per column is enough.
 */
define( 'SNAP_OCR_BACKGROUND_GRID_ID', 53 );
define( 'SNAP_OCR_ICON_MINUS_ID', 54 );
define( 'SNAP_OCR_ICON_CHECK_ID', 55 );

/**
 * "Designed Around UK Accounting Workflows" section (Figma node 15150:1739,
 * "Background"). Same check-icon glyph as the More Than OCR section's Snap
 * column, re-exported at its own 42x42 native size here rather than
 * upscaling the 21x21 asset — both are the same fi_14090371 vector, just
 * exported at the size each section actually uses.
 */
define( 'SNAP_UK_PHOTO_ID', 56 );
define( 'SNAP_UK_ICON_CHECK_ID', 57 );

/**
 * "How Snap Works" section (Figma node 15150:1803, "Frame 55").
 *
 * This section had THREE duplicate-pair questions, all resolved by
 * checking which layer Figma's own rendered screenshot actually shows on
 * top (later siblings in the layer list paint over earlier ones):
 *
 * 1. Heading/eyebrow exist twice — once nested inside the 4-step frame
 *    (15150:1847/1870) and once as section-level siblings (15150:1972/
 *    1973). The section-level pair is what's visible; the nested pair is
 *    fully covered by the opaque white step-timeline card sitting on top
 *    of it. Its node NAME says "How you get a new career in 5 months" but
 *    that's a stale Figma layer name — the actual TEXT CONTENT rendered
 *    (confirmed in the screenshot) is "One clean flow. Zero busywork.",
 *    which is legitimate Snap copy, not placeholder text.
 * 2. The 4-step timeline is two frames: 15150:1804 (orange, offset 8px
 *    up/right) and 15150:1889 (white, on top). Same peeking-color-backing
 *    pattern used everywhere else in this build (hero, Meet Snap, Built
 *    for UK) — 1804 is a plain backing div, all visible icons/titles/
 *    connectors come from 1889.
 * 3. The integration strip is two frames: 15150:1974 (solid orange, small
 *    right-side photo only) and 15150:2000 (full-width photo background,
 *    on top). 2000 is what's visible — 1974 is again just the peeking
 *    backing. Within 2000 itself, there's a THIRD-level duplicate: photo
 *    15150:2001 vs 15150:2002 (2002 has a dark gradient overlay and paints
 *    last) — 2002 is the one actually visible.
 */
define( 'SNAP_HSW_BG_PHOTO_ID', 58 );
define( 'SNAP_HSW_SUBJECT_CUTOUT_ID', 59 );
define( 'SNAP_HSW_ICON_UPLOAD_ID', 60 );
define( 'SNAP_HSW_ICON_UNDERSTAND_ID', 61 );
define( 'SNAP_HSW_ICON_VALIDATE_ID', 62 );
define( 'SNAP_HSW_ICON_DELIVER_ID', 63 );
define( 'SNAP_HSW_CONNECTOR_LINE_ID', 64 );
define( 'SNAP_HSW_CONNECTOR_CHEVRON_ID', 65 );
define( 'SNAP_HSW_INTEGRATION_XERO_ID', 66 );
define( 'SNAP_HSW_INTEGRATION_QB_ID', 67 );
define( 'SNAP_HSW_INTEGRATION_LB_ID', 68 );
define( 'SNAP_HSW_UK_FLAG_ID', 69 );
define( 'SNAP_HSW_COPY_UNDERLINE_ID', 70 );

/**
 * "Real Usecases" section (Figma node 15151:902, "Frame 64").
 *
 * Each row's main photo has a flat orange "backing" rectangle behind it
 * (15150:1492/1493/1494/1495) — same peeking-color-backing pattern as every
 * other section, not a real second photo, so it's a CSS div. Rows 1 and 3
 * ("Stock Photo — Generated & Embedded" frames) each contain 2-3 candidate
 * photo layers from design iteration; only the LAST one in each frame's
 * layer list is actually visible (confirmed against a 1:1 screenshot) —
 * the others are fully-covered leftovers, not used here.
 *
 * Two floating cards per row ("Monthly Profit" on the Bookkeepers row,
 * "Expense Summary" on the SMEs row) were not in the original brief but are
 * genuinely visible in Figma's own rendered screenshot, so they're included.
 */
define( 'SNAP_USECASES_ROW1_PHOTO_ID', 71 );
define( 'SNAP_USECASES_ROW2_PHOTO_ID', 72 );
define( 'SNAP_USECASES_ROW3_PHOTO_ID', 73 );
define( 'SNAP_USECASES_ROW4_PHOTO_ID', 74 );
define( 'SNAP_USECASES_ROW1_ICON_ID', 75 );
define( 'SNAP_USECASES_ROW2_ICON_ID', 76 );
define( 'SNAP_USECASES_ROW3_ICON_ID', 77 );
define( 'SNAP_USECASES_ROW4_ICON_ID', 78 );
define( 'SNAP_USECASES_R1_INVOICE_ICON_ID', 79 );
define( 'SNAP_USECASES_R1_FILED_CHECK_ID', 80 );
define( 'SNAP_USECASES_R1_APPROVED_CIRCLE_ID', 81 );
define( 'SNAP_USECASES_R1_APPROVED_CHECK_ID', 82 );
define( 'SNAP_USECASES_R2_RECONCILIATION_BG_ID', 83 );
define( 'SNAP_USECASES_R2_RECONCILIATION_CHECK_ID', 84 );
define( 'SNAP_USECASES_R2_MONTHLY_CHART_ID', 85 );
define( 'SNAP_USECASES_R2_DONUT_CHART_ID', 86 );
define( 'SNAP_USECASES_R3_CAPTURED_BG_ID', 87 );
define( 'SNAP_USECASES_R3_CAPTURED_CHECK_ID', 88 );
define( 'SNAP_USECASES_R3_CAMERA_ICON_ID', 89 );
define( 'SNAP_USECASES_R3_ORGANIZED_CHECK_ID', 90 );
define( 'SNAP_USECASES_R3_EXPENSE_FILE_ICON_ID', 91 );
define( 'SNAP_USECASES_R4_BUILDING_HEADER_ID', 92 );
define( 'SNAP_USECASES_R4_BUILDING_ROW_ID', 93 );
define( 'SNAP_USECASES_R4_FOLDER_ICON_ID', 94 );
define( 'SNAP_USECASES_R4_CENTRALIZED_CHECK_ID', 95 );
define( 'SNAP_USECASES_R4_SYNCED_ICON_ID', 96 );

/*
 * Node 15150:2343 ("Vector") — the footer's logo. Confirmed via the
 * downloaded SVG (fill="#F2440D" / fill="white") that this is a THIRD
 * logo variant, distinct from both the header's (orange icon + black
 * text, for the light header bar) and the CTA section's (plain white
 * icon, no text) — this one is orange icon + WHITE text, specifically
 * for the dark footer background. Reusing the header's custom_logo
 * theme mod here would render the wordmark's text in black, invisible
 * against the footer's #111315 background — confirmed broken by
 * rendering it and pixel-inspecting the result before catching this.
 */
define( 'SNAP_FOOTER_LOGO_ID', 101 );

/**
 * The plain white Snap mark (no text) used on orange backgrounds — first
 * built for the landing page's CTA/Demo Form section. Reused as the
 * default logo for the Pricing page's closing CTA (template-parts/
 * cta-simple.php) rather than re-uploading the same asset a second time.
 */
define( 'SNAP_CTA_LOGO_MARK_ID', 97 );

/**
 * Contact page — icon badges (template-parts/contact.php).
 *
 * The Contact page's info-column badges originally reused
 * SNAP_OCR_ICON_CHECK_ID, which turned out to be a solid-orange-fill SVG
 * (confirmed by inspecting the file: `fill="#FB4B16"` throughout, no
 * white anywhere) — invisible once placed on the badges' matching orange
 * background. The site's actual "icon on an orange badge" precedent (the
 * Real Usecases row icons, e.g. row1-icon.svg / row2-icon.svg) are white-
 * fill outline glyphs instead, so these 4 were hand-authored as simple
 * white-stroke line icons in that same visual weight — no existing
 * asset in the library covers mail/phone/pin/clock concepts, and pulling
 * in a new icon library for 4 glyphs wasn't warranted.
 */
define( 'SNAP_CONTACT_ICON_EMAIL_ID', 107 );
define( 'SNAP_CONTACT_ICON_PHONE_ID', 108 );
define( 'SNAP_CONTACT_ICON_PIN_ID', 109 );
define( 'SNAP_CONTACT_ICON_CLOCK_ID', 110 );
