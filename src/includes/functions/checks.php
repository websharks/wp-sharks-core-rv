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
 * Running WP Sharks™ Core vX.x+?
 *
 * @since 160501 Rewrite before launch.
 *
 * @return bool True if running a compatible version.
 */
function wp_sharks_core_rv(): bool
{
    if (isset($GLOBALS['wp_sharks_core_rv'])) {
        ___wp_sharks_core_rv_initialize();
    }
    $version     = wp_sharks_core_rv_get_version();
    $min_version = $GLOBALS['___wp_sharks_core_rv']['min'];
    $max_version = $GLOBALS['___wp_sharks_core_rv']['max'];

    if (!$version || version_compare($version, $min_version, '<')) {
        return false;
    } elseif ($max_version && version_compare($version, $max_version, '>')) {
        return false;
    }
    return true;
}

/**
 * Initializes each instance; unsets `$GLOBALS['wp_sharks_core_rv']`.
 *
 * @note `$GLOBALS['wp_sharks_core_rv']` is for the API, we use a different variable internally.
 *    The internal global is defined here: `$GLOBALS['___wp_sharks_core_rv']`.
 *
 * @since 160501 Rewrite before launch.
 */
function ___wp_sharks_core_rv_initialize()
{
    $GLOBALS['___wp_sharks_core_rv'] = ['min' => '', 'max' => ''];

    if (!empty($GLOBALS['wp_sharks_core_rv']) && is_string($GLOBALS['wp_sharks_core_rv'])) {
        $GLOBALS['___wp_sharks_core_rv']['min'] = $GLOBALS['wp_sharks_core_rv'];
    } elseif (!empty($GLOBALS['wp_sharks_core_rv']) && is_array($GLOBALS['wp_sharks_core_rv'])) {
        if (!empty($GLOBALS['wp_sharks_core_rv']['min']) && is_string($GLOBALS['wp_sharks_core_rv']['min'])) {
            $GLOBALS['___wp_sharks_core_rv']['min'] = $GLOBALS['wp_sharks_core_rv']['min'];
        }
        if (!empty($GLOBALS['wp_sharks_core_rv']['max']) && is_string($GLOBALS['wp_sharks_core_rv']['max'])) {
            $GLOBALS['___wp_sharks_core_rv']['max'] = $GLOBALS['wp_sharks_core_rv']['max'];
        }
    }
    if (!$GLOBALS['___wp_sharks_core_rv']['min']) {
        $GLOBALS['___wp_sharks_core_rv']['min'] = '160229'; // Must have something.
    }
    unset($GLOBALS['wp_sharks_core_rv']); // Unset each time to avoid theme/plugin conflicts.
}

/**
 * Running WP Sharks™ Core vX.x+?
 *
 * @since 160501 Rewrite before launch.
 *
 * @return bool True if running a compatible version.
 */
function wp_sharks_core_rv_get_v(): bool
{
    return isset($GLOBALS[Core::class]) ? $GLOBALS[Core::class]::VERSION : '';
}
