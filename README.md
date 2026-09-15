# Reference fidelity update � v1.1.1

This update includes the original Spearhead patch, a generated decorative terrain texture, subdued condensed heading, tighter sidebar/header/unit proportions, and compact category-labelled discussion rows. Pinned rows appear above the discussion heading through CSS ordering; the native component DOM and query rules stay intact. All displays forum sections in admin order, not a globally sorted feed.

Install all files, including public/reference.css and public/images/, and run plugin refresh and cache clear. This is prepared source; v1.1.1 has not been tagged or published. The existing v1.1.0 tag is unchanged.

The reference's fixed event, online/game/Discord counts and extra destinations are not invented. Populate your CMS operation snippet and Menu Builder with real content. Source artwork stays unchanged; the heading font and map texture are approximations, not exact pixel copies. The reference palette is intentionally applied within the command shell regardless of prior saved accent colors.

# Command Net — v1.1.1

A native Forumify theme for Spearhead Gaming. Requires **PHP 8.4+ and Forumify ^1.3.1**. Template compatibility was checked against upstream tag `1.3.1`, commit `9b6947123513fa8b420c90f4d4d6b83f6cc9b19c`.

## Included

- Desktop sidebar using the configured community logo/title and native Menu Builder output.
- Responsive Command Net masthead, unit navigation and CMS operation briefing.
- Default homepage with six recent discussions **per unit**, pinned first, using native TopicList components. All shows unit sections together, not a global chronological merge.
- Real author, reply, tag, read-marker, last-activity and online-user data. No fabricated operation counts, server status, events or Discord/game-player totals.
- Forum view checks before rendering any unit links or discussion components. Native queries retain hidden-topic and own-topic-only restrictions.
- Native account controls, notifications, alerts, posting, subscriptions, regular forum pages, CMS content, privacy link and Forumify attribution.

The mockup's patch is not bundled as a cropped screenshot. Upload the original patch as the community logo; it displays uncropped in the sidebar. Without a configured logo, the original supplied SHG.png patch is used, bundled unchanged as public/images/spearhead.png.

## Install or upgrade

After the reviewed implementation is published as the stable **v1.1.1 Git tag**, run in the Forumify application directory:

```sh
composer require majesticdev/command-net-theme:^1.1 --with-all-dependencies
php bin/console forumify:plugins:refresh
php bin/console cache:clear
```

Activate Command Net in admin theme settings. Refresh copies `public/` into `public/themes/majesticdev/command-net-theme/`. Confirm `style.css`, `reference.css`, and `command-net.js` load. Clear a reverse-proxy/browser cache if an old stylesheet remains. Existing admin color overrides remain configured; optionally reset them to use the revised default gold/muted text.

The `1.1.x-dev` alias is not a stable release. Do not lower application minimum stability. Before publication, install the branch through a Composer path repository on staging, using an explicit development constraint scoped to this package. A source ZIP alone does not register a theme: use Composer and plugin refresh.

## Homepage and units

This replaces Forumify's **unconfigured homepage**. It does not overwrite an existing root CMS page or change `forumify.index`. The welcome page in the original screenshot becomes this dashboard once the theme is active.

Default forum slugs are `hq`, `reaper`, `misfit`, `gambler`, and `viking`. Create those forums with your desired ACLs or map existing slugs below. No records are created by the theme. Missing/restricted units remain as disabled, non-link labels. When no mapped unit forums are accessible, the dashboard selects up to six accessible forums from the first 50 forums in admin order; an empty community still has an honest empty state. Unit order follows admin forum position.

The sidebar supplies Home and Forums. Configure Unit Channels, Events, Media, Resources, Members, Store, or installed plugin destinations in **Menu Builder** using real destinations and appropriate visibility. Avoid duplicate Home/Forums entries. Native menu collections continue to use Forumify's controller.

### Map existing slugs

In your application, create `templates/themes/majesticdev/command-net-theme/Forumify/frontend/base.html.twig`:

```twig
{% extends '@!Forumify/frontend/base.html.twig' %}
{% set commandNetUnitDefinitions = {
    'headquarters': {label: 'HQ', subtitle: 'Command & news', icon: 'compass'},
    'reaper-company': {label: 'Reaper', subtitle: 'Special operations', icon: 'skull'},
    'misfit': {label: 'Misfit', subtitle: 'Recon & scouting', icon: 'spade'},
    'gambler': {label: 'Gambler', subtitle: 'Aviation', icon: 'dice-five'},
    'viking': {label: 'Viking', subtitle: 'Infantry', icon: 'axe'}
} %}
```

Forumify chains local theme overrides after the package. Clear the application cache after adding it. Use actual slugs, not display titles or guessed database IDs. Keep customizations out of vendor files.

### Operation briefing

By default (no `command-net-operation` snippet, or an empty one) the panel now shows **real data**, not placeholders:

