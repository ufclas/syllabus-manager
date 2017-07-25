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
 * @since      0.0.1
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Courses {
	public $post_type_name;
	public $post_type_base;
	
	public function __construct() {
		$this->post_type_name = 'syllabus_course';
		$this->post_type_base = 'courses';
	}
	
	public function register_post_type(){
		
		$post_type_labels = array(
			'name' => __( 'Courses', 'syllabus_manager' ),
			'singular_name' => __( 'Course', 'syllabus_manager' ),
		);
		
		$post_type_args = array(
			'label' => $post_type_labels['name'],
			'labels' => $post_type_labels,
			'description' => '',
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'show_in_rest' => true,
			'rest_base' => $this->post_type_base,
			'has_archive' => true,
			'show_in_menu' => false,
			'exclude_from_search' => false,
			'capability_type' => 'page',
			'map_meta_cap' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => $this->post_type_base, 'with_front' => true ),
			'query_var' => true,
			'supports' => array( 'title' )
		);

		register_post_type( $this->post_type_name, $post_type_args );
	}
	
	public function register_taxonomies(){
		/**
		 * Taxonomy: Instructors.
		 */
		$instructor_labels = array(
			'name' => __( 'Instructors', 'syllabus_manager' ),
			'singular_name' => __( 'Instructor', 'syllabus_manager' ),
		);

		$instructor_args = array(
			'label' => $instructor_labels['name'],
			'labels' => $instructor_labels,
			'public' => true,
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => "{$this->post_type_base}/instructor", 'with_front' => true, ),
			'show_admin_column' => true,
			'show_in_rest' => false,
			'rest_base' => '',
			'show_in_quick_edit' => true,
		);
		register_taxonomy( 'syllabus_instructor', array( $this->post_type_name ), $instructor_args );

		/**
		 * Taxonomy: Departments.
		 */
		$dept_labels = array(
			'name' => __( 'Departments', 'syllabus_manager' ),
			'singular_name' => __( 'Department', 'syllabus_manager' ),
		);

		$dept_args = array(
			'label' => $dept_labels['name'],
			'labels' => $dept_labels,
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => "{$this->post_type_base}/dept", 'with_front' => true, ),
			'show_admin_column' => true,
			'show_in_rest' => false,
			'rest_base' => '',
			'show_in_quick_edit' => true,
		);
		register_taxonomy( 'syllabus_department', array( 'attachment', $this->post_type_name ), $dept_args );

		/**
		 * Taxonomy: Course Levels.
		 */
		$level_labels = array(
			'name' => __( 'Course Levels', 'syllabus_manager' ),
			'singular_name' => __( 'Course Level', 'syllabus_manager' ),
		);

		$level_args = array(
			'label' => $level_labels['name'],
			'labels' => $level_labels,
			'public' => true,
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => "{$this->post_type_base}/level", 'with_front' => true, ),
			'show_admin_column' => true,
			'show_in_rest' => false,
			'rest_base' => '',
			'show_in_quick_edit' => true,
		);
		register_taxonomy( 'syllabus_level', array( 'attachment', $this->post_type_name ), $level_args );

		/**
		 * Taxonomy: Terms
		 */
		$semester_labels = array(
			'name' => __( 'Semesters', 'syllabus_manager' ),
			'singular_name' => __( 'Semester', 'syllabus_manager' ),
		);

		$semester_args = array(
			'label' => $semester_labels['name'],
			'labels' => $semester_labels,
			'public' => true,
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_menu' => false,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => "{$this->post_type_base}/semester", 'with_front' => true, ),
			'show_admin_column' => true,
			'show_in_rest' => false,
			'rest_base' => '',
			'show_in_quick_edit' => true,
		);
		register_taxonomy( 'syllabus_semester', array( $this->post_type_name, 'attachment' ), $semester_args );
	}
}
