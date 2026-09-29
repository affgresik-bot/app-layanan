---
name: Sapa Sosial Blitar
colors:
  surface: '#f8f9ff'
  surface-dim: '#ccdbf3'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e6eeff'
  surface-container-high: '#dce9ff'
  surface-container-highest: '#d5e3fc'
  on-surface: '#0d1c2e'
  on-surface-variant: '#3e4947'
  inverse-surface: '#233144'
  inverse-on-surface: '#eaf1ff'
  outline: '#6e7977'
  outline-variant: '#bdc9c6'
  surface-tint: '#006a63'
  primary: '#005c55'
  on-primary: '#ffffff'
  primary-container: '#0f766e'
  on-primary-container: '#a3faef'
  inverse-primary: '#80d5cb'
  secondary: '#855300'
  on-secondary: '#ffffff'
  secondary-container: '#fea619'
  on-secondary-container: '#684000'
  tertiary: '#0047bf'
  on-tertiary: '#ffffff'
  tertiary-container: '#1e5fe7'
  on-tertiary-container: '#e6e9ff'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#9cf2e8'
  primary-fixed-dim: '#80d5cb'
  on-primary-fixed: '#00201d'
  on-primary-fixed-variant: '#00504a'
  secondary-fixed: '#ffddb8'
  secondary-fixed-dim: '#ffb95f'
  on-secondary-fixed: '#2a1700'
  on-secondary-fixed-variant: '#653e00'
  tertiary-fixed: '#dbe1ff'
  tertiary-fixed-dim: '#b4c5ff'
  on-tertiary-fixed: '#00174b'
  on-tertiary-fixed-variant: '#003ea8'
  background: '#f8f9ff'
  on-background: '#0d1c2e'
  surface-variant: '#d5e3fc'
typography:
  display-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 3rem
    fontWeight: '700'
    lineHeight: 3.75rem
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 2.25rem
    fontWeight: '700'
    lineHeight: 2.75rem
    letterSpacing: -0.01em
  headline-xl:
    fontFamily: Plus Jakarta Sans
    fontSize: 2rem
    fontWeight: '700'
    lineHeight: 2.5rem
    letterSpacing: -0.015em
  headline-xl-mobile:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.5rem
    fontWeight: '700'
    lineHeight: 2rem
    letterSpacing: -0.01em
  headline-lg:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.5rem
    fontWeight: '600'
    lineHeight: 2rem
  headline-sm:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.25rem
    fontWeight: '600'
    lineHeight: 1.75rem
  title-md:
    fontFamily: Plus Jakarta Sans
    fontSize: 1.125rem
    fontWeight: '600'
    lineHeight: 1.5rem
  body-lg:
    fontFamily: Inter
    fontSize: 1.125rem
    fontWeight: '400'
    lineHeight: 1.75rem
  body-md:
    fontFamily: Inter
    fontSize: 1rem
    fontWeight: '400'
    lineHeight: 1.5rem
  body-sm:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '400'
    lineHeight: 1.25rem
  label-lg:
    fontFamily: Inter
    fontSize: 1rem
    fontWeight: '600'
    lineHeight: 1.5rem
  label-md:
    fontFamily: Inter
    fontSize: 0.875rem
    fontWeight: '500'
    lineHeight: 1.25rem
  label-sm:
    fontFamily: Inter
    fontSize: 0.75rem
    fontWeight: '600'
    lineHeight: 1rem
    letterSpacing: 0.02em
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  gutter: 1.5rem
  gutter-mobile: 1rem
  margin: 2rem
  margin-mobile: 1rem
  space-xs: 0.25rem
  space-sm: 0.5rem
  space-md: 1rem
  space-lg: 1.5rem
  space-xl: 2rem
---

## Brand & Style

This design system powers the single-door social service portal for Dinas Sosial Kabupaten Blitar, East Java. It bridges governmental credibility with genuine civic warmth, designed for a broad demographic spanning urban staff, rural facilitators (pendamping sosial), and citizens of all digital literacy levels.

### Visual Aesthetic & Philosophy
- **Approach:** Modern Institutional & Humane. Clean public-service clarity elevated with soft, approachable contours and warm regional dignity.
- **Atmosphere:** Reassuring, welcoming, transparent, and orderly. The interface removes administrative anxiety, offering clear visual pathways and empathetic tone of voice.
- **Language & Voice:** 100% Bahasa Indonesia. Terminology is standard Indonesian civil administration (baku yet accessible), avoiding technical jargon (e.g., using "Bantuan Sosial Tersalurkan", "Lacak Status Pengajuan", "Perlu Perbaikan Berkas").
- **Accessibility Principle:** High-contrast text compliance (WCAG 2.1 AA/AAA), generous touch targets (minimum 48×48px for interactive elements), and screen-reader-ready structural hierarchies.

## Colors

The palette balances public-sector authority with humane care through deep teal, supported by warm amber accents and purpose-built semantic status colors.

### Core Swatches
- **Primary Teal (`#0F766E`):** Represents public governance, stability, and care. Used for primary buttons, active navigation markers, key headers, and brand focal points.
  - Deep variant (`#115E59` / `#134E4A`) for pressed states and contrast headers.
  - Surface tint (`#CCFBF1` / `#F0FDFA`) for light backgrounds, active menu states, and badge fills.
- **Secondary Warm Amber (`#F59E0B`):** Represents human attention and key actions. Used for primary callouts, warning indicators, and priority action buttons.
  - Dark variant (`#B45309`) for text-on-light badge contrast.
  - Light variant (`#FEF3C7`) for amber badge container surfaces.
- **Tertiary Civic Blue (`#2563EB`):** Applied for initial submission states and transactional notifications.
- **Neutral Slate Slate (`#475569`):** Grounded, low-glare neutral scale.
  - Canvas Background: `#F6F8F7` (Light herbal-tinted gray-green for low eye strain).
  - Surface Pure: `#FFFFFF` (Card surfaces, modals, elevated panels).
  - Surface Border: `#E2E8F0` (Default borders) and `#CBD5E1` (Input borders).
  - Text Primary: `#0F172A` (98% contrast against white).
  - Text Secondary: `#475569` (Body reading, helper descriptions).
  - Text Muted: `#94A3B8` (Placeholders and disabled text).

### Service Status Matrix (Tracking & Triage)
- **Diajukan (Submitted):** Blue (`#2563EB` text on `#EFF6FF` container).
- **Perlu Perbaikan (Revision Required):** Amber (`#D97706` text on `#FFFBEB` container).
- **Sedang Diverifikasi (Verifying):** Purple (`#7C3AED` text on `#F5F3FF` container).
- **Diproses (In Process):** Teal (`#0F766E` text on `#F0FDFA` container).
- **Selesai (Completed):** Green (`#16A34A` text on `#F0FDF4` container).
- **Ditolak (Rejected):** Red (`#DC2626` text on `#FEF2F2` container).

## Typography

The typography pairing uses **Plus Jakarta Sans** for prominent headers to deliver human warmth and modern public approachability, balanced by **Inter** for forms, tables, body text, and navigational UI due to its supreme legibility at small sizes and high-density information layouts.

### Usage Rules
- **Display & Headlines:** Reserved for service portal landers, greeting cards ("Selamat Datang di Portal SAPA SOSIAL"), and top-level summary counters.
- **Body:** Inter regular (`400`) handles instructions, verification guidelines, and public policy terms. Paragraph widths must not exceed 68 characters to ensure readable civic documents.
- **Labels & Forms:** Inter medium (`500`) and semibold (`600`) ensure input headers (e.g., "Nomor Induk Kependudukan (NIK)", "Nomor Kartu Keluarga") are distinct, unambiguous, and compliant with low-vision clarity thresholds.

## Layout & Spacing

A structured 12-column grid anchors desktop views, folding cleanly to 4 columns on mobile viewports.

### Grid & Breakpoints
- **Mobile (`< 640px`):** 4 columns, 16px (`1rem`) gutters, 16px margins. Full-width stacked forms, sticky bottom application buttons.
- **Tablet (`640px – 1024px`):** 8 columns, 24px (`1.5rem`) gutters, 24px margins. Two-column service grids.
- **Desktop (`> 1024px`):** 12 columns, 24px gutters, maximum container width capped at 1280px (`80rem`) centered, preserving generous white space.

### Spacing Philosophy
- Standard padding adheres to an 8pt linear rhythm.
- Spacing inside functional cards stays spacious (`space-lg` / 24px) to avoid visual fatigue when reviewing extensive social registry records.

## Elevation & Depth

To sustain a crisp, accessible civic portal without visual clutter, depth is communicated through crisp single-pixel low-contrast borders combined with faint, atmospheric teal-tinted drop shadows.

### Elevation Hierarchy
- **Level 0 (Flat Canvas):** `#F6F8F7` background, no shadow.
- **Level 1 (Card & Content Containers):** White (`#FFFFFF`) surface, 1px border (`#E2E8F0`), shadow `0 1px 3px 0 rgba(15, 118, 110, 0.04), 0 1px 2px -1px rgba(15, 118, 110, 0.02)`.
- **Level 2 (Hover States, Interactive Cards, Dropdowns):** White surface, 1px border (`#CBD5E1`), shadow `0 4px 6px -1px rgba(15, 118, 110, 0.08), 0 2px 4px -2px rgba(15, 118, 110, 0.04)`.
- **Level 3 (Modals, Citizen Detail Drawers, Popovers):** White surface, shadow `0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.05)`, backed by a 40% opacity slate backdrop overlay (`#0F172A` with 40% opacity).

## Shapes

The design system enforces a coherent 12px corner radius (`rounded-lg` token) across all standard interaction surfaces.

### Radius Assignments
- **Inputs, Buttons, Cards, Status Badges:** Fixed 12px radius (`rounded-lg`). Creates a friendly, modern civic feel that avoids both harsh sharp corners and overly playful pill buttons.
- **Avatars & Service Icon Containers:** Soft rounded squares (12px radius) for icons; 50% circular for citizen profile avatars.
- **Modals & Bottom Sheets:** 16px top corners on mobile drawers; 12px standard on desktop dialogs.

## Components

Components are built for resilient accessibility, touch clarity, and operational transparency.

### 1. Buttons
- **Touch Target:** Minimum height is strictly 48px across all variants.
- **Primary Button:** Background `#0F766E`, text `#FFFFFF`, font `Inter Semibold (1rem)`, 12px border radius. Hover state transitions to `#115E59`. Focus ring: 3px solid `#CCFBF1` with a 2px offset.
- **Accent / Priority Action Button:** Background `#F59E0B`, text `#FFFFFF`, hover `#D97706`. Used for urgent calls such as "Lengkapi Berkas Sekarang" or "Ajukan Bantuan".
- **Secondary / Outlined Button:** White background, 1.5px border `#0F766E`, text `#0F766E`, hover background `#F0FDFA`.
- **Icon Alignment:** Lucide 20px stroke-based icons with 8px margin spacing preceding or trailing text.

### 2. Status Chips & Badges
- **Shape & Dimension:** 12px corner radius, padding `4px 12px`, typography `label-sm` (uppercase letter-spacing).
- **Semantics:**
  - *Diajukan:* `#EFF6FF` background, `#1D4ED8` text, accompanied by `Clock` icon.
  - *Perlu Perbaikan:* `#FFFBEB` background, `#B45309` text, accompanied by `AlertTriangle` icon.
  - *Sedang Diverifikasi:* `#F5F3FF` background, `#6D28D9` text, accompanied by `Search` icon.
  - *Diproses:* `#F0FDFA` background, `#0F766E` text, accompanied by `RefreshCw` icon.
  - *Selesai:* `#F0FDF4` background, `#15803D` text, accompanied by `CheckCircle` icon.
  - *Ditolak:* `#FEF2F2` background, `#B91C1C` text, accompanied by `XCircle` icon.

### 3. Form Input Fields & Selects
- **Geometry:** 48px height, 12px border radius, 1px border `#CBD5E1`, background `#FFFFFF`, text `#0F172A`.
- **States:**
  - *Focus:* Border `#0F766E`, outer outline ring 3px `#CCFBF1`.
  - *Error:* Border `#DC2626`, helper text in `#DC2626` with `AlertCircle` icon.
- **Field Labels:** Positioned above inputs, `label-md` weight (500), dark slate `#334155`. Required fields indicated by a red asterisk (`*`).
- **File Uploaders (Dokumen KK/KTP/SKTM):** Dashed 2px border `#94A3B8`, background `#F8FAFC`, minimum drop zone height 120px with clear file-size constraints listed beneath.

### 4. Selection Controls (Checkboxes & Radios)
- **Checkboxes:** 20×20px dimension, 4px rounded radius, checked state `#0F766E` with white checkmark. Tap zone padded to 48×48px.
- **Radio Buttons:** 20×20px circular, 2px border, selected state features a 6px central disc in `#0F766E`.

### 5. Cards & Data Display
- **Service Portal Card:** White surface, 12px radius, 1px border `#E2E8F0`, padding 20px. Features category badge, bold title, short description, and teal text action link ("Pilih Layanan →").
- **Application Status Card (Lacak Berkas):** Prominent header with application tracking number (ID Permohonan), date stamp, citizen NIK, and an active progress stepper visualizing the flow from "Diajukan" to "Selesai".

### 6. Iconography
- **Set:** Lucide line icons exclusively. Stroke width is consistently 1.75px for standard UI elements and 2px for active navigation items.