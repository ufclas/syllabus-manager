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
		
		// Flush rules
		flush_rewrite_rules();
		
		/**
		 * Create custom roles and add capabilities
		 */
		$default_admin_role = get_role( 'administrator' );
		$admin_role = add_role( 'sm_admin', __('Syllabus Administrator', 'syllabus-manager'), $default_admin_role->capabilities );
		
		$default_editor_role = get_role( 'editor' );
		$dept_role = add_role( 'sm_admin_dept', __('Syllabus Department Admin', 'syllabus-manager'), $default_editor_role->capabilities );
		
		// Add admin capabilities
		foreach( array($admin_role, $default_admin_role) as $role ){
			$role->add_cap( 'sm_manage_syllabus_manager' );
			$role->add_cap( 'sm_import_syllabus_manager' );
			$role->add_cap( 'sm_edit_syllabus_department' );
			$role->add_cap( 'sm_edit_syllabus_instructor' );
			$role->add_cap( 'sm_edit_syllabus_level' );
			$role->add_cap( 'sm_edit_syllabus_semester' );
			$role->add_cap( 'sm_manage_syllabus_department' );
			$role->add_cap( 'sm_manage_syllabus_instructor' );
			$role->add_cap( 'sm_manage_syllabus_level' );
			$role->add_cap( 'sm_manage_syllabus_semester' );
		}
		
		// Add basic course syllabus editing capabilities
		foreach( array($admin_role, $dept_role, $default_admin_role) as $role ){
			$role->add_cap( 'sm_delete_others_syllabus_courses' );
			$role->add_cap( 'sm_delete_private_syllabus_courses' );
			$role->add_cap( 'sm_delete_published_syllabus_courses' );
			$role->add_cap( 'sm_delete_syllabus_courses' );
			$role->add_cap( 'sm_edit_others_syllabus_courses' );
			$role->add_cap( 'sm_edit_private_syllabus_courses' );
			$role->add_cap( 'sm_edit_published_syllabus_courses' );
			$role->add_cap( 'sm_edit_syllabus_courses' );
			$role->add_cap( 'sm_publish_syllabus_courses' );
			$role->add_cap( 'sm_read_private_syllabus_courses' );
			
			// Allows users to set taxonomies for courses and media
			$role->add_cap( 'sm_assign_syllabus_department' );
			$role->add_cap( 'sm_assign_syllabus_instructor' );
			$role->add_cap( 'sm_assign_syllabus_level' );
			$role->add_cap( 'sm_assign_syllabus_semester' );
			
			// Allows users to remove taxonomies from courses and media
			$role->add_cap( 'sm_delete_syllabus_department' );
			$role->add_cap( 'sm_delete_syllabus_instructor' );
			$role->add_cap( 'sm_delete_syllabus_level' );
			$role->add_cap( 'sm_delete_syllabus_semester' );
		}
		
		// Remove access to posts and pages for non-admin role
		foreach( array($dept_role) as $role ){
			$role->remove_cap( 'copy_posts' );
			$role->remove_cap( 'delete_others_pages' );
			$role->remove_cap( 'delete_others_posts' );
			$role->remove_cap( 'delete_pages' );
			$role->remove_cap( 'delete_posts' );
			$role->remove_cap( 'delete_private_pages' );
			$role->remove_cap( 'delete_private_posts' );
			$role->remove_cap( 'delete_published_pages' );
			$role->remove_cap( 'delete_published_posts' );
			$role->remove_cap( 'edit_others_pages' );
			$role->remove_cap( 'edit_others_posts' );
			$role->remove_cap( 'edit_pages' );
			$role->remove_cap( 'edit_posts' );
			$role->remove_cap( 'edit_private_pages' );
			$role->remove_cap( 'edit_private_posts' );
			$role->remove_cap( 'edit_published_pages' );
			$role->remove_cap( 'edit_published_posts' );
			$role->remove_cap( 'manage_categories' );
			$role->remove_cap( 'manage_links' );
			$role->remove_cap( 'moderate_comments' );
			$role->remove_cap( 'publish_pages' );
			$role->remove_cap( 'publish_posts' );
			$role->remove_cap( 'read_private_pages' );
			$role->remove_cap( 'read_private_posts' );
		}
		
		
		if ( WP_DEBUG ) {error_log('Syllabus Manager activated.');}
	}
	
	/**
	 * Create the syllabus course tables
	 * 
	 * @todo Needs to be updated and implemented with new table structure
	 */
	public static function create_tables(){
		global $wpdb;
		
		/*
		$table_name = $wpdb->prefix . 'semester_20178';
		
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
		
		if ( WP_DEBUG ) {error_log('Syllabus Manager activated.');}
		*/
	}
}
