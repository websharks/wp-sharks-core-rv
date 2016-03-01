<?php
/**
 * WP Sharks™ Core RV check.
 *
 * @since 160229 First documented version.
 *
 * @copyright WebSharks, Inc. <http://websharks-inc.com>
 * @license GNU General Public License, version 3
 */
if (!defined('WPINC')) {
    exit('Do NOT access this file directly: '.basename(__FILE__));
}
if (!function_exists('wp_sharks_core_rv')) {
    require_once dirname(__FILE__).'/functions/wp.php';
}
___wp_sharks_core_rv_initialize(); // Run initilization routines.
return wp_sharks_core_rv(); // True if running a compatible version.
