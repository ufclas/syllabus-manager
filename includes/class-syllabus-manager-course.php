<?php
/**
 * Class for interacting with course data from data tables
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.1.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/admin
 */

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
	 * Unique identifier for the course post type
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $course_id
	 */
	public $course_id;
	
	/**
	 * Unique identifier for the course in external source
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $import_code
	 */
	public $import_code;
	
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
	 * Course prefix and number
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $semester_code
	 */
	public $semester_code;
	
	/** 
	 * Define a course section from $_POST or DB data
	 *
	 * @since    0.0.0
	 */
	public function __construct( $course_args = array() ) {
		$defaults = array(
			'course_id' => null,
			'import_code' => null,
			'code' => null,
			'name' => null,
			'semester_code' => null,
			'sections' => array(),
		);
		$args = array_merge( $defaults, $course_args );
		
		$this->course_code 	= $args['code'];
		$this->import_code 	= $args['code'];
		$this->course_title = $args['name'];
	}
	
	/**
	 * Get arguments that can be used for insert/update course posts
	 * 
	 * @return array Array with import code as the key and post args as value
	 * @since 0.4.0
	 */
	public function get_post_args(){
		return array( $this->import_code => array(
			'name' => $this->course_title, 
			'slug' => $this->import_code
		));
	}
	
	/**
	 * Get terms from the UF SOC API, used to import taxonomies
	 * 
	 * @param  string $taxonomy Taxonomomy for new/existing terms
	 * @return array|WP_Error Term data as an associative array or error
	 */
	public static function get_courses_from_api( $semester_id, $department_id, $level_id ){
		$courses = array();
		
		$request_args = array(
			'term' => get_term_meta( $semester_id, 'sm_import_code', true ),
			'dept' => get_term_meta( $department_id, 'sm_import_code', true ),
			'prog-level' => get_term_meta( $level_id, 'sm_import_code', true ),
		);
		
		$response = self::request_courses( $request_args );
		//error_log('$response: ' . print_r($response, true));
		
		if ( is_wp_error($response) ){
			return $response;
		}
		
		// Get JSON objects as array
		$json = ( isset($response['body']) )? $response['body'] : null;
		$response_data = json_decode( $json, true );
		
		// Test valid response
		if ( empty($response_data) ){
			return new WP_Error('import_no_data', __("Error: API response data not found.", 'syllabus-manager'));
		}
		if ( !isset($response_data[0]['COURSES']) ){
			return new WP_Error('import_invalid_format', __("Error: API format not valid.", 'syllabus-manager'));
		}
		
		$response_data = $response_data[0]['COURSES'];
				
		foreach ( $response_data as $course_args ):
			// Add semester import code to the args
			$course_args['semester'] = $request_args['term'];
		
			// Process course arguments
			$course = new Syllabus_Manager_Course( $course_args );
			
			// Add data to be used for inserting/updating course post
			$courses = array_merge( $courses, array( $course->import_code => $course ) );
		endforeach;

		return $courses;
	}

	
	/**
	 * Get course array from external source
	 * 
	 * @param  array $query_args Query to get data from external source
	 * @return array|WP_Error JSON array of course objects
	 *                              
	 * @since 0.0.1
	 */
	public static function request_courses( $query_args = array() ){
		$defaults = array(
			'category' => 'RES',
			'course-code' => '',
			'course-title' => '',
			'cred-srch' => '',
			'credits' => '',
			'day-f' => '',
			'day-m' => '',
			'day-r' => '',
			'day-s' => '',
			'day-t' => '',
			'day-w' => '',
			'days' => 'false',
			'dept' => '',
			'eep' => '',
			'fitsSchedule' => 'false',
			'ge' => '',
			'ge-b' => '',
			'ge-c' => '',
			'ge-h' => '',
			'ge-m' => '',
			'ge-n' => '',
			'ge-p' => '',
			'ge-s' => '',
			'instructor' => '',
			'last-row' => '0',
			'level-max' => '--',
			'level-min' => '--',
			'no-open-seats' => 'false',
			'online-a' => '',
			'online-c' => '',
			'online-h' => '',
			'online-p' => '',
			'online-b' => '',
			'online-e' => '',
			'prog-level' => '', 
			'term' => '',
			'var-cred' => 'true',
			'writing' => '',
		);
		$args = array_merge($defaults, $query_args);
		
		// Get external data
		$api_url = 'https://one.uf.edu/apix/soc/schedule/?';
		$request_url = $api_url . http_build_query( $args );
		$response = wp_remote_get( $request_url );
		
		if ( empty($response) ){
			return new WP_Error('import_request_error', __("Error: API response data not found.", 'syllabus-manager'));
		}
		
		return $response;
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
			'Fall 2017' AS semester
		 FROM
			sy_soc_sections AS A 
			LEFT JOIN sy_soc_courses AS B ON A.course_id = B.id
			LEFT JOIN sy_soc_sections_instructors AS C ON A.id = C.section_id
			LEFT JOIN sy_soc_instructors AS D ON C.instructor_id = D.id
			LEFT JOIN sy_soc_departments AS E ON A.dept_id = E.id
			LEFT JOIN sy_soc_semesters AS F ON A.semester_id = F.id
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
				'post_id' => '',
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
		
		if ( WP_DEBUG ){ 
			//error_log( print_r( $courses, true ) ); 
		}
		return $courses;
	}
}