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
 * Any compatibility issue?
 *
 * @since 160501 Rewrite before launch.
 *
 * @return bool True if no issue.
 */
function wp_sharks_core_rv(): bool
{
    return ___wp_sharks_core_rv_issue() ? false : true;
}

/**
 * Any compatibility issue?
 *
 * @since 160501 Rewrite before launch.
 *
 * @return array Issue; else empty array.
 */
function ___wp_sharks_core_rv_issue(): array
{
    global $wp_sharks_core_rv;
    global $___wp_sharks_core_rv;

    if (isset($wp_sharks_core_rv)) {
        ___wp_sharks_core_rv_initialize();
    }
    $min_version = $___wp_sharks_core_rv['min'];
    $max_version = $___wp_sharks_core_rv['max'];
    $version     = ___wp_sharks_core_rv_get_version();

    if (!$version) { // Inactive or missing?
        if (($is_installed = is_dir(WP_PLUGIN_DIR.'/wp-sharks-core'))) {
            return ['reason' => 'inactive', 'cap' => 'activate_plugins'];
        } else { // Simply missing in this WP installation.
            return ['reason' => 'missing', 'cap' => 'install_plugins'];
        }
    } elseif ($min_version && version_compare($version, $min_version, '<')) {
        return ['reason' => 'needs-upgrade', 'cap' => 'update_plugins'];
    } elseif ($max_version && version_compare($version, $max_version, '>')) {
        return ['reason' => 'needs-downgrade', 'cap' => 'update_plugins'];
    }
    return []; // No problem.
}

/**
 * Initializes each instance; unsets `$wp_sharks_core_rv`.
 *
 * @note `$wp_sharks_core_rv` is for the API, we use a different variable internally.
 *    The internal global is defined here: `$___wp_sharks_core_rv`.
 *
 * @since 160501 Rewrite before launch.
 */
function ___wp_sharks_core_rv_initialize()
{
    global $wp_sharks_core_rv;
    global $___wp_sharks_core_rv;

    $___wp_sharks_core_rv = ['min' => '', 'max' => ''];

    if (!empty($wp_sharks_core_rv)) {
        if (is_string($wp_sharks_core_rv)) {
            $___wp_sharks_core_rv['min'] = $wp_sharks_core_rv;
        } elseif (is_array($wp_sharks_core_rv)) {
            if (!empty($wp_sharks_core_rv['min'])) {
                $___wp_sharks_core_rv['min'] = (string) $wp_sharks_core_rv['min'];
            }
            if (!empty($wp_sharks_core_rv['max'])) {
                $___wp_sharks_core_rv['max'] = (string) $wp_sharks_core_rv['max'];
            }
        }
    } // This global is nullified after each new check initializes.
    $wp_sharks_core_rv = null; // Unset to avoid theme/plugin conflicts.
}
