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
	}
	
	
	/**
	 * Registers the post type
	 * 
	 * @since 0.0.1
	 * @param [[Type]] $label_name          [[Description]]
	 * @param [[Type]] $label_name_singular [[Description]]
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
			'capability_type' => 'page',
			'map_meta_cap' => true,
			'hierarchical' => true,
			'rewrite' => array( 'slug' => $this->post_type_base, 'with_front' => true ),
			'query_var' => true,
			'supports' => array( 'title', 'page-attributes' )
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
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name ), $args );

		/**
		 * Taxonomy: Departments.
		 */
		$taxonomy_name = 'syllabus_department';
		$taxonomy_base = 'departments';
		
		$labels = array(
			'name' => __( 'Departments', 'syllabus_manager' ),
			'singular_name' => __( 'Department', 'syllabus_manager' ),
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
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name ), $args );

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
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name ), $args );
		
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
		);
		register_taxonomy( $taxonomy_name, array( $this->post_type_name ), $args );
	}
}
