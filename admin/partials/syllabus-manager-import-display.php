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
	
	<div id="import-courses-row" class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<?php _e('Import Courses', 'syllabus-manager'); ?></h3>
		</div>
		<div class="panel-body">
			<form id="import-courses-form" method="post" class="col-md-6 col-sm-12">
			<div class="form-group">
				<label class="sr-only" for="import-course-source"><?php _e( 'Select Import Source: ', 'syllabus-manager' ); ?></label>
				<select id="import-course-source" name="import-course-source" class="form-control" required>
					<option value="uf-soc"><?php _e( 'UF Schedule of Courses', 'syllabus-manager' ); ?></option>
				</select>
				<span id="help-block-import-course-source" class="help-block"></span>
			</div>
			<div class="form-group">
				<label class="sr-only" for="import-course-semester"><?php _e( 'Semesters: ', 'syllabus-manager' ); ?></label><br>
				<?php wp_dropdown_categories( array( 
					'show_option_none' => __( 'Select a Semester', 'syllabus-manager' ), 
					'taxonomy' => 'syllabus_semester', 
					'name' => 'import-course-semester',
					'id' => 'import-course-semester',
					'class' => 'form-control',
					'required' => true,
					'orderby' => 'name',
					'hide_empty' => false,
				)); 
				?>
				<span id="help-block-import-course-semester" class="help-block"></span>
			</div>
			
			<div class="form-group">
				<label class="sr-only" for="import-course-department"><?php _e( 'Departments: ', 'syllabus-manager' ); ?></label><br>
				<?php wp_dropdown_categories( array( 
					'show_option_none' => __( 'Select a Department', 'syllabus-manager' ), 
					'taxonomy' => 'syllabus_department', 
					'name' => 'import-course-department',
					'id' => 'import-course-department',
					'class' => 'form-control',
					'required' => true,
					'orderby' => 'name',
					'hide_empty' => false,
				)); 
				?>
				<span id="help-block-import-course-department" class="help-block"></span>
			</div>
				
			<div class="form-group">
				<label class="sr-only" for="import-course-level"><?php _e( 'Program Levels: ', 'syllabus-manager' ); ?></label><br>
				<?php wp_dropdown_categories( array( 
					'show_option_none' => __( 'Select a Program Level', 'syllabus-manager' ), 
					'taxonomy' => 'syllabus_level', 
					'name' => 'import-course-level',
					'id' => 'import-course-level',
					'class' => 'form-control',
					'required' => true,
					'orderby' => 'name',
					'hide_empty' => false,
				)); 
				?>
				<span id="help-block-import-course-level" class="help-block"></span>
			</div>
			<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" id="import-course-update" name="import-course-update" value="1" /> Update existing courses</label>
			</div>
			</div>
				
			<input type="hidden" name="action" value="import_courses" />
			<?php wp_nonce_field('sm_import_courses', 'sm_import_courses_nonce'); ?>
			<?php submit_button( __( 'Import Courses', 'syllabus-manager' ), 'primary', 'submit', false); ?>
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
			<?php _e('Import Taxonomy Terms', 'syllabus-manager'); ?></h3>
		</div>
		<div class="panel-body">
		<div class="col-md-6 col-sm-12">
			
		<form id="import-taxonomy-form" method="post" enctype="multipart/form-data" action="">
			<div class="form-group">
				<label class="sr-only" for="import-source"><?php _e( 'Select Import Source: ', 'syllabus-manager' ); ?></label>
				<select id="import-source" name="import-source" class="form-control" aria-describedby="help-block-import-source" required>
					<!-- <option value=""><?php _e( 'Select Import Source', 'syllabus-manager' ); ?></option> -->
					<option value="uf-soc"><?php _e( 'UF Schedule of Courses', 'syllabus-manager' ); ?></option>
					<!--<option value="csv" class="text-muted"><?php _e( 'CSV', 'syllabus-manager' ); ?></option> -->
				</select>
				<span id="help-block-import-source" class="help-block"></span>
			</div>
			<div class="form-group">
				<label class="sr-only" for="import-taxonomy"><?php _e( 'Filter Name: ', 'syllabus-manager' ); ?></label>
				<select id="import-taxonomy" name="import-taxonomy" class="form-control" aria-describedby="help-block-import-taxonomy" required>
					<option value="syllabus_department"><?php _e( 'Departments', 'syllabus-manager' ); ?></option>
					<option value="syllabus_semester"><?php _e( 'Semesters', 'syllabus-manager' ); ?></option>
					<option value="syllabus_level"><?php _e( 'Program Levels', 'syllabus-manager' ); ?></option>
				</select>
				<span id="help-block-import-taxonomy" class="help-block"></span>
				
			</div>
			<!--
			<div class="form-group">
				<label for="import-filter-file" class="sr-only"><?php _e( 'Choose a file:', 'syllabus-manager' ); ?></label><br />
				<input type="file" id="import-filter-file" name="import-filter-file" accept=".json, .csv" aria-describedby="help-block-import-filter-file" />
				<span id="help-block-import-filter-file" class="help-block"></span>
			</div>
			-->
			<div class="form-group">
			<div class="checkbox">
				<label><input type="checkbox" id="import-update" name="import-update" value="1" /> Update existing terms</label>
			</div>
			</div>
			
			<input type="hidden" name="action" value="import_taxonomies" />
			<?php wp_nonce_field('sm_import_taxonomies', 'sm_import_taxonomies_nonce'); ?>
			<?php submit_button( __( 'Import Terms', 'syllabus-manager' ), 'primary', 'submit', false); ?>
		</form>
		</div>

		</div>
		</div>
	</div>
	</div><!-- import-taxonomies row -->
	
</div>