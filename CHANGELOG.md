# Changelog

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
