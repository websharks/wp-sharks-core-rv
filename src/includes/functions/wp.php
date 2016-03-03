<?php
/**
 * WP Sharks™ Core RV functions.
 *
 * @since 160229 First documented version.
 *
 * @copyright WebSharks, Inc. <http://websharks-inc.com>
 * @license GNU General Public License, version 3
 */

/**
 * Running WP Sharks™ Core vX.x+?
 *
 * @return bool True if running a compatible version.
 */
function wp_sharks_core_rv()
{
    # Maybe initialize.

    if (isset($GLOBALS['wp_sharks_core_rv'])) {
        ___wp_sharks_core_rv_initialize();
    }
    # Current WP Sharks Core versions.

    $version = isset($GLOBALS['wp_sharks_core']->version)
        ? $GLOBALS['wp_sharks_core']->version
        : ''; // Not available.

    $min_version = $GLOBALS['___wp_sharks_core_rv']['min'];
    $max_version = $GLOBALS['___wp_sharks_core_rv']['max'];

    # Check if we have a compatible version of the WP Sharks Core.

    if (!$version || version_compare($version, $min_version, '<')) {
        return false;
    } elseif ($max_version && version_compare($version, $max_version, '>')) {
        return false;
    }
    return true; // No problems.
}

/**
 * Creates a WP Dashboard notice regarding PHP requirements.
 *
 * @param string $brand_name Name of the calling theme/plugin.
 * @param array  $args       Any additional behavioral args.
 */
