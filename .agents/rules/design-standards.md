# Workspace Design Rules

## Border Radius Standard
- **Standard UI Radius**: `6px` (`rounded-md` / `rounded-[6px]`)
- **Usage**: Use `rounded-md` (or `rounded-[6px]`) for all buttons, select boxes, inputs, modal dialogs, chip tags, and dropdown popovers.
- **Configured Base**: `--radius: 0.5rem;` in `resources/css/app.css` and `DEFAULT: "6px"` / `md: calc(var(--radius) - 2px)` in `tailwind.config.js`.
