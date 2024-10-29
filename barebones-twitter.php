<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           barebones-twitter
 *
 * @wordpress-plugin
 * Plugin Name:       Barebones Twitter
 * Plugin URI:        http://aaronfisher.co
 * Description:       Easily add a barebones Twitter widget to your Wordpress website
 * Version:           1.0.0
 * Author:            Aaron Fisher
 * Author URI:        http://aaronfisher.co
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       barebones-twitter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-barebones-twitter-activator.php
 */
function activate_barebones_twitter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-barebones-twitter-activator.php';
	Barebones_Twitter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-barebones-twitter-deactivator.php
 */
function deactivate_barebones_twitter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-barebones-twitter-deactivator.php';
	Barebones_Twitter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_barebones_twitter' );
register_deactivation_hook( __FILE__, 'deactivate_barebones_twitter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-barebones-twitter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_plugin_name() {

	$plugin = new Barebones_Twitter();
	$plugin->run();

}
run_plugin_name();
