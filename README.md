# Dark Mode Toggle for phpBB [![Tests](https://github.com/vinny/darkmodetoggle/actions/workflows/tests.yml/badge.svg)](https://github.com/vinny/darkmodetoggle/actions/workflows/tests.yml)

Dark Mode Toggle adds a theme switcher to phpBB 4, letting users and guests switch between light and dark modes.

## Features

- **Automatic mode detection:** Follows the visitor’s system or browser theme on their first visit.
- **Saved preference:** Remembers the selected mode across pages and future visits for both registered users and guests.
- **Two button styles:** Choose between a single-icon **Toggle** button or a **Slider** switch.
- **Three display positions:** Place the button in the breadcrumbs bar, main navigation bar, or footer navigation bar.
- **Optional text labels:** Show or hide “Light” and “Dark” labels next to the icons.
- **ACP settings:** Enable or disable the extension and customize its appearance and placement directly from the Admin Control Panel.

## Requirements

- **PHP:** 8.2 or higher
- **phpBB:** 4.0.0-a1 or higher

## Installation

1. Download the extension repository.
2. Copy the files to your phpBB installation under `ext/vinny/darkmodetoggle/`:
   ```text
   phpBB/ext/vinny/darkmodetoggle/
   ```
3. Go to the **Admin Control Panel (ACP)** > **Customise** > **Extension Management** > **Manage extensions**.
4. Locate **Dark Mode Toggle** under **Disabled Extensions** and click **Enable**.

## Configuration

After enabling the extension, go to **ACP** > **Extensions** > **Dark mode toggle** > **Settings** to configure the button appearance, position, and label visibility.

## Development & Linting

CSS code quality is enforced with Stylelint.

To install dependencies and run the CSS linter locally:

```bash
npm install
npm test
```

Automated extension tests run via GitHub Actions on every push and pull request.

## Credits

- [`<dark-mode-toggle>`](https://github.com/GoogleChromeLabs/dark-mode-toggle) custom element and SVG icons by GoogleChromeLabs.

## Support

[![Donate with Ko-fi](https://img.shields.io/badge/Donate-Ko--fi-29ABE2.svg)](https://ko-fi.com/vinny1)

## License

[![License: GPL v2](https://img.shields.io/badge/License-GPL%20v2-blue.svg)](license.txt)
