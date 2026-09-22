# Changelog

## [1.2.1-pl] - 2026-09-22

### Fixed
- The buttons dialog showed the raw key `managerbuttons_description` when the manager lexicon cache was still the previous topic. Captions are now read from the component lexicon files
- Edit and delete actions on a button row use the manager Font Awesome icons, so they stay visible when PrimeIcons do not paint inside the table

## [1.2.0-pl] - 2026-09-22

### Added
- Button description under the title
- Per-button background color
- General settings for the default background and text color. With no background, buttons are blue with white text

## [1.1.1-pl] - 2026-09-22

### Fixed
- Groups saved to the database stayed out of the list on MySQL 8 and MariaDB: `rank` is reserved, and unquoted `ORDER BY rank` / `MAX(rank)` failed
- Manager page padding, toolbar spacing, and create dialogs (labels, help text, fieldsets) follow the VueTools sample

## [1.1.0-pl] - 2026-09-22

### Added
- Full Font Awesome 5 icon set from the MODX 3 manager
- `managerbuttons` permission on the Administrator policy (settings page)
- Bulk delete, search, and pagination in the VueTools manager page
- Widget property `group_id`

### Changed
- External links in the dashboard widget open in a new tab
- Manager actions (`?a=...`) still open through `MODx.loadPage`

## [1.0.0-pl] - 2026-09-21

### Added
- Button groups with a 4-column dashboard grid
- Access control by MODX user groups (Administrators always have access)
- Buttons with name, link, Font Awesome 5 icon, and width from 1 to 4 columns
- Export and import of a group as JSON (move to another site or duplicate)
- VueTools-based manager UI and dashboard widget (theme from `vuetools.theme`)
- MIT license
