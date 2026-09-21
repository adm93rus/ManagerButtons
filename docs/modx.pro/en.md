---
title: ManagerButtons
description: Button and link sets for the MODX 3 manager dashboard.
repository: https://github.com/adm93rus/ManagerButtons
author: adm93rus
dependencies:
  - VueTools
compatibility:
  - modx3
  - php81
  - vue3
outline: [2, 3]
---

# ManagerButtons

A MODX Revolution 3 extra for dashboard button groups. Same job as Quickstart Buttons, built for MODX 3. The manager UI uses [VueTools](/en/components/vuetools/) and follows the PrimeVue theme from `vuetools.theme`. The extra does not ship its own visual styles.

## Requirements

| Requirement | Version |
|-------------|---------|
| MODX Revolution | 3.0.0+ |
| PHP | 8.1+ |
| VueTools | 1.2.0+ |

Install **VueTools** before ManagerButtons. The transport package declares the dependency. Without VueTools the Import Map and theme are missing.

## Installation

1. Extras → Installer.
2. Install VueTools if it is not installed yet.
3. Upload `ManagerButtons-1.0.0-pl.transport.zip` and install it.

The **ManagerButtons** item appears under Extras. The **ManagerButtons** widget is placed on the Default dashboard.

::: info Name casing
The installer, menu, and category use **ManagerButtons**.
:::

## Groups

A group is a set of links in a **4-column** grid.

Group fields:

- **Name**
- **User groups** — who can see the set on the dashboard

**Administrators** (the `Administrator` group and `sudo` users) always see every set. If no user groups are selected, only administrators see the set.

Drag table rows to change group order.

## Buttons

Each button has:

- **Name**
- **Link** — a manager action (`?a=resource/create`), a path, or an external URL
- **Icon** — Font Awesome 5 from the MODX 3 manager (`icon icon-home`, and so on)
- **Columns** — width from 1 to 4 in the group grid

The group editor includes a live grid preview.

Links like `?a=...` open through `MODx.loadPage` without a full manager reload.

## Dashboard widget

The **ManagerButtons** widget lists every group the current user can access. Each group is a heading plus a 4-column button grid.

To show a single group, set `group_id` in the widget properties.

Button styling follows the VueTools theme (`aura` or `modx`).

## Export and import

**Export** downloads the group as JSON (name, buttons, user group names).

**Import** always creates a **new** group on the current site, so you can move a set to another site or duplicate it here. Duplicate in the grid does the same without a file.

On import, user groups are matched **by name**. If a name is missing, that restriction is skipped. Administrators still see the imported set.

Example file:

```json
{
  "package": "ManagerButtons",
  "format": 1,
  "version": "1.0.0-pl",
  "group": {
    "name": "Editors",
    "usergroups": ["Content Editor"],
    "buttons": [
      {
        "name": "Create resource",
        "url": "?a=resource/create",
        "icon": "plus",
        "cols": 2,
        "rank": 0
      }
    ]
  }
}
```

## Building the package

Source: [github.com/adm93rus/ManagerButtons](https://github.com/adm93rus/ManagerButtons).

```bash
cd vueManager && npm install && npm run build && cd ..
php _build/pack.php
```

The zip is written to `_packages/ManagerButtons-x.y.z-pl.transport.zip`. Ship each change as a new version of that file.

## License

MIT.
