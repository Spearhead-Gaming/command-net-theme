# COMMAND NET — Theme Reconstruction Kit

Reference canvas: 1487 × 1058 px

## 1. Structural layout

### A. Fixed sidebar
- Width: ~232 px on the reference.
- Position: fixed left, full viewport height.
- Background: nearly black/olive fabric grain.
- Top brand block: approx. 0–430 px tall.
- Main navigation begins near y=444 px.
- Selected navigation row uses a muted gold left rail and a slightly warmer panel fill.
- Bottom motto block is anchored near the bottom.

Recommended desktop CSS:
```css
.sidebar { width:232px; position:fixed; inset:0 auto 0 0; }
.page { margin-left:232px; min-height:100vh; }
```

### B. Command header
- Content begins at x≈232 px.
- Internal left/right padding ≈20 px.
- Height to bottom of status panel ≈230 px.
- Background contains very dark topographic map art with grid lines and field coordinates.
- Main wordmark is oversized, distressed, warm gray.
- Top strapline uses wide letter spacing.
- Right status card is a bordered 3-row telemetry block.

### C. Unit tab rail
Approx. y=245–322 px.
Five equal-width cells:
1. HQ
2. Reaper
3. Misfit
4. Gambler
5. Viking

Each cell:
- ~76 px tall
- 1 px gray border
- unit icon on left
- large condensed uppercase name
- small subtitle beneath
- active state = gold border + subtle gold wash

### D. Pinned notice
Approx. y=340–446 px.
- Tall dark panel
- red 10 px vertical priority bar
- red PINNED badge
- title + secondary copy
- author/avatar/meta on the right
- utility icons aligned to far right

### E. Latest discussions
Approx. y=465–888 px.
- heading with a short olive/gold vertical accent
- category filters on heading row
- 5-column table:
  Topic / Category / Author / Replies / Last Activity
- row height ≈57 px
- fine separators, no zebra striping
- leading topic-type icons
- category pills
- circular avatars

### F. Online strip
Approx. y=901–977 px.
- left green online state
- avatar stack
- overflow count circle
- right-aligned KPI counters:
  in game / on forums / in Discord

### G. Footer
- minimal centered slogan with flanking rules
- small establishment date at far right

---

## 2. Color system

Use these as base tokens:
- Page black: `#0B0F0D`
- Deep olive black: `#111613`
- Panel: `#151A17`
- Raised panel: `#1B211D`
- Primary line: `#3A403B`
- Soft line: `#2A2F2B`
- Primary text: `#D9D4C8`
- Muted text: `#9A9B93`
- Command gold: `#D2A548`
- Aged gold: `#8D733D`
- Muted olive: `#68705A`
- Online green: `#55CA6A`
- Alert red: `#EF4D43`

Avoid pure white and pure black. The reference gains most of its character from low-contrast warm grays, olive blacks, and restrained gold.

---

## 3. Typography

Closest practical stack:
- Hero / major titles: `Teko`, `Anton`, or `Bebas Neue`
- UI labels / unit names: `Barlow Condensed`, `Roboto Condensed`, or `DIN Condensed`
- Telemetry / coordinates / microcopy: `IBM Plex Mono`, `Share Tech Mono`, or `Space Mono`

Recommended styling:
- Major display heading: 78–94 px desktop, 700–800 weight, 0.02em tracking
- Section title: 27–32 px condensed, 700
- Unit tab label: 21–25 px, 700
- Small caps: 11–14 px, 0.12–0.22em tracking
- Body: 14–16 px

Do not overuse stencil fonts. The reference is military because of spacing, condensed typography, field labels, map graphics, and materials—not because every letter is stencil-cut.

---

## 4. Materials / image assets

Use images only for:
- Topographic map background
- Sidebar grain
- Micro-noise overlay
- Worn-gold material
- Unit iconography
- Navigation iconography
- Compass / coordinate decoration
- Real Spearhead patch artwork if you have the original source

Keep these as CSS:
- cards
- borders
- table rows
- status LEDs
- category pills
- active tab glows
- red pinned rail
- separators
- avatar rings

This makes the theme much easier to maintain.

---

## 5. Texture compositing

Suggested page background:
```css
background:
  linear-gradient(rgba(8,11,9,.84), rgba(8,11,9,.84)),
  url('/assets/backgrounds/bg-command-topo-2048.png') center top / cover fixed,
  #0b0f0d;
```

Panel finish:
```css
background:
  linear-gradient(180deg,rgba(25,30,27,.96),rgba(17,21,19,.96)),
  url('/assets/textures/overlay-micro-noise.png');
```

Use the noise texture at very low opacity (roughly 4–8%). More than that will make the UI muddy.

---

## 6. Responsive behavior

### >= 1200 px
Reproduce the reference closely:
- fixed 232 px sidebar
- five unit tabs in one row
- full forum table columns
- KPI strip visible

### 900–1199 px
- sidebar shrinks to 88–96 px icon rail
- wordmark reduces
- unit tab subtitles may hide
- discussion author/reply columns remain

### < 900 px
- sidebar becomes off-canvas
- unit tabs become horizontal scroll
- discussion table becomes stacked topic cards
- online avatars show only first 5 + overflow
- coordinates/status telemetry can collapse behind a button

---

## 7. Forumify implementation map

Build the theme in layers:

1. Global page shell
2. Header / masthead
3. Unit navigation component
4. Announcement / pinned component
5. Forum listing component
6. Category pill styles
7. User/avatar treatments
8. Online member strip
9. Footer
10. Responsive overrides

Do not put the entire screenshot into a background image. Forumify needs to retain real selectable text, links, accessibility states, dynamic data, and responsive structure.

---

## 8. Asset inventory in this kit

### Backgrounds
- `bg-command-topo-2048.png`
- `bg-sidebar-grain.png`

### Textures
- `overlay-micro-noise.png`
- `texture-worn-gold.png`

### Unit icons
- `hq-spearhead.svg`
- `reaper-skull.svg`
- `misfit-spade.svg`
- `gambler-dice.svg`
- `viking-axe.svg`

### Navigation icons
- home
- forums
- units
- events
- media
- resources
- members
- store

### Decorative
- compass
- online/live status marks
- gold divider

### Brand
- editable COMMAND NET lockup template

### Reference
- original screenshot
- annotated region overlay

---

## 9. Assets still best supplied from your originals

For a production-quality exact match, replace generated placeholders with:
- your actual Spearhead Gaming shoulder patch
- exact unit insignia if you already have official art
- any proprietary/official typography you have licensed
- real user avatars

The layout, materials, icon scale, colors, and treatments in this kit are intended to give you the full reconstruction framework.
