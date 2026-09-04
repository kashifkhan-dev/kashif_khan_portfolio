# 🎨 Vercel Ultra-Dark Developer Theme (`colors.md`)

This color system defines the **Vercel & Linear Inspired Executive Monochrome** aesthetic used across the entire portfolio and admin dashboard.

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
