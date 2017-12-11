<?php
/**
 * Adds custom post types and taxonomies
 *
 * Adds Courses post type and Taxonomies for departments, semesters, and instructors
 *
 * @since      0.0.1
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Post_Type {
	
	/**
	 * Post type name
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $post_type_name
	 */
	private $post_type_name;
	
	/**
	 * Base used in URLs and REST API for the post type
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      string    $post_type_base
	 */
	private $post_type_base;
	
	/**
	 * Custom taxonomies used for the custom post type
	 *
	 * @since    0.0.1
	 * @access   private
	 * @var      array    $taxonomies
	 */
	private $taxonomies;
	
	/** 
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.1
	 */
	public function __construct() {
		$this->post_type_name = 'syllabus_course';
		$this->post_type_base = 'courses';
		$this->taxonomies = array( 'syllabus_instructor', 'syllabus_department', 'syllabus_level', 'syllabus_semester' );
	}
	
	
	/**
	 * Registers the post type
	 * 
	 * @since 0.0.1
	 */
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
			'show_in_menu' => true,
			'exclude_from_search' => false,
			'capability_type' => 'syllabus_course',
			'capabilities' => array(
				'delete_others_posts' => 'sm_delete_others_syllabus_courses',
				'delete_posts' => 'sm_delete_syllabus_courses',
				'edit_others_posts' => 'sm_edit_others_syllabus_courses',
				'edit_posts' => 'sm_edit_syllabus_courses',
				'publish_posts' => 'sm_publish_syllabus_courses',
				'read_private_posts' => 'sm_read_private_syllabus_courses',
				'edit_post' => 'sm_edit_syllabus_course',
				'delete_post' => 'sm_delete_syllabus_course',
				'read_post' => 'sm_read_syllabus_course',
			),
			'hierarchical' => true,
			'rewrite' => array( 'slug' => $this->post_type_base, 'with_front' => true ),
			'query_var' => true,
			'supports' => array( 'title', 'editor', 'page-attributes' )
		);

		register_post_type( $this->post_type_name, $post_type_args );
	}
	
	/**
	 * Registers the taxonomies for the post type
	 * 
	 * Departments, Instructors, Semesters, Course Levels
	 * 
	 * @since 0.0.1
	 */
	public function register_taxonomies(){
		/**
		 * Taxonomy: Instructors.
		 */
		$taxonomy_name = 'syllabus_instructor';
		$taxonomy_base = 'instructors';
		$labels = array(
			'name' => __( 'Instructors', 'syllabus_manager' ),
			'singular_name' => __( 'Instructor', 'syllabus_manager' ),
		);
		$args = array(
			'label' => $labels['name'],
			'labels' => $labels,
			'public' => true,
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $taxonomy_base ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => $taxonomy_base,
			'show_in_quick_edit' => true,
			'capabilities' => array(
				'manage_terms' 	=> 'sm_manage_' . $taxonomy_name,
				'edit_terms' 	=> 'sm_edit_' . $taxonomy_name,
				'delete_terms' 	=> 'sm_delete_' . $taxonomy_name,
				'assign_terms' 	=> 'sm_assign_' . $taxonomy_name,
			)
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name ), $args );

		/**
		 * Taxonomy: Departments.
		 */
		$taxonomy_name = 'syllabus_department';
		$taxonomy_base = 'departments';
		$taxonomy_caps = array (
		  'manage_terms' => 'sm_manage_' . $taxonomy_name,
		  'edit_terms' => 'sm_edit_' . $taxonomy_name,
		  'delete_terms' => 'sm_delete_' . $taxonomy_name,
		  'assign_terms' => 'sm_assign_' . $taxonomy_name,
		);
		$labels = array(
			'name' => __( 'Departments', 'syllabus_manager' ),
			'singular_name' => __( 'Department', 'syllabus_manager' ),
		);
		$args = array(
			'label' => $labels['name'],
			'labels' => $labels,
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $taxonomy_base ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => $taxonomy_base,
			'show_in_quick_edit' => true,
			'capabilities' => array(
				'manage_terms' 	=> 'sm_manage_' . $taxonomy_name,
				'edit_terms' 	=> 'sm_edit_' . $taxonomy_name,
				'delete_terms' 	=> 'sm_delete_' . $taxonomy_name,
				'assign_terms' 	=> 'sm_assign_' . $taxonomy_name,
			)
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name, 'attachment', 'user' ), $args );

		/**
		 * Taxonomy: Program Levels.
		 */
		$taxonomy_name = 'syllabus_level';
		$taxonomy_base = 'program-levels';
		
		$labels = array(
			'name' => __( 'Program Levels', 'syllabus_manager' ),
			'singular_name' => __( 'Program Level', 'syllabus_manager' ),
		);
		$args = array(
			'label' => $labels['name'],
			'labels' => $labels,
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $taxonomy_base ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => $taxonomy_base,
			'show_in_quick_edit' => true,
			'capabilities' => array(
				'manage_terms' 	=> 'sm_manage_' . $taxonomy_name,
				'edit_terms' 	=> 'sm_edit_' . $taxonomy_name,
				'delete_terms' 	=> 'sm_delete_' . $taxonomy_name,
				'assign_terms' 	=> 'sm_assign_' . $taxonomy_name,
			)
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name, 'attachment' ), $args );
		
		/**
		 * Taxonomy: Semester
		 */
		$taxonomy_name = 'syllabus_semester';
		$taxonomy_base = 'semesters';
		$labels = array(
			'name' => __( 'Semesters', 'syllabus_manager' ),
			'singular_name' => __( 'Semester', 'syllabus_manager' ),
		);
		$args = array(
			'label' => $labels['name'],
			'labels' => $labels,
			'public' => true,
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_menu' => true,
			'show_in_nav_menus' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => $taxonomy_base ),
			'show_admin_column' => true,
			'show_in_rest' => true,
			'rest_base' => $taxonomy_base,
			'show_in_quick_edit' => true,
			'capabilities' => array(
				'manage_terms' 	=> 'sm_manage_' . $taxonomy_name,
				'edit_terms' 	=> 'sm_edit_' . $taxonomy_name,
				'delete_terms' 	=> 'sm_delete_' . $taxonomy_name,
				'assign_terms' 	=> 'sm_assign_' . $taxonomy_name,
			)
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name, 'attachment' ), $args );
	}
}
