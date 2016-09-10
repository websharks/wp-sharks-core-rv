## v160910.71018

- Simplifying `wp_sharks_core_rv()`.
- Refactored `wp_sharks_core_rv_notice()`.
- Refactored `___wp_sharks_core_rv_issue()`.
- Refactored `___wp_sharks_core_rv_notice_brand_name()`.
- Adding new function `___wp_sharks_core_rv_get_wp_version()`.
- Updating location returned by `___wp_sharks_core_rv_product_url()`.
- Updating location returned by `___wp_sharks_core_rv_release_archive_url()`.
- Changing from filter `pre_site_transient_update_plugins` to `site_transient_update_plugins` for better compatibility w/ ManageWP and IWP.
- Bug fix. The previous release was calling `___wp_sharks_core_rv_admin_install_url()` too early in some cases, resulting in a 'doing it wrong' notice in WordPress core whenever bbPress was installed. This was due to `wp_nonce_url()` being used by `___wp_sharks_core_rv_admin_install_url()`, which relies on the current user. Fixed in this release.
- `___wp_sharks_core_rv_filter_transient_update_plugins()` now returns a `tested` array key as well.
- `___wp_sharks_core_rv_filter_transient_update_plugins()` now returns a `plugin` array key as well.
- Enhancing UTF-8 support in brand name detection.
- Removing filter: `wp_sharks_core_rv_notice_refs_before_markup`.
- Removing filter: `wp_sharks_core_rv_notice_refs`.
- New filter: `wp_sharks_core_rv_notice_markup`.

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
