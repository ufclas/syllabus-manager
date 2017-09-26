<?php
/**
 * Class for interacting with section data from data tables
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
class Syllabus_Manager_Section {
	
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
	 * @var      string    $section_code
	 */
	public $section_code;
	
	/**
	 * Unique identifier for the section in the sections table
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $section_id
	 */
	public $section_id;
	
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
	 * Instructor names for syllabus_instructor taxonomy
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      array    $instructors
	 */
	public $instructors;
	
	/**
	 * Unique identifier for the syllabus_course post
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $post_id
	 */
	public $post_id;
	
	/** 
	 * Define a course section from $_POST or DB data
	 *
	 * @param array $section_args
	 * @since    0.0.0
	 */
	public function __construct( $section_args = array() ) {
		$defaults = array(
			'section_id' => null,
			'section_code' => null,
			'course_id' => null,
			'course_code' => null,
			'course_title' => null,
			'instructors' => null,
			'dept_id' => null,
			'deptcode' => null,
			'deptname' => null,
			'semester_id' => null,
			'semester_code' => null,
			'post_id' => null,
		);
		$args = array_merge( $defaults, $section_args );
		
		$this->course_id 	 = $args['course_id'];
		$this->course_code 	 = $args['course_code'];
		$this->course_title  = $args['course_title'];
		$this->section_code	 = $args['section_code'];
		$this->semester_code = $args['semester_code'];
		$this->department 	 = $this->set_department( $args['deptcode'] );
		$this->instructors 	 = $this->set_instructors( $args['instructors'] );
		$this->section_id 	 = $args['section_id'];
		$this->post_id 		 = $args['post_id'];
	}
	
	/** 
	 * Set section department
	 *
	 * @param string|array $department_list
	 * @return array Department codes
	 * @since 0.0.0
	 */
	public function set_department( $department_list = array() ){
		
		// Convert to an array if this list is a string with semicolor delimiter
		return ( !is_array($department_list) )? explode(',', $department_list) : $department_list;
	}
	
	/** 
	 * Set section instructors
	 *
	 * @param string|array $instructor_list
	 * @return array Instructor names
	 * @since 0.0.0
	 */
	public function set_instructors( $instructor_list = array() ){
		
		// Convert to an array if this list is a string with semicolor delimiter
		$instructors = ( is_array($instructor_list) )? $instructor_list : explode(';', $instructor_list);
		
		// Format instructor name to change firstname lastname order
		foreach ( $instructors as $index => $instructor ){
			$instructors[$index] = preg_replace("/(.+),\s?(\S+)(.*)/", "$2 $1", $instructor);
		}
		return $instructors;
	}
	
	/** 
	 * Get department terms matching the department code
	 * 
	 * @return array Department terms
	 * @since 0.0.0
	 */
	public function get_post_department(){
		return $this->get_post_terms( $this->department, 'syllabus_department');
	}
	
	/**
	 * Converts an array of term slugs for a taxonomy to an array of term IDs
	 * 
	 * @param  array $term_slugs 
	 * @param  string $taxonomy   
	 * @return array Term ids
	 */
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
	
	/**
	 * Return a course title including course_code and section_code
	 * 
	 * @return string
	 * @since 0.1.0
	 */
	public function get_post_title(){
		//return wp_strip_all_tags( "{$this->course_code} {$this->section_code} {$this->course_title}" );
		return wp_strip_all_tags( "{$this->course_code} {$this->course_title}" );
	}
	
	/**
	 * Get arguments used to insert add a syllabus_course post
	 * 
	 * @param  string [$prog_level = '']
	 * @return array
	 * @since 0.1.0
	 */
	public function get_post_args( $prog_level = '' ){
		
		// Format values for wp_insert_post
		$post_title = $this->get_post_title();
		$post_department = $this->get_post_department();
		//$post_instructors = join( ', ', $this->instructors );
		$post_instructors = '';
		$post_author = get_current_user_id();
		$post_type = 'syllabus_course';
		$post_status = 'publish';
		$post_id = ( !empty($this->post_id) )? $this->post_id : null;
		
		return array(
			'ID' => $post_id,
			'post_title' => $post_title,
			'post_name' => $this->section_id,
			'post_content' => '',
			'post_status' => $post_status,
			'post_author' => $post_author,
			'post_type' => $post_type,
			'tax_input' => array(
				'syllabus_department' => $post_department,
				'syllabus_level' => $prog_level,
				'syllabus_semester' => $this->semester_code,
				'syllabus_instructor' => $post_instructors
			),
			'meta_input' => array(
				'sm_section_id' => $this->section_id,
				'sm_course_id' => $this->course_id,
			)
		);
	}
}