<?php
/**
 * WP Sharks™ Core RV functions.
 *
 * @since 160620 Adding support for OPcache flushing.
 *
 * @copyright WebSharks, Inc. <http://websharks-inc.com>
 * @license GNU General Public License, version 3
 */

/**
 * On `upgrader_process_complete`.
 *
 * @since 160620 Adding support for OPcache flushing.
 */
function ___wp_sharks_core_rv_on_upgrader_process_complete()
{
    // NOTE: Avoid relying on objects in the shutdown phase.
    // PHP's shutdown phase is known to destruct objects randomly.
    add_action('shutdown', '___wp_sharks_core_rv_on_upgrader_process_complete__on_shutdown');
}

/**
 * Flush the OPcache whenever an upgrade occurs.
 *
 * @since 160620 Adding support for OPcache flushing.
 */
function ___wp_sharks_core_rv_on_upgrader_process_complete__on_shutdown()
{
    // NOTE: Avoid relying on objects in the shutdown phase.
    // PHP's shutdown phase is known to destruct objects randomly.
    if (function_exists('opcache_reset')) {
        @opcache_reset();
    }
}
