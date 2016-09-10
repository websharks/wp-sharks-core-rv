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
 * Filter WP Sharks™ Core in plugin API calls.
 *
 * @note This is what makes new installations of the framework possible.
 *
 * @since 160501 Rewrite before launch.
 *
 * @param StdClass|array|bool $response False (by default).
 * @param string              $action   The API action that is being performed by WP core.
 * @param StdClass            $args     Incoming arguments for the API request.
 *
 * @return StdClass|array|bool An object|array when filtering.
 */
function ___wp_sharks_core_rv_filter_plugins_api($response, $action, $args)
{
    if ($response !== false) {
        return $response; // Filtered already.
    } elseif ($action !== 'plugin_information') {
        return $response; // Not applicable.
    } elseif (empty($args->slug) || $args->slug !== 'wp-sharks-core') {
        return $response; // Not applicable.
    }
    $_r = stripslashes_deep($_REQUEST); // Clean these up.

    if (empty($_r['action']) || $_r['action'] !== 'install-plugin') {
        return $response; // Nothing to do here.
    } elseif (empty($_r['___action_via']) || $_r['___action_via'] !== 'wp-sharks-core-rv') {
        return $response; // Not applicable.
    } elseif (empty($_r['plugin']) || $_r['plugin'] !== 'wp-sharks-core') {
        return $response; // Not applicable.
    }
    return $response = (object) [
       'version' => 'latest',
       'slug'    => 'wp-sharks-core',
       'name'    => 'WP Sharks Core',

       'homepage'    => ___wp_sharks_core_rv_home_url(),
       'donate_link' => ___wp_sharks_core_rv_donate_url(),

       'author_profile' => ___wp_sharks_core_rv_wp_profile_url(),
       'author'         => '<a href="'.esc_attr(___wp_sharks_core_rv_home_url()).'">WP Sharks</a>',

       'contributors' => ['wpsharks' => ___wp_sharks_core_rv_wp_profile_url()],

       'short_description' => 'The WP Sharks Core is a WordPress plugin that serves as a framework for other plugins by the WP Sharks team.',
       'description'       => 'This plugin (by itself) does nothing. It merely serves as a framework for other plugins by the WP Sharks team; i.e., it contains code that is resused by other plugins that we develop. In other words, instead of shipping each plugin with our full framework we provide the framework as an installable plugin. This allows you to run lots of other plugins that we offer, without the added overhead of loading our framework in each one. Instead, it is loaded just once by this core.',
       'tags'              => ['websharks', 'wpsharks', 'wordpress', 'framework'],

       'download_link' => ___wp_sharks_core_rv_latest_zip_url(),

       'versions' => [
           'latest' => ___wp_sharks_core_rv_latest_zip_url(),
       ],

       'requires'      => ___wp_sharks_core_rv_get_wp_version(),
       'tested'        => ___wp_sharks_core_rv_get_wp_version(),
       'compatibility' => [
           ___wp_sharks_core_rv_get_wp_version() => [
               'latest' => [100, 1, 1],
           ],
       ],

       'downloaded'      => 1,
       'active_installs' => 1,
       'rating'          => 100,
       'num_ratings'     => 1,
       'ratings'         => [
           5 => 1,
           4 => 0,
           3 => 0,
           2 => 0,
           1 => 0,
       ],

       'added'        => date('Y-m-d'),
       'last_updated' => date('Y-m-d g:ia e'),

       'group' => '', // Not sure what this is for yet.

       'sections' => [
           'description' => 'This plugin (by itself) does nothing. It merely serves as a framework for other plugins by the WP Sharks team; i.e., it contains code that is resused by other plugins that we develop. In other words, instead of shipping each plugin with our full framework we provide the framework as an installable plugin. This allows you to run lots of other plugins that we offer, without the added overhead of loading our framework in each one. Instead, it is loaded just once by this core.',
           'screenshots' => '',
           'changelog'   => '',
           'faq'         => '',
           'reviews'     => '',
       ],
    ];
}

/**
 * Filter `update_plugins` transient data.
 *
 * @note This is what makes updates of the framework possible.
 *
 * @since 160501 Rewrite before launch.
 *
 * @param \StdClass|mixed $report Report details.
 *
 * @return \StdClass|mixed Report details.
 */
function ___wp_sharks_core_rv_filter_transient_update_plugins($report)
{
    $_r = stripslashes_deep($_REQUEST);

    if (empty($_r['action']) || $_r['action'] !== 'upgrade-plugin') {
        return $report; // Nothing to do here.
    } elseif (empty($_r['___action_via']) || $_r['___action_via'] !== 'wp-sharks-core-rv') {
        return $report; // Not applicable.
    } elseif (empty($_r['plugin']) || $_r['plugin'] !== 'wp-sharks-core/plugin.php') {
        return $report; // Not applicable.
    }
    if (!is_object($report)) {
        $report = (object) []; // New object class.
    }
    if (!isset($report->response) || !is_array($report->response)) {
        $report->response = []; // Force an array value.
    }
    $report->response['wp-sharks-core/plugin.php'] = (object) [
        'id'          => -1,
        'new_version' => 'latest',
        'slug'        => 'wp-sharks-core',
        'plugin'      => 'wp-sharks-core/plugin.php',
        'url'         => ___wp_sharks_core_rv_product_url(),
        'package'     => ___wp_sharks_core_rv_latest_zip_url(),
        'tested'      => ___wp_sharks_core_rv_get_wp_version(),
    ];
    return $report; // With update properties.
}
