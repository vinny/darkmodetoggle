# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-11-07

### Added

- Initial release of Dark Mode Toggle for phpBB 4.0.
- Automatic theme detection following the visitor’s system or browser preference on first visit.
- Persistent user preference across pages and future visits for both registered users and guests.
- Two button styles: single-icon **Toggle** and **Slider** switch.
- Three display positions: breadcrumbs bar (default), main navigation bar, and footer navigation bar.
- Option to show or hide text labels next to the icons.
- Admin Control Panel (ACP) settings module to enable or disable the extension and customize appearance, placement, and labels.
- Dark mode theme stylesheet for `prosilver` (`styles/prosilver/theme/dark.css`).
- English (`en`) and Brazilian Portuguese (`pt_br`) translations.
- Automated PHPUnit test suite and Stylelint CSS validation via GitHub Actions.

[1.0.0]: https://github.com/vinny/darkmodetoggle/releases/tag/1.0.0
