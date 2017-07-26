<?php

/**
 * Fired during plugin activation
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.0.0
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.0
	 */
	public static function activate() {
		global $wpdb;
				
		$table_name = $wpdb->prefix . 'courses_20178';
		
		$sql = "CREATE TABLE $table_name (
		  ID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		  course_code char(7) NOT NULL,
		  section char(4) NOT NULL,
		  post_id bigint(20) unsigned NOT NULL,
		  PRIMARY KEY  (ID),
		  UNIQUE KEY  course_section (course_code, section),
		  KEY course_code (course_code)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
		
		// Examine the current table structure to the desired one and updates if needed
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		// Save version number of the table structure
		add_option( 'sm_db_version', '0.0.0' );
		
		error_log('Syllabus manager activated.');
		error_log($table_name);
		error_log($charset_collate);
		error_log(get_option('sm_db_version'));
	}

}
