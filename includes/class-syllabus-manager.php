<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.0.0
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Syllabus_Manager {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.0.0
	 * @access   protected
	 * @var      Syllabus_Manager_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/** 
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'syllabus-manager';
		$this->version = '0.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Syllabus_Manager_Loader. Orchestrates the hooks of the plugin.
	 * - Syllabus_Manager_i18n. Defines internationalization functionality.
	 * - Syllabus_Manager_Admin. Defines all hooks for the admin area.
	 * - Syllabus_Manager_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-syllabus-manager-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-syllabus-manager-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-syllabus-manager-admin.php';
		
		/**
		 * Template loader classes
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-gamajo-template-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-syllabus-manager-template-loader.php';
		
		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-syllabus-manager-public.php';
		
		/**
		 * Custom Post Types and Taxonomies
		 */ 
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-syllabus-manager-section.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-syllabus-manager-courses.php';
		
		
		$this->loader = new Syllabus_Manager_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Syllabus_Manager_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Syllabus_Manager_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Syllabus_Manager_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
		$this->loader->add_action( 'wp_ajax_add_syllabus', $plugin_admin, 'add_syllabus' );
		$this->loader->add_action( 'wp_ajax_remove_syllabus', $plugin_admin, 'remove_syllabus' );
		$this->loader->add_action( 'load-syllabus-manager_page_syllabus-manager-import', $plugin_admin, 'import_handler' );
		$this->loader->add_filter( 'parent_file', $plugin_admin, 'menu_highlight' ); 
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Syllabus_Manager_Public( $this->get_plugin_name(), $this->get_version() );
		$plugin_courses = new Syllabus_Manager_Courses();

		$this->loader->add_action( 'init', $plugin_courses, 'register_post_type' );
		$this->loader->add_action( 'init', $plugin_courses, 'register_taxonomies' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp_ajax_nopriv_get_courses_table', $plugin_public, 'get_courses_table' );
		$this->loader->add_action( 'pre_get_posts', $plugin_public, 'set_courses_query' );
		$this->loader->add_action( 'template_include', $plugin_public, 'set_templates' );
		$this->loader->add_action( 'syllabus_manager_content', $plugin_public, 'display_content' );
		$this->loader->add_action( 'syllabus_manager_content_before', $plugin_public, 'display_content_header' );
		$this->loader->add_action( 'syllabus_manager_content_after', $plugin_public, 'display_content_footer' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.0.0
	 * @return    Syllabus_Manager_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
