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
	
	<div class="row">
	<div class="col-md-12">
		<div id="vue-import" class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<?php _e('Vue.js Test', 'syllabus-manager'); ?></h3>
		</div>
		<div class="panel-body">
		<div class="col-md-6 col-sm-12">
		<p class="bg-info" :class="{'bg-info': true}" :style="fancyDiv">{{msg}}</p>
		<p><a v-bind:href="url">View Source</a></p>
		<form>
			<div class="form-group">
				<label for="email" class="control-label">Email</label>
				<input type="email" id="email" v-model.lazy="email" class="form-control" aria-describedby="email-help">
				<span v-show="email.length > 3" id="email-help" class="help-block">You entered: {{email}}.</span>
			</div>
			<div class="form-group">
				<fieldset>
					<legend>Interests</legend>
					<div v-for="interest in interests">
						<div class="checkbox"><label><input type="checkbox" v-model="selectedInterests" v-bind:value="interest"> {{interest}}</label></div>
					</div>
					<span v-if="selectedInterests.length == 0" id="interests-help" class="help-block">Select at least one interest.</span>
					<span v-else-if="selectedInterests.length >= 3" id="interests-help" class="help-block">You're very active !</span>
					<span v-else>You selected: {{selectedInterests.join(', ')}}.</span>
				</fieldset>
			</div>
			<div class="form-group">
				<label for="dept-dropdown" class="control-label">Departments</label>
				<select v-model="selectedDepartment" id="dept-dropdown" class="form-control">
					<option v-for="dept in departments" v-bind:value="dept.id">{{dept.name}}</option>
				</select>
				<span v-show="selectedDepartment" class="help-block">You selected: {{selectedDepartment}}.</span>
			</div>
			<button v-on:click.prevent="subscribe" class="btn btn-primary">Subscribe</button>
		</form>
		</div>
		</div>
		</div>
	</div>
	</div>