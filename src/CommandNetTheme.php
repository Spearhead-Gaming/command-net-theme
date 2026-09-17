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
        return ['style.css'];
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
                    defaultDarkValue: '#0b0f0d',
                ),
                new ThemeVar(
                    key: 'c-bg-elevated',
                    label: 'Panel / Card Background',
                    type: ThemeVarType::Color,
                    defaultValue: '#ffffff',
                    defaultDarkValue: '#151a17',
                ),
                new ThemeVar(
                    key: 'c-bg-sunken',
                    label: 'Sunken Background (headers, nav)',
                    type: ThemeVarType::Color,
                    defaultValue: '#dcd7ca',
                    defaultDarkValue: '#0b0f0d',
                ),
                new ThemeVar(
                    key: 'c-border',
                    label: 'Border Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#c8c2b0',
                    defaultDarkValue: '#3a403b',
                ),

                // Text
                new ThemeVar(
                    key: 'c-text',
                    label: 'Primary Text',
                    type: ThemeVarType::Color,
                    defaultValue: '#1b1a15',
                    defaultDarkValue: '#d9d4c8',
                ),
                new ThemeVar(
                    key: 'c-text-muted',
                    label: 'Muted / Secondary Text',
                    type: ThemeVarType::Color,
                    defaultValue: '#5c5848',
                    defaultDarkValue: '#9a9b93',
                ),

                // Brand / accent
                new ThemeVar(
                    key: 'c-accent',
                    label: 'Accent (Rank Gold)',
                    type: ThemeVarType::Color,
                    defaultValue: '#8a6d1f',
                    defaultDarkValue: '#d2a548',
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
                    defaultDarkValue: '#55ca6a',
                ),
                new ThemeVar(
                    key: 'c-status-live',
                    label: 'Live / Alert / Pinned',
                    type: ThemeVarType::Color,
                    defaultValue: '#a3312a',
                    defaultDarkValue: '#ef4d43',
                ),

                /*
                 * Everything below fills in forumify's own base variable set (the one
                 * Forumify\ForumifyTheme ships). ThemeService generates the site's
                 * light/dark/system CSS from whichever theme is *active* - it doesn't
                 * merge in the base theme's vars as fallbacks, so without these, any
                 * surface that isn't explicitly reskinned by style.css/reference.css
                 * (most notably the whole admin dashboard, which intentionally opts out
                 * of loading a theme's custom stylesheets) loses its color scheme and
                 * its dark/light toggle entirely. Values below are the same tactical
                 * palette as above, just mapped onto forumify's own variable names.
                 */
                new ThemeVar(
                    key: 'c-primary',
                    label: 'Primary Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#8a6d1f',
                    defaultDarkValue: '#d2a548',
                ),
                new ThemeVar(
                    key: 'c-primary-accent',
                    label: 'Primary Accent Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#6d5518',
                    defaultDarkValue: '#8d733d',
                ),
                new ThemeVar(
                    key: 'c-primary-text',
                    label: 'Primary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#141209',
                    defaultDarkValue: '#141209',
                ),
                new ThemeVar(
                    key: 'c-secondary',
                    label: 'Secondary Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#5c5848',
                    defaultDarkValue: '#a5a99c',
                ),
                new ThemeVar(
                    key: 'c-secondary-text',
                    label: 'Secondary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#f5f2e8',
                    defaultDarkValue: '#f5f2e8',
                ),
                new ThemeVar(
                    key: 'c-call-to-action',
                    label: 'Call to Action Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#8a6d1f',
                    defaultDarkValue: '#d2a548',
                ),
                new ThemeVar(
                    key: 'c-call-to-action-accent',
                    label: 'Call to Action Accent Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#6d5518',
                    defaultDarkValue: '#8d733d',
                ),
                new ThemeVar(
                    key: 'c-call-to-action-text',
                    label: 'Call to Action Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#141209',
                    defaultDarkValue: '#141209',
                ),
                new ThemeVar(
                    key: 'c-text-primary',
                    label: 'Primary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#1b1a15',
                    defaultDarkValue: '#d9d4c8',
                ),
                new ThemeVar(
                    key: 'c-text-secondary',
                    label: 'Secondary Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#5c5848',
                    defaultDarkValue: '#9a9b93',
                ),
                new ThemeVar(
                    key: 'c-success',
                    label: 'Success Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#e6f0df',
                    defaultDarkValue: '#1e2a18',
                ),
                new ThemeVar(
                    key: 'c-success-text',
                    label: 'Success Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#2f4a20',
                    defaultDarkValue: '#8fbf6e',
                ),
                new ThemeVar(
                    key: 'c-info',
                    label: 'Info Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#e4e8ee',
                    defaultDarkValue: '#1a222c',
                ),
                new ThemeVar(
                    key: 'c-info-text',
                    label: 'Info Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#2b3f57',
                    defaultDarkValue: '#9db3cc',
                ),
                new ThemeVar(
                    key: 'c-warning',
                    label: 'Warning Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#f5ecd7',
                    defaultDarkValue: '#332a15',
                ),
                new ThemeVar(
                    key: 'c-warning-text',
                    label: 'Warning Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#5c4413',
                    defaultDarkValue: '#d9b25c',
                ),
                new ThemeVar(
                    key: 'c-error',
                    label: 'Error Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#f7e3e1',
                    defaultDarkValue: '#301613',
                ),
                new ThemeVar(
                    key: 'c-error-text',
                    label: 'Error Text Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#7a231d',
                    defaultDarkValue: '#e2695f',
                ),
                new ThemeVar(
                    key: 'c-elevation-0',
                    label: 'Elevation 0 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#eae6db',
                    defaultDarkValue: '#0b0f0d',
                ),
                new ThemeVar(
                    key: 'c-elevation-1',
                    label: 'Elevation 1 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#ffffff',
                    defaultDarkValue: '#151a17',
                ),
                new ThemeVar(
                    key: 'c-elevation-2',
                    label: 'Elevation 2 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#e3ded0',
                    defaultDarkValue: '#171c18',
                ),
                new ThemeVar(
                    key: 'c-elevation-3',
                    label: 'Elevation 3 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#dbd5c4',
                    defaultDarkValue: '#1b211d',
                ),
                new ThemeVar(
                    key: 'c-elevation-4',
                    label: 'Elevation 4 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#d3ccb8',
                    defaultDarkValue: '#1b211d',
                ),
                new ThemeVar(
                    key: 'c-elevation-5',
                    label: 'Elevation 5 Color',
                    type: ThemeVarType::Color,
                    defaultValue: '#cbc3ac',
                    defaultDarkValue: '#1b211d',
                ),
                new ThemeVar(
                    key: 'c-hover',
                    label: 'Hover Color',
                    type: ThemeVarType::Color,
                    defaultValue: 'rgba(27, 26, 21, 0.04)',
                    defaultDarkValue: 'rgba(233, 228, 214, 0.04)',
                ),
                new ThemeVar(
                    key: 'border-style',
                    label: 'Border Style',
                    type: ThemeVarType::String,
                    defaultValue: 'solid',
                ),
                new ThemeVar(
                    key: 'border-width',
                    label: 'Border Width',
                    type: ThemeVarType::Size,
                    defaultValue: '1px',
                ),
                new ThemeVar(
                    key: 'border-color',
                    label: 'Border Color',
                    type: ThemeVarType::Color,
                    defaultValue: 'rgba(27, 26, 21, 0.14)',
                    defaultDarkValue: 'rgba(145, 151, 143, 0.30)',
                ),
                new ThemeVar(
                    key: 'border',
                    label: 'Border',
                    type: ThemeVarType::String,
                    defaultValue: 'var(--border-style) var(--border-width) var(--border-color)',
                ),
                new ThemeVar(
                    key: 'border-radius',
                    label: 'Border Radius',
                    type: ThemeVarType::Size,
                    // A tactical UI reads as restrained, not "SaaS" - kept tight (2-5px)
                    // rather than Forumify's own rounder 10px default.
                    defaultValue: '4px',
                ),
                new ThemeVar(
                    key: 'button-border-radius',
                    label: 'Button Border Radius',
                    type: ThemeVarType::Size,
                    defaultValue: '3px',
                ),
                new ThemeVar(
                    key: 'font-size',
                    label: 'Font Size',
                    type: ThemeVarType::Size,
                    defaultValue: '16px',
                ),
            ],
        );
    }
}
