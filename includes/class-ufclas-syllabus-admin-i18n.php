<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      1.0.0
 *
 * @package    Ufclas_Syllabus_Admin
 * @subpackage Ufclas_Syllabus_Admin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ufclas_Syllabus_Admin
 * @subpackage Ufclas_Syllabus_Admin/includes
 * @author     Priscilla Chapman (CLAS IT) <wordpress@clas.ufl.edu>
 */
class Ufclas_Syllabus_Admin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ufclas-syllabus-admin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
