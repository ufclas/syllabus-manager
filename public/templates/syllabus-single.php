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
 * @package Ufclas_Syllabus_Manager
 */
get_header();

do_action( 'ufcsm_content_before' );

do_action( 'ufcsm_content' );

do_action( 'ufcsm_content_after' );

get_footer(); 

?>