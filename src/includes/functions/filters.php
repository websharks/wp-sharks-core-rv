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
        return $response;
    }
    if ($action !== 'plugin_information') {
        return $response; // Not applicable.
    }
    if (empty($args->slug) || $args->slug !== 'wp-sharks-core') {
        return $response; // Not applicable.
    }
    $_r = stripslashes_deep($_REQUEST); // Clean these up.

    if (empty($_r['action']) || $_r['action'] !== 'install-plugin') {
        return $transient; // Nothing to do here.
    }
    if (empty($_r['action_via']) || $_r['action_via'] !== 'wp-sharks-core-rv') {
        return $response; // Not applicable.
    }
    if (empty($_r['plugin']) || $_r['plugin'] !== 'wp-sharks-core') {
        return $response; // Not applicable.
    }
    $response = (object) [
       'version' => 'master',
       'slug'    => 'wp-sharks-core',
       'name'    => 'WP Sharks Core',

       'homepage'    => ___wp_sharks_core_rv_home_url(),
       'donate_link' => ___wp_sharks_core_rv_donate_url(),

       'author_profile' => 'https://profiles.wordpress.org/wpsharks',
       'author'         => '<a href="'.esc_attr(___wp_sharks_core_rv_home_url()).'">WP Sharks</a>',

       'contributors' => ['wpsharks' => 'https://profiles.wordpress.org/wpsharks'],

       'short_description' => 'The WP Sharks Core is a WordPress plugin that serves as a framework for other plugins by the WP Sharks team.',
       'description'       => 'This plugin (by itself) does nothing. It merely serves as a framework for other plugins by the WP Sharks team; i.e., it contains code that is resused by other plugins that we develop. In other words, instead of shipping each plugin with our full framework we provide the framework as an installable plugin. This allows you to run lots of other plugins that we offer, without the added overhead of loading our framework in each one. Instead, it is loaded just once by this core.',
       'tags'              => ['websharks', 'wpsharks', 'wordpress', 'framework'],

       'download_link' => ___wp_sharks_core_rv_latest_zip_url(),

       'versions' => [
           'trunk'  => ___wp_sharks_core_rv_latest_zip_url(),
           'master' => ___wp_sharks_core_rv_latest_zip_url(),
       ],

       'requires'      => get_bloginfo('version'),
       'tested'        => get_bloginfo('version'),
       'compatibility' => [
           get_bloginfo('version') => [
               'master' => [100, 1, 1],
           ],
       ],

       'downloaded' > 1,
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
 * @param StdClass|bool $transient Existing transient data.
 *
 * @return StdClass|bool Filtered transient data.
 */
function ___wp_sharks_core_rv_filter_transient_update_plugins($transient)
{
    $_r = stripslashes_deep($_REQUEST); // Clean these up.

    if (empty($_r['action']) || $_r['action'] !== 'upgrade-plugin') {
        return $transient; // Nothing to do here.
    }
    if (empty($_r['plugin']) || $_r['plugin'] !== 'wp-sharks-core/plugin.php') {
        return $response; // Not applicable.
    }
    if (empty($_r['via']) || $_r['via'] !== 'wp-sharks-core-rv') {
        return $response; // Not applicable.
    }
    if (!is_object($transient)) {
        $transient = (object) []; // New object class.
    }
    $transient->last_checked                          = time();
    $transient->checked['wp-sharks-core/plugin.php']  = 'master';
    $transient->response['wp-sharks-core/plugin.php'] = (object) [
        'id'          => -1,
        'new_version' => 'master',
        'slug'        => 'wp-sharks-core',
        'url'         => ___wp_sharks_core_rv_product_url(),
        'package'     => ___wp_sharks_core_rv_latest_zip_url(),
    ];
    return $transient;
}
