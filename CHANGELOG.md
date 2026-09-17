# Changelog

## Unreleased

- Fix: activating this theme silently broke the admin dashboard's color scheme and
  light/dark toggle. ThemeService generates the site's CSS from whichever theme is
  *active*, without falling back to the base Forumify Theme's variables - so a theme
  that only defines its own bespoke vars (as this one did) leaves every surface that
  isn't explicitly reskinned by style.css (most notably the whole admin
  panel, which intentionally excludes a theme's custom stylesheets) without a color
  scheme at all. Filled in the full set of variables Forumify\ForumifyTheme ships
  (c-primary, c-elevation-0..5, border-*, etc.) using this theme's own tactical
  palette, so admin gets a matching dark/light scheme with no core template changes.
- Consolidated `public/reference.css` into `public/style.css` and removed
  reference.css entirely; the theme now ships a single stylesheet. Replaced
  hardcoded/stale hex colors throughout with the existing `--c-*` custom
  properties so admin-configured theme colors actually propagate to every
  surface (sidebar nav, unit nav, section headings, filter tabs, status
  colors) instead of only the surfaces reference.css didn't touch. Also
  reconciled three sets of overlapping responsive breakpoints (two separate
  ~1100px rules, plus duplicate 800px/600px rules) that previously produced
  conflicting cascade behavior into one block per breakpoint.

## 1.1.1

- Bundle the original Spearhead patch unchanged and a generated terrain background.
- Match reference proportions, muted palette, stencil masthead, pinned banner and compact discussion table.
- Keep missing units visible as disabled labels; fall back to existing accessible forums.
- Add category links and preserve live component DOM while visually consolidating rows.
- Extend render coverage to non-unit forums and disabled unit links.

## 1.1.0

- Add desktop sidebar, responsive navigation, Command Net masthead and operation briefing panel through native frontend overrides.
- Preserve Forumify account controls, notifications, theme switch, alerts, metadata, assets, privacy link and attribution.
- Replace the unconfigured homepage with a dynamic unit dashboard. Existing CMS homepages and index overrides keep their content.
- Resolve real HQ/Reaper/Misfit/Gambler/Viking forums, check view permissions and use native TopicList components.
- Add progressive unit filters, pinned rows, author/reply/activity columns, empty states and native online users.
- Preserve the upstream discussion list for normal forum pages, including sorting, subscriptions and posting controls.
- Map configurable colors to Forumify's actual CSS variables.
- Require PHP 8.4+ and Forumify ^1.3.1. Update the development alias to 1.1.x-dev; stable installation requires a v1.1.0 Git tag.
- Add real-loader template contract checks and CI.

See README.md for validation scope and the pending installed-instance release gate.
