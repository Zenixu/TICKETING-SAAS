---
name: Neon Protocol
colors:
  surface: '#111319'
  surface-dim: '#111319'
  surface-bright: '#37393f'
  surface-container-lowest: '#0c0e13'
  surface-container-low: '#191c21'
  surface-container: '#1d2025'
  surface-container-high: '#282a30'
  surface-container-highest: '#33353b'
  on-surface: '#e2e2ea'
  on-surface-variant: '#e4bdbc'
  inverse-surface: '#e2e2ea'
  inverse-on-surface: '#2e3036'
  outline: '#ab8888'
  outline-variant: '#5b403f'
  surface-tint: '#ffb3b2'
  primary: '#ffb3b2'
  on-primary: '#680013'
  primary-container: '#ff525e'
  on-primary-container: '#5b0010'
  inverse-primary: '#bc0d2e'
  secondary: '#41e184'
  on-secondary: '#00391b'
  secondary-container: '#07c46b'
  on-secondary-container: '#004a24'
  tertiary: '#bec7dc'
  on-tertiary: '#283141'
  tertiary-container: '#8891a5'
  on-tertiary-container: '#212a3a'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#ffdad9'
  primary-fixed-dim: '#ffb3b2'
  on-primary-fixed: '#410008'
  on-primary-fixed-variant: '#920020'
  secondary-fixed: '#64fe9e'
  secondary-fixed-dim: '#41e184'
  on-secondary-fixed: '#00210d'
  on-secondary-fixed-variant: '#005229'
  tertiary-fixed: '#dae2f9'
  tertiary-fixed-dim: '#bec7dc'
  on-tertiary-fixed: '#131c2b'
  on-tertiary-fixed-variant: '#3e4758'
  background: '#111319'
  on-background: '#e2e2ea'
  surface-variant: '#33353b'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '800'
    lineHeight: 56px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '800'
    lineHeight: 40px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  body-lg:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-mono:
    fontFamily: JetBrains Mono
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0.05em
  stat-lg:
    fontFamily: JetBrains Mono
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  base: 8px
  xs: 4px
  sm: 12px
  md: 24px
  lg: 48px
  xl: 80px
  container-max: 1280px
  gutter: 24px
---

## Brand & Style

The design system is a **Cyberpunk-Light** framework tailored for high-energy music and anime subcultures. It balances the raw, technical aesthetic of a futuristic digital landscape with the clean, high-conversion requirements of a modern SaaS platform.

The visual direction uses **Modern Dark Minimalism** as a foundation, layering **Glassmorphism** and **Vibrant Accents** to create a sense of depth and urgency. The emotional response should be one of "Hyper-efficiency meets Nightlife"—reliable enough for professional organizers, yet visceral enough for fans of J-Pop, EDM, and anime conventions.

**Key Visual Principles:**
- **Technological Precision:** Clean lines and monospaced accents suggest automation and speed.
- **Deep Immersion:** A layered dark palette prevents eye strain while making content "pop."
- **High-Energy Signaling:** Neon accents are used sparingly but strategically to drive conversion and signify live status.

## Colors

The palette is optimized for OLED displays and low-light environments typical of event venues.

- **Background (Obsidian):** The true-dark foundation of the interface. Use for the lowest level of the UI.
- **Surface (Deep Glass):** The primary container color. Used for cards and sections to create a subtle lift from the background.
- **Primary (Neon Coral):** Reserved for critical actions: "Buy Tickets," "Register," and "Check-in." It represents energy and passion.
- **Secondary (Neon Mint):** Used for "Success" states, "Early Bird" pricing, and active status indicators. It represents growth and availability.
- **Border (Slate Glow):** A technical blue-grey used for structural boundaries. In active states, this can adopt a subtle outer glow.

## Typography

This design system utilizes a dual-font strategy to balance readability with a "hacker-chic" aesthetic.

**Inter (Sans-Serif)** handles the bulk of the communication. It is set with tight letter-spacing for headlines to maintain a punchy, editorial feel. 

**JetBrains Mono (Monospace)** is utilized for tactical data points. This includes ticket IDs, prices, dates, capacities, and countdown timers. The mono-spacing ensures that changing numbers (like a ticking clock) do not cause layout shifts.

**Usage Rules:**
- All caps for `label-mono` to increase the "technical" feel of metadata.
- Bold weights (700+) for calls-to-action to ensure they are legible against dark glass backgrounds.

## Layout & Spacing

The layout follows a **Fluid Grid** system based on an 8px rhythmic scale. 

**Breakpoints:**
- **Mobile (< 768px):** 4-column layout. Margins: 16px. Gutters: 16px.
- **Tablet (768px - 1024px):** 8-column layout. Margins: 24px. Gutters: 24px.
- **Desktop (> 1024px):** 12-column layout. Max container width of 1280px to maintain readability.

**Philosophy:**
Use generous vertical spacing (`xl`) between sections to create a high-end, gallery-like feel for event posters. Use tight, technical spacing (`xs`, `sm`) within ticket cards to emphasize density and information efficiency.

## Elevation & Depth

Depth is achieved through **Glassmorphism** and **Tonal Layering** rather than traditional heavy shadows.

1.  **Level 0 (Floor):** Obsidian (#07090E). Background of the entire application.
2.  **Level 1 (Card):** Deep Glass (#0E131F) at 80% opacity with a `backdrop-filter: blur(12px)`.
3.  **Level 2 (Hover/Overlay):** Deep Glass at 90% opacity with a Slate Glow (#1A2333) 1px border.

**Edge Lighting:**
Instead of drop shadows, use a `1px` inner border (stroke) on the top and left edges with a low-opacity white (e.g., `rgba(255,255,255,0.05)`) to simulate a light source from above. This makes surfaces look like machined glass panels.

## Shapes

The design system uses a **Rounded** aesthetic (0.5rem base) to soften the aggressive nature of the dark theme and neon colors, making the platform feel more approachable for a diverse community.

- **Standard Elements:** 8px (0.5rem) radius for buttons, input fields, and small cards.
- **Large Containers:** 16px (1rem) radius for main event sections or modal windows.
- **Interactive Badges/Pills:** Fully rounded (pill-shaped) to distinguish them from structural UI elements.

## Components

### Buttons
- **Primary (CTA):** Neon Coral background. Text: White. No border. On hover, apply a `0px 0px 20px rgba(255, 71, 87, 0.4)` glow.
- **Secondary:** Transparent background. 1px Slate Glow border. Text: White.
- **Ghost:** No background or border. Text: Neon Mint. Used for "Add to Calendar" or "Share."

### Glassmorphism Cards
- **Construction:** Deep Glass surface + 1px Slate Glow border.
- **Interactive State:** On hover, the border color changes to Neon Mint and the backdrop blur increases from 12px to 20px.

### Pill Badges
- Used for "Sold Out," "Limited," or "Anime." 
- Small caps JetBrains Mono text. 
- Background: 10% opacity of the status color (e.g., 10% Coral) with a 100% opacity text of the same color.

### Input Fields
- Dark, recessed appearance. 
- Background: #05070A. 
- Border: 1px Slate Glow. 
- Focus state: Border transitions to Neon Mint with a subtle inner glow.

### Ticket QR Component
- A dedicated white-background container (high contrast for scanning) embedded within a glass card.
- Surround with monospaced metadata (Batch Number, Entry Gate) to reinforce the "automated" theme.