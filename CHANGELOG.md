## v160712.43338

- Changing query arg `action_via` to `___action_via`.
- Updating to latest phing build system.
- Updating `composer.json`.
- Updating dotfiles.

## v160620.31571

- Adding `___wp_sharks_core_rv_wp_profile_url()`
- Adding `___wp_sharks_core_rv_on_upgrader_process_complete()`
- Adding `___wp_sharks_core_rv_on_upgrader_process_complete__on_shutdown()`
- Now flushing the OPcache automatically whenever a theme, plugin, or core upgrade occurs. Referencing: <https://core.trac.wordpress.org/ticket/36455>

## v160601.62817

- Updating bleeding edge location for WPSC.

## v160531.13728

- Adding latest websharks/phings build system.

## v160530

- Updating endpoint URLs that lead to official distros.
- Adding support for `WP_DEBUG_EDGE`, which will enable bleeding edge distros.

## v160524

- Minor refactoring.
- Correct bug in download URL; i.e., remove hash.

## v160503

- Enhancing display of notices.

![](https://github.com/websharks/wp-sharks-core-rv/raw/000000-dev/assets/screenshot.png)

## v160501

- Improving `composer.json`.
- Adding `_rv` to all function prefixes.
- Reorganizing functions into multiple files.
- Enhancing notices after testing each of them.
- No longer a need to remain PHP v5.2 compatible. Bumping to PHP v7.0.4.
- Ditching `->version` in favor of `::VERSION`.
- Bug fix related to `isset()` against `::VERSION`.

## v160417

- Adding PHP v5.2 compat.
- Improving `composer.json`.

## v160229

- Initial release.
