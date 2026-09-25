# command-net-theme

A [Forumify](https://forumify.net) theme (`majesticdev/command-net-theme`) — dark, tactical,
military-ops-inspired — for **Spearhead Gaming**'s Forumify install. Replaces the
unconfigured homepage with a dashboard showing per-unit forum sections, an operation-status
panel, and online-activity stats, all backed by real data (no fabricated counts). See
[README.md](README.md) for the full feature list and [`CHANGELOG.md`](CHANGELOG.md) for
version history.

**Pure template/asset overrides — this theme writes nothing to the database and has no
entities/migrations of its own.**

Built for this one community, not a general-purpose skeleton.

## The ecosystem

Sibling repos (PHP, `G:\Github Repos`): **commandnet-plugin** (soft dependency — the
operation-status panel calls `command_net_online_count()` and reads its `Operation`
repository when that plugin is active; the theme still works without it, just with a plainer
panel), **commandnet-s3-plugin**, **commandnet-discord-plugin**, **commandnet-discord-bot**,
**forumify-id-card-plugin**.

## The unit forums this theme expects

The homepage's top navigation looks for exactly five Forumify `Forum` entities by **slug**:
`hq`, `reaper`, `misfit`, `gambler`, `viking` (see `templates/Forumify/frontend/base.html.twig`
— `unitDefinitions`). **The theme does not create these forums itself** — if they don't exist
in the target Forumify install, the top nav falls back to the first 6 accessible forums in
admin order. To use different slugs, override `commandNetUnitDefinitions` in a local
`templates/themes/majesticdev/command-net-theme/Forumify/frontend/base.html.twig` (see README
"Map existing slugs").

Remember Forumify's `Forum`/`ACL` default-deny: a forum with no `ACL` rows is invisible to
*everyone*, admin included, until `view` (and `create_topic`/`create_comment` for posting) is
granted to the relevant roles.

## Local dev

Developed via a Composer **path repository** — the real Forumify app is `~/dev/forumify` in
WSL, whose `composer.json` points a `path` repo at this directory's WSL path
(`/mnt/g/Github Repos/command-net-theme`). After install/refresh, `forumify:plugins:refresh`
copies `public/` into `public/themes/majesticdev/command-net-theme/` — a stale copy there
after editing `public/` source is a common "my CSS/JS change isn't showing" cause; re-run
refresh (and clear cache) rather than assuming the edit was wrong.

```bash
bin/console forumify:plugins:refresh
bin/console cache:clear
```
Then activate **Command Net Theme** in admin theme settings if not already active.

## Testing

`tests/render.php` is a standalone PHP fixture-render script (not PHPUnit) that renders the
theme's templates against fixture data and asserts on the output string — e.g. it checks that
a restricted unit's forum link is omitted before the component even runs. Read it before
assuming Twig-only manual testing is the only option here.

## Gotchas learned the hard way

- **CMS snippets, not live polling, drive the "extra" homepage stats.** `command-net-server-status`,
  `command-net-in-game-count`, `command-net-discord-count` are plain CMS snippets an admin
  types by hand — the theme never queries a game server or Discord's API. A row/stat simply
  doesn't render if its snippet doesn't exist. Don't go looking for a scheduled sync job that
  updates these; there isn't one by design.
- A CMS snippet named **`command-net-operation`** fully replaces the whole operation panel
  with admin-authored content when present — real operation data only shows when that snippet
  is absent or empty.
