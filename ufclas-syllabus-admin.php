<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://it.clas.ufl.edu/
 * @since             1.0.0
 * @package           Ufclas_Syllabus_Admin
 *
 * @wordpress-plugin
 * Plugin Name:       UFCLAS Syllabus Admin
 * Plugin URI:        https://it.clas.ufl.edu/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Priscilla Chapman (CLAS IT)
 * Author URI:        https://it.clas.ufl.edu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ufclas-syllabus-admin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ufclas-syllabus-admin-activator.php
 */
function activate_ufclas_syllabus_admin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ufclas-syllabus-admin-activator.php';
	Ufclas_Syllabus_Admin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ufclas-syllabus-admin-deactivator.php
 */
function deactivate_ufclas_syllabus_admin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ufclas-syllabus-admin-deactivator.php';
	Ufclas_Syllabus_Admin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ufclas_syllabus_admin' );
register_deactivation_hook( __FILE__, 'deactivate_ufclas_syllabus_admin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ufclas-syllabus-admin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ufclas_syllabus_admin() {

	$plugin = new Ufclas_Syllabus_Admin();
	$plugin->run();

}
run_ufclas_syllabus_admin();
