<?php
/**
 * WP Sharks™ Core RV functions.
 *
 * @since 160501 Rewrite before launch.
 *
 * @copyright WebSharks, Inc. <http://websharks-inc.com>
 * @license GNU General Public License, version 3
 */
use WebSharks\WpSharks\Core\Classes\App as Core;

/**
 * Get installed WP version.
 *
 * @since 160910 Enhancing notices.
 *
 * @return string Installed WP version.
 */
function ___wp_sharks_core_rv_get_wp_version(): string
{
    return (string) ($GLOBALS['wp_version'] ?? '');
}

/**
 * Get installed core version.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Installed core version.
 */
function ___wp_sharks_core_rv_get_version(): string
{
    return isset($GLOBALS[Core::class]) ? $GLOBALS[Core::class]::VERSION : '';
}
