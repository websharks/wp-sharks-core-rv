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
function ___wp_sharks_core_rv_home_url(): string
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
function ___wp_sharks_core_rv_donate_url(): string
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
function ___wp_sharks_core_rv_product_url(): string
{
    return 'https://wpsharks.com/product/wp-sharks-core';
}

/**
 * WP Sharks™ Core ZIP/package URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Core ZIP/package URL.
 */
function ___wp_sharks_core_rv_latest_zip_url(): string
{
    if (defined('WP_DEBUG') && WP_DEBUG && defined('WP_DEBUG_EDGE') && WP_DEBUG_EDGE) {
        return 'https://cdn.wpsharks.com/software/bleeding-edge/wp-sharks-core/2cfeecf3eaebb8d.zip';
    }
    return 'https://cdn.wpsharks.com/software/latest/wp-sharks-core/0edbcdd1d8a97a6.zip';
}

/**
 * WP Sharks™ Core release archive URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Release archive URL.
 */
function ___wp_sharks_core_rv_release_archive_url(): string
{
    return 'https://wpsharks.com/product/wp-sharks-core/release-archive';
}

/**
 * WP Sharks™ Core WP profile URL.
 *
 * @since 160620 Adding profile URL.
 *
 * @return string WP profile URL.
 */
function ___wp_sharks_core_rv_wp_profile_url(): string
{
    return 'https://profiles.wordpress.org/wpsharks';
}

/**
 * WP Sharks™ Core admin install URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Install URL.
 */
function ___wp_sharks_core_rv_admin_install_url(): string
{
    $args = [
        'action'        => 'install-plugin',
        '___action_via' => 'wp-sharks-core-rv',
        'plugin'        => 'wp-sharks-core',
    ];
    $admin_url = is_multisite() ? 'network_admin_url' : 'self_admin_url';

    $url = $admin_url('/update.php');
    $url = add_query_arg(urlencode_deep($args), $url);
    $url = wp_nonce_url($url, 'install-plugin_wp-sharks-core');

    return $url;
}

/**
 * WP Sharks™ Core admin activate URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Activate URL.
 */
function ___wp_sharks_core_rv_admin_activate_url(): string
{
    $args = [
        'action'        => 'activate',
        '___action_via' => 'wp-sharks-core-rv',
        'plugin'        => 'wp-sharks-core/plugin.php',
    ];
    // Activation always uses `self_admin_url()`.

    $url = self_admin_url('/plugins.php');
    $url = add_query_arg(urlencode_deep($args), $url);
    $url = wp_nonce_url($url, 'activate-plugin_wp-sharks-core/plugin.php');

    return $url;
}

/**
 * WP Sharks™ Core admin upgrade URL.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Upgrade URL.
 */
function ___wp_sharks_core_rv_admin_upgrade_url(): string
{
    $args = [
        'action'        => 'upgrade-plugin',
        '___action_via' => 'wp-sharks-core-rv',
        'plugin'        => 'wp-sharks-core/plugin.php',
    ];
    $admin_url = is_multisite() ? 'network_admin_url' : 'self_admin_url';

    $url = $admin_url('/update.php');
    $url = add_query_arg(urlencode_deep($args), $url);
    $url = wp_nonce_url($url, 'upgrade-plugin_wp-sharks-core/plugin.php');

    return $url;
}
