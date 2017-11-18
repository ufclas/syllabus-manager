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
 		<header class="entry-header">
		<?php 
			//the_title( '<h1 class="page-title">', '</h1>' );
		?>
		</header>
		
		<section class="sm-container">
		<?php

			if ( is_front_page() ){
				$page_taxonomy = "syllabus_department";
			}
			else {
				$page_obj = get_queried_object();
				$page_term = rtrim($page_obj->post_name, 's');
				$page_taxonomy = "syllabus_{$page_term}";
			}
			
			$page_terms = get_terms( array(
				'taxonomy' => $page_taxonomy, 
				'parent' => 0,
				'hide_empty' => false
			));

			if ( !is_wp_error( $page_terms ) ):
			
			/**
			 * @todo Implement term link override to go to department website instead
			 */
			foreach ( $page_terms as $term ): 
				$term_image_id = get_term_meta($term->term_id, 'sm_department_cover', true);
				$term_link = get_term_link($term->term_id, $page_taxonomy);
				$term_link_override = get_term_meta($term->term_id, 'sm_department_override', true);
				$term_image = (!empty($term_image_id))? wp_get_attachment_image( $term_image_id ) : '<div class="img-thumbnail"></div>';
			?>
			<div class="col-sm-6 col-md-4"> 
				<div class="sm-card media">
					<div class="sm-card-graphic media-left">
						<a href="<?php echo $term_link; ?>"><?php echo $term_image; ?></a>
					</div>
					<div class="sm-card-text media-body">
						<h4 class="subtitle">
							<a href="<?php echo $term_link; ?>"><?php echo $term->name; ?></a>
						</h4>
					</div>
				</div>
			</div>
		<?php 
			endforeach;
			endif;
		?>
		</section><!-- .sm-container --> 
	</div><!-- .col-md-12 -->
</div><!-- .row -->
</div><!-- .syllabus-main-content -->
<?php 

do_action( 'syllabus_manager_content_after' );

get_footer(); 

?>