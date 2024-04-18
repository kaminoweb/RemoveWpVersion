<?php
/**
* Plugin Name:       Remove WordPress version
* Plugin URI:        https://github.com/kaminoweb
* Description:       Removes WordPress version in HTML pages
* Version:           0.2
* Requires at least: 5.5
* Author:            Kaminoweb Inc
* Author URI:        https://kaminoweb.com/
* License:           GPLv2
*/

// Prevent direct access to the plugin file
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

$menu_slug = "kaminoweb-dashboard";

// Add administration menu
function kaminoweb_add_admin_menu() {
add_menu_page(
'Kaminoweb',                            // Page title
'Kaminoweb',                            // Menu title
'manage_options',                       // Capability
'kaminoweb-dashboard',                  // Menu slug
'kaminoweb_render_main_admin_page',     // Callback function to render the main page
'dashicons-admin-generic'               // Icon URL or name
);
// Add submenu page
add_submenu_page(
'kaminoweb-dashboard',                  // Parent slug
'Dashboard',                            // Page title
'Dashboard',                            // Menu title
'manage_options',                       // Capability
'kaminoweb-dashboard',                  // Menu slug
'kaminoweb_render_main_admin_page'      // Callback function to render the remove version page
);
// Add submenu page
add_submenu_page(
'kaminoweb-dashboard',                  // Parent slug
'Remove WordPress Version',             // Page title
'Remove WP Version',                    // Menu title
'manage_options',                       // Capability
'remove-wp-version',                    // Menu slug
'kaminoweb_render_remove_version_page'  // Callback function to render the remove version page
);
}

add_action('admin_menu', 'kaminoweb_add_admin_menu');

// Callback function to render main administration page
function kaminoweb_render_main_admin_page() {
?>
<div class="wrap">
<h1>Kaminoweb Dashboard</h1>
<p>Welcome to the Kaminoweb dashboard. Here you can manage various Kaminoweb plugins.</p>
</div>
<?php
}

// Callback function to render remove version administration page
function kaminoweb_render_remove_version_page() {
?>
<div class="wrap">
<h1>Remove WordPress Version</h1>
<h3>This plugin removes the WordPress version from HTML pages.</h3>
<p>Removing the WordPress version from HTML pages enhances security by minimizing the risk of targeted attacks based on known vulnerabilities in specific versions.</p>
<form method="post" action="options.php">
<?php settings_fields('kaminoweb_settings_group'); ?>
<?php do_settings_sections('kaminoweb_settings_group'); ?>
<table class="form-table">
<tr valign="top">
<th scope="row">Status:</th>
<td>
<label for="kaminoweb_plugin_active">
<?php $active = get_option('kaminoweb_plugin_active', false);
if ($active) { ?>
<input type="checkbox" id="kaminoweb_plugin_active" name="kaminoweb_plugin_active" checked="checked"> Enabled. Check the box to disable the plugin.</label>
<?php } else { ?>
<input type="checkbox" id="kaminoweb_plugin_active" name="kaminoweb_plugin_active"> Disabled. Check the box to enable the plugin.</label>
<?php
}
?>
</td>
</tr>
</table>
<?php submit_button(); ?>
</form>
</div>
<?php
}

// Register plugin settings
function kaminoweb_register_settings() {
register_setting('kaminoweb_settings_group', 'kaminoweb_plugin_active');
}

add_action('admin_init', 'kaminoweb_register_settings');

// Function to remove WordPress version from HTML pages
function kaminoweb_remove_version() {
return '';
}

// Add filter to remove WordPress version
function kaminoweb_enable_disable_plugin() {
$active = get_option('kaminoweb_plugin_active', false);
if ($active) {
add_filter('the_generator', 'kaminoweb_remove_version', 10, 3);
} else {
remove_filter('the_generator', 'kaminoweb_remove_version', 10);
}
}

add_action('wp_loaded', 'kaminoweb_enable_disable_plugin');


// Function to run when the plugin is deleted
function kaminoweb_plugin_uninstall() {
// Remove the option from the database
delete_option('kaminoweb_plugin_active');
}

register_uninstall_hook(__FILE__, 'kaminoweb_plugin_uninstall');
?>