function wp_sharks_core_rv_notice($brand_name = '', $args = [])
{
    # Maybe initialize.

    if (isset($GLOBALS['wp_sharks_core_rv'])) {
        ___wp_sharks_core_rv_initialize();
    }
    # Establish function arguments.

    $default_args = [
        'text_domain' => '',
        'cap'         => '',
        'action'      => '',
        'markup'      => '',
    ];
    $args = array_merge($default_args, $args);
    $args = array_intersect_key($args, $default_args);

    $brand_name  = (string) $brand_name;
    $text_domain = (string) $args['text_domain'];
    $cap         = (string) $args['cap'];
    $action      = (string) $args['action'];
    $markup      = (string) $args['markup'];

    # Current WP Sharks Core versions.

    $version = isset($GLOBALS['wp_sharks_core']->version)
        ? $GLOBALS['wp_sharks_core']->version
        : ''; // Not available.

    $min_version = $GLOBALS['___wp_sharks_core_rv']['min'];
    $max_version = $GLOBALS['___wp_sharks_core_rv']['max'];

    # Determine reason for dependency failure.

    if (!$version) {
        $reason = 'missing';
    } elseif (version_compare($version, $min_version, '<')) {
        $reason = 'needs-upgrade';
    } elseif ($max_version && version_compare($version, $max_version, '>')) {
        $reason = 'needs-downgrade';
    } else {
        $reason = 'missing';
    }
    # Fill-in anything that is currently empty.

    if (!$brand_name) {
        if (($_debug_backtrace = @debug_backtrace()) && !empty($_debug_backtrace[1]['file'])) {
            if (($_calling_file_base_dir = basename(dirname($_debug_backtrace[1]['file'])))) {
                $brand_name = strtolower($_calling_file_base_dir);
                $brand_name = trim(preg_replace('/[^a-z0-9]+/i', ' ', $brand_name));
                $brand_name = ucwords($brand_name);
            }
        } // unset($_debug_backtrace, $_calling_file_base_dir);
        $brand_name = !$brand_name ? 'This Software' : $brand_name;
    }
    if (!$text_domain) {
        $text_domain = strtolower($brand_name);
        $text_domain = preg_replace('/[^a-z0-9\-]/ui', '-', $text_domain);
        $text_domain = trim($text_domain, '-');
    }
    if (!$cap) {
        $cap = 'activate_plugins';
    }
    if (!$action) {
        $action = 'all_admin_notices';
    }
    if (!$markup) {
        switch ($reason) {
            case 'needs-upgrade':
                $core_plugin_upgrade_url = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&plugin=wp-sharks-core/plugin.php&via=wp-sharks-core-rv'), 'upgrade-plugin_wp-sharks-core/plugin.php');
                $markup                  = '<a href="https://wpsharks.com/" target="_blank" title="WP Sharks™"><img src="https://wpsharks.com/wp-content/uploads/2016/03/wp-sharks-icon-64.png" alt="WP Sharks™" style="width:64px; float:left; margin:0 10px 0 0;" /></a>';
                $markup .= sprintf(__('<strong>%1$s is NOT active. It requires the WP Sharks™ Core framework plugin v%2$s (or higher).</strong><br />', $text_domain), esc_html($brand_name), esc_html($min_version));
                $markup .= sprintf(__('&#8627; You\'re currently running an older copy of the framework plugin (v%1$ of the WP Sharks™ Core is what you have now).<br />', $text_domain), esc_html($version));
                $markup .= sprintf(__('A simple update is necessary. Please <strong><a href="%1$s">click here to upgrade</a></strong> the WP Sharks™ Core framework plugin now.<br />', $text_domain), esc_attr($core_plugin_upgrade_url));
                $markup .= sprintf(__('<em>To remove this message, please upgrade the WP Sharks™ Core plugin or remove %1$s from WordPress.</em>', $text_domain), esc_html($brand_name));
                break;

            case 'needs-downgrade':
                $core_plugin_archive_url = 'https://wpsharks.com/product/core/release-archive/';
                $markup                  = '<a href="https://wpsharks.com/" target="_blank" title="WP Sharks™"><img src="https://wpsharks.com/wp-content/uploads/2016/03/wp-sharks-icon-64.png" alt="WP Sharks™" style="width:64px; float:left; margin:0 10px 0 0;" /></a>';
                $markup .= sprintf(__('<strong>%1$s is NOT active. It requires an older version of the WP Sharks™ Core framework plugin (%1$s is compatible up to WP Sharks™ Core v%2$s).</strong><br />', $text_domain), esc_html($brand_name), esc_html($max_version));
                $markup .= sprintf(__('&#8627; You\'re currently running a newer copy of the framework plugin (v%1$ of the WP Sharks™ Core is what you have now), which will not work in v%2$s yet, unfortunately.<br />', $text_domain), esc_html($version), esc_html($brand_name));
                $markup .= sprintf(__('A manual downgrade is necessary. Please <strong><a href="%1$s" target="_blank">click here to open the WP Sharks™ Core release archive</a></strong> and obtain an older copy.<br />', $text_domain), esc_attr($core_plugin_archive_url));
                $markup .= sprintf(__('<em>To remove this message, please downgrade the WP Sharks™ Core plugin or remove %1$s from WordPress.</em>', $text_domain), esc_html($brand_name));
                break;

            case 'missing':
            default: // Also the default case.
                $core_plugin_install_url = wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=wp-sharks-core&via=wp-sharks-core-rv'), 'install-plugin_wp-sharks-core');
                $markup                  = '<a href="https://wpsharks.com/" target="_blank" title="WP Sharks™"><img src="https://wpsharks.com/wp-content/uploads/2016/03/wp-sharks-icon-64.png" alt="WP Sharks™" style="width:64px; float:left; margin:0 10px 0 0;" /></a>';
                $markup .= sprintf(__('<strong>%1$s is NOT active. It requires the WP Sharks™ Core framework plugin to be installed first.</strong><br />', $text_domain), esc_html($brand_name));
                $markup .= sprintf(__('A simple addition is necessary. Please <strong><a href="%1$s">click here to install</a></strong> the WP Sharks™ Core framework plugin now.<br />', $text_domain), esc_attr($core_plugin_install_url));
                $markup .= sprintf(__('<em>To remove this message, please install the WP Sharks™ Core framework plugin or remove %1$s from WordPress.</em>', $text_domain), esc_html($brand_name));
                break;
        }
    }
    add_action($action, create_function('', 'if(!current_user_can(\''.str_replace("'", "\\'", $cap).'\')) return;'.
                                             'echo \''.// Wrap `$notice` inside a WordPress error.
                                             '<div class="notice notice-error">'.
                                                '<p>'.str_replace("'", "\\'", $markup).'</p>'.
                                             '</div>'.
                                             '\';'));
}

/**
 * Filter WP Sharks™ Core in plugin API calls.
 *
 * @param StdClass|array|bool $response False (by default).
 * @param string              $action   The API action that is being performed by WP core.
 * @param StdClass            $args     Incoming arguments for the API request.
 *
 * @return StdClass|array|bool An object|array when filtering.
 */
