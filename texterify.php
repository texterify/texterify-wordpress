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
function texterify_activate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-texterify-activator.php';
	Texterify_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-texterify-deactivator.php
 */
function texterify_deactivate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-texterify-deactivator.php';
	Texterify_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'texterify_activate' );
register_deactivation_hook( __FILE__, 'texterify_deactivate' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-texterify.php';

function texterify_polylang_language_show_in_rest_taxonomy_args($args, $taxonomy, $object_type) {
	$taxonomies = array('language');

	if (in_array($taxonomy, $taxonomies)) {
		$args['show_in_rest'] = true;
	}

	return $args;
}

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

	$plugin = new Texterify();
	$plugin->run();

	// Polylang does not set "show_in_rest" which is required to get the language of posts and pages.
	// https://wordpress.org/support/topic/how-to-know-the-language-of-a-post-through-the-wordpress-rest-api/
	add_filter('register_taxonomy_args', 'texterify_polylang_language_show_in_rest_taxonomy_args', 10, 3);
}

run_texterify();
