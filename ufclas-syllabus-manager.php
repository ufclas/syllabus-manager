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
 * @package           Ufclas_Syllabus_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       UFCLAS Syllabus Manager
 * Plugin URI:        https://it.clas.ufl.edu/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Priscilla Chapman (CLAS IT)
 * Author URI:        https://it.clas.ufl.edu/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ufclas-syllabus-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ufclas-syllabus-manager-activator.php
 */
function activate_ufclas_syllabus_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ufclas-syllabus-manager-activator.php';
	Ufclas_Syllabus_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ufclas-syllabus-manager-deactivator.php
 */
function deactivate_ufclas_syllabus_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ufclas-syllabus-manager-deactivator.php';
	Ufclas_Syllabus_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ufclas_syllabus_manager' );
register_deactivation_hook( __FILE__, 'deactivate_ufclas_syllabus_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ufclas-syllabus-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ufclas_syllabus_manager() {

	$plugin = new Ufclas_Syllabus_Manager();
	$plugin->run();

}
run_ufclas_syllabus_manager();
