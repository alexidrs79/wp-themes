# wp-themes

Custom WordPress themes, kept in one repo so they share history, tooling conventions, and a single place to look for anything client-theme-related.

## Themes

### `snap/`

Custom theme for **Snap**, an AI document-processing product for UK accounting. Built around ACF Pro field groups (one per landing-page section — Hero, Trust, Problem, Meet Snap, More Than OCR, Built for UK, How Snap Works, Real Usecases, CTA/Demo, Contact, Pricing) and template parts under `template-parts/`.

- Design source of truth: Figma file 'https://www.figma.com/design/Z4GJ8kwnbWMldCHHZbaEHY/Design-Team---General?node-id=15150-79&p=f&m=dev'. Most section rules in `style.css` and `template-parts/*.php` carry a comment citing the exact Figma node ID they were pulled from — don't eyeball redesign a section without checking there first.
- Decorative icons/images live in the Media Library and are referenced from `inc/media-defaults.php` via `snap_print_icon()` (see `theme-setup.php`). Newer constants there hold a filename stem (e.g. `hero-scan-glyph`) rather than a numeric attachment ID — numeric IDs are environment-specific and silently break on any install other than the one they were captured against. Prefer the filename-stem style for anything new.
- Local dev: this folder is the real, git-tracked copy. The Local by Flywheel site's `wp-content/themes/snap` is a **symlink** into this repo — edit here, the running site picks it up immediately, no syncing step.
- Live site: `snaplanding.lucibook.co.uk`. There is currently no automated deploy — code and content are pushed to live manually. See the note below.

### `devotel/`

Official marketing theme for **devotel.com** — carrier-grade telecom/communications product. Also ACF-driven, with page rendering and section logic split across `inc/` (`dynamic-sections.php`, `page-render.php`, `inner-page-layout.php`, `acf.php`, `gutenberg.php`, etc.) and reusable pieces in `template-parts/`.

- `patterns/` holds block patterns; `snapshots/` holds Playwright-captured reference screenshots per page (`about-us`, `blog`, `brand-kit`, `contact-us`, ...) used for visual QA — see `tools/qa-header.mjs` and `tools/verify-*.php`/`.js` for how they're driven.
- `node_modules/` (gitignored) only needs `playwright`/`playwright-core` — there's no CSS/JS build step, assets are authored directly under `assets/`.

## Known gap: no content/DB sync between local and live

Both themes' *code* can be deployed to their respective live sites, but neither has an automated way to carry ACF *content* (post meta, options-page values, media library uploads) along with it. In practice this means:

- A live database was cloned from local once, at each site's launch, and hasn't been kept in sync since.
- Any ACF field added locally after that point will silently render blank on live, even though wp-admin's edit screen can look populated (ACF's `default_value` pre-fills the *edit form* for a never-saved field — it doesn't affect what `get_field()` actually returns on the front end).
- Media Library attachment IDs aren't portable between installs. A constant that hardcodes a numeric ID will break the moment code re-deploys to an environment where that ID means something else (or nothing). This bit Snap's hero-section icons twice — see the filename-stem fix in `snap/theme-setup.php` for the pattern to follow instead.

Until there's a real sync step (WP-CLI over SSH, scripted `wp db export`/`import`, or similar), treat "add new ACF content locally" as needing a **manual follow-up step on live** every time — and prefer filename-stem-style lookups over hardcoded attachment IDs for anything new.
