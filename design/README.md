# Design reference

`command-net-theme-kit/` is a design reconstruction kit (layout spec, color tokens,
textures, icons) matching the original Command Net mockup. Kept here as source material
for future design work — not all of it is wired into the theme yet.

## What's actually in use (copied into `public/images/`)

- `assets/backgrounds/bg-command-topo-2048.png` → re-compressed as `bg-command-topo-2048.jpg`,
  the page/hero background.
- `assets/backgrounds/bg-sidebar-grain.png` → re-compressed as `bg-sidebar-grain.jpg`,
  the sidebar fill.
- `assets/textures/overlay-micro-noise.png` → downsized/re-compressed, layered into the
  operation briefing panel via `background-blend-mode`.
- `assets/icons/units/*.svg` → inlined directly into `templates/Forumify/frontend/base.html.twig`
  (as `currentColor` paths, not `<img>` tags, so they pick up the gold hover/active tint the
  way the old Phosphor icon font did) for the five unit tabs.
- `assets/decor/compass.svg` → inlined into the hero HUD compass.
- `docs/theme-tokens.css`'s exact color values → applied to `ThemeConfig`'s dark defaults
  in `src/CommandNetTheme.php` and the hardcoded fidelity values in `public/reference.css`.

## Not yet used

- `assets/icons/navigation/*.svg` — the sidebar's Home/Forums links (and native menu items)
  still use Forumify's own Phosphor icon font; swapping them would mean auditing every
  `forum_menu()`-driven nav item, not just these two.
- `assets/brand/command-net-lockup-editable.svg` — deliberately not used. The theme already
  has real Spearhead Gaming patch artwork (`public/images/spearhead.png`); this generic
  lockup is a placeholder for communities that don't.
- `assets/textures/texture-worn-gold.png`, `assets/decor/divider-gold.svg`,
  `assets/decor/status-live.svg`, `assets/decor/status-online.svg` — the kit's own
  `implementation-spec.md` recommends keeping status LEDs, separators, and dividers as CSS
  for maintainability, which is what this theme already does. Available if a future pass
  wants the material look instead.
