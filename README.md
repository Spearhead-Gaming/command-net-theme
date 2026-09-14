# Command Net — v1.1.0

A native Forumify theme for Spearhead Gaming. Requires **PHP 8.4+ and Forumify ^1.3.1**. Template compatibility was checked against upstream tag `1.3.1`, commit `9b6947123513fa8b420c90f4d4d6b83f6cc9b19c`.

## Included

- Desktop sidebar using the configured community logo/title and native Menu Builder output.
- Responsive Command Net masthead, unit navigation and CMS operation briefing.
- Default homepage with six recent discussions **per unit**, pinned first, using native TopicList components. All shows unit sections together, not a global chronological merge.
- Real author, reply, tag, read-marker, last-activity and online-user data. No fabricated operation counts, server status, events or Discord/game-player totals.
- Forum view checks before rendering any unit links or discussion components. Native queries retain hidden-topic and own-topic-only restrictions.
- Native account controls, notifications, alerts, posting, subscriptions, regular forum pages, CMS content, privacy link and Forumify attribution.

The mockup's patch is not bundled as a cropped screenshot. Upload the original patch as the community logo; it displays uncropped in the sidebar. Without a logo, a compass fallback appears.

## Install or upgrade

After the reviewed implementation is published as the stable **v1.1.0 Git tag**, run in the Forumify application directory:

```sh
composer require majesticdev/command-net-theme:^1.1 --with-all-dependencies
php bin/console forumify:plugins:refresh
php bin/console cache:clear
```

Activate Command Net in admin theme settings. Refresh copies `public/` into `public/themes/majesticdev/command-net-theme/`. Confirm both `style.css` and `command-net.js` load. Clear a reverse-proxy/browser cache if an old stylesheet remains. Existing admin color overrides remain configured; optionally reset them to use the revised default gold/muted text.

The `1.1.x-dev` alias is not a stable release. Do not lower application minimum stability. Before publication, install the branch through a Composer path repository on staging, using an explicit development constraint scoped to this package. A source ZIP alone does not register a theme: use Composer and plugin refresh.

## Homepage and units

This replaces Forumify's **unconfigured homepage**. It does not overwrite an existing root CMS page or change `forumify.index`. The welcome page in the original screenshot becomes this dashboard once the theme is active.

Default forum slugs are `hq`, `reaper`, `misfit`, `gambler`, and `viking`. Create those forums with your desired ACLs or map existing slugs below. No records are created by the theme. Missing/restricted units are omitted; an empty dashboard links to the forum index. Unit order follows admin forum position.

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

Create a CMS snippet with slug **`command-net-operation`**. Its rendered content fills the panel. Without it, a neutral forum link appears. Fill it with confirmed editorial details or your installed plugin's documented widget/component. This theme does not poll game servers or claim operational status.

Example structure to populate:

```html
<h2>Operation briefing</h2>
<dl>
  <div><dt>Next event</dt><dd>Enter the confirmed schedule</dd></div>
  <div><dt>Briefing</dt><dd>Enter the published briefing location</dd></div>
</dl>
```

Treat the snippet as public editorial content; do not put restricted operation details in it. Forumify's snippet renderer owns sanitization/rendering. Dynamic forum sections retain their ACL checks.

## Files

| File | Purpose |
| --- | --- |
| `templates/Forumify/frontend/base.html.twig` | Shell, sidebar, hero and permitted units; native head/footer retained |
| `templates/Forumify/frontend/blocks/header/header.html.twig` | Account, notifications and theme toolbar |
| `templates/Forumify/frontend/index.html.twig` | Default dashboard, filters and online activity |
| `templates/Forumify/frontend/components/topic_list.html.twig` | Compact widget rows; parent output for normal forum lists |
| `public/style.css` | Native variable mapping and responsive styles |
| `public/command-net.js` | Progressive filtering and active sidebar links |

Only templates with existing upstream parents are overridden. Forumify automatically constructs the inheritance chain; new partial templates in this namespace can fail if an original does not exist. The old sample forum-list wrapper has been removed.

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

Before publishing v1.1.0:

1. Refresh/activate the theme and verify assets and overrides load.
2. Check guest/member/moderator views. Private units must be absent for unauthorized accounts; verify own-topic-only forums with two accounts.
3. Open, post and reply to topics; subscribe, sort and paginate. Check notifications, profile/settings, logout and both theme modes.
4. Verify existing CMS content, nested menus and installed plugin routes at desktop and phone widths. Keep privacy and Powered by forumify visible.
5. Verify the actual logo, unit mappings and operation snippet. Native online users are recently active Forumify accounts, not Discord/game-server players.

There was no running Forumify application/database in this workspace. These installed-instance checks remain pending. This is a prepared release implementation, not a verified production deployment.

## Publish and rollback

After staging passes, merge the reviewed changes and create an annotated `v1.1.0` tag at that commit. Publish the release and refresh the Composer package index. Do not add a composer.json version field or retag v1.0.0.

To roll back, select the prior theme or reinstall the previous stable version, refresh plugins and clear cache. No community data is migrated or removed.

References: [Forumify theme guide](https://docs.forumify.net/guides/theme), [Forumify 1.3.1 source](https://github.com/forumify/forumify-platform/tree/1.3.1).
