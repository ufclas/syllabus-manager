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
	 * @var      string    $plugin_name
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.0.0
	 * @access   private
	 * @var      string    $version
	 */
	private $version;
	
	/**
	 * Names of plugin's admin dashboard pages
	 *
	 * @since    0.0.0
	 * @access   private
	 * @var      string    $plugin_pages
	 */
	private $plugin_pages;
	
	/**
	 * Message to display in admin notices
	 *
	 * @since    0.4.0
	 * @access   private
	 * @var      WP_Error|string    $admin_notice
	 */
	private $admin_notice;
	
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
	 * @param string $hook The current admin page.
	 * @since 0.0.0
	 */
	public function enqueue_styles( $hook ) {

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
		if ( in_array( $hook, $this->plugin_pages ) ){
			wp_enqueue_style( 'bootstrap', plugins_url('includes/bootstrap/css/bootstrap.min.css', dirname(__FILE__) ), array(), $this->version, 'screen' );
            wp_enqueue_style( $this->plugin_name, plugins_url('css/syllabus-manager-admin.css', __FILE__ ), array(), $this->version, 'all' );
        }
	}

	/**
	 * Register the JavaScript for the admin area.
	 * 
	 * @param string $hook The current admin page.
	 * @since    0.0.0
	 */
	public function enqueue_scripts( $hook ) {

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
		if ( 'toplevel_page_syllabus-manager' == $hook ){
			
			// Bootstrap
			wp_enqueue_script( 'bootstrap', plugins_url('includes/bootstrap/js/bootstrap.min.js', dirname(__FILE__)), array( 'jquery' ), $this->version, true );
			
            // VueJS
			//$js_version = (WP_DEBUG)? 'vue.js' : 'vue.min.js';
            //wp_enqueue_script( 'vue-js', plugins_url('includes/vue/' . $js_version, dirname(__FILE__)), array(), null, true);
            
			// Add custom script
			/*
			wp_enqueue_script( $this->plugin_name, plugins_url('js/syllabus-manager-admin.js', __FILE__), array( 'vue-js' ), $this->version, true );
			wp_localize_script( $this->plugin_name, 'syllabus_manager_data', array(
				'panel_title' => __('Courses', 'syllabus_manager'),
				'courses' => Syllabus_Manager_Course::get_courses(),
                'ajax_nonce' => wp_create_nonce('syllabus-manager-add-syllabus')
			));
			*/
		}
		
		if ( 'syllabus-manager_page_syllabus-manager-import' == $hook ){
			wp_enqueue_script( 'bootstrap', plugins_url('includes/bootstrap/js/bootstrap.min.js', dirname(__FILE__)), array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'syllabus-manager-import', plugins_url('js/syllabus-manager-admin-import.js', __FILE__), array( 'jquery' ), $this->version, true );
			//wp_enqueue_script( 'vue-js', plugins_url('includes/vue/vue.min.js', dirname(__FILE__)), array(), null, true);
			//wp_enqueue_script( 'vue-import', plugins_url('js/syllabus-manager-admin-import.js', __FILE__), array( 'vue-js' ), $this->version, true );
		}
	}
	
	/**
	 * Adds Syllabus Manager menu items
	 * 
	 * @since 0.0.0
	 */
	public function add_menu(){
		add_menu_page('Syllabus Manager', 'Syllabus Manager', 'sm_manage_syllabus_manager', 'syllabus-manager', array( $this, 'display_admin_page'), 'dashicons-book-alt');
		add_submenu_page('syllabus-manager', 'Import', 'Import', 'sm_import_syllabus_manager', 'syllabus-manager-import', array( $this, 'display_import_page'));
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
				
		$courses = Syllabus_Manager_Course::get_courses();
		
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
		
		echo json_encode( Syllabus_Manager_Course::get_courses() );
		
		wp_die(); // Required to terminate immediately and return a proper response
	}
    
    /**
	 * Gets data for the Schedule of Courses DataTable
	 * 
	 * @since 0.0.0
	 */
	public function add_syllabus(){
		// Verify the request to prevent preocessing external requests
		check_ajax_referer( 'syllabus-manager-add-syllabus', 'ajax_nonce' );
		
		if ( !current_user_can( 'sm_manage_syllabus_manager' ) ) {
			wp_send_json_error( array('msg' => __('You do not have sufficient permissions to access this page.', 'syllabus_manager')) );
		}
		
		// Merge post values into one array
		$post_data = $_POST['course_data'];
		
		if ( false ) {error_log(print_r($post_data, true));}
		
		$section = new Syllabus_Manager_Section( 
			$post_data['code'],
			$post_data['title'],
			$post_data['section_number'],
			$post_data['semester'],
			array($post_data['department']),
			$post_data['level'],
			explode(', ', $post_data['instructors'])
		);
		
		// Insert the post into the database
		$post_id = wp_insert_post( $section->get_post_args() );
		
		if ( !is_wp_error( $post_id ) ){
			error_log( 'Successfully inserted post: ' . $post_id . ' for ' . $section->section_id );
			add_post_meta( $post_id, 'sm_course_code', $section->course_code );
			add_post_meta( $post_id, 'sm_course_title', $section->course_title );
			add_post_meta( $post_id, 'sm_section_number', $section->section_code );
			wp_send_json_success( array('msg' => 'Added course: '. $section->section_id) );	
		}
		else {
			error_log( 'Error inserting post: ' . print_r($post_id, true) );
			wp_send_json_error( array('msg' => $post_id->get_error_message()) );
		}
	}
	
	/**
	 * Removes document from course
	 * 
	 * @since 0.1.0
	 * @todo Implement removing selected attachment
	 */
	public function remove_syllabus(){
		// Verify the request to prevent preocessing external requests
		check_ajax_referer( 'syllabus-manager-add-syllabus', 'ajax_nonce' );
		
		if ( !current_user_can( 'sm_manage_syllabus_manager' ) ) {
			wp_send_json_error( array('msg' => __('You do not have sufficient permissions to access this page.', 'syllabus_manager')) );
		}
		
		wp_send_json_success( array('msg' => 'Removed syllabus') );
	}
	
	
	
	/**
	 * Get course array from external source
	 * 
	 * @param  array $query_args Query to get data from external source
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
		if ( false ) { error_log( 'request_url: ' . $request_url ); }
								  
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
	
	/**
	 * Handle forms on the Import screen depending on action
	 * 
	 * @since 0.1.0
	 */
	public function import_handler(){
		//error_log('$_POST: ' . print_r($_POST, true));
		
		if ( !isset($_POST['action']) ){
			return;
		}
				
		// Process the import
		switch ( $_POST['action'] ){
			case 'import_taxonomies':
				$this->admin_notice = $this->import_taxonomy_terms();
				break;
			case 'update':
				$this->update_courses();
				break;
			case 'create':
				$this->create_courses();
				break;
		}
		
		// Display admin notice, if necessary
		add_action( 'admin_notices', array($this, 'admin_notice') );
	}
	
	/**
	 * Import taxonomy terms from source data
	 * 
	 * @return array Admin notices in string or WP_Error format
	 * @since 0.4.0
	 */
	public function import_taxonomy_terms(){
		// Test whether the request includes a valid nonce
		check_admin_referer('sm_import_taxonomies', 'sm_import_taxonomies_nonce');
		//error_log('$_POST: ' . print_r($_POST, true));
		
		$import_source = sanitize_text_field( $_POST['import-source'] );
		$import_taxonomy = sanitize_text_field( $_POST['import-taxonomy'] );
		$import_update = ( isset($_POST['import-update']) && intval($_POST['import-update']) );
		$notice_messages = array();
		
		// Check if form is valid
		if (empty($import_source) || empty($import_taxonomy)){
			return new WP_Error('import_invalid_fields', __("Error: Missing required fields.", 'syllabus-manager'));
		}
		
		// Check if correct value is selected
		if ('uf-soc' != $import_source){
			return new WP_Error('import_not_implemented', __("Sorry! This feature has not been implemented.", 'syllabus-manager'));
		}
		
		// Get the terms to import, import code is key for both arrays
		$source_terms = $this->get_import_api_terms( $import_taxonomy );
		
		if ( is_wp_error( $source_terms ) ){
			return $source_terms;
		}
		
		// Add term_ids or exclude already imported terms
		$import_terms = $this->get_imported_terms( $source_terms, $import_taxonomy, $import_update );
		//error_log('$source_terms: ' . print_r($source_terms, true));
		//error_log('$import_terms: ' . print_r($import_terms, true));
		
		if ( empty($import_terms) ){
			return new WP_Error('import_no_terms', __("No terms to import.", 'syllabus-manager'));
		}
				
		/**
		 * Update or Add New Terms from Import Source
		 * 
		 * Loop over source values and update/insert terms
		 */
		foreach( $import_terms as $import_code => $import_term ):
			// Get existing term_id if it exists
			$found_term_id = ( isset($import_term['term_id']) )? $import_term['term_id'] : false;
			
			// Import/update
			if ( !$found_term_id ){
				$action = 'insert';
				$term = wp_insert_term( $import_term['name'], $import_taxonomy, array('description' => $import_term['description'] ));
			}
			else {
				// Only update the term title and the meta values
				$action = 'update';
				$term = wp_update_term( $found_term_id, $import_taxonomy, array(
					'name' => $import_term['name']
				));
			}
			
			// If import/update successful, update term meta
			if ( !is_wp_error( $term ) ) {
				if ( isset( $import_term['meta'] ) && !empty( $import_term['meta'] ) ){
					foreach ( $import_term['meta'] as $meta_key => $meta_value ){
						update_term_meta( $term['term_id'], $meta_key, $meta_value );
					}
				}
			}
			
			// Set the notice and display based on action
			switch ( $action ){
				case 'insert':
					$notice_messages[] = sprintf('<strong class="text-success">%s</strong> %s', __('Imported term', 'syllabus-manager'), $import_term['name'] );
					break;
				case 'update':
					$notice_messages[] = sprintf('<strong class="text-success">%s</strong> %s', __('Updated term', 'syllabus-manager'), $import_term['name'] );
					break;
				default:
					$notice_messages[] = sprintf('<strong class="text-info">%s</strong> %s', $term->get_error_message(), $import_term['name'] );
			}
		endforeach;
		
		return $notice_messages;
	}
	
	/**
	 * Get an array of terms that have import code metadata
	 * 
	 * @param  string $taxonomy [[Description]]
	 * @return array Array of terms sm_import_code/WP_Term
	 */
	function get_imported_terms( $source_terms, $taxonomy, $include_existing = true ){
		$terms = $source_terms;
		$import_key = 'sm_import_code';
		$existing_terms = get_terms( array( 'taxonomy' => $taxonomy, 'hide_empty' => false,	'meta_key' => $import_key ));
		
		// Create an array of existing terms import code/term data
		if ( !empty($existing_terms) ){
			foreach( $existing_terms as $term ){
				$term_code = get_term_meta( $term->term_id, $import_key, true );
				
				if ( !empty($term_code) ){
					$existing_terms[$term_code] = array( 'term_id' => $term->term_id );
				}
			}
			
			// Add or remove existing items
			if ( !$include_existing ) {
				$terms = array_diff_key( $terms, $existing_terms );
			}
			else {
				foreach( $terms as $import_code => $term ){
					$terms[$import_code] = array_merge( $term, $existing_terms[$import_code] );
				}
			}
		}
		
		return $terms;
	}
	
	/**
	 * Get terms from the UF SOC API, used to import taxonomies
	 * 
	 * @param  string $taxonomy Taxonomomy for new/existing terms
	 * @return array Term data as an associative array
	 */
	public function get_import_api_terms( $taxonomy ){
		
		// Get JSON data from transient, if it exists
		if ( false === ( $response = get_transient('syllabus-manager-import-uf-soc') ) ){
			$request_url = 'https://one.uf.edu/apix/soc/filters/';
			$response = wp_remote_get( $request_url );

			set_transient( 'syllabus-manager-import-uf-soc', $response, 24 * HOUR_IN_SECONDS );
		}

		if ( is_wp_error($response) ){
			return $response;
		}

		// Get JSON objects as array
		$json = ( isset($response['body']) )? $response['body'] : null;
		$response_data = json_decode( $json, true );

		if ( empty($response_data) ){
			return new WP_Error('import', __("Error: API response data not found.", 'syllabus-manager'));
		}

		// Get correct selected values from JSON, need to match form value to JSON array key
		$filters = array(
			'syllabus_department' 	=> 'departments',
			'syllabus_semester' 	=> 'terms',
			'syllabus_level' 		=> 'progLevels',
		);
		
		$term_data_key = $filters[$taxonomy];
		$term_data = $response_data[$term_data_key];
		$terms = array();
		
		foreach ( $term_data as $data ):
			$term_name = $data['DESC'];
			$term_slug = null; // Use default from sanitize_title()
			$term_desc = '';
			$term_import_code = $data['CODE'];
			$term_meta = array( 
				'sm_import_code' => $term_import_code, 
				'sm_import_date' => current_time('mysql')
			);		

			if ( 'syllabus_department' == $taxonomy ){
				$include_departments = array('11662001', '11650000', '11686003', '11686004', '11602000', '11686005', '11629000', '11690003', '11606000', '11686006', '11607000', '11692003', '11686007', '11686008', '11643001', '11608000', '11637000', '11686009', '11609000', '11610000', '11686010', '11607001', '11686011', '11686012', '11612000', '11686014', '11686015', '11653000', '11686001', '11607003', '11654000', '11613000', '11680000', '11615000', '11616003', '11686017', '11617000', '11688005', '11618000', '11619002', '11686018', '11692005', '11688003', '11623000', '11686020', '11686022', '11686023', '11657006', '15862001', '11626000', '11686025');
				
				// Change Department names
				$term_name = str_replace('AFRICAN AMERICAN STUDIES', 'African-American Studies', $term_name);
				$term_name = str_replace('LANGUAGES LIT/CULTURE', 'Languages Literatures and Cultures', $term_name);
				$term_name = str_replace('SPANISH/PORTUGUESE STUDIES-PORTUG', 'Spanish and Portuguese Studies-Portuguese', $term_name);
				$term_name = str_replace('SPANISH/PORTUGUESE STUDIES-SPANIS', 'Spanish and Portuguese Studies-Spanish', $term_name);
				$term_name = str_replace('SOCIOLOGY/CRIMINOLOGY/LAW-CRIMINO', 'Sociology Criminology and Law-Criminology', $term_name);
				$term_name = str_replace('SOCIOLOGY/CRIMINOLOGY/LAW-SOCIOLO', 'Sociology Criminology and Law-Sociology', $term_name);

				// Change Format to title case
				$ugly_terms = explode( '-', $term_name );
				$pretty_terms = array();
				foreach( $ugly_terms as $ugly_title ){
					$pretty_terms[] = ucwords(strtolower(trim($ugly_title)));
				}
				$term_name = implode('-', $pretty_terms);

				// Final formatting
				$term_name = str_replace('&', 'and', $term_name);
				$term_name = str_replace('And', 'and', $term_name);
				$term_name = str_replace(',', ' ', $term_name);
			}

			$terms[$term_import_code] = array( 'name' => $term_name, 'slug' => $term_slug, 'description' => '', 'meta' => $term_meta );
		endforeach;

		return $terms;
	}
	
	/**
	 * Get terms from uploaded file, used to import taxonomies
	 * 
	 * @param  string $taxonomy Taxonomomy for new/existing terms
	 * @return array Term data as an associative array
	 * @todo Implement this for CSV file import
	 */
	public function get_import_upload_terms( $taxonomy ){
		if ( empty($_FILES) ){
			return;
		}
		
		// Test whether the request includes a valid nonce
		check_admin_referer('sm_import_taxonomies', 'sm_import_taxonomies_nonce');
		
		
		$filter_name = sanitize_text_field( $_POST['import-taxonomy'] );
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
				'terms' => 'syllabus_semester',
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
	
	/**
	 * Updates WP course post attributes from the external source data
	 * 
	 * @since 0.1.0
	 */
	public function update_courses(){
		// Test whether the request includes a valid nonce
		check_admin_referer('sm_update_courses', 'sm_update_courses_nonce');
		
		if ( WP_DEBUG ) {error_log('Updating courses...'); }
		
		$semester = $_POST['semester'];
		$department = $_POST['department'];
		$level = $_POST['level'];
		
		// Get the courses
		$course_data = Syllabus_Manager_Course::get_courses( $semester, $department, $level );
		
		$matched_courses = $this->get_matched_courses( $semester, $department, $level, $course_data );
		if ( WP_DEBUG ){ error_log( print_r($matched_courses, true) ); }
		
		foreach ( $matched_courses as $section_id => $post_id ){
			
			$section = new Syllabus_Manager_Section( 
				$course_data[$section_id]['code'],
				$course_data[$section_id]['title'],
				$course_data[$section_id]['section_number'],
				$semester,
				array($department),
				$level,
				explode(', ', $course_data[$section_id]['instructors']),
				$post_id
			);
						
			$post_id = wp_update_post( $section->get_post_args() );
			
			if ( !is_wp_error($post_id) ){
				error_log( 'Successfully updated post: ' . $post_id . ' for ' . $section_id );
				update_post_meta( $post_id, 'sm_course_code', $course_data[$section_id]['code'] );
				update_post_meta( $post_id, 'sm_course_title', $course_data[$section_id]['title'] );
				update_post_meta( $post_id, 'sm_section_number', $course_data[$section_id]['section_number'] );
			}
			
		}
	}
	
	/**
	 * Compares WP course posts with courses in the data tables
	 * 
	 * @param  string $semester      
	 * @param  string $department     
	 * @param  string $level           
	 * @param  array $new_course_data Array of Syllabus_Manager_Course objects
	 * @return array Array of Syllabus_Manager_Courses that exist in the external table data
	 * @since 0.1.0
	 */
	public function get_matched_courses( $semester, $department, $level, $new_course_data ){
		$current_courses = array();
		
		// Get target course ids
		$current_query = new WP_Query( array(
			'post_type' => 'syllabus_course',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'syllabus_semester',
					'field' => 'slug',
					'terms' => $semester,
				),
				array(
					'taxonomy' => 'syllabus_department',
					'field' => 'slug',
					'terms' => $department,
				),
				array(
					'taxonomy' => 'syllabus_level',
					'field' => 'slug',
					'terms' => $level,
				)
			),
		));
		$current_course_posts = $current_query->get_posts();
		
		// Add meta values to the array
		foreach( $current_course_posts as $post ){
			$current_courses[$post->sm_section_id] = $post->ID;
		}
		
		// Get the list of course posts that exist in the course data
		return array_intersect_key($current_courses, $new_course_data);
	}
	
	/**
	 * Inserts a new WP course post into the database
	 * 
	 * @since 0.1.0
	 */
	public function create_courses(){
		// Test whether the request includes a valid nonce
		check_admin_referer('sm_create_courses', 'sm_create_courses_nonce');
		
		if ( !current_user_can( 'sm_manage_syllabus_manager' ) ) {
			wp_die( __('You do not have sufficient permissions to access this page.', 'syllabus_manager'));
		}
		
		if ( WP_DEBUG ) {error_log('Creating courses...'); }
		
		$semester = $_POST['semester'];
		$department = $_POST['department'];
		$level = $_POST['level'];
		
		// Get the courses
		$course_data = Syllabus_Manager_Course::get_courses( $semester, $department, $level );
		
		foreach ( $course_data as $section_id => $course_section ){
			$section = $course_section->sections[0];
			
			//error_log( print_r($section->get_post_args(), true) );
			
			// Insert the post into the database
			
			$post_id = wp_insert_post( $section->get_post_args() );
			
			if ( !is_wp_error( $post_id ) ){
				//error_log( 'Successfully inserted post: ' . $post_id . ' for ' . $section_id );
				add_post_meta( $post_id, 'sm_course_code', $section->course_code );
				add_post_meta( $post_id, 'sm_course_title', $section->course_title );
				add_post_meta( $post_id, 'sm_section_number', $section->section_code );
			}
			else {
				//error_log( 'Error inserting post: ' . print_r($post_id, true) );
			}
		}
	}
	
	
	/**
	 * Add support for uploading file formats
	 * 
	 * @param array $existing_mimes
	 * @return array $existing_mimes
	 * @since 1.0
	 */
	function custom_upload_mimes( $existing_mimes = array() ) {
		// Add file extension 'extension' with mime type 'mime/type'
		$existing_mimes['svg'] = 'image/svg+xml';
		$existing_mimes['json'] = 'application/json'; 

		// and return the new full result
		return $existing_mimes;
	}
	
	/**
	 * Display custom meta on term edit screens
	 * @param WP_Term $term     Current taxonomy term object
	 * @param string $taxonomy Current taxonomy slug
	 */
	function display_taxonomy_meta_form_fields( $term, $taxonomy ){
		var_dump( get_term_meta( $term->term_id ) );
	}
	
	function customize_user_profile(){
		remove_action('admin_color_scheme_picker', 'admin_color_scheme_picker');
		
	}
	
	/**
	 * Prevent Syllabus Department Admins from viewing other department courses
	 * 
	 * @param WP_Query $query
	 * @since 0.3.0
	 */
	function restrict_content( $query ){
		if ( !is_admin() && !$query->is_main_query() ){
			return;
		}
		
		$restricted_role = 'sm_admin_dept';
		$allowed_types = array('syllabus_course', 'attachment');
		$taxonomy = 'syllabus_department';
		$allowed_mime = 'application/pdf';
		
		$user = wp_get_current_user();
		
		if ( in_array( $restricted_role, $user->roles ) && in_array( $query->get('post_type'), $allowed_types) ){
			
			$user_terms = wp_get_object_terms( $user->ID, $taxonomy, array('fields' => 'ids') );

			$query->set('tax_query', array(array(
				'taxonomy' => $taxonomy, 'field' => 'term_id', 'terms' => $user_terms,
			)));

			if ( $query->get('post_type') == 'attachment' ){
				$query->set('post_mime_type', $allowed_mime);
			}
		}
		
	}
	
	/**
	 * Customize capabilities to access courses
	 * 
	 * @param array   $caps    	Returns the user's capabilities
	 * @param string  $cap      Meta capability name
	 * @param integer $user_id  The user ID
	 * @param array   $args     Adds the context to the cap. Typically the object ID
	 * @since 0.3.0
	 */
	function map_capabilities( $caps, $cap, $user_id, $args ){
		
		//error_log( "Checking $cap for $user_id with args: " . print_r($args, true) . "and caps: " . print_r($args, true) );
		
		if ( 'edit_post' == $cap ){
			if (!empty($args)){
				$post = get_post( $args[0] );
				if ( 'attachment' == $post->post_type ){
					/**
					 * Checking user department value against attachment value
					 * 
					 * For now this allows users to technically edit any media
					 * 
					 * @todo Add this back in after uploads default to department
					 */
					/*
					
					$taxonomy = 'syllabus_department';
					$user = get_user_by( 'id', $user_id );
					$user_terms = wp_get_object_terms( $user->ID, $taxonomy, array( 'fields' => 'ids') );
					
					//error_log( 'Checking ' . $post->post_title );
					//error_log( '$user_terms: ' . print_r($user_terms, true) );
					$post_type = get_post_type_object( $post->post_type );
					$caps = array();
					$caps[] = 'sm_edit_syllabus_courses';
					$caps[] = 'sm_edit_syllabus_courses';
					$caps[] = 'sm_edit_syllabus_courses';
					//error_log( '$caps: ' . print_r($caps, true) );
					*/
					$post_type = get_post_type_object( 'syllabus_course' );
					$caps = array( $post_type->cap->edit_posts );
				} 
			}
		}
		
		// Get post type information
		if ( 'sm_edit_syllabus_course' == $cap || 'sm_delete_syllabus_course' == $cap || 'sm_read_syllabus_course' == $cap ) {
			$post_type = get_post_type_object( 'syllabus_course' );
		}
		
		if ( 'sm_edit_syllabus_course' == $cap ) {
			$caps = array( $post_type->cap->edit_posts );
		}
		
		if ( 'sm_delete_syllabus_course' == $cap ) {
			$caps = array( $post_type->cap->delete_posts );
		}
		
		if ( 'sm_read_syllabus_course' == $cap ) {
			$caps = array( $post_type->cap->read_posts );
		}
		
		// Return the capabilities required by the user
		return $caps;
	}
	
	
	/**
	 * Add an admin notice as a result of action taken
	 *
	 * @since 0.4.0
	 */
	function admin_notice(){
		if ( !$this->admin_notice && !empty($this->admin_notice) ) {
			return;
		}
				
		// Set notice message and type
		if ( is_wp_error( $this->admin_notice ) ){
			$notice_message = $this->admin_notice->get_error_message();
			$notice_type = 'error';
		}
		else {
			$notice_message = $this->admin_notice;
			$notice_type = 'success';
		}
		
		// Handle arrays of notices
		$notice_message = ( is_array($notice_message) )? join('<br>', $notice_message) : $notice_message;
		
		// Display notice
		?>
		<div class="notice notice-<?php echo $notice_type; ?>">
			<p><?php echo $notice_message; ?></p>
		</div>
		<?php
	}
}
