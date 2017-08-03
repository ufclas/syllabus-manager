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
			'sections' => array(),
		);
		$args = array_merge( $defaults, $section_args );
		
		$this->course_id 	= $args['course_id'];
		$this->course_code 	= $args['course_code'];
		$this->course_title = $args['course_title'];
		$this->sections 	= $args['sections'];
		$this->semester		= $args['semester'];
	}
	
	/**
	 * Get courses from the semester's stored tables
	 * 
	 * @param  string [$semester = '20178']       [[Description]]
	 * @param  string [$department = '011690003'] [[Description]]
	 * @param  string [$level = 'ugrd']           [[Description]]
	 * @return array Syllabus_Manager_Course objects
	 */
	public static function get_courses( $semester = '20178', $department = '011690003', $level = 'ugrd' ){
		
		global $wpdb;
		
		$courses = array();
		
		/**
		 * Query
		 * 
		 * @todo Update repo with new query string
		 */
		$query = "SELECT
			A.id AS section_id,
			A.number AS section_code,
			A.course_id,
			B.code AS course_code,
			B.name AS course_title,
			GROUP_CONCAT( D.name SEPARATOR ';') AS instructor_list,
			A.dept_id,
			E.deptcode, 
			E.deptname,
			A.semester_id,
			F.semester AS semester_code,
			G.post_id,
			'Fall 2017' AS semester
		 FROM
			sy_soc_sections AS A 
			LEFT JOIN sy_soc_courses AS B ON A.course_id = B.id
			LEFT JOIN sy_soc_sections_instructors AS C ON A.id = C.section_id
			LEFT JOIN sy_soc_instructors AS D ON C.instructor_id = D.id
			LEFT JOIN sy_soc_departments AS E ON A.dept_id = E.id
			LEFT JOIN sy_soc_semesters AS F ON A.semester_id = F.id
			LEFT JOIN sy_soc_sections_posts AS G ON A.id = G.section_id
		 WHERE 
			A.dept_id >= 1 AND
			A.semester_id = 1 AND
			SUBSTR(B.code,4,4) < 5000
		 GROUP BY
		A.id";
		
		/**
		 * Query list of courses
		 * 
		 * @todo Determine if this needs to be an array or objects
		 * @todo Pass in the semester name as a parameter in query, use prepare
		 */
		$results = $wpdb->get_results( $query );
		
		if ( WP_DEBUG ){ 
			error_log( 'Getting sections from tables...' );
			// error_log( print_r( $courses, true ) );
		}
		
		if ( is_null( $results ) ){
			return false;
		}

		$tax_queries =  array(
			'taxonomy' 	=> 'syllabus_semester',
			'field' 	=> 'slug',
			'terms' 	=> $semester
		);

		if ( !empty($department) ){
			$tax_queries[] = array(
				'taxonomy' => 'syllabus_department',
				'field' => 'slug',
				'terms' => $department
			);
		}

		if ( !empty($level) ){
			$tax_queries[] = array(
				'taxonomy' => 'syllabus_level',
				'field' => 'slug',
				'terms' => $level
			);
		}

		foreach ( $results as $section ):

			//error_log( print_r( $section->instructor_list, true ) );

			$syllabus_section = new Syllabus_Manager_Section( array( 
				'section_id' => $section->section_id,
				'section_code' => $section->section_code,
				'course_id' => $section->course_id,
				'course_code' => $section->course_code,
				'course_title' => $section->course_title,
				'instructors' => $section->instructor_list,
				'department' => $section->deptcode,
				'semester_code' => $section->semester_code,
				'post_id' => $section->post_id,
			));

			// Add course objects to the array indexed by course_id
			if ( !isset( $courses[$syllabus_section->course_id] ) ){
				$courses[$syllabus_section->course_id] = new Syllabus_Manager_Course(
					array(
						'course_id' => $syllabus_section->course_id,
						'course_code' => $syllabus_section->course_code,
						'course_title' => $syllabus_section->course_title,
						'semester' => $semester,
						'sections' => array(),
					)
				);
			}

			$courses[$syllabus_section->course_id]->sections[] = $syllabus_section;

		endforeach;
		
		error_log( print_r( $courses, true ) );
		return $courses;
	}
}