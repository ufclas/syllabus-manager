<?php
/**
 * The template file for archives.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Syllabus_Manager
 */
get_header();

do_action( 'syllabus_manager_content_before' );

?>
<div id="main" class="container main-content syllabus-main-content">
<div class="row">
  	<div class="col-sm-12">
 		<?php do_action( 'syllabus_manager_content' ); ?>
	</div><!-- .col-md-12 -->
</div><!-- .row -->
</div><!-- .syllabus-main-content -->
<?php 

do_action( 'syllabus_manager_content_after' );

get_footer(); 

?>