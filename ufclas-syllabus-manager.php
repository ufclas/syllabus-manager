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
 * @since             0.0.1
 * @package           Syllabus_Manager
 *
 * @wordpress-plugin
 * Plugin Name:       UFCLAS Syllabus Manager
 * Plugin URI:        https://it.clas.ufl.edu/
 * Description:       WordPress plugin that manages course syllabi. 
 * Version:           0.3.0
 * Author:            Priscilla Chapman (CLAS IT)
 * Author URI:        https://it.clas.ufl.edu/
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       syllabus-manager
 * Domain Path:       /languages
 * BuildDate:		  20171011
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'SYLLABUS_MANAGER_DIR', plugin_dir_path( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-syllabus-manager-activator.php
 */
function activate_syllabus_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-syllabus-manager-activator.php';
	Syllabus_Manager_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-syllabus-manager-deactivator.php
 */
function deactivate_syllabus_manager() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-syllabus-manager-deactivator.php';
	Syllabus_Manager_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_syllabus_manager' );
register_deactivation_hook( __FILE__, 'deactivate_syllabus_manager' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-syllabus-manager.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.0.0
 */
function run_syllabus_manager() {

	$plugin = new Syllabus_Manager();
	$plugin->run();

}
run_syllabus_manager();
