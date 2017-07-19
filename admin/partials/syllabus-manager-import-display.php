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
			
			<input type="hidden" name="action" value"import-filter" />
			<?php wp_nonce_field('syllabus-manager-import', 'wpnonce_syllabus_manager_import' ); ?>
			<?php submit_button( __( 'Import File', 'syllabus-manager' ), 'primary', 'submit', false); ?>
		</form>
		</div>
		</div>

		</div>
		</div>
	</div>
</div>