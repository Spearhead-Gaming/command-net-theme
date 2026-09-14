# Command Net — forumify theme

A dark, tactical/military-ops themed skin for forumify, inspired by the
"Command Net" HQ dashboard mockup: gold rank-style accents, status dots
(online/live), category tab cards, and a stencil-style uppercase header
font on top of a clean body font.

## What's in the box

```
command-net-theme/
  composer.json                         theme package manifest
  src/CommandNetTheme.php               theme class: metadata + editable CSS vars
  public/style.css                      the actual theme styling
  templates/Forumify/frontend/forum/
    list.html.twig                      example (optional) template override
```

This follows forumify's official theme spec:
https://docs.forumify.net/guides/theme

## 1. Rename it to your vendor

Before installing, find-and-replace `YourVendor` and `yourvendor` throughout
`composer.json` and `src/CommandNetTheme.php` with your own namespace,
e.g. `AcmeCorp`. Also update the `PluginMetadata` name/author/description
in `CommandNetTheme.php` to whatever you want shown in the admin panel.

## 2. Test it locally

Assuming your forumify install and this theme folder are siblings:

```
/forumify
/command-net-theme
```

Add a path repository to **your instance's** `composer.json` (not the theme's):

```json
{
    "repositories": [
        {
            "type": "path",
            "url": "../command-net-theme"
        }
    ]
}
```

Then, from `/forumify`:

```
composer require yourvendor/command-net-theme:@dev
```

If it doesn't show up automatically under **Settings → Themes**, run:

```
php bin/console forumify:plugins:refresh
```

Activate it there, then open the theme's settings to tweak the color
variables (Page Background, Accent/Rank Gold, Online/Live status colors,
etc.) live — including separate values for dark mode.

## 3. Matching the mockup further

`public/style.css` is organized in four parts:

1. **Fonts + base page** — Oswald for headings/stencil feel, Inter for body
   text, plus a very subtle grid-line background texture.
2. **Framework primitives** — restyles forumify's actual documented classes
   (`.box`, `.card` / `.card-title` / `.card-body` / `.card-footer`,
   `.btn-primary` / `.btn-cta` / `.btn-outlined` / `.btn-link`) so every
   built-in component picks up the theme automatically.
3. **Header/nav** — best-effort selectors (`header`, `.site-header`, `nav a`,
   `.menu a`). If your installed forumify version renders different class
   names, open devtools on your live site, find the real selectors, and
   add matching rules — the CSS variables (`var(--c-accent)`, etc.) will
   still do the heavy lifting.
4. **Utility classes** you can drop into CMS content blocks or your own
   template overrides to rebuild specific pieces of the mockup:
   - `.status-dot` / `.status-dot--online` / `.status-dot--live`
   - `.tag-pill`, `.tag-pill--accent`, `.tag-pill--live`
   - `.badge-live` (the pulsing "● LIVE" label)
   - `.stat-row` (the "Community Status / Operations / Server Status" list)
   - `.category-tabs` (the HQ / REAPER / MISFIT / GAMBLER / VIKING row)
   - `.pinned-strip` (the pinned-post callout)
   - `.avatar-ring`, `.avatar-ring--online`

Example, recreating the "Operation" status card body:

```html
<div class="card">
  <div class="card-title">🌲 Operation Pine <span class="badge-live">Live</span></div>
  <div class="card-body">
    <div class="stat-row"><span class="label">Community Status</span><span class="value"><span class="status-dot status-dot--online"></span>Online 237</span></div>
    <div class="stat-row"><span class="label">Operations</span><span class="value">2 Active</span></div>
    <div class="stat-row"><span class="label">Server Status</span><span class="value"><span class="status-dot status-dot--online"></span>Operational</span></div>
  </div>
</div>
```

And the category row:

```html
<div class="category-tabs">
  <a href="/forum/hq" class="active"><span>🗡️</span><span><strong>HQ</strong><span>Command &amp; News</span></span></a>
  <a href="/forum/reaper"><span>💀</span><span><strong>Reaper</strong><span>Special Operations</span></span></a>
  <a href="/forum/misfit"><span>♠</span><span><strong>Misfit</strong><span>Recon &amp; Scouting</span></span></a>
</div>
```

## 4. Template overrides (optional)

`templates/Forumify/frontend/forum/list.html.twig` shows the documented
override pattern: extend the original with `@!`, override only the `body`
block, call `parent()` to keep the original content. Delete it if you don't
need it — the theme works fine on CSS alone. Block coverage differs by
template/version, so if you want to override a page that has no block yet,
you'll need to add one to the core/plugin template and submit a PR, per
the official guide.

## 5. Publish

When ready to share/sell it, push this to a public git repo and register
it on Packagist, per:
https://docs.forumify.net/guides/theme#publishing
