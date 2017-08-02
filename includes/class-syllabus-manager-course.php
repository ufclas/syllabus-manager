<?php
/**
 * Class for interacting with section data from data tables
 *
 * @since      0.1.0
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Course {
	
	/**
	 * Unique identifier for the course in the courses table
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $course_id
	 */
	public $course_id;
	
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
	 * @var      array    Syllabus_Manager_Section
	 */
	public $sections;
	
	/**
	 * Semester slugs from syllabus_semester taxonomy, comma-separated list
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $semester
	 */
	public $semester;
	
	/** 
	 * Define a course section from $_POST or DB data
	 *
	 * @since    0.0.0
	 */
	public function __construct( $section_args = array() ) {
		$defaults = array(
			'course_id' => null,
			'course_code' => null,
			'course_title' => null,
			'semester' => null,
		);
		$args = array_merge( $defaults, $section_args );
		
		$this->course_id 	= $args['course_id'];
		$this->course_code 	= $args['course_code'];
		$this->course_title = $args['course_title'];
		$this->sections 	= $args['sections'];
		$this->semester		= $args['semester'];
	}
}