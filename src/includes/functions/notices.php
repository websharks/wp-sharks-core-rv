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
 */
function wp_sharks_core_rv_notice(string $brand_name = '')
{
    # Maybe initialize.

    if (isset($GLOBALS['wp_sharks_core_rv'])) {
        ___wp_sharks_core_rv_initialize();
    }
    # Only in the admin area.

    if (!is_admin()) {
        return; // Not applicable.
    }
    # Establish the brand name.

    if (!$brand_name) { // Try auto-detection.
        $brand_name = ___wp_sharks_core_rv_notice_brand_name();
    } // If brand name detection fails too, use generic.
    $brand_name = $brand_name ?: 'This Software';

    # Current WP Sharks Core versions.

    $version     = ___wp_sharks_core_rv_get_version();
    $min_version = $GLOBALS['___wp_sharks_core_rv']['min'];
    $max_version = $GLOBALS['___wp_sharks_core_rv']['max'];

    # Detect if the plugin is installed within WordPress.

    $is_installed = is_dir(WP_PLUGIN_DIR.'/wp-sharks-core');

    # Determine reason for dependency failure.

    if (!$version && !$is_installed) {
        $reason = 'missing';
        $cap    = 'install_plugins';
    } elseif (!$version && $is_installed) {
        $reason = 'inactive';
        $cap    = 'activate_plugins';
    } elseif ($min_version && $version && version_compare($version, $min_version, '<')) {
        $reason = 'needs-upgrade';
        $cap    = 'update_plugins';
    } elseif ($max_version && $version && version_compare($version, $max_version, '>')) {
        $reason = 'needs-downgrade';
        $cap    = 'update_plugins';
    } else { // Unexpected scenario here.
        return; // Nothing to do.
    }
    # Fill-in additional variables needed down below.

    $action          = 'all_admin_notices'; // All admin views.
    $action_priority = 10; // Default priority.

    # Establish important URLs needed below.

    $core_plugin_archive_url  = ___wp_sharks_core_rv_release_archive_url();
    $core_plugin_install_url  = ___wp_sharks_core_rv_admin_install_url();
    $core_plugin_activate_url = ___wp_sharks_core_rv_admin_activate_url();
    $core_plugin_upgrade_url  = ___wp_sharks_core_rv_admin_upgrade_url();

    # Defined pre-styled icons needed below for markup generation.

    $arrow = '<span class="dashicons dashicons-editor-break" style="-webkit-transform:scale(-1, 1); transform:scale(-1, 1);"></span>';
    $icon  = '<span class="dashicons dashicons-admin-plugins" style="display:inline-block; width:64px; height:64px; font-size:64px; float:left; margin:-5px 10px 0 -2px;"></span>';

    # This allows hooks to alter any variable by reference.

    foreach (array_keys(get_defined_vars()) as $___var_key) {
        $___refs[$___var_key] = &$$___var_key;
    } // Hooks can alter any variable by reference.

    do_action('wp_sharks_core_rv_notice_refs_before_markup', $___refs);
    unset($___refs, $___var_key); // Housekeeping.

    # Generate markup for the WP Sharks Core dependency notice.

    switch ($reason) { // Based on reason.

        case 'missing': // Installation of core dependency.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('\'WP Sharks Core\' Dependency Required', 'wp-sharks-core-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It depends on the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> plugin.', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url($core_plugin_archive_url)).'<br />';
            $markup     .= $arrow.' '.sprintf(__('A simple addition is necessary. <strong><a href="%1$s">Click here to install the WP Sharks Core</a></strong>.', 'wp-sharks-core-rv'), esc_url($core_plugin_install_url)).'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, install the core framework or remove %1$s from WordPress.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'inactive': // Activate core dependency.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('\'WP Sharks Core\' Activation Required', 'wp-sharks-core-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It depends on the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> plugin.', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url($core_plugin_archive_url)).'<br />';
            $markup     .= $arrow.' '.sprintf(__('A simple activation is necessary. <strong><a href="%1$s">Click to activate the WP Sharks Core</a></strong>.', 'wp-sharks-core-rv'), esc_url($core_plugin_activate_url)).'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, activate the core framework or remove %1$s until you do.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'needs-upgrade': // Upgrade to latest core.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('\'WP Sharks Core\' Upgrade Required', 'wp-sharks-core-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> v%3$s (or higher).', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url($core_plugin_archive_url), esc_html($min_version)).'<br />';
            $markup     .= sprintf(__('You\'re currently running an older copy (v%1$s) of the WP Sharks Core plugin.', 'wp-sharks-core-rv'), esc_html($version)).'<br />';
            $markup     .= $arrow.' '.sprintf(__('A simple update is necessary. <strong><a href="%1$s">Click to upgrade the WP Sharks Core</a></strong>.', 'wp-sharks-core-rv'), esc_url($core_plugin_upgrade_url)).'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, upgrade the core framework or remove %1$s from WordPress.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        case 'needs-downgrade': // Downgrade. Requires manual intervention.
            $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
            $markup     .= __('\'WP Sharks Core\' Downgrade Required', 'wp-sharks-core-rv');
            $markup .= '</p>';
            $markup .= '<p style="margin:0 0 .5em 0;">';
            $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires an older version of the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> plugin.', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url($core_plugin_archive_url)).'<br />';
            $markup     .= sprintf(__('This software is compatible up to WP Sharks Core v%1$s, but you\'re running the newer v%2$s.', 'wp-sharks-core-rv'), esc_html($max_version), esc_html($version)).'<br />';
            $markup     .= $arrow.' '.sprintf(__('A manual downgrade is necessary. <strong><a href="%1$s" target="_blank">Visit the WP Sharks Core release archive</a></strong>.', 'wp-sharks-core-rv'), esc_url($core_plugin_archive_url)).'<br />';
            $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, downgrade the core framework or remove %1$s from WordPress.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
            $markup .= '</p>';
            break; // All done here.

        default: // Default case handler; i.e., anything else.
            return; // Nothing to do here.
    }
    # This allows hooks to alter any variable by reference.

    foreach (array_keys(get_defined_vars()) as $___var_key) {
        $___refs[$___var_key] = &$$___var_key;
    } // Hooks can alter any variable by reference.

    do_action('wp_sharks_core_rv_notice_refs', $___refs);
    unset($___refs, $___var_key); // Housekeeping.

    # Attach an action to display the notice now.

    add_action($action, function () use ($cap, $markup) {
        global $pagenow; // Needed below.

        if (!current_user_can($cap)) {
            return; // Not applicable.
        }
        if (in_array($pagenow, ['update-core.php'], true)) {
            return; // Not during core update.
        }
        if (in_array($pagenow, ['plugins.php', 'themes.php', 'update.php'], true)
            && ($_REQUEST['action_via'] ?? '') === 'wp-sharks-core-rv') {
            return; // Not during a plugin install/activate/update.
        }
        if (!apply_filters('wp_sharks_core_rv_notice_display', true, get_defined_vars())) {
            return; // Disabled by a filter.
        }
        echo '<div class="notice notice-warning" style="min-height:7.5em;">'.$markup.'</div>';
    }, $action_priority); // Priority of the action hook can be filtered above.
}

/**
 * Last-ditch effort to find a brand name.
 *
 * @return string Name of the calling theme/plugin.
 */
function ___wp_sharks_core_rv_notice_brand_name(): string
{
    if (!($debug_backtrace = @debug_backtrace())) {
        return ''; // Not possible.
    }
    if (empty($debug_backtrace[1]['file'])) {
        return ''; // Not possible.
    }
    $calling_plugin_theme_dir = ''; // Initialize.
    $_calling_dir             = dirname($debug_backtrace[1]['file']);

    for ($_i = 0; $_i < 10; ++$_i) {
        if (in_array(basename(dirname($_calling_dir)), ['plugins', 'themes'], true)
            && basename(dirname(dirname($_calling_dir))) === 'wp-content') {
            $calling_plugin_theme_dir = $_calling_dir;
            break; // We can stop here.
        } else {
            $_calling_dir = dirname($_calling_dir);
        }
    } // unset($_i, $_calling_dir); // Housekeeping.

    if (empty($calling_plugin_theme_dir)) {
        return ''; // Not possible.
    }
    $brand_name = strtolower(basename($calling_plugin_theme_dir));
    $brand_name = preg_replace('/[_\-]+(?:lite|pro)$/u', '', $brand_name);
    $brand_name = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $brand_name);
    $brand_name = ucwords(trim($brand_name));

    return $brand_name;
}
