<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://texterify.com
 * @since             1.0.0
 * @package           Texterify
 *
 * @wordpress-plugin
 * Plugin Name:       Texterify
 * Plugin URI:        https://docs.texterify.com/integrations/wordpress
 * Description:       Exchange your content with Texterify.
 * Version:           1.0.0
 * Author:            Texterify
 * Author URI:        https://texterify.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       texterify
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('TEXTERIFY_VERSION', '1.0.0');

define('TEXTERIFY_FILE', __FILE__);
define('TEXTERIFY_DIR', plugin_dir_path(TEXTERIFY_FILE));
define('TEXTERIFY_URL', plugin_dir_url(TEXTERIFY_FILE));

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-texterify-activator.php
 */
function activate_texterify() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-texterify-activator.php';
	Texterify_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-texterify-deactivator.php
 */
function deactivate_texterify() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-texterify-deactivator.php';
	Texterify_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_texterify' );
register_deactivation_hook( __FILE__, 'deactivate_texterify' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-texterify.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_texterify() {
    global $wpdb;
	// $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key = '_pll_strings_translations'", OBJECT);

	$plugin = new Texterify();
	$plugin->run();

}
run_texterify();
