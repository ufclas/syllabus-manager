<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.0.0
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.0.0
	 */
	public static function deactivate() {
		global $wp_roles;
		
		// Get rid of the custom rewrite rules
		flush_rewrite_rules();
		
		/**
		 * Remove custom roles
		 */
		$roles = array( 'sm_admin', 'sm_admin_dept' );
		
		foreach( $roles as $role_name ){
			if ( get_role( $role_name ) ){
				remove_role( $role_name );
			}
		}
		
		/**
		 * Remove custom capabilities
		 */
		$role = get_role('administrator');
		$role->remove_cap( 'delete_others_syllabus_courses' );
		$role->remove_cap( 'delete_private_syllabus_courses' );
		$role->remove_cap( 'delete_published_syllabus_courses' );
		$role->remove_cap( 'delete_syllabus_course' );
		$role->remove_cap( 'delete_syllabus_courses' );
		$role->remove_cap( 'edit_others_syllabus_courses' );
		$role->remove_cap( 'edit_private_syllabus_courses' );
		$role->remove_cap( 'edit_published_syllabus_courses' );
		$role->remove_cap( 'edit_syllabus_course' );
		$role->remove_cap( 'edit_syllabus_courses' );
		$role->remove_cap( 'edit_syllabus_courses' );
		$role->remove_cap( 'publish_syllabus_courses' );
		$role->remove_cap( 'read_private_syllabus_courses' );
		$role->remove_cap( 'read_syllabus_course' );
		$role->remove_cap( 'assign_syllabus_department' );
		$role->remove_cap( 'assign_syllabus_instructor' );
		$role->remove_cap( 'assign_syllabus_level' );
		$role->remove_cap( 'assign_syllabus_semester' );
		$role->remove_cap( 'delete_syllabus_department' );
		$role->remove_cap( 'delete_syllabus_instructor' );
		$role->remove_cap( 'delete_syllabus_level' );
		$role->remove_cap( 'delete_syllabus_semester' );
		$role->remove_cap( 'edit_syllabus_department' );
		$role->remove_cap( 'edit_syllabus_instructor' );
		$role->remove_cap( 'edit_syllabus_level' );
		$role->remove_cap( 'edit_syllabus_semester' );
		$role->remove_cap( 'manage_syllabus_department' );
		$role->remove_cap( 'manage_syllabus_instructor' );
		$role->remove_cap( 'manage_syllabus_level' );
		$role->remove_cap( 'manage_syllabus_semester' );
		
		
		if ( WP_DEBUG ) {error_log('Syllabus Manager deactivated.');}
	}

}