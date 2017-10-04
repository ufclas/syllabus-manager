<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/public/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<header class="entry-header">
<?php 
	if ( is_archive() ){
		the_archive_title( '<h1 class="page-title">', '</h1>' );
	}
	else {
		the_title( '<h1 class="page-title">', '</h1>' );
	}
?>
</header>
<!-- .entry-header --> 

<section class="sm-container">
<?php 
	
	// Set up the default query to display courses
	
	if ( have_posts() ): ?>
	
	<table id="sm-archive-table" class="table table-hover syllabus-table">
		<thead>
		  <tr>
			<th class="syllabus-course sr-only"><?php _e('Course', 'syllabus-manager'); ?></th>
			<th class="syllabus-title sr-only"><?php _e('Title / Syllabus', 'syllabus-manager'); ?></th>
			<th class="syllabus-instruct sr-only"><?php _e('Instructor(s)', 'syllabus-manager'); ?></th>
			<th class="syllabus-dept sr-only"><?php _e('Department', 'syllabus-manager'); ?></th>
			<th class="syllabus-level sr-only"><?php _e('Course Level', 'syllabus-manager'); ?></th>
			<th class="syllabus-semester sr-only"><?php _e('Semester', 'syllabus-manager'); ?></th>
		  </tr>
		</thead>
		<tbody>
		<?php
			while ( have_posts() ) : the_post(); 
				$course_code = get_field('sm_course_code');
				$section_number = get_field('sm_section_number');
				$title = get_field('sm_course_title');
				
				// Get the syllabus documents for the course
				$syllabus_url = null;
				$syllabus_attachments = get_attached_media( 'application/pdf', get_the_ID() );
			
				if ( $syllabus_attachments ) {
					$syllabus = array_pop( $syllabus_attachments );
					$syllabus_url = $syllabus->guid;
				}
			
				$syllabus_title = ( $syllabus_url )? sprintf('<a href="%s" target="_blank">%s</a>', $syllabus_url, $title) : $title;
				
				$syllabus_lists =  array(
					'instruct' => 'syllabus_instructor',
					'dept' => 'syllabus_department',
					'level' => 'syllabus_level',
					'semester' => 'syllabus_semester',
				);
		?>
		<tr>
			<td class="syllabus-course"><?php echo $course_code; ?></td>
			<td class="syllabus-title"><?php echo $syllabus_title; ?></td>
			
			<?php
				// Display the taxonomy lists
				foreach ( $syllabus_lists as $key => $term ):
					$term_class = 'syllabus-' . $key;
					$term_list = get_the_term_list( get_the_ID(), $term, '<ul class="list-inline"><li>', ',</li><li>', '</li>' );
					$term_list = ( !is_wp_error( $term_list ) )? $term_list : '<code>' . print_r($term_list, true) . '</code>';	
					printf( '<td class="%s">%s</td>', $term_class, $term_list );
				endforeach;
			?>
		</tr>
			<?php endwhile; // End of the loop. ?>
		</tbody>
		</table>
	<?php else: ?>
		<div><?php _e('No courses found.', 'Syllabus_Manager'); ?></div>
	<?php endif; ?>
</section><!-- .ufcsm-container --> 