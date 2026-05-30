# System Management Design Specification

This document outlines the UI/UX design guidelines for the system management dashboard. The design language is tailored to evoke the trust, cleanliness, and professionalism of an official healthcare or hospital system. 

---

## 1. Typography

The typography focuses on extreme legibility, accessibility, and a clinical, professional aesthetic. We use clean sans-serif typefaces that are standard in medical and enterprise software.

*   **Primary Font (Headings & UI Elements):** **Inter** 
    *   *Why:* Crisp, modern, and highly legible even at small sizes.
*   **Secondary Font (Body Text & Data Tables):** **Roboto**
    *   *Why:* Familiar, straightforward, and excellent for reading long strings of data or reports.

### Hierarchy
| Element | Font Family | Weight | Size (Desktop) | Usage |
| :--- | :--- | :--- | :--- | :--- |
| **H1** | Inter | Semi-Bold (600) | 28px | Page titles (e.g., "Patient Records", "Dashboard") |
| **H2** | Inter | Medium (500) | 22px | Section headers |
| **H3** | Inter | Medium (500) | 18px | Card titles, widget headers |
| **Body** | Roboto | Regular (400) | 15px | Main paragraphs, descriptions |
| **Data/Table** | Roboto | Regular (400) | 14px | Table cells, system logs |
| **Small/Caption** | Roboto | Regular (400) | 12px | Timestamps, minor labels |

---

## 2. Color Palette

The color system is designed to convey trust (blues), healing/status (greens), and sterility/cleanliness (whites and grays). 

### Brand Colors
*   **Primary Color:** **#0056B3** (Trust Blue)
    *   *Usage:* Top navigation, primary brand elements, active states, active sidebar links.
*   **Secondary Color:** **#0B877D** (Clinical Teal)
    *   *Usage:* Progress bars, success metrics, secondary accents, highlight indicators.
*   **Tertiary Color:** **#E2E8F0** (Sterile Slate)
    *   *Usage:* Borders, dividers, subtle backgrounds for inactive tabs.

### Background & Text Colors
*   **App Background:** **#F8FAFC** (Very light gray-blue to reduce eye strain).
*   **Surface/Card Background:** **#FFFFFF** (Pure white for main content areas and cards).
*   **Sidebar Background:** **#FFFFFF** (or alternatively **#0F172A** for a high-contrast dark sidebar).
*   **Primary Text:** **#1E293B** (Dark Slate - easier on the eyes than pure black).
*   **Secondary Text:** **#64748B** (Muted Gray for sub-labels and placeholders).

### Button & State Colors
| State | Background Color | Text Color | Border/Hover |
| :--- | :--- | :--- | :--- |
| **Primary Button** | `#0056B3` (Blue) | `#FFFFFF` | Hover: `#004494` |
| **Secondary Button** | `#FFFFFF` | `#0056B3` | Border: `#0056B3` |
| **Success / Save** | `#10B981` (Green) | `#FFFFFF` | Hover: `#059669` |
| **Danger / Delete** | `#EF4444` (Red) | `#FFFFFF` | Hover: `#DC2626` |
| **Warning / Alert** | `#F59E0B` (Amber)| `#FFFFFF` | Hover: `#D97706` |
| **Disabled** | `#E2E8F0` (Gray) | `#94A3B8` | None |

---

## 3. Layout Structure

The layout utilizes a classic, highly efficient dashboard structure to maximize horizontal screen real estate for data tables and system metrics.

### 3.1. Sidebar (Navigation)
*   **Position:** Fixed on the left side.
*   **Width:** 260px (collapsible to 72px for icon-only view on smaller screens).
*   **Content:** 
    *   **Top:** System/Hospital Logo and System Name.
    *   **Middle:** Primary navigation links with medical/system icons (e.g., Dashboard, Users, Records, Analytics, Settings).
    *   **Bottom:** User profile snippet, Help/Support, Log Out.
*   **Styling:** White background with a subtle right border (`1px solid #E2E8F0`), or deep dark blue (`#0F172A`) with white text for high contrast.

### 3.2. Main Content Area
*   **Position:** Right of the sidebar, occupying the remaining viewport width.
*   **Top Bar (Header):**
    *   Contains page breadcrumbs (e.g., *Home > System Management > Users*).
    *   Global search bar (prominent, center).
    *   Notification bell (with red dot for unread alerts).
*   **Content Container:**
    *   Padding: 24px to 32px around the perimeter for a "breathing room" effect.
    *   Content is grouped into "Cards" (white boxes with 8px border-radius and a very soft drop shadow, e.g., `box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05)`). This creates a clean, organized, paper-like feel.

---

## 4. UI Components

### Inputs and Forms
*   **Style:** Clean rectangles with slightly rounded corners (4px radius).
*   **Borders:** Light gray (`#CBD5E1`) by default. Changes to Primary Blue (`#0056B3`) on focus to clearly indicate where the user is typing.
*   **Labels:** Positioned above the input fields in Secondary Text color, size 14px.

### Tables (Critical for System Management)
*   **Header Row:** Slightly off-white background (`#F1F5F9`) with bold, uppercase text in small font (12px).
*   **Rows:** White background, separated by thin, subtle gray borders (`1px solid #E2E8F0`).
*   **Hover State:** Row background changes to a very faint blue (`#F8FAFC`) on hover to help users track long lines of data.

### Badges/Status Indicators
Used to show system health or user status:
*   **Active/Healthy:** Green background (`#D1FAE5`) with dark green text (`#065F46`).
*   **Pending/Maintenance:** Amber background (`#FEF3C7`) with dark amber text (`#92400E`).
*   **Error/Critical:** Red background (`#FEE2E2`) with dark red text (`#991B1B`).