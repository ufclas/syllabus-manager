<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://it.clas.ufl.edu/
 * @since      0.0.0
 *
 * @package    Syllabus_Manager
 * @subpackage Syllabus_Manager/admin/partials
 */

if ( !current_user_can( 'manage_options' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
	<h1 class="wp-heading-inline"><?php _e('CLAS Syllabus Manager', 'syllabus-manager'); ?></h1>
	<hr class="wp-header-end">
	<br>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">
				<!-- <span class="glyphicon glyphicon-book" aria-hidden="true"></span> -->
				<?php _e('Schedule of Courses', 'syllabus-manager'); ?></h3>
			  </div>
			  <div class="panel-body">
				<table id="soc-table" class="table table-striped">
					<thead>
						<tr><th>Course</th><th>Section</th><th>Course Title</th><th>Level</th><th>Meet Times</th><th>Instructor(s)</th><th>Status</th><th>Actions</th></tr>
					</thead>
					<tbody></tbody>
				</table>
			  </div>
			</div>
		</div>
	</div>	

	<div id="ajax-response"></div>
	<br class="clear">
</div>