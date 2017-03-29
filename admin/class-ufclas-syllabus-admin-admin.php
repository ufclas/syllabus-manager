<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      1.0.0
 *
 * @package    Ufclas_Syllabus_Admin
 * @subpackage Ufclas_Syllabus_Admin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ufclas_Syllabus_Admin
 * @subpackage Ufclas_Syllabus_Admin/admin
 * @author     Priscilla Chapman (CLAS IT) <wordpress@clas.ufl.edu>
 */
class Ufclas_Syllabus_Admin_Admin {

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
	
	/**
	 * The option prefix to be used in this plugin
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $option_name    The option prefix
	 */
	private $option_name = 'ufclas_syllabus';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ufclas_Syllabus_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ufclas_Syllabus_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ufclas-syllabus-admin-admin.css', array('bootstrap'), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ufclas_Syllabus_Admin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ufclas_Syllabus_Admin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ufclas-syllabus-admin-admin.js', array( 'jquery', 'bootstrap' ), $this->version, true );

	}
	
	/**
	 * Add Admin menu item
	 * 
	 * @since 1.0.0
	 */
	public function register_menu(){
		$this->plugin_screen_hook_suffix = add_menu_page(
			__('UF CLAS Course Syllabi', 'ufclas-syllabus-admin'),
			__('Syllabus', 'ufclas-syllabus-admin'),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_main_page' )
		);
		
		dbgx_trace_var($this->plugin_screen_hook_suffix);
	}
	/** 
	 * Render the menu page for the plugin
	 *
	 * @since 1.0.0
	 */
	public function display_main_page(){
		include_once 'partials/ufclas-syllabus-admin-display.php';
	}
	
	/**
	 * Remove default widgets from the dashboard
	 * 
	 * @since 1.0.0
	 */
	public function disable_dashboard_widgets(){
		$dashboard_widgets = array(
			'dashboard_right_now' => 'normal',
			'dashboard_primary' => 'side',
			'dashboard_activity' => 'side',
			'dashboard_quick_press' => 'side',
		);
		
		foreach ( $dashboard_widgets as $widget => $position ){
			remove_meta_box( $widget , 'dashboard', $position ); 
		}
	}

	/**
	 * Replace the dashboard welcome panel
	 * 
	 * @since 1.0.0
	 */
	public function welcome_panel(){
		include_once 'partials/ufclas-syllabus-admin-welcome-display.php';
	}
	
	/**
	 * Add a menu page 'Syllabus Admin'
	 * 
	 * @since 1.0.0
	 */
	public function add_options_page(){
		$this->plugin_screen_hook_suffix = add_options_page(
			__('UFCLAS Syllabus Settings', 'ufclas-syllabus-admin'),
			__('UFCLAS Syllabus Admin', 'ufclas-syllabus-admin'),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' )
		);
	}
	
	/** 
	 * Render the menu page for the plugin
	 *
	 * @since 1.0.0
	 */
	public function display_options_page(){
		include_once 'partials/ufclas-syllabus-admin-settings-display.php';
	}
	
	/**
	 * Register settings
	 *
	 * @since 1.0.0
	 */
	public function register_setting(){
		
		// Add a general section
		add_settings_section(
			$this->option_name . '_general',
			__('General', 'ufclas-syllabus-admin'),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);
		
		// Add field for the text position 
		add_settings_field(
			$this->option_name . '_position',
			__('Text position', 'ufclas-syllabus-admin'),
			array( $this, $this->option_name . '_position_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_position' )
		);
		
		// Add a field for the 
		add_settings_field(
			$this->option_name . '_day',
			__('Text position', 'ufclas-syllabus-admin'),
			array( $this, $this->option_name . '_day_cb' ),
			$this->plugin_name,
			$this->option_name . '_general',
			array( 'label_for' => $this->option_name . '_day' )
		);
		
		register_setting( $this->plugin_name, $this->option_name . '_position', array( $this, $this->option_name . '_sanitize_position' ) );
		register_setting( $this->plugin_name, $this->option_name . '_day', 'intval' );
	}
	
	/**
	 * Render the text for the general section 
	 *
	 * @since 1.0.0
	 */
	public function ufclas_syllabus_general_cb() {
		echo '<p>' . __('Please change the settings accordingly.', 'ufclas-syllabus-admin') . '</p>';
	}
	
	/**
	 * Render the radio input field for position option
	 *
	 * @since  1.0.0
	 */
	public function ufclas_syllabus_position_cb() {
		$position = get_option( $this->option_name . '_position' );

		?>
			<fieldset>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" id="<?php echo $this->option_name . '_position' ?>" value="before" <?php checked($position, 'before'); ?>>
					<?php _e( 'Before the content', 'ufclas-syllabus-admin' ); ?>
				</label>
				<br>
				<label>
					<input type="radio" name="<?php echo $this->option_name . '_position' ?>" value="after" <?php checked($position, 'after'); ?>>
					<?php _e( 'After the content', 'ufclas-syllabus-admin' ); ?>
				</label>
			</fieldset>
		<?php
	}
	
	/**
	 * Render the treshold day input for this plugin
	 *
	 * @since  1.0.0
	 */
	public function ufclas_syllabus_day_cb() {
		$day = get_option( $this->option_name . '_day' );
		
		echo '<input type="text" name="' . $this->option_name . '_day' . '" id="' . $this->option_name . '_day' . '" value="' . $day . '"> '. __( 'days', 'ufclas-syllabus-admin' );
	}
	
	/**
	 * Sanitize the text position value before being saved to database
	 *
	 * @param  string $position $_POST value
	 * @since  1.0.0
	 * @return string           Sanitized value
	 */
	public function ufclas_syllabus_sanitize_position( $position ) {
		if ( in_array( $position, array( 'before', 'after' ), true ) ) {
	        return $position;
	    }
	}

}
