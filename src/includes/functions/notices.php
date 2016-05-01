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
 * Creates a WP Dashboard notice regarding PHP requirements.
 *
 * @since 160501 Rewrite before launch.
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

    $version = isset($GLOBALS['wp_sharks_core'])
        ? $wp_sharks_core::VERSION : '';

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
        $text_domain = preg_replace('/[^a-z0-9\-]/i', '-', $text_domain);
        $text_domain = trim($text_domain, '-');
    }
    if (!$cap) {
        $cap = 'activate_plugins';
    }
    if (!$action) {
        $action = 'all_admin_notices';
    }
    if (!$markup) {
        $core_plugin_upgrade_url = ___wp_sharks_core_rv_admin_upgrade_url();
        $core_plugin_archive_url = ___wp_sharks_core_rv_release_archive_url();
        $core_plugin_install_url = ___wp_sharks_core_rv_admin_install_url();

        $arrow  = '<span class="dashicons dashicons-editor-break" style="-webkit-transform:scale(-1, 1); transform:scale(-1, 1);"></span>';
        $bubble = '<span class="dashicons dashicons-admin-plugins" style="display:inline-block; width:64px; height:64px; font-size:64px; float:left; margin:-5px 10px 0 -2px;"></span>';

        $markup = $bubble; // Initialize markup; starting with the bubble icon.

        switch ($reason) {
            case 'needs-upgrade': // Upgrade to latest core.
                $markup .= sprintf(__('<strong>%1$s is not active.</strong> It requires <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> v%3$s (or higher).<br />', $text_domain), esc_html($brand_name), esc_attr($core_plugin_archive_url), esc_html($min_version));
                $markup .= sprintf(__('You\'re currently running an older copy (v%1$s) of the WP Sharks Core.<br />', $text_domain), esc_html($version));
                $markup .= $arrow.' '.sprintf(__('A simple update is necessary. <strong><a href="%1$s">Click here to upgrade the WP Sharks Core</a></strong>.<br />', $text_domain), esc_attr($core_plugin_upgrade_url));
                break; // All done here.

            case 'needs-downgrade': // Downgrade. Requires manual intervention.
                $markup .= sprintf(__('<strong>%1$s is not active.</strong> It requires an older version of the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> framework.<br />', $text_domain), esc_html($brand_name), esc_attr($core_plugin_archive_url));
                $markup .= sprintf(__('You\'re running a newer copy (v%1$s). That will not work for %2$s, unfortunately.<br />', $text_domain), esc_html($version), esc_html($brand_name));
                $markup .= $arrow.' '.sprintf(__('A manual downgrade is necessary. <strong><a href="%1$s" target="_blank">Click here to open the WP Sharks Core release archive</a></strong>.<br />', $text_domain), esc_attr($core_plugin_archive_url));
                $markup .= '<span style="display:inline-block; margin:0 0 0 1.75em;"></span>'.sprintf(__('%1$s is compatible up to WP Sharks Core v%2$s.<br />', $text_domain), esc_html($brand_name), esc_html($max_version));
                break; // All done here.

            case 'missing': // Installation of core dependency.
            default: // Also the default case handler; i.e., anything else.
                $markup .= sprintf(__('<strong>%1$s is not active yet.</strong> It depends on the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> framework.<br />', $text_domain), esc_html($brand_name), esc_attr($core_plugin_archive_url));
                $markup .= $arrow.' '.sprintf(__('A simple addition is necessary. <strong><a href="%1$s">Click here to install the WP Sharks Core dependency</a></strong>.<br />', $text_domain), esc_attr($core_plugin_install_url));
                $markup .= sprintf(__('<em>To remove this message install the framework or remove %1$s from WordPress.</em>', $text_domain), esc_html($brand_name));
                break; // All done here.
        }
    }
    add_action($action, function () use ($cap, $markup) {
        if (current_user_can($cap)) {
            echo '<div class="notice notice-error">'.
                    '<p>'.$markup.'</p>'.
                 '</div>';
        }
    });
}