- Community status: current online-user count (`command_net_online_count()`, same 5-minute activity window as Forumify's own online-users widget).
- Operations: count of not-yet-cancelled, not-yet-started `MajesticDev\CommandNet\Entity\Operation` rows (`OperationRepository::countUpcoming()`).
- Upcoming event: the soonest such operation's title and start time (`OperationRepository::findNextUpcoming()`); a "Live" badge appears automatically when that operation's status is `in_progress`.

Nothing here polls a game server. To also show a **server status** line, create a CMS snippet with slug **`command-net-server-status`** containing plain text (e.g. `Operational`) — it's admin-typed, not fetched, and the row is omitted entirely if the snippet doesn't exist. To fully replace the whole panel with your own editorial content instead, create a CMS snippet with slug **`command-net-operation`**; its rendered content wins over everything above, same as before.

### Online activity stats

The "online now" bar's "On forums" number is the same live count as above. To also show "In game" and "In Discord" numbers, create CMS snippets **`command-net-in-game-count`** and **`command-net-discord-count`** with plain numeric text — each stat only renders when its snippet exists and is non-empty. These are not polled from any game server or Discord's API; update them by hand.

### Sidebar navigation

Home and Forums are built in. Everything else — Unit Channels, Events, Media, Resources, Members, Store, or any installed plugin's own pages — is Forumify's native **Menu Builder** (Settings → Menu in admin), rendered automatically by the existing `forum_menu()` call. A menu item's "Route" type can target any named route, including this plugin's own `command_net_roster` (Members) or `forumify_cms_page` with a `urlKey` parameter (for a CMS page you've created). No theme code is involved in adding these.

### Sidebar ribbon and grid HUD

The "Spearhead" ribbon above the sidebar patch is static branding, matching the hardcoded "Command Net" wordmark elsewhere. The decorative grid-reference text in the top-right HUD (visible at wide/desktop widths) defaults to "AO SPEARHEAD" but can be overridden with a plain-text CMS snippet slug **`command-net-grid-ref`** — purely cosmetic, not a real coordinate.

### Discussion category tags

The "Category" column and each row's icon now come from the topic's first Forum Tag (Admin → Forums → a forum → Tags), using that tag's own admin-configured color (`tag.color`, contrast-computed text via the existing `fg_color` filter) — not a fixed palette. The icon is looked up from the tag's slug against a small built-in map (`hq`/`announcements` → megaphone, `operations` → calendar, `media` → camera, `training` → graduation cap, `introductions` → question mark), falling back to a generic chat icon for anything else; pinned topics always use the megaphone icon regardless of tag. A topic with no tag falls back to showing its forum's name, as before.

## Files

| File | Purpose |
| --- | --- |
| `templates/Forumify/frontend/base.html.twig` | Shell, sidebar, hero and permitted units; native head/footer retained |
| `templates/Forumify/frontend/blocks/header/header.html.twig` | Account, notifications and theme toolbar |
| `templates/Forumify/frontend/index.html.twig` | Default dashboard, filters and online activity |
| `templates/Forumify/frontend/components/topic_list.html.twig` | Compact widget rows; parent output for normal forum lists |
| `public/style.css` | Native variable mapping and responsive styles |
| `public/command-net.js` | Progressive filtering and active sidebar links |

Only templates with existing upstream parents are overridden. Forumify automatically constructs the inheritance chain; new partial templates in this namespace can fail if an original does not exist. The legacy forum-list file is retained as a first-line extends-only replacement to support ZIP upgrades.

Fonts use Google Fonts with system fallbacks. Icons use Forumify's existing Phosphor assets. No frontend build is required to install the theme. Both light and dark modes remain available.

## Validation

```sh
composer validate --strict
php -l src/CommandNetTheme.php
node --check public/command-net.js
composer install --working-dir=tests --no-interaction --no-plugins --no-scripts
php tests/render.php /path/to/forumify-platform
```

The isolated suite uses the **real Forumify override loader and upstream templates**, strict Twig variables and fixture services/component data. It checks guest/member controls, permissions before component calls, missing/restricted units, empty topics, pinned rows, read markers, safe text, snippets, native forum/CMS content, privacy and attribution. It does not establish real Doctrine query behavior or authenticated HTTP workflows.

Local browser checks use rendered fixtures with the actual upstream stylesheet. They cover mobile overflow and unit filtering. Fixture screenshots are not a live production install.

### Staging release gate

Before publishing v1.1.1:

1. Refresh/activate the theme and verify assets and overrides load.
2. Check guest/member/moderator views. Private units must be absent for unauthorized accounts; verify own-topic-only forums with two accounts.
3. Open, post and reply to topics; subscribe, sort and paginate. Check notifications, profile/settings, logout and both theme modes.
4. Verify existing CMS content, nested menus and installed plugin routes at desktop and phone widths. Keep privacy and Powered by forumify visible.
5. Verify the actual logo, unit mappings and operation snippet. Native online users are recently active Forumify accounts, not Discord/game-server players.

There was no running Forumify application/database in this workspace. These installed-instance checks remain pending. This is a prepared release implementation, not a verified production deployment.

## Publish and rollback

After staging passes, merge the reviewed changes and create an annotated `v1.1.1` tag at that commit. Publish the release and refresh the Composer package index. Do not add a composer.json version field or retag v1.0.0.

To roll back, select the prior theme or reinstall the previous stable version, refresh plugins and clear cache. No community data is migrated or removed.

References: [Forumify theme guide](https://docs.forumify.net/guides/theme), [Forumify 1.3.1 source](https://github.com/forumify/forumify-platform/tree/1.3.1).
