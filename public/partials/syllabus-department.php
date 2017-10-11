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

// Get department data
$term_meta = get_term_meta( get_queried_object_id() );	  	  
$dept_website = ( isset($term_meta['sm_department_website']) )? esc_url( $term_meta['sm_department_website'][0] ) : '';
$dept_cover = ( isset($term_meta['sm_department_cover']) )? wp_get_attachment_image_url( $term_meta['sm_department_cover'][0], 'large' ) : '';
$dept_cover_style = ( !empty($dept_cover) )? sprintf(' style="background-color:transparent;background-image:url(%s);"', $dept_cover) : '';
?>

<header class="entry-header sm-header" <?php echo $dept_cover_style; ?>>
	<div class="sm-header-content">
		<ul class="breadcrumb-wrap">
			<li><a href="/departments">Departments</a></li>
		</ul>
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' );	?>
		<ul class="sm-header-nav nav nav-pills">
		  <li role="presentation" class="active"><a href="?syllabus_semester=fall-2017">Fall 2017</a></li>
		  <li role="presentation"><a href="?syllabus_semester=summer-2017">Summer 2017</a></li>
		  <li role="presentation"><a href="?syllabus_semester=spring-2017">Spring 2017</a></li>
		  <li role="presentation" class="link"><a href="<?php echo $dept_website; ?>" target="_blank">Website</a></li>
		</ul>
		<form class="search-form" role="search" style="width: 100%;">
			<label for="sm-search-filter" class="visuallyhidden sr-only">Search Courses</label>
			<input type="text" id="sm-search-filter" name="s" placeholder="Search">
			<button type="submit" class="btn-search">
				<span class="sr-only">Search</span>
				<span class="icon-svg">
					<svg>
					<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/wp-content/themes/ufclas-ufl-2015/img/spritemap.svg#search"></use>
					</svg>
				</span>
			</button>     
		</form>
	</div>
</header><!-- .entry-header -->
	
<section class="sm-container">
	
<?php 
	// Set up the default query to display courses
	
	if ( have_posts() ): ?>
	
	<table id="sm-archive-table" class="table table-hover syllabus-table">
		<thead>
		  <tr>
			<th class="syllabus-course"><?php _e('Course', 'syllabus-manager'); ?></th>
			<th class="syllabus-title"><?php _e('Title / Syllabus', 'syllabus-manager'); ?></th>
			<th class="syllabus-instruct"><?php _e('Instructor(s)', 'syllabus-manager'); ?></th>
			<th class="syllabus-level"><?php _e('Course Level', 'syllabus-manager'); ?></th>
			<th class="syllabus-semester"><?php _e('Semester', 'syllabus-manager'); ?></th>
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
		?>
		<tr>
			<td class="syllabus-course"><?php echo $course_code; ?></td>
			<td class="syllabus-title"><?php echo $syllabus_title; ?></td>
			<td class="syllabus-instruct">
				<?php
					// Display the taxonomy lists
					$term = 'syllabus_instruct';
					$term_list = get_the_term_list( get_the_ID(), $term, '<ul class="list-inline"><li>', ',</li><li>', '</li>' );
					echo ( !is_wp_error( $term_list ) )? $term_list : '<em>' . __('Not Available', 'syllabus-manager') . '</em>';	
				?>
			</td>
			<td class="syllabus-level">
				<?php
					// Display the taxonomy lists
					$term = 'syllabus_level';
					$term_list = get_the_term_list( get_the_ID(), $term, '<ul class="list-inline"><li>', ',</li><li>', '</li>' );
					echo ( !is_wp_error( $term_list ) )? $term_list : '<em>' . __('Not Available', 'syllabus-manager') . '</em>';	
				?>
			</td>
			<td class="syllabus-semester">
				<?php
					// Display the taxonomy lists
					$term = 'syllabus_semester';
					$term_list = get_the_term_list( get_the_ID(), $term, '<ul class="list-inline"><li>', ',</li><li>', '</li>' );
					echo ( !is_wp_error( $term_list ) )? $term_list : '<em>' . __('Not Available', 'syllabus-manager') . '</em>';	
				?>
			</td>
		</tr>
			<?php endwhile; // End of the loop. ?>
		</tbody>
		</table>
	
	<?php else: ?>
		<div><?php _e('No courses found.', 'Syllabus_Manager'); ?></div>
	<?php endif; ?>
</section> <!-- .sm-container -->