function ___wp_sharks_core_plugins_api($response, $action, $args)
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
    if (empty($_REQUEST['action']) || $_REQUEST['action'] !== 'install-plugin') {
        return $transient; // Nothing to do here.
    }
    if (empty($_REQUEST['plugin']) || $_REQUEST['plugin'] !== 'wp-sharks-core') {
        return $response; // Not applicable.
    }
    if (empty($_REQUEST['via']) || $_REQUEST['via'] !== 'wp-sharks-core-rv') {
        return $response; // Not applicable.
    }
    $wp_version = get_bloginfo('version');
    $response   = (object) [
       'version' => 'master',
       'slug'    => 'wp-sharks-core',
       'name'    => 'WP Sharks™ Core',

       'homepage'       => 'https://wpsharks.com/',
       'author_profile' => '//profiles.wordpress.org/wpsharks',
       'author'         => '<a href="https://wpsharks.com/">WP Sharks™</a>',
       'contributors'   => ['wpsharks' => '//profiles.wordpress.org/wpsharks'],
       'donate_link'    => 'https://wpsharks.com/donate/',

       'short_description' => 'The WP Sharks Core is a WordPress plugin that serves as a framework for other plugins by the WP Sharks™ team.',
       'description'       => 'This plugin (by itself) does nothing. It merely serves as a framework for other plugins by the WP Sharks™ team; i.e., it contains code that is resused by other plugins that we develop. In other words, instead of shipping each plugin with our full framework, we provide the framework as an installable plugin. This allows you to run lots of other plugins that we offer, without the added overhead of loading our framework in each one. Instead, it is loaded just once by this core.',
       'tags'              => ['websharks', 'wp sharks', 'wordpress', 'framework'],

       'download_link' => 'https://github.com/websharks/wp-sharks-core/archive/master.zip',
       'versions'      => [
           'trunk'  => 'https://github.com/websharks/wp-sharks-core/archive/master.zip',
           'master' => 'https://github.com/websharks/wp-sharks-core/archive/master.zip',
       ],

       'requires'      => $wp_version,
       'tested'        => $wp_version,
       'compatibility' => [
           $wp_version => [
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
           'description' => 'This plugin (by itself) does nothing. It merely serves as a framework for other plugins by the WP Sharks™ team; i.e., it contains code that is resused by other plugins that we develop. In other words, instead of shipping each plugin with our full framework, we provide the framework as an installable plugin. This allows you to run lots of other plugins that we offer, without the added overhead of loading our framework in each one. Instead, it is loaded just once by this core.',
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
 * @param StdClass|bool $transient Existing transient data.
 *
 * @return StdClass|bool Filtered transient data.
 */
function ___wp_sharks_core_rv_pre_site_transient_update_plugins($transient)
{
    if (empty($_REQUEST['action']) || $_REQUEST['action'] !== 'upgrade-plugin') {
        return $transient; // Nothing to do here.
    }
    if (empty($_REQUEST['plugin']) || $_REQUEST['plugin'] !== 'wp-sharks-core/plugin.php') {
        return $response; // Not applicable.
    }
    if (empty($_REQUEST['via']) || $_REQUEST['via'] !== 'wp-sharks-core-rv') {
        return $response; // Not applicable.
    }
    if (!is_object($transient)) {
        $transient = new StdClass();
    }
    $transient->last_checked                          = time();
    $transient->checked['wp-sharks-core/plugin.php']  = 'master';
    $transient->response['wp-sharks-core/plugin.php'] = (object) [
        'id'          => 0,
        'new_version' => 'master',
        'slug'        => 'wp-sharks-core',
        'url'         => 'https://wpsharks.com/product/core/',
        'package'     => 'https://github.com/websharks/wp-sharks-core/archive/master.zip',
    ];
    return $transient;
}

/**
 * Initializes each instance; unsets `$GLOBALS['wp_sharks_core_rv']`.
 *
 * @note `$GLOBALS['wp_sharks_core_rv']` is for the API, we use a different variable internally.
 *    The internal global is defined here: `$GLOBALS['___wp_sharks_core_rv']`.
 */
function ___wp_sharks_core_rv_initialize() // For internal use only.
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
