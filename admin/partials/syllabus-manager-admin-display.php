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
				<h3 class="panel-title"><?php _e('Course Filters', 'syllabus-manager'); ?></h3>
			</div>
			<div class="panel-body">
			<form>

			<div class="form-group col-md-4">
				<label for="filter-dept" class="control-label">Departments: </label>
				<?php 
					wp_dropdown_categories(array(
						'taxonomy' => 'syllabus_department',
						'hide_empty' => false,
						'value_field' => 'slug',
						'id' => 'filter-dept',
						'name' => 'filter-dept',
						'class' => 'form-control',
					)); 
				 ?>
			 </div>
				
			<div class="form-group col-md-4">
				<label for="filter-term" class="control-label">Term: </label>
				<?php 
					wp_dropdown_categories(array(
						'taxonomy' => 'syllabus_term',
						'hide_empty' => false,
						'value_field' => 'slug',
						'id' => 'filter-term',
						'name' => 'filter-term',
						'class' => 'form-control',
					)); 
				 ?>
			</div>
				
			<div class="form-group col-md-4">
				<label for="filter-level" class="control-label">Course Level: </label>
				<?php 
					wp_dropdown_categories(array(
						'taxonomy' => 'syllabus_level',
						'hide_empty' => false,
						'value_field' => 'slug',
						'id' => 'filter-level',
						'name' => 'filter-level',
						'class' => 'form-control',
					)); 
				 ?>
			  </div>
			  <div class="form-group col-md-12">
					<button type="submit" class="btn btn-default">Apply Filters</button>
				</div>
			
			</form>
			</div>
		</div>
	</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">
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

</div>