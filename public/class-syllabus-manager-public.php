<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/public
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager_Public {

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
	
	/**
	 * Template loader
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      Syllabus_Manager_Template_Loader $templates
	 */
	public $templates;
	
	/**
	 * Post type name
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      string    $post_type
	 */
	public $post_type;
	
	/**
	 * Taxonomies used in this plugin
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      array $taxonomies
	 */
	public $taxonomies;
	
	/**
	 * Page ID of page to replace with courses content
	 *
	 * @since    0.0.0
	 * @access   public
	 * @var      int    $post_page_id
	 */
	public $post_page_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->templates = new Syllabus_Manager_Template_Loader;
		
		$this->post_type = 'syllabus_course';
		$this->taxonomies = array('syllabus_instructor', 'syllabus_department', 'syllabus_level', 'syllabus_semester');
		$this->post_page_id = 90;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name . '-datatables-css', plugin_dir_url( dirname(__FILE__) ) . 'includes/dataTables/datatables.min.css', array(), $this->version, 'screen' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/syllabus-manager-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name . '-datatables-js', plugin_dir_url( dirname(__FILE__) ) . 'includes/dataTables/datatables.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/syllabus-manager-public.js', array( 'jquery' ), $this->version, false );
		/*wp_localize_script( $this->plugin_name, 'sm_public_data', array(
			'courses' => $this->get_courses_table(),
			'ajax_nonce' => wp_create_nonce('sm-get-courses=table')
		));*/
	}
	
	/**
	 * Use custom plugin or theme templates
	 * 
	 * @since 0.0.0
	 * @param  string $template_path [[Description]]
	 * @return string [[Description]]
	 */
	public function set_templates( $template_path ) {
		
		if ( is_post_type_archive( $this->post_type )){			
			$template_path = $this->templates->locate_template( 'syllabus-archive.php', false );
		}
		elseif ( is_tax('syllabus_instructor') || is_tax('syllabus_department') || is_tax('syllabus_level') || is_tax('syllabus_semester') ){
			$template_path = $this->templates->locate_template( 'syllabus-archive.php', false );
		}
		elseif (is_singular( $this->post_type )){
			$template_path = $this->templates->locate_template( 'syllabus-single.php', false );
		}
		elseif ( is_page( array('departments','instructors','semesters') ) ){
			$template_path = $this->templates->locate_template( 'syllabus-archive-taxonomy-terms.php', false );
		}
		
		return $template_path;
	}
	
	/**
	 * Display page content
	 * 
	 * @since 0.0.0
	 */
	public function display_content(){
		include 'partials/syllabus-content.php';
	}
	
	/**
	 * Display page header
	 * 
	 * @since 0.0.0
	 */
	public function display_content_header(){
		include 'partials/syllabus-content-header.php';
	}
	
	/**
	 * Display page footer
	 * 
	 * @since 0.0.0
	 */
	public function display_content_footer(){
		include 'partials/syllabus-content-footer.php';
	}
	
	/**
	 * Allows using a page for displaying courses
	 * 
	 * @param WP_Query $query Page query
	 * @since 0.1.0
	 * @todo Implement using a user-picked page ID instead of hardcoded one.
	 */
	function set_courses_query( $query ) {
		if ( is_admin() || !$query->is_main_query() ) {
			return;
		}
		
		if ( WP_DEBUG ){ //error_log( print_r($query, true) ); }
				
		if ( $query->get_queried_object_id() == $this->post_page_id ){
			error_log( 'Syllabus Manager changing query for page' );
			
			// Reset properties to emulate an archive page
			$query->set('post_type', 'syllabus_course');
			$query->set('pagename', null);
			$query->is_page = false;
			$query->is_singular = false;
			$query->is_post_type_archive = true;
        	$query->is_archive = true;
			
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
			$query->set( 'posts_per_page', -1 );
		}
		elseif ( $query->is_post_type_archive('syllabus_course') || is_tax('syllabus_instructor') || is_tax('syllabus_department') || is_tax('syllabus_level') || is_tax('syllabus_semester')  ){
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
			$query->set( 'posts_per_page', -1 );
		}
	}
}
}
