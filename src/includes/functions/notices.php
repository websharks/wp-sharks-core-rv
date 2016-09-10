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
    # Admin area only.

    if (!is_admin()) {
        return; // Unnecesary.
    } // Stop if not in admin area.

    # Maybe initialize.

    global $wp_sharks_core_rv;
    global $___wp_sharks_core_rv;

    if (isset($wp_sharks_core_rv)) {
        ___wp_sharks_core_rv_initialize();
    }
    # Copy of WP Sharks Core requirements (RV).

    $rv = $___wp_sharks_core_rv; // Snapshot in time.

    # Determine reason for dependency failure.

    if (!($issue = ___wp_sharks_core_rv_issue())) {
        return; // Nothing to do here.
    } // This is also a snapshot in time.

    # Establish brand name for this software.

    if (!$brand_name) { // Try auto-detection.
        $brand_name = ___wp_sharks_core_rv_notice_brand_name();
    } // If brand name detection fails too, use generic.
    $brand_name = $brand_name ?: __('This Software', 'wp-sharks-core-rv');

    # Attach an action to display the notice on hook `all_admin_notices`.

    add_action('all_admin_notices', function () use (&$rv, &$issue, &$brand_name) {
        global $pagenow; // Global used below.

        # Check if applicable.

        if (!current_user_can($issue['cap'])) {
            return; // Not applicable.
        } elseif (in_array($pagenow, ['update-core.php'], true)) {
            return; // Not during core update.
        } elseif (in_array($pagenow, ['plugins.php', 'themes.php', 'update.php'], true)
                && ($_REQUEST['___action_via'] ?? '') === 'wp-sharks-core-rv') {
            return; // Not during a plugin install/activate/update.
        } elseif (!apply_filters('wp_sharks_core_rv_notice_display', true, get_defined_vars())) {
            return; // Disabled by a filter.
        }
        # Define pre-styled icons needed for markup.

        $arrow = '<span class="dashicons dashicons-editor-break" style="-webkit-transform:scale(-1, 1); transform:scale(-1, 1);"></span>';
        $icon = '<span class="dashicons dashicons-admin-plugins" style="display:inline-block; width:64px; height:64px; font-size:64px; float:left; margin:-5px 10px 0 -2px;"></span>';

        # Generate markup for WP Sharks Core dependency notice.

        switch ($issue['reason']) { // Based on reason.

            case 'missing': // Installation of core dependency.
                $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
                $markup     .= __('\'WP Sharks Core\' Dependency Required', 'wp-sharks-core-rv');
                $markup .= '</p>';
                $markup .= '<p style="margin:0 0 .5em 0;">';
                $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It depends on the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> plugin.', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url(___wp_sharks_core_rv_release_archive_url())).'<br />';
                $markup     .= $arrow.' '.sprintf(__('A simple addition is necessary. <strong><a href="%1$s">Click here to install the WP Sharks Core</a></strong>.', 'wp-sharks-core-rv'), esc_url(___wp_sharks_core_rv_admin_install_url())).'<br />';
                $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, install the core framework or remove %1$s from WordPress.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
                $markup .= '</p>';
                break; // All done here.

            case 'inactive': // Activate core dependency.
                $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
                $markup     .= __('\'WP Sharks Core\' Activation Required', 'wp-sharks-core-rv');
                $markup .= '</p>';
                $markup .= '<p style="margin:0 0 .5em 0;">';
                $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It depends on the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> plugin.', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url(___wp_sharks_core_rv_release_archive_url())).'<br />';
                $markup     .= $arrow.' '.sprintf(__('A simple activation is necessary. <strong><a href="%1$s">Click to activate the WP Sharks Core</a></strong>.', 'wp-sharks-core-rv'), esc_url(___wp_sharks_core_rv_admin_activate_url())).'<br />';
                $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, activate the core framework or remove %1$s until you do.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
                $markup .= '</p>';
                break; // All done here.

            case 'needs-upgrade': // Upgrade to latest core.
                $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
                $markup     .= __('\'WP Sharks Core\' Upgrade Required', 'wp-sharks-core-rv');
                $markup .= '</p>';
                $markup .= '<p style="margin:0 0 .5em 0;">';
                $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> v%3$s (or higher).', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url(___wp_sharks_core_rv_release_archive_url()), esc_html($rv['min'])).'<br />';
                $markup     .= sprintf(__('You\'re currently running an older copy (v%1$s) of the WP Sharks Core plugin.', 'wp-sharks-core-rv'), esc_html(___wp_sharks_core_rv_get_version())).'<br />';
                $markup     .= $arrow.' '.sprintf(__('A simple update is necessary. <strong><a href="%1$s">Click to upgrade the WP Sharks Core</a></strong>.', 'wp-sharks-core-rv'), esc_url(___wp_sharks_core_rv_admin_upgrade_url())).'<br />';
                $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, upgrade the core framework or remove %1$s from WordPress.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
                $markup .= '</p>';
                break; // All done here.

            case 'needs-downgrade': // Downgrade. Requires manual intervention.
                $markup = '<p style="font-weight:bold; font-size:125%; margin:.25em 0 0 0;">';
                $markup     .= __('\'WP Sharks Core\' Downgrade Required', 'wp-sharks-core-rv');
                $markup .= '</p>';
                $markup .= '<p style="margin:0 0 .5em 0;">';
                $markup     .= $icon.sprintf(__('<strong>%1$s is not active.</strong> It requires an older version of the <a href="%2$s" target="_blank" style="text-decoration:none;">WP Sharks Core</a> plugin.', 'wp-sharks-core-rv'), esc_html($brand_name), esc_url(___wp_sharks_core_rv_release_archive_url())).'<br />';
                $markup     .= sprintf(__('This software is compatible up to WP Sharks Core v%1$s, but you\'re running the newer v%2$s.', 'wp-sharks-core-rv'), esc_html($rv['max']), esc_html(___wp_sharks_core_rv_get_version())).'<br />';
                $markup     .= $arrow.' '.sprintf(__('A manual downgrade is necessary. <strong><a href="%1$s" target="_blank">Visit the WP Sharks Core release archive</a></strong>.', 'wp-sharks-core-rv'), esc_url(___wp_sharks_core_rv_release_archive_url())).'<br />';
                $markup     .= sprintf(__('<em style="font-size:80%%; opacity:.7;">To remove this message, downgrade the core framework or remove %1$s from WordPress.</em>', 'wp-sharks-core-rv'), esc_html($brand_name));
                $markup .= '</p>';
                break; // All done here.

            default: // Default case handler; i.e., anything else.
                return; // Nothing to do here.
        }
        # This allows filters to alter markup before display.

        if (($markup = apply_filters('wp_sharks_core_rv_notice_markup', $markup, get_defined_vars()))) {
            echo '<div class="notice notice-warning" style="min-height:7.5em;">'.$markup.'</div>';
        }
    });
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
    } elseif (empty($debug_backtrace[1]['file'])) {
        return ''; // Not possible.
    }
    $calling_theme_plugin_dir = ''; // Initialize.
    $_calling_dir             = dirname($debug_backtrace[1]['file']);

    for ($_i = 0; $_i < 10; ++$_i) { // Search 10 levels max.
        //
        if (in_array(basename(dirname($_calling_dir)), ['themes', 'plugins'], true)
            && basename(dirname(dirname($_calling_dir))) === 'wp-content') {
            $calling_theme_plugin_dir = $_calling_dir;
            break; // We can stop here.
            //
        } else { // Move up one directory.
            $_calling_dir = dirname($_calling_dir);
        }
    } // unset($_i, $_calling_dir); // Housekeeping.

    if (!$calling_theme_plugin_dir) {
        return ''; // Not possible.
    }
    $brand_name        = mb_strtolower(basename($calling_theme_plugin_dir));
    $brand_name        = preg_replace('/[_\-]+(?:lite|pro)$/u', '', $brand_name);
    $brand_name        = preg_replace('/[^\p{L}\p{N}]+/u', ' ', $brand_name);
    return $brand_name = mb_convert_case(trim($brand_name), MB_CASE_TITLE);
}
