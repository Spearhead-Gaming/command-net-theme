<?php

namespace MajesticDev\CommandNetTheme;

use Forumify\Plugin\AbstractForumifyTheme;
use Forumify\Plugin\PluginMetadata;
use Forumify\Plugin\ThemeConfig;
use Forumify\Plugin\ThemeVar;
use Forumify\Plugin\ThemeVarType;

/**
 * "Command Net" — a dark tactical/military-ops theme for forumify.
 *
 * Version 1.1.0: native frontend shell and permission-aware dashboard.
 */
class CommandNetTheme extends AbstractForumifyTheme
{
    public function getPluginMetadata(): PluginMetadata
    {
        return new PluginMetadata(
            'Command Net',
            'Spearhead Gaming',
            'Command Net community dashboard with native Forumify navigation, unit channels, discussions and account controls.'
        );
    }

    /**
     * Loaded on every page. Must exist in /public.
     */
    public function getStylesheets(): array
    {
        return ['style.css', 'reference.css'];
    }

    /**
     * All colors below are exposed as CSS custom properties (e.g. var(--c-bg))
     * and become editable by admins under Settings -> Themes, without touching code.
     *
     * Value priority:
     *   Dark mode:  User Config > Dark Default > Default
     *   Light mode: User Config > Default
     */
    public function getThemeConfig(): ThemeConfig
    {
        return new ThemeConfig(
            hasDarkVariant: true,
            vars: [
                // Surfaces
                new ThemeVar(
                    key: 'c-bg',
                    label: 'Page Background',
                    type: ThemeVarType::Color,
                    defaultValue: '#eae6db',
                    defaultDarkValue: '#111310',
                ),
                new ThemeVar(
                    key: 'c-bg-elevated',
                    label: 'Panel / Card Background',
                    type: ThemeVarType::Color,
                    defaultValue: '#ffffff',
                    defaultDarkValue: '#181b16',
                ),
                new ThemeVar(
                    key: 'c-bg-sunken',
                    label: 'Sunken Background (headers, nav)',
                    type: ThemeVarType::Color,
                    defaultValue: '#dcd7ca',
                    defaultDarkValue: '#0b0d0a',
                ),
                new ThemeVar(
                    key: 'c-border',
                    label: 'Border Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#c8c2b0',
                    defaultDarkValue: '#2b2e26',
                ),

                // Text
                new ThemeVar(
                    key: 'c-text',
                    label: 'Primary Text',
                    type: ThemeVarType::Color,
                    defaultValue: '#1b1a15',
                    defaultDarkValue: '#e9e4d6',
                ),
                new ThemeVar(
                    key: 'c-text-muted',
                    label: 'Muted / Secondary Text',
                    type: ThemeVarType::Color,
                    defaultValue: '#5c5848',
                    defaultDarkValue: '#a5a99c',
                ),

                // Brand / accent
                new ThemeVar(
                    key: 'c-accent',
                    label: 'Accent (Rank Gold)',
                    type: ThemeVarType::Color,
                    defaultValue: '#8a6d1f',
                    defaultDarkValue: '#c7ab6c',
                ),
                new ThemeVar(
                    key: 'c-accent-contrast',
                    label: 'Text on Accent',
                    type: ThemeVarType::Color,
                    defaultValue: '#141209',
                    defaultDarkValue: '#141209',
                ),

                // Status colors
                new ThemeVar(
                    key: 'c-status-online',
                    label: 'Online / Operational',
                    type: ThemeVarType::Color,
                    defaultValue: '#4c7a3d',
                    defaultDarkValue: '#6f9c4d',
                ),
                new ThemeVar(
                    key: 'c-status-live',
                    label: 'Live / Alert / Pinned',
                    type: ThemeVarType::Color,
                    defaultValue: '#a3312a',
                    defaultDarkValue: '#c0392b',
                ),
            ],
        );
    }
}
