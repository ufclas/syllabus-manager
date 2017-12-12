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
	 * Department term IDs
	 *
	 * @since    0.4.1
	 * @access   public
	 * @var      array    $departments
	 */
	public $departments;
	
	/**
	 * Instructor terms
	 *
	 * @since    0.4.1
	 * @access   public
	 * @var      array    $departments
	 */
	public $instructors;
	
	
	/** 
	 * Define a course section from $_POST or DB data
	 *
	 * @since    0.0.0
	 */
	public function __construct( $args = array() ) {
		$defaults = array(
			'course_id' => '',
			'import_code' => '',
			'code' => '',
			'name' => '',
			'sections' => array(),
			'semester_code' => '',
			'departments' => array(),
			'instructors' => array(),
		);
		$args = array_merge( $defaults, $args );
		
		$this->course_code 	= $args['code'];
		$this->departments = $args['departments'];
		$this->set_course_title( $args['name'] );
		$this->set_import_code( $args['semester_code'] );
        
        if ( !empty($args['sections']) ){
            foreach ( $args['sections'] as $section_args ){
                $section_args['course_code'] = $this->import_code;
				$section = new Syllabus_Manager_Course_Section( $section_args );
				
				// Add section instructors to the course instructors list
				if ( is_array($this->instructors) && is_array($section->instructors) ){
					array_push( $this->instructors, $section->instructors );	
				}
				
				// Add section
				$this->sections[] = $section;
            }
        }
	}
	
	/**
	 * Adds semester code to the end of course code to form a unique id
	 * 
	 * @param string $semester_code
	 * @since 0.4.1
	 */
	public function set_import_code( $semester_code ){
		$this->import_code = $this->course_code;
		
		if ( !empty( $semester_code ) ){
			$this->import_code .= '-' . $semester_code;
		}
	}
	
	/**
	 * Set course title to course_code course_name
	 * 
	 * @param string $title
	 * @since 0.4.1
	 */
	public function set_course_title( $title ){
		$this->course_title = wp_strip_all_tags( "{$this->course_code} {$title}" );
	}
	
	/**
	 * Get arguments that can be used for insert/update course posts
	 * 
	 * @param int $semester
	 * @param int $department
	 * @param int $level
	 * @return array Array with import code as the key and post args as value
	 * @since 0.4.1
	 */
	public function get_post_args( $semester, $department, $level ){
		
		$post_author = get_current_user_id();
		$post_type = 'syllabus_course';
		$post_status = 'publish';
		$post_id = ( !empty($this->post_id) )? $this->post_id : null;
		
		// Merge section instructors into a single array
		$post_instructors = array();
		foreach( $this->sections as $section ){
			$post_instructors = array_merge( $post_instructors, $section->instructors );
		}
		
		$args = array(
			'ID' => $post_id,
			'post_title' => $this->course_title,
			'post_name' => $this->import_code,
			'post_content' => '',
			'post_status' => $post_status,
			'post_author' => $post_author,
			'post_type' => $post_type,
			'tax_input' => array(
				'syllabus_department' => $department,
				'syllabus_level' => $level,
				'syllabus_semester' => $semester,
				'syllabus_instructor' => join( ', ', $post_instructors)
			),
			'meta_input' => array(
				'sm_import_code' => $this->import_code,
				'sm_import_date' => current_time('mysql'),
				'sm_sections' => json_encode($this->sections),
			)
		);
		
		//error_log('$args: ' . print_r($args, true));
		return $args;
	}
	
	/**
	 * Get terms from the UF SOC API, used to import taxonomies
	 * 
	 * @param  string $taxonomy Taxonomomy for new/existing terms
	 * @return array|WP_Error Term data as an associative array or error
	 */
	public static function get_courses_from_api( $semester_id, $department_id, $level_id ){
				
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
			if ( WP_DEBUG ){ error_log( '$response_data:' . print_r($response_data, true) ); }
			return new WP_Error('import_invalid_format', __("Error: API format not valid.", 'syllabus-manager'));
		}
		
		$response_data = $response_data[0]['COURSES'];
        //error_log('$response_data: ' . print_r($response_data, true));
		
		$courses = array();
		
		foreach ( $response_data as $course_args ):
			// Add semester import code to the args
			$course_args['semester_code'] = $request_args['term'];
			error_log('$course_args: ' . print_r($course_args, true));
		
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
		
		if ( WP_DEBUG ){ error_log( '$request_url: ' . $request_url ); }
		
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

/**
 * Class for course sections
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.4.1
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/admin
 */
class Syllabus_Manager_Course_Section {
    public $import_code;
    public $section_number;
    public $section_display;
    public $dept_code;
    public $dept_name;
    public $instructors;
    
    public function __construct( $args ){
    	$defaults = array(
			'import_code' => '',
			'section_number' => '',
			'section_display' => '',
			'dept_code' => '',
			'dept_name' => '',
			'instructors' => array(),
			'course_code' => '',
		);
		$args = array_merge( $defaults, $args );
		
		$this->section_number = $args['number'];
        $this->section_display = $args['display'];
        $this->dept_code = $args['deptCode'];
        $this->dept_name = $args['deptName'];
        
		$this->set_import_code( $args['course_code'] );
        $this->set_instructors( $args['instructors'] );
    }
	
	/**
	 * Creates a unique section code using the course import code and section number
	 * 
	 * @param string $course_code
	 * @since 0.4.1
	 */
	public function set_import_code( $course_code ){
		$this->import_code = $this->section_number;
		
		if ( !empty($course_code) ){
			$this->import_code = $course_code . '-' . $this->import_code;
		}
	}
    
    /**
     * Formats instructor array from api
     * 
     * @param  array $instructors
	 8 @since 0.4.0
     */
    public function set_instructors( $instructors ){
        if ( empty($instructors) ){
            $this->instructors = array();
        }
        
        $instructor_names = array();
        foreach ( $instructors as $instructor ){
            $name = $instructor['name'];

            // Change to firstname lastname format, ignore middle name
            if ( false !== strpos( $name, ',' ) ){
                $name = preg_replace("/(.*),\s?(\S*)(.*)/", "$2 $1", $name);
            }
            
            $instructor_names[] = $name;
        }
        $this->instructors = $instructor_names;
    }
}