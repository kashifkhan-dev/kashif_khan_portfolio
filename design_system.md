# 🎨 Design System & Typography (`design_system.md`)

This document defines the **Vercel & Linear Inspired Executive Design System**, covering the dark stealth color palette, typography hierarchy, font feature settings, and surface styling across the application.

---

## 🅰️ Typography & Fonts

### 1. Primary Font Family
- **Font**: **Inter** (Google Fonts / Variable Font)
- **Fallback Stack**: `Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif`
- **Tailwind Utility**: `font-sans`

### 2. Typographic OpenType Features
- **Font Feature Settings**: `"cv02", "cv03", "cv04", "cv11"`
- **Purpose**: Enables Vercel/Linear-style contextual alternates, tabular numbers, and sharp legibility on high-DPI OLED screens.

### 3. Monospace Font Family
- **Font Stack**: System Monospace / JetBrains Mono
- **Tailwind Utility**: `font-mono`
- **Application**: Dates, timestamps, email handles, code snippets, status badges, and database IDs.

### 4. Typography Scale & Weights
| Element | Weight | Tracking | Application |
|---|---|---|---|
| **Hero Headline** | `font-black` (900) | `tracking-tight` (-0.03em) | Main Landing Page Headlines |
| **Section Title** | `font-extrabold` (800) | `tracking-tight` (-0.02em) | Section Titles (`h2`, Bento Headers) |
| **Card Title** | `font-bold` (700) | `tracking-tight` | Project Titles, Skill Headers |
| **Body Copy** | `font-normal` (400) | `normal` | Sub-titles, Descriptions, Prose |
| **Labels & Badges** | `font-semibold` (600) | `tracking-wide` | Status Pills, Filter Buttons |

---

## 💎 System Color Palette

| Role | Color Value / Hex | Tailwind Utility / CSS Class | Application |
|---|---|---|---|
| **Ultra-Black Pitch Canvas** | `#000000` | `bg-black` / `.vercel-bg` | Global App & Body Background |
| **Monochrome Card Surface** | `rgba(10, 10, 10, 0.7)` | `.vercel-card` / `bg-neutral-900/60` | Containers, Tables, Bento Cards |
| **Glass Backdrop Surface** | `rgba(0, 0, 0, 0.8)` | `.vercel-glass` | Sticky Navbars, Floating Drawers |
| **Primary Action Button** | `#FFFFFF` | `bg-white text-black hover:bg-neutral-200` | High-Impact Action CTAs |
| **Secondary Button** | `#171717` | `bg-neutral-900 border-neutral-800 text-neutral-300` | Secondary Action Buttons |
| **Accent Brand Blue** | `#0070F3` | `text-blue-500`, `bg-blue-600` | Primary Accents & Active States |
| **Emerald Status Pill** | `#10B981` | `text-emerald-400`, `bg-emerald-950` | Availability Badge & Online Indicators |
| **Metallic Hero Headline** | `linear-gradient(180deg, #FFFFFF, #A1A1AA)` | `.vercel-text-gradient` / `.gradient-text` | Main Typography & Headlines |
| **Crisp Surface Border** | `rgba(255, 255, 255, 0.08)` | `border-neutral-800` / `border-border` | 1px Clean Borders |

---

## 🚫 Design Rules & Guidelines
- **Monochrome & High Contrast**: Deep pitch-black base with crisp white & neutral typography.
- **Micro-Animations**: Smooth 300ms transitions (`cubic-bezier(0.16, 1, 0.3, 1)`) on interactive hover elements.
- **NO Harsh Purples/Pink Gradients**: Avoid standard saturated purple/pink gradients in favor of high-contrast metallic and subtle blue highlights.
