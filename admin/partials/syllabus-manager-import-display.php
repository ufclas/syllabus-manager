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
<div id="app" class="wrap">
	<h1 class="wp-heading-inline"><?php _e('Import', 'syllabus-manager'); ?></h1>
	<hr class="wp-header-end">
	<br>
	
	<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<?php _e('Import Filters', 'syllabus-manager'); ?></h3>
		</div>
		<div class="panel-body">
		<div class="ow">
		<div class="col-md-6 col-sm-12">
		
		<form id="filters-upload" method="post" enctype="multipart/form-data" action="">
			<div class="form-group">
				<label class="sr-only" for="import-name"><?php _e( 'Filter Name: ', 'syllabus_manager' ); ?></label>
				<select id="import-name" name="import-name" class="form-control" required>
					<option value="departments"><?php _e( 'Departments', 'syllabus_manager' ); ?></option>
					<option value="terms"><?php _e( 'Terms', 'syllabus_manager' ); ?></option>
					<option value="progLevels"><?php _e( 'Course Levels', 'syllabus_manager' ); ?></option>
				</select>
			</div>
			
			<div class="form-group">
				<label for="import-filter-file" class="sr-only"><?php _e( 'Choose a .json file:', 'syllabus_manager' ); ?></label><br />
				<input type="file" id="import-filter-file" name="import-filter-file" accept=".json" required />
			</div>
			
			<input type="hidden" name="action" value="filter" />
			<?php wp_nonce_field('sm_import_filters', 'sm_import_filters_nonce'); ?>
			<?php submit_button( __( 'Import File', 'syllabus-manager' ), 'primary', 'submit', false); ?>
		</form>
		</div>
		</div>

		</div>
		</div>
	</div>
	</div>
	
	
	<div id="create-courses-row" class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<?php _e('Create Courses', 'syllabus-manager'); ?></h3>
		</div>
		<div class="panel-body">
			<form id="create-courses-form" method="post">
			
			<div class="form-group">
				<label class="sr-only" for="create-semester"><?php _e( 'Semesters: ', 'syllabus_manager' ); ?></label><br>
				<select id="create-semester" name="semester" class="form-control" required>
					<option value=""><?php _e( 'Select a Semester', 'syllabus_manager' ); ?></option>
					<option v-for="option in semesters" :value="option.id">{{option.label}}</option>
				</select>
			</div>
			
			<div class="form-group">
				<label class="sr-only" for="create-departments"><?php _e( 'Departments: ', 'syllabus_manager' ); ?></label><br>
				<select id="create-department" name="department" class="form-control"  required>
					<option value=""><?php _e( 'Select a Department', 'syllabus_manager' ); ?></option>
					<option v-for="option in departments" :value="option.id">{{option.label}}</option>
				</select>
			</div>
				
			<div class="form-group">
				<label class="sr-only" for="create-level"><?php _e( 'Levels: ', 'syllabus_manager' ); ?></label><br>
				<select id="create-level" name="level" class="form-control"  required>
					<option value=""><?php _e( 'Select a Program Level', 'syllabus_manager' ); ?></option>
					<option v-for="option in levels" :value="option.id">{{option.label}}</option>
				</select>
			</div>
			
			<input type="hidden" name="action" value="create" />
			<?php wp_nonce_field('sm_create_courses', 'sm_create_courses_nonce'); ?>
			<?php submit_button( __( 'Create Courses', 'syllabus-manager' ), 'primary', 'submit', false); ?>
		</form>
		</div><!-- .panel-body -->
		</div><!-- .panel -->
	</div>
	</div>
	
	
	<div id="update-courses-row" class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php _e('Update Courses from Source', 'syllabus-manager'); ?>
			</h3>
		</div>
		<div class="panel-body">
		<div class="col-md-6 col-sm-12">
		<form id="update-courses-form" method="post">
			
			<div class="form-group" class="col-md-4 col-sm-12">
				<label class="sr-only" for="update-semester"><?php _e( 'Semesters: ', 'syllabus_manager' ); ?></label><br>
				<select id="update-semester" name="semester" class="form-control" required>
					<option value=""><?php _e( 'Select a Semester', 'syllabus_manager' ); ?></option>
					<option v-for="option in semesters" :value="option.id">{{option.label}}</option>
				</select>
			</div>
			
			<div class="form-group" class="col-md-4 col-sm-12">
				<label class="sr-only" for="update-departments"><?php _e( 'Departments: ', 'syllabus_manager' ); ?></label><br>
				<select id="update-department" name="department" class="form-control"  required>
					<option value=""><?php _e( 'Select a Department', 'syllabus_manager' ); ?></option>
					<option v-for="option in departments" :value="option.id">{{option.label}}</option>
				</select>
			</div>
			
			<div class="form-group" class="col-md-4 col-sm-12">
				<label class="sr-only" for="update-level"><?php _e( 'Levels: ', 'syllabus_manager' ); ?></label><br>
				<select id="update-level" name="level" class="form-control"  required>
					<option value=""><?php _e( 'Select a Program Level', 'syllabus_manager' ); ?></option>
					<option v-for="option in levels" :value="option.id">{{option.label}}</option>
				</select>
			</div>
			
			<input type="hidden" name="action" value="update" />
			<?php wp_nonce_field('sm_update_courses', 'sm_update_courses_nonce'); ?>
			<?php submit_button( __( 'Update Courses', 'syllabus-manager' ), 'primary', 'submit', false); ?>
		</form>
		</div>
		</div><!-- .panel-body -->
		</div><!-- .panel -->
	</div>
</div><!-- #update-courses-row -->
	
</div>