<?php
/**
 * Plugin Name:       pbwebd-childnav
 * Plugin URI:        http://pbwebd.com
 * Description:       Add a child navigation as a widget or directly to a page.
 * Version:           1.0.0
 * Author:            Danielle Zarcaro
 * Author URI:        http://pbwebd.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pbwebd_childnav
 * Domain Path:       /languages
 *
 * @link              http://pbwebd.com
 * @since             1.0.0
 * @package           Pbwebd_childnav
 *
 * The plugin bootstrap file --
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 */
function activate_pbwebd_childnav() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pbwebd_childnav-activator.php';
	Pbwebd_childnav_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_pbwebd_childnav() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pbwebd_childnav-deactivator.php';
	Pbwebd_childnav_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pbwebd_childnav' );
register_deactivation_hook( __FILE__, 'deactivate_pbwebd_childnav' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pbwebd_childnav.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_pbwebd_childnav() {

	$plugin = new Pbwebd_childnav();
	$plugin->run();

}
run_pbwebd_childnav();
