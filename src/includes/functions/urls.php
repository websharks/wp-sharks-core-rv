<?php
/**
 * WP Sharks™ Core RV functions.
 *
 * @since 160501 Rewrite before launch.
 *
 * @copyright WebSharks, Inc. <http://websharks-inc.com>
 * @license GNU General Public License, version 3
 */

/**
 * WP Sharks™ Core home URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Core home URL.
 */
function ___wp_sharks_core_rv_home_url()
{
    return 'https://wpsharks.com';
}

/**
 * WP Sharks™ Core donate URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Core donate URL.
 */
function ___wp_sharks_core_rv_donate_url()
{
    return 'https://wpsharks.com/donate';
}

/**
 * WP Sharks™ Core product URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Core product URL.
 */
function ___wp_sharks_core_rv_product_url()
{
    return 'https://wpsharks.com/product/core';
}

/**
 * WP Sharks™ Core ZIP/package URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Core ZIP/package URL.
 */
function ___wp_sharks_core_rv_latest_zip_url()
{
    return 'http://www.websharks-inc.com/r/wp-sharks-core-latest-zip/#wp-sharks-core.zip';
}

/**
 * WP Sharks™ Core release archive URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Release archive URL.
 */
function ___wp_sharks_core_rv_release_archive_url()
{
    return 'https://wpsharks.com/product/core/release-archive/';
}

/**
 * WP Sharks™ Core admin install URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Install URL.
 */
function ___wp_sharks_core_rv_admin_install_url()
{
    return wp_nonce_url(self_admin_url('update.php?action=install-plugin&action_via=wp-sharks-core-rv&plugin=wp-sharks-core'), 'install-plugin_wp-sharks-core');
}

/**
 * WP Sharks™ Core admin upgrade URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Upgrade URL.
 */
function ___wp_sharks_core_rv_admin_upgrade_url()
{
    return wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&action_via=wp-sharks-core-rv&plugin='.urlencode('wp-sharks-core/plugin.php')), 'upgrade-plugin_wp-sharks-core/plugin.php');
}
