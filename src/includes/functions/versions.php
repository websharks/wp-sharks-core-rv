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
 * Get installed core version.
 *
 * @since 160501 Rewrite before launch.
 *
 * @return string Installed core version.
 */
function wp_sharks_core_rv_get_version(): string
{
    return isset($GLOBALS[Core::class]) ? $GLOBALS[Core::class]::VERSION : '';
}
