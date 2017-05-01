<?php
/**
 * 
 *
 * A class that extends Gamajo_Template_Loader to allow loading 
 * template parts with fallback through the child and parent themes.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Ufclas_Syllabus_Manager
 * @subpackage Ufclas_Syllabus_Manager/includes
 */

/**
 * Template loader for UFCLAS Syllabus Manager.
 *
 * Only need to specify class properties here.
 *
 * @package    Ufclas_Syllabus_Manager
 * @subpackage Ufclas_Syllabus_Manager/includes
 * @author     Priscilla Chapman (CLAS IT) <no-reply@clas.ufl.edu>
 */
class Ufclas_Syllabus_Manager_Template_Loader extends Gamajo_Template_Loader {
  /**
   * Prefix for filter names.
   *
   * @since 0.0.0
   *
   * @var string
   */
  protected $filter_prefix = 'ufcsm';

  /**
   * Directory name where custom templates for this plugin should be found in the theme.
   *
   * @since 0.0.0
   *
   * @var string
   */
  protected $theme_template_directory = 'page-templates';

  /**
   * Reference to the root directory path of this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * In this case, `MEAL_PLANNER_PLUGIN_DIR` would be defined in the root plugin file as:
   *
   * ~~~
   * define( 'MEAL_PLANNER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
   * ~~~
   *
   * @since 0.0.0
   *
   * @var string
   */
  protected $plugin_directory = UFCLAS_SYLLABUS_MANAGER_DIR;

  /**
   * Directory name where templates are found in this plugin.
   *
   * Can either be a defined constant, or a relative reference from where the subclass lives.
   *
   * e.g. 'templates' or 'includes/templates', etc.
   *
   * @since 1.1.0
   *
   * @var string
   */
  protected $plugin_template_directory = 'public/templates';
}