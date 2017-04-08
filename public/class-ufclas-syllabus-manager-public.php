<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      1.0.0
 *
 * @package    Ufclas_Syllabus_Manager
 * @subpackage Ufclas_Syllabus_Manager/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ufclas_Syllabus_Manager
 * @subpackage Ufclas_Syllabus_Manager/public
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Ufclas_Syllabus_Manager_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	public $templates;
	
	public $post_type;
	public $taxonomies;
	public $post_page_id;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->templates = new Ufclas_Syllabus_Manager_Template_Loader;
		
		$this->post_type = 'ufcsm_course';
		$this->taxonomies = array('ufcsm_instructor', 'ufcsm_department', 'ufcsm_level', 'ufcsm_semester');
		$this->post_page_id = 90;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ufclas_Syllabus_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ufclas_Syllabus_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ufclas-syllabus-manager-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ufclas_Syllabus_Manager_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ufclas_Syllabus_Manager_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ufclas-syllabus-manager-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Use custom plugin or theme templates
	 * 
	 * @since 1.0.0
	 * @param  string $template_path [[Description]]
	 * @return string [[Description]]
	 */
	public function set_templates( $template_path ) {
		
		if ( is_post_type_archive( $this->post_type )){			
			$template_path = $this->templates->locate_template( 'syllabus-archive.php', false );
		}
		elseif ( is_tax('ufcsm_instructor') || is_tax('ufcsm_department') || is_tax('ufcsm_level') || is_tax('ufcsm_semester') ){
			$template_path = $this->templates->locate_template( 'syllabus-archive.php', false );
		}
		elseif (is_singular( $this->post_type )){
			$template_path = $this->templates->locate_template( 'syllabus-single.php', false );
		}
		
		return $template_path;
	}
	
	public function display_content(){
		include 'templates/syllabus-content.php';
	}
	
	public function display_content_header(){
		include 'partials/syllabus-content-header.php';
	}
	
	public function display_content_footer(){
		include 'partials/syllabus-content-footer.php';
	}
	
	function set_courses_query( $query ) {
		if ( is_admin() || !$query->is_main_query() ) {
			return;
		}
		
		if ( $query->get('page_id') == $this->post_page_id ){
			
			// Reset properties to emulate an archive page
			$query->set('post_type', 'ufcsm_course');
			$query->set('page_id', '');
			$query->is_page = 0;
			$query->is_singular = 0;
			$query->is_post_type_archive = 1;
        	$query->is_archive = 1;
			
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
			$query->set( 'posts_per_page', -1 );
		}
		elseif ( $query->is_post_type_archive('ufcsm_course') || is_tax('ufcsm_instructor') || is_tax('ufcsm_department') || is_tax('ufcsm_level') || is_tax('ufcsm_semester')  ){
			$query->set( 'orderby', 'title' );
			$query->set( 'order', 'ASC' );
			$query->set( 'posts_per_page', -1 );
		}
	}
}
