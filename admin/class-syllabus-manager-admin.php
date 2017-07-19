<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/admin
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	private $plugin_pages;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		$this->plugin_pages = array(
			'toplevel_page_syllabus-manager',
			'syllabus-manager_page_syllabus-manager-import',
		);
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    0.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Syllabus_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Syllabus_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		// Only add styles to the plugin main pages
		$current_screen = get_current_screen();
		
		if ( in_array( $current_screen->id, $this->plugin_pages ) ){
			wp_enqueue_style( 'bootstrap', plugins_url('includes/bootstrap/css/bootstrap.min.css', dirname(__FILE__) ), array(), $this->version, 'screen' );
			wp_enqueue_style( 'dataTables', plugins_url('includes/dataTables/dataTables.min.css', dirname(__FILE__) ), array(), $this->version, 'screen' );	
		}
				
		wp_enqueue_style( $this->plugin_name, plugins_url('css/syllabus-manager-admin.css', __FILE__ ), array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    0.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Syllabus_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Syllabus_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		// Only add scripts to the plugin main pages
		$current_screen = get_current_screen();
		
		if ( in_array( $current_screen->id, $this->plugin_pages ) ){
			wp_enqueue_script( 'bootstrap', plugins_url('includes/bootstrap/js/bootstrap.min.js', dirname(__FILE__)), array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'dataTables', plugins_url('includes/dataTables/dataTables.min.js', dirname(__FILE__)), array( 'jquery','bootstrap' ), $this->version, true );
		}
		
		wp_enqueue_script( $this->plugin_name, plugins_url('js/syllabus-manager-admin.js', __FILE__), array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name, 'syllabus_manager_data', array(
			'action' => 'syllabus_manager_main',
			'nonce_name' => 'syllabus-manager-main-nonce',
			'nonce_value' => wp_create_nonce( 'syllabus-manager-get-main' ),
		));
	}
	
	/**
	 * Adds Syllabus Manager menu items
	 * 
	 * @since 0.0.0
	 */
	public function add_menu(){
		add_menu_page('Syllabus Manager', 'Syllabus Manager', 'manage_options', 'syllabus-manager', array( $this, 'display_admin_page'), 'dashicons-book-alt');
		add_submenu_page('syllabus-manager', 'Import', 'Import', 'manage_options', 'syllabus-manager-import', array( $this, 'display_import_page'));
		add_submenu_page('syllabus-manager', 'Courses', 'Courses', 'manage_options', 'edit.php?post_type=syllabus_course');
		add_submenu_page('syllabus-manager', 'Departments', 'Departments', 'manage_options', 'edit-tags.php?post_type=syllabus_course&taxonomy=syllabus_department');
		add_submenu_page('syllabus-manager', 'Instructors', 'Instructors', 'manage_options', 'edit-tags.php?post_type=syllabus_course&taxonomy=syllabus_instructor');
		add_submenu_page('syllabus-manager', 'Course Levels', 'Course Levels', 'manage_options', 'edit-tags.php?post_type=syllabus_course&taxonomy=syllabus_level');
		add_submenu_page('syllabus-manager', 'Terms', 'Terms', 'manage_options', 'edit-tags.php?post_type=syllabus_course&taxonomy=syllabus_term');
	}
	
	/**
	 * Moves menu highlight to the Syllabus Manager item
	 * @param  string $parent_file [[Description]]
	 * @return string Parent menu item
	 *                       
	 * @since 0.0.1
	 */
	public function menu_highlight( $parent_file ){ 
		global $post_type;
		
		if ('syllabus_course' == $post_type) { 
			$parent_file = 'syllabus-manager';  
		}
		return $parent_file; 
	} 
	
	/**
	 * Displays the main Syllabus Manager Admin page
	 * 
	 * @since 0.0.0
	 */
	public function display_admin_page(){
		include 'partials/syllabus-manager-admin-display.php';
	}
	
	/**
	 * Displays the main Syllabus Manager Admin page
	 * 
	 * @since 0.0.0
	 */
	public function display_import_page(){
		include 'partials/syllabus-manager-import-display.php';
	}
	
	/**
	 * Gets data for the Schedule of Courses DataTable
	 * 
	 * @since 0.0.1
	 */
	public function get_main_table_data(){
				
		$courses = $this->get_course_data();
		
		foreach ( $courses as $course ){
			echo '<tr>';
			$count = count( $course );
			for ( $i=0; $i<$count; $i++ ){
				echo '<td>' . $course[$i] . '</td>';
			}
			echo '</tr>';
		}
	}
	
	/**
	 * Gets data for the Schedule of Courses DataTable
	 * 
	 * @since 0.0.0
	 */
	public function get_main_table_json_data(){
		// Verify the request to prevent preocessing external requests
		check_ajax_referer( 'syllabus-manager-get-main', 'syllabus-manager-main-nonce' );
		
		echo json_encode( $this->get_course_data() );
		
		wp_die(); // Required to terminate immediately and return a proper response
	}
	
	/**
	 * Requests courses data
	 * 
	 * Fetches data array from transient or refreshes data from external source
	 * 
	 * @return array JSON-decoded data
	 * @since 0.0.0
	 */
	public function get_course_data( $dept = '', $term = '20178', $prog_level = 'UGRD' ){
		// Get the correct transient
		$transient_key = "syllabus_manager_{$term}{$dept}{$prog_level}";
		
		// Get existing copy of transient data, if exists
		$data = get_transient( $transient_key );
		if ( WP_DEBUG || empty($data) ){
			
			$args = array(
				'dept' => $dept,
				'prog-level' => $prog_level, 
				'term' => $term,
			);
			
			if ( false !== ($courses = $this->fetch_courses( $args ) ) ){
				foreach ( $courses as $course ):
					$prefix = $course->code;
					$title = $course->name;

					foreach ( $course->sections as $section ):
						$number = $section->number;
						$dept = $section->deptCode;
						$level = $prog_level;
						$status = '<i>No Syllabus</i>';
						$button = '<button type="button" class="btn btn-default">Add Syllabus</button>';


						// Get and format instructor string
						if ( !empty( $section->instructors ) ){
							$instructors = array();
							foreach ( $section->instructors as $instructor ){
								$instructors[] = $instructor->name;
							}
							$instr_str = implode(", ", $instructors);
						}
						else {
							$instr_str = '<i>No Instructor</i>';
						}

						// Add values to the data array
						$data[] = array(
							$prefix,
							$number,
							$title,
							$instr_str,
							$dept,
							$term,
							$level,
							$status,
							$button
						);
				
					endforeach;
				endforeach;
				
				// Seve the updated data
				set_transient( $transient_key, $data, 24 * HOUR_IN_SECONDS );
			}
		}
		return $data;
	}
	
	/**
	 * Get course array from external source
	 * 
	 * @param  string $dept       
	 * @param  string $term       
	 * @param  string $prog_level 
	 * @return array|false JSON array of course objects
	 *                              
	 * @since 0.0.1
	 */
	public function fetch_courses( $query_args = array() ){
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
		if ( WP_DEBUG ) { error_log( 'request_url: ' . $request_url ); }
								  
		$response = wp_remote_get( $request_url );
		
		// Valid response
		if ( ! is_wp_error($response) && is_array($response) ){
			$headers = $response['headers'];
			$body = $response['body'];
			$response_data = json_decode($body);
			
			return $response_data[0]->COURSES;
		}
		return false;
	}
	
	public function import_init(){
		if ( empty($_POST) || empty($_FILES) ){
			return;
		}
		
		// Test whether the request includes a valid nonce
		check_admin_referer('syllabus-manager-import', 'wpnonce_syllabus_manager_import');
		
		$filter_name = sanitize_text_field( $_POST['import-name'] );
		$uploaded_file = $_FILES['import-filter-file'];
		
		/** Include admin functions to get access to wp_handle_upload() */
    	require_once ABSPATH . 'wp-admin/includes/admin.php';
		
		$file = wp_handle_upload( $uploaded_file, array('test_form' => false,'mimes' => array('json' => 'application/json')));
		
		if ( isset($file['error']) ){
			return new WP_Error( 'import_filter_upload_error', __( 'File upload error.' ), array( 'status' => 400 ) );
		}
		
		/**
		 * Save the uploaded file to the media library temporarily
		 */
		$file_args = array(
			'post_title' => sanitize_file_name($file['file']),
			'post_content' => $file['url'],
			'post_mime_type' => $file['type'],
			'guid' => $file['url'],
			'context' => 'import',
			'post_status' => 'private'
		);
		$file_id = wp_insert_attachment( $file_args, $file['file'] );
		
		// Process the selected array and insert terms
		if ( false !== ( $json = file_get_contents( $file['file'] ) ) ){
			$filter_data = json_decode( $json );
			$filter_data = $filter_data->{$filter_name};
			
			$taxonomies = array(
				'terms' => 'syllabus_term',
				'departments' => 'syllabus_department',
				'progLevels' => 'syllabus_level',
			);
			
			foreach ( $filter_data as $data ){
				$slug = $data->CODE;
				$term = $desc = $data->DESC;
				
				// Change Department names to title case
				if ( 'departments' == $filter_name ){
					$ugly_terms = explode( '-', $term );
					$pretty_terms = array();
					foreach( $ugly_terms as $ugly_title ){
						//$pretty_terms[] = ucwords(strtolower(trim($ugly_title)), " -\t\r\n\f\v/");
						$pretty_terms[] = ucwords(strtolower(trim($ugly_title)));
					}
					$term = implode('-', $pretty_terms);
					$term = str_replace('Languages Lit/culture', 'Languages, Literatures, & Cultures', $term);
				}
				
				wp_insert_term( $term, $taxonomies[$filter_name], array('slug' => $slug, 'description' => $desc ));
			}
		}
		
		// Clean up files
		wp_delete_attachment( $file_id );
	}
}
