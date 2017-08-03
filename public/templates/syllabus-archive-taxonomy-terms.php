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

<div class ="container">
	<div class="row">
		<div class="col-md-12">
			<?php the_content(); ?>
		</div>
	</div>
    <div class="row">
	<?php

		$page_obj = get_queried_object();
		$page_term = rtrim($page_obj->post_name, 's');
		$page_taxonomy = "syllabus_{$page_term}";
		$page_terms = get_terms( array(
			'taxonomy' => $page_taxonomy, 
			'parent' => 0,
		));

		if ( !is_wp_error( $page_terms ) ):

		foreach ( $page_terms as $term ): ?>
		<div class="col-md-4"> 
			<div class="media">
				<div class="media-left">
						<span style="font-size: 18px" class="glyphicon glyphicon-menu-right"></span>
				</div>
				<div class="media-body">
					<h4 class="subtitle">
						<a href="<?php echo get_term_link( $term ); ?>"><?php echo $term->name; ?></a>
					</h4>
				</div>
			</div>
		</div>
	<?php 
		endforeach;
		endif;
	?>
	</div>
</div>
<?php

do_action( 'syllabus_manager_content_after' );

get_footer(); 

?>