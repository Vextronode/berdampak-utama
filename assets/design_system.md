---
name: "Berdampak Utama"
description: "Institutional digital impact portfolio design system for Universitas Widyatama (berdampak.widyatama.ac.id), pairing Deep Navy Blue and Vibrant UTama Orange with clean white surfaces."
---

## Overview

**Berdampak Utama** (`berdampak.widyatama.ac.id`) is the official digital impact showcase portal of **Universitas Widyatama (UTama)**, Bandung. It presents real-world web applications and information systems built by students and lecturers through *Tri Dharma Perguruan Tinggi* and *Pengabdian kepada Masyarakat*—such as **SIGAP**, **SIDUtama**, and **Sistem Informasi Desa Cibenda**—to village partners, accreditation assessors, university leadership, and the public.

The design system adopts a **Corporate / Modern Institutional** style: crisp white surfaces, structured grid alignment, generous breathing room, and high-contrast typography that reflects UTama's identity as *"Friendly Campus for Future Business Pro"*. It balances academic authority (Deep Navy Blue) with community warmth and actionability (Vibrant UTama Orange and Warm Gold).

## Colors

The palette is anchored directly to the official Universitas Widyatama visual identity (`Logo WIdyatama.jpg`) and `desain.md`, operating in a **light-first theme** for maximum legibility across institutional reports, public showcases, and admin workflows.

- **Brand Navy (`primary-navy-blue` `#1E1B64` & `primary-royal-indigo` `#261C6A`):** Dominant institutional authority used for navigation bars, primary headings, and structural anchors.
- **Brand Orange (`vibrant-utama-orange` `#F15A24` & `secondary` `#D4460E`):** Energetic call-to-action accent used for primary "Kunjungi Web" buttons, active indicators, and interactive highlights. `secondary` (`#D4460E`) is used when white text requires 4.5:1 WCAG AA contrast on smaller labels.
- **Warm Gold (`warm-gold` `#F7931E`):** Secondary highlight for partner badges, impact callouts, and icon accents.
- **Surfaces & Neutrals:** Pure clean white (`#FFFFFF`) for cards and main canvas, slate tint (`#F8FAFC`) for secondary bands (impact stats and footer), `#0F172A` for primary body copy, `#64748B` for metadata, and `#E2E8F0` for subtle dividers.

```yaml
colors:
  primary-navy-blue: "#1E1B64"
  primary-royal-indigo: "#261C6A"
  vibrant-utama-orange: "#F15A24"
  warm-gold: "#F7931E"
  diktisaintek-blue: "#0088FF"
  diktisaintek-container: "#E6F3FF"
  on-diktisaintek-container: "#003B73"
  primary: "#1E1B64"
  on-primary: "#FFFFFF"
  primary-container: "#E2DFFF"
  on-primary-container: "#120C59"
  secondary: "#D4460E"
  on-secondary: "#060606"
  secondary-container: "#FFEDE8"
  on-secondary-container: "#5D1800"
  tertiary: "#8D4F00"
  on-tertiary: "#FFFFFF"
  tertiary-container: "#FFEEE1"
  on-tertiary-container: "#4B2800"
  surface: "#FFFFFF"
  on-surface: "#0F172A"
  surface-variant: "#F8FAFC"
  on-surface-variant: "#64748B"
  surface-container: "#F1F5F9"
  on-surface-container: "#334155"
  outline: "#94A3B8"
  outline-variant: "#E2E8F0"
  success: "#15803D"
  on-success: "#FFFFFF"
  success-container: "#DCFCE7"
  on-success-container: "#14532D"
  error: "#BA1A1A"
  on-error: "#FFFFFF"
  error-container: "#FFDAD6"
  on-error-container: "#410002"
```

## Typography

A dual-font Google Fonts pairing balances institutional confidence with effortless UI scanning:

- **Headings (`Poppins`, Bold 700 / SemiBold 600):** Geometric, upright, and confident—ideal for hero statements, section titles, and impact metrics.
- **Body & UI (`Inter`, Regular 400 / Medium 500 / SemiBold 600):** High x-height and crisp legibility for project summaries, filter pills, metadata, and admin tables.
- **Responsive Scaling:** Every display and headline token above `32px` defines a corresponding `-mobile` token at `<= 32px` for smaller viewports.

```yaml
typography:
  display-lg:
    fontFamily: "Poppins"
    fontSize: 48px
    fontWeight: 700
    lineHeight: 56px
    letterSpacing: -0.75px
  display-lg-mobile:
    fontFamily: "Poppins"
    fontSize: 32px
    fontWeight: 700
    lineHeight: 40px
    letterSpacing: -0.5px
  headline-lg:
    fontFamily: "Poppins"
    fontSize: 36px
    fontWeight: 700
    lineHeight: 44px
    letterSpacing: -0.5px
  headline-lg-mobile:
    fontFamily: "Poppins"
    fontSize: 28px
    fontWeight: 700
    lineHeight: 36px
    letterSpacing: -0.25px
  headline-md:
    fontFamily: "Poppins"
    fontSize: 24px
    fontWeight: 600
    lineHeight: 32px
    letterSpacing: -0.25px
  title-lg:
    fontFamily: "Poppins"
    fontSize: 20px
    fontWeight: 600
    lineHeight: 28px
    letterSpacing: 0px
  title-md:
    fontFamily: "Inter"
    fontSize: 16px
    fontWeight: 600
    lineHeight: 24px
    letterSpacing: 0px
  body-lg:
    fontFamily: "Inter"
    fontSize: 18px
    fontWeight: 400
    lineHeight: 28px
    letterSpacing: 0px
  body-md:
    fontFamily: "Inter"
    fontSize: 15px
    fontWeight: 400
    lineHeight: 24px
    letterSpacing: 0px
  body-sm:
    fontFamily: "Inter"
    fontSize: 13px
    fontWeight: 400
    lineHeight: 20px
    letterSpacing: 0px
  label-lg:
    fontFamily: "Inter"
    fontSize: 14px
    fontWeight: 600
    lineHeight: 20px
    letterSpacing: 0.1px
  label-md:
    fontFamily: "Inter"
    fontSize: 12px
    fontWeight: 600
    lineHeight: 16px
    letterSpacing: 0.2px
```

## Layout & Spacing

The portal uses a **12-column Fixed-Max-Width Grid** (`max-w-7xl`, `1280px`) on desktop with `24px`–`32px` outer page margins, collapsing smoothly to a **Fluid Grid** on tablet (`768px`, 2 columns) and mobile (`390px`, 1 column). All spacing adheres strictly to an **8px base scale** (with a `4px` half-step for tight badge/icon gaps).

```yaml
spacing:
  gutter-xs: 4px
  gutter-sm: 8px
  gutter-md: 16px
  gutter-lg: 24px
  gutter-xl: 32px
  section: 64px
  page-margin: 24px
```

## Elevation & Depth

Hierarchy relies on **tonal surface contrast** (`#FFFFFF` cards resting on `#F8FAFC` bands or clean white canvas) paired with **crisp 1px `outline-variant` (`#E2E8F0`) borders** and **subtle ambient shadows** (`shadow-sm` at rest, `shadow-xl` on card hover). Floating primary CTAs use a soft warm shadow; modals use `shadow-2xl`. No backdrop-blur or heavy glassmorphism is used on content cards.

## Shapes

Corners are approachable yet structured: **16px (`lg`)** for project showcase cards, **12px (`md`)** for primary CTA buttons and dashboard mockup frames, **8px (`DEFAULT`)** for form inputs, and **9999px (`full`)** for category filter pills and status badges.

```yaml
rounded:
  sm: 4px
  DEFAULT: 8px
  md: 12px
  lg: 16px
  xl: 24px
  full: 9999px
```

## Motion & Micro-interaction

Motion is crisp, purposeful, and restrained—never decorative. Interactive buttons and filter pills respond within `150ms` using `transform` and `color` transitions, while card hover elevation settles smoothly in `250ms`. Always respect `prefers-reduced-motion` and avoid animating layout properties.

```yaml
motion:
  state-change:
    duration: 150ms
    delay: 0ms
    timingFunction: ease-out
  card-hover:
    duration: 250ms
    delay: 0ms
    timingFunction: cubic-bezier(0.2, 0, 0, 1)
  surface-enter:
    duration: 300ms
    delay: 0ms
    timingFunction: cubic-bezier(0.2, 0, 0, 1)
```

## Voice & Content Strategy

- **Tone of Voice:** Institutional, warm, and impact-oriented—proud of student and lecturer achievements without sounding boastful. Written in clear **Bahasa Indonesia** (formal-friendly).
- **Capitalisation:** Title Case for navigation items, project names, and primary CTAs (*Kunjungi Web*, *Detail Proyek*, *Portal Admin*); Sentence case for descriptions and impact narratives.
- **Button & Action Labels:** Action-first verb phrases (*Jelajahi Proyek*, *Kunjungi Web*, *Lihat Detail*, *Buka Aplikasi Live*). Never generic labels like *OK* or *Submit*.
- **Numbers & Metrics:** Always pair figures with `tabular-nums` and concrete context (e.g., *3+ Sistem Aktif*, *1 Desa Binaan Utama*, *100% Beroperasi*).

## Components

Component implementations live as individual HTML sticker sheet files in
`components/`. Each file contains the canonical, styled HTML components with
`<!-- COMPONENT: name -->` comment markers. Read each file before use.

- **Button** → `@components/button.html`: `button-primary`, `button-icon`, `button-with-icon`
- **Card** → `@components/card.html`: `card-elevated`, `card-action`, `card-interactive`, `card-interactive-2`
- **Chip** → `@components/chip.html`: `chip-action`, `chip-input`, `chip-with-icon`
- **Typography** → `@components/typography.html`: `typography-display`, `typography-body`, `typography-label`
