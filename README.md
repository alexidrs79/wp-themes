# Wordpress themes

Custom WordPress themes, kept in one repo so they share history, tooling conventions, and a single place to look for anything client-theme-related.

## Themes

### `snap/`

Custom theme for **Snap**, an AI document-processing product for UK accounting. Built around ACF Pro field groups (one per landing-page section — Hero, Trust, Problem, Meet Snap, More Than OCR, Built for UK, How Snap Works, Real Usecases, CTA/Demo, Contact, Pricing) and template parts under `template-parts/`.

- Design source of truth: Figma file 'https://www.figma.com/design/Z4GJ8kwnbWMldCHHZbaEHY/Design-Team---General?node-id=15150-79&p=f&m=dev'. Most section rules in `style.css` and `template-parts/*.php`.
- Decorative icons/images live in the Media Library and are referenced from `inc/media-defaults.php` via `snap_print_icon()` (see `theme-setup.php`). Newer constants there hold a filename stem (e.g. `hero-scan-glyph`) rather than a numeric attachment ID — numeric IDs are environment-specific and silently break on any install other than the one they were captured against. Prefer the filename-stem style for anything new.
- Local dev: this folder is the real, git-tracked copy. The Local by Flywheel site's `wp-content/themes/snap` is a **symlink** into this repo — edit here, the running site picks it up immediately, no syncing step.
- Live site: `snaplanding.lucibook.co.uk`. There is currently no automated deploy — code and content are pushed to live manually. See the note below.

### `devotel/`

Official marketing theme for **devotel.com** — carrier-grade telecom/communications product. Also ACF-driven, with page rendering and section logic split across `inc/` (`dynamic-sections.php`, `page-render.php`, `inner-page-layout.php`, `acf.php`, `gutenberg.php`, etc.) and reusable pieces in `template-parts/`.

- `patterns/` holds block patterns; `snapshots/` holds Playwright-captured reference screenshots per page (`about-us`, `blog`, `brand-kit`, `contact-us`, ...) used for visual QA — see `tools/qa-header.mjs` and `tools/verify-*.php`/`.js` for how they're driven.
- `node_modules/` (gitignored) only needs `playwright`/`playwright-core` — there's no CSS/JS build step, assets are authored directly under `assets/`.
