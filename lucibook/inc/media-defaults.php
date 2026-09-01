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
define( 'LUCIBOOK_HERO_ORB_ID', 'hero-orb' );
define( 'LUCIBOOK_HERO_ICON_SUBMISSION_ID', 'hero-icon-submission' );
define( 'LUCIBOOK_HERO_ICON_RECONCILED_ID', 'hero-icon-reconciled' );
define( 'LUCIBOOK_HERO_ICON_CATEGORISED_ID', 'hero-icon-categorised' );
define( 'LUCIBOOK_HERO_STAR_1_ID', 'hero-star-1' );
define( 'LUCIBOOK_HERO_STAR_2_ID', 'hero-star-2' );

// ---- Section 03 — Reconciliation (LuciCore mockup) ----
define( 'LUCIBOOK_RC_GLOW_LEFT_ID', 'reconciliation-glow-left' );
define( 'LUCIBOOK_RC_GLOW_RIGHT_ID', 'reconciliation-glow-right' );
define( 'LUCIBOOK_RC_BLOB_LEFT_ID', 'reconciliation-blob-left' );
define( 'LUCIBOOK_RC_BLOB_RIGHT_ID', 'reconciliation-blob-right' );
define( 'LUCIBOOK_RC_MARK_ID', 'lucicore-mark' );
define( 'LUCIBOOK_RC_CHECK_CIRCLE_ID', 'reconciliation-check-circle' );
define( 'LUCIBOOK_RC_CHECK_ICON_ID', 'reconciliation-check-icon' );
define( 'LUCIBOOK_RC_RING_1_ID', 'reconciliation-ring-1' );
define( 'LUCIBOOK_RC_RING_2_ID', 'reconciliation-ring-2' );
define( 'LUCIBOOK_RC_RING_3_ID', 'reconciliation-ring-3' );
define( 'LUCIBOOK_RC_SELECT_ALL_CHECK_ID', 'reconciliation-select-all-check' );
define( 'LUCIBOOK_RC_CURSOR_1_ID', 'reconciliation-cursor-1' );
define( 'LUCIBOOK_RC_CURSOR_2_ID', 'reconciliation-cursor-2' );
define( 'LUCIBOOK_RC_CLICK_RAYS_ID', 'reconciliation-click-rays' );
define( 'LUCIBOOK_RC_ROW_DIVIDER_ID', 'reconciliation-row-divider' );
define( 'LUCIBOOK_RC_CHECKBOX_CHECK_ID', 'reconciliation-checkbox-check' );
define( 'LUCIBOOK_RC_STATUS_CIRCLE_ID', 'reconciliation-status-circle' );
define( 'LUCIBOOK_RC_STATUS_CHECK_ID', 'reconciliation-status-check' );
define( 'LUCIBOOK_RC_ROW_ICON_BG_1_ID', 'reconciliation-row-icon-bg-1' );
define( 'LUCIBOOK_RC_ROW_ICON_BG_2_ID', 'reconciliation-row-icon-bg-2' );
define( 'LUCIBOOK_RC_ROW_ICON_BG_3_ID', 'reconciliation-row-icon-bg-3' );
define( 'LUCIBOOK_RC_ROW_ICON_BG_4_ID', 'reconciliation-row-icon-bg-4' );
define( 'LUCIBOOK_RC_ROW_ICON_BG_5_ID', 'reconciliation-row-icon-bg-5' );
define( 'LUCIBOOK_RC_ROW_ICON_1_ID', 'reconciliation-row-icon-1' );
define( 'LUCIBOOK_RC_ROW_ICON_2_ID', 'reconciliation-row-icon-2' );
define( 'LUCIBOOK_RC_ROW_ICON_3_ID', 'reconciliation-row-icon-3' );
define( 'LUCIBOOK_RC_ROW_ICON_4_ID', 'reconciliation-row-icon-4' );
define( 'LUCIBOOK_RC_ROW_ICON_5_ID', 'reconciliation-row-icon-5' );
define( 'LUCIBOOK_RC_BANNER_ICON_ID', 'reconciliation-banner-icon' );
define( 'LUCIBOOK_RC_ACCENT_1_ID', 'reconciliation-accent-1' );
define( 'LUCIBOOK_RC_ACCENT_2_ID', 'reconciliation-accent-2' );
define( 'LUCIBOOK_RC_ACCENT_3_ID', 'reconciliation-accent-3' );
define( 'LUCIBOOK_RC_ACCENT_4_ID', 'reconciliation-accent-4' );
define( 'LUCIBOOK_RC_WALLET_ID', 'reconciliation-wallet' );
define( 'LUCIBOOK_RC_COIN_STACK_ID', 'reconciliation-coin-stack' );

// ---- Section 04 — Luci AI ----
define( 'LUCIBOOK_LUCI_FLAG_ICON_ID', 'luci-flag-icon' );
define( 'LUCIBOOK_LUCI_SEND_ICON_ID', 'luci-send-icon' );
define( 'LUCIBOOK_LUCI_GLOW_ID', 'luci-glow' );
define( 'LUCIBOOK_LUCI_ICON_COMPLIANCE_ID', 'luci-icon-compliance' );
define( 'LUCIBOOK_LUCI_ICON_LEGISLATION_ID', 'luci-icon-legislation' );
define( 'LUCIBOOK_LUCI_ICON_STANDARDS_ID', 'luci-icon-standards' );

// ---- Section 05 — One Connected Workspace ----
define( 'LUCIBOOK_WS_ORBIT_ID', 'workspace-orbit' );
define( 'LUCIBOOK_WS_SNAP_ICON_BUBBLE_ID', 'workspace-snap-icon-bubble' );
define( 'LUCIBOOK_WS_PHONE_SCREEN_ID', 'workspace-phone-screen' );
define( 'LUCIBOOK_WS_CAPTURED_CHECK_ID', 'workspace-captured-check' );
define( 'LUCIBOOK_WS_ACCENT_VECTOR_ID', 'workspace-accent-vector' );
define( 'LUCIBOOK_WS_DASHBOARD_HEADER_ID', 'workspace-dashboard-header' );
define( 'LUCIBOOK_WS_CAMERA_ICON_ID', 'workspace-camera-icon' );
define( 'LUCIBOOK_WS_ROW_ICON_BG_ID', 'workspace-row-icon-bg' );
define( 'LUCIBOOK_WS_ICON_OFFICE_SUPPLIES_ID', 'workspace-icon-office-supplies' );
define( 'LUCIBOOK_WS_CHECK_ID', 'workspace-check' );
define( 'LUCIBOOK_WS_ICON_TRAVEL_ID', 'workspace-icon-travel' );
define( 'LUCIBOOK_WS_ICON_LUNCH_ID', 'workspace-icon-lunch' );
define( 'LUCIBOOK_WS_LUCI_OUTER_GLOW_ID', 'workspace-luci-outer-glow' );
define( 'LUCIBOOK_WS_LUCI_ORB_ID', 'workspace-luci-orb' );
define( 'LUCIBOOK_WS_LUCI_FACE_ID', 'workspace-luci-face' );
define( 'LUCIBOOK_WS_LUCI_FACE_PHOTO_ID', 'workspace-luci-face-photo' );
define( 'LUCIBOOK_WS_LAYERS_BUBBLE_ID', 'workspace-layers-bubble' );
define( 'LUCIBOOK_WS_TOGETHER_ACCENT_1_ID', 'workspace-together-accent-1' );
define( 'LUCIBOOK_WS_TOGETHER_ACCENT_2_ID', 'workspace-together-accent-2' );

// ---- Section 06 — Pricing ----
define( 'LUCIBOOK_PRICING_CHECK_BLUE_ID', 'pricing-check-blue' );
define( 'LUCIBOOK_PRICING_CHECK_WHITE_ID', 'pricing-check-white' );

// ---- Section 07 — Founding Offer ----
define( 'LUCIBOOK_FO_SUNBURST_ID', 'founding-offer-sunburst' );
define( 'LUCIBOOK_FO_LOGO_WHITE_ID', 'founding-offer-logo-white' );
