# Wordpress themes

[![CI](https://github.com/alexidrs79/wp-themes/actions/workflows/ci.yml/badge.svg)](https://github.com/alexidrs79/wp-themes/actions/workflows/ci.yml)

Custom WordPress themes, kept in one repo so they share history, tooling conventions, and a single place to look for anything client-theme-related.

All three are built the same way: one ACF field group per landing-page section, rendered by a matching part under `template-parts/`. Copy stays editable in wp-admin instead of being hardcoded in PHP, and a section can be reordered or dropped without touching markup.

## Requirements

- WordPress 6.4 or newer, PHP 8.0 or newer
- Advanced Custom Fields **Pro**. The field groups use repeaters and options pages, neither of which the free plugin provides, so a theme activated without it renders its sections empty.

## Installing a theme

Each top-level folder is a whole theme, not a parent/child pair. Copy or symlink one into `wp-content/themes/`, activate it, then create a page and assign the theme's page template — `Snap Landing`, `Lucibook Landing`, `Contact`, or `Pricing`. Devotel renders through `front-page.php` and `inc/page-render.php` instead of a named template.

Section content is then filled in on the page itself, with site-wide values under the theme's own options page.

## Themes

### `snap/`

![The Snap landing page](snap/screenshot.png)

Custom theme for **Snap**, an AI document-processing product for UK accounting. Built around ACF Pro field groups (one per landing-page section — Hero, Trust, Problem, Meet Snap, More Than OCR, Built for UK, How Snap Works, Real Usecases, CTA/Demo, Contact, Pricing) and template parts under `template-parts/`.

- Design source of truth: Figma file 'https://www.figma.com/design/Z4GJ8kwnbWMldCHHZbaEHY/Design-Team---General?node-id=15150-79&p=f&m=dev'. Most section rules in `style.css` and `template-parts/*.php`.
- Decorative icons/images live in the Media Library and are referenced from `inc/media-defaults.php` via `snap_print_icon()` (see `theme-setup.php`). Newer constants there hold a filename stem (e.g. `hero-scan-glyph`) rather than a numeric attachment ID — numeric IDs are environment-specific and silently break on any install other than the one they were captured against. Prefer the filename-stem style for anything new.
- Local dev: this folder is the real, git-tracked copy. The Local by Flywheel site's `wp-content/themes/snap` is a **symlink** into this repo — edit here, the running site picks it up immediately, no syncing step.
- Live site: `snaplanding.lucibook.co.uk`.

### `devotel/`

![The Devotel marketing site](devotel/screenshot.png)

Official marketing theme for **devotel.com** — carrier-grade telecom/communications product. Also ACF-driven, with page rendering and section logic split across `inc/` (`dynamic-sections.php`, `page-render.php`, `inner-page-layout.php`, `acf.php`, `gutenberg.php`, etc.) and reusable pieces in `template-parts/`.

- `patterns/` holds block patterns; `snapshots/` holds Playwright-captured reference screenshots per page (`about-us`, `blog`, `brand-kit`, `contact-us`, ...) used for visual QA — see `tools/qa-header.mjs` and `tools/verify-*.php`/`.js` for how they're driven.
- `node_modules/` (gitignored) only needs `playwright`/`playwright-core` — there's no CSS/JS build step, assets are authored directly under `assets/`.
- `acf-json/` is on, so field-group changes are written to disk and travel with the repo rather than living only in the database.

### `lucibook/`

![The Lucibook landing page](lucibook/screenshot.jpeg)

Landing-page theme for **Lucibook**, the workspace that ties the other products together — Snap for document capture, LuciCore for reconciliation, and Luci AI. Live at `lucibook.co.uk`.

Same shape as Snap: a field group per section in `inc/`, a part per section in `template-parts/`, and the `Lucibook Landing` page template pulling them in order — Hero, Social Proof, Reconciliation, Luci AI, One Connected Workspace, Pricing, Founding Offer.

- Built from Figma node `15532:79` ("Lucibook — Final Landing Page"), with the design tokens at the top of `style.css` taken from that file rather than eyeballed.
- Media lookups use the filename-stem style from the start, so `inc/media-defaults.php` carries no numeric attachment IDs.

## Deploys

There is no automated deploy for any of these. Code and content go to live manually, so a change that works locally is not live until it is copied up, and the database side (ACF values, Media Library items) has to be reproduced on the target install by hand.

Two things follow from that, and both have caused real breakage:

- Anything referencing a Media Library item by numeric ID works only on the install where that ID was captured. Use the filename-stem lookups instead.
- A theme depends on its ACF field groups existing on the target install. Devotel keeps them in `acf-json/`; for Snap and Lucibook the groups are registered in PHP under `inc/`, so they travel with the code.
