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

if ( !current_user_can( 'sm_import_syllabus_manager' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="app" class="wrap">
	<h1 class="wp-heading-inline"><?php _e('Import', 'syllabus-manager'); ?></h1>
	<hr class="wp-header-end">
	<br>
	
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
	</div><!-- import-courses row -->
	
	<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<?php _e('Import Course Taxonomies', 'syllabus-manager'); ?></h3>
		</div>
		<div class="panel-body">
		<div class="col-md-6 col-sm-12">
			
		<form id="filters-upload" method="post" enctype="multipart/form-data" action="">
			<div class="form-group">
				<label class="sr-only" for="import-source"><?php _e( 'Select Import Source: ', 'syllabus_manager' ); ?></label>
				<select id="import-source" name="import-source" class="form-control" aria-describedby="help-block-import-source" required>
					<!-- <option value=""><?php _e( 'Select Import Source', 'syllabus_manager' ); ?></option> -->
					<option value="uf-soc"><?php _e( 'UF Schedule of Courses', 'syllabus_manager' ); ?></option>
					<!--<option value="csv" class="text-muted"><?php _e( 'CSV', 'syllabus_manager' ); ?></option> -->
				</select>
				<span id="help-block-import-source" class="help-block"></span>
			</div>
			<div class="form-group">
				<label class="sr-only" for="import-taxonomy"><?php _e( 'Filter Name: ', 'syllabus_manager' ); ?></label>
				<select id="import-taxonomy" name="import-taxonomy" class="form-control" aria-describedby="help-block-import-taxonomy" required>
					<option value="syllabus_department"><?php _e( 'Departments', 'syllabus_manager' ); ?></option>
					<option value="syllabus_semester"><?php _e( 'Semesters', 'syllabus_manager' ); ?></option>
					<option value="syllabus_level"><?php _e( 'Program Levels', 'syllabus_manager' ); ?></option>
				</select>
				<span id="help-block-import-taxonomy" class="help-block"></span>
				
			</div>
			<!--
			<div class="form-group">
				<label for="import-filter-file" class="sr-only"><?php _e( 'Choose a file:', 'syllabus_manager' ); ?></label><br />
				<input type="file" id="import-filter-file" name="import-filter-file" accept=".json, .csv" aria-describedby="help-block-import-filter-file" />
				<span id="help-block-import-filter-file" class="help-block"></span>
			</div>
			-->
			<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" id="import_update" name="import-update" value="1" /> Update existing terms</label>
			</div>
			</div>
			
			<input type="hidden" name="action" value="import_taxonomies" />
			<?php wp_nonce_field('sm_import_taxonomies', 'sm_import_taxonomies_nonce'); ?>
			<?php submit_button( __( 'Import', 'syllabus-manager' ), 'primary', 'submit', false); ?>
		</form>
		</div>

		</div>
		</div>
	</div>
	</div><!-- import-taxonomies row -->
	
</div>