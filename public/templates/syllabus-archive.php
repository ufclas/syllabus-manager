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

?>
<div class="ufcsm-container container">
  <table class="table table-hover table-striped ufcsm-table">
    <thead>
      <tr>
        <th><?php _e('Course', 'ufclas-syllabus-manager'); ?></th>
        <th><?php _e('Section', 'ufclas-syllabus-manager'); ?></th>
        <th><?php _e('Title / Syllabus', 'ufclas-syllabus-manager'); ?></th>
        <th><?php _e('Instructor(s)', 'ufclas-syllabus-manager'); ?></th>
      </tr>
    </thead>
    <tbody>
		<?php 
			while ( have_posts() ) : the_post(); 
			
			$prefix = get_field('ufcsm_prefix');
			$number = get_field('ufcsm_number');
			$section = get_field('ufcsm_section');
			$title = get_field('ufcsm_title');
			$syllabus_url = get_field('ufcsm_syllabus');
			$instructor_tax = 'ufcsm_instructor';
		
		?>
			<tr>
				<td><?php echo $prefix . $number; ?></td>
				<td><?php echo $section; ?></td>
				<td><a href="<?php echo $syllabus_url; ?>" target="_blank"><?php echo $title; ?></a></td>
				<td><?php echo get_the_term_list( get_the_ID(), $instructor_tax, '<ul class="list-inline"><li>', ',</li><li>', '</li>' ); ?></td>
			</tr>
			<?php 
			endwhile; // End of the loop. 
		?>
  </tbody>
  </table>
</div><!-- .ufcsm-container --> 

<?php 

do_action( 'ufcsm_content_after' );

get_footer(); 

?>