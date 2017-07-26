<?php

class Syllabus_Manager_Section {
	
	/**
	 * Course prefix and number
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $course_code
	 */
	public $course_code;
	
	/**
	 * Course title
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $course_title
	 */
	public $course_title;
	
	/**
	 * Section number
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $number
	 */
	public $number;
	
	/**
	 * Unique identifier for the section in the courses table
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $section_key
	 */
	public $section_key;
	
	/**
	 * Semester slugs from syllabus_semester taxonomy, comma-separated list
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $semester
	 */
	public $semester;
	
	/**
	 * Department slugs from syllabus_department taxonomy
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      array    $dept_terms
	 */
	public $department;
	
	/**
	 * Course level slug from syllabus_level taxonomy
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $level
	 */
	public $level;
	
	/**
	 * Instructor names for syllabus_instructor taxonomy
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      array    $instructors
	 */
	public $instructors;
	
	/** 
	 * Define a course section from $_POST or DB data
	 *
	 * @since    0.0.0
	 */
	public function __construct( $course_code, $course_title, $number, $semester, $department = array(), $level = '', $instructors = array() ) {
		$this->course_code 	= $course_code;
		$this->course_title = $course_title;
		$this->number 		= $number;
		$this->semester 	= $semester;
		$this->department 	= $this->set_department( $department );
		$this->level 		= $level;
		$this->instructors 	= $this->set_instructors( $instructors );
		$this->section_key 	= $this->set_section_key();
	}
	
	/** 
	 * Use the 
	 *
	 * @since    0.0.0
	 */
	public function set_section_key(){
		$parts = array( $this->semester, $this->course_code, $this->number );
		return strtoupper( implode('-', $parts ));
	}
	
	public function set_department( $dept = array() ){
		return ( !is_array($dept) )? explode(',', $dept) : $dept;
	}
	
	public function set_instructors( $instructors ){
		foreach ( $instructors as $index => $instructor ){
			if ( is_object( $instructor ) ){
				// If the array data is coming from the API, change to Firstname Lastname
				$instructors[$index] = preg_replace("/(.+),\s?(\S+)(.*)/", "$2 $1", $instructor->name);
			}
		}
		return $instructors;
	}
	
	public function get_post_department(){
		return $this->get_post_terms( $this->department, 'syllabus_department');
	}
		
	public function get_post_terms( $term_slugs, $taxonomy ){
		$term_ids = array();
		foreach ( $term_slugs as $slug ){
			$term = get_term_by( 'slug', $slug, $taxonomy );
			if ( !is_wp_error( $term ) && !empty( $term ) ){
				$term_ids[] = $term->term_id;
			}
		}
		return $term_ids;
	}
	
	public function get_post_title(){
		return wp_strip_all_tags( "{$this->course_code} {$this->number} {$this->course_title}" );
	}
	
	public function get_post_args(){
		
		// Format values for wp_insert_post
		$post_title = $this->get_post_title();
		$post_department = $this->get_post_department();
		$post_instructors = join( ', ', $this->instructors );
		$post_author = get_current_user_id();
		$post_type = 'syllabus_course';
		$post_status = 'publish';
		
		return array(
			'post_title' => $post_title,
			'post_name' => $this->section_key,
			'post_content' => '',
			'post_status' => $post_status,
			'post_author' => $post_author,
			'post_type' => $post_type,
			'tax_input' => array(
				'syllabus_department' => $post_department,
				'syllabus_level' => $this->level,
				'syllabus_semester' => $this->semester,
				'syllabus_instructor' => $post_instructors
			),
			'meta_input' => array(
				'sm_section_key' => $this->section_key
			)
		);
	}
}