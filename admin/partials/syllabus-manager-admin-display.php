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

if ( !current_user_can( 'sm_manage_syllabus_manager' ) )  {
	wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div id="sm-admin" class="wrap">
	<h1 class="wp-heading-inline"><?php _e('CLAS Syllabus Manager', 'syllabus-manager'); ?></h1>
	<hr class="wp-header-end">
	<div class="notice" :class="notice_class">
		<transition name="fade">
			<p v-if="notice_msg">{{notice_msg}}</p>
		</transition>
	</div>  
    <div class="row">
		<div class="col-md-4">
		<div class="panel panel-default sm-card">
			<div class="panel-heading sr-only">
				<h3 class="panel-title"><?php _e('Department', 'syllabus-manager'); ?></h3>
			</div>
			<div class="panel-body">
				<div class="sm-card-icon">
					<span class="glyphicon glyphicon-blackboard" aria-hidden="true"></span>
				</div>
				<div class="sm-card-desc">
					<h4 class="sm-card-title">Department</h4>
					<p class="sm-card-info">Biology <span class="badge">60%</span></p>
				</div>
			</div>
		</div>
		</div>
			<div class="col-md-4">
		<div class="panel panel-default sm-card">
			<div class="panel-heading sr-only">
				<h3 class="panel-title"><?php _e('Semester', 'syllabus-manager'); ?></h3>
			</div>
			<div class="panel-body">
				
				<div class="sm-card-icon">
					<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
				</div>
				<div class="sm-card-desc">
					<h4 class="sm-card-title">Current Semester</h4>
					<p class="sm-card-info">Fall 2017 <span class="badge">60%</span></p>
				</div>
			</div>
		</div>
		</div>
		<div class="col-md-4">
		<div class="panel panel-default sm-card">
			<div class="panel-heading sr-only">
				<h3 class="panel-title"><?php _e('Status', 'syllabus-manager'); ?></h3>
			</div>
			<div class="panel-body">
				<div class="sm-card-icon">
					<span class="glyphicon glyphicon-book" aria-hidden="true"></span>
				</div>
				<div class="sm-card-desc">
					<h4 class="sm-card-title">Program Level</h4>
					<p class="sm-card-info">Undergraduate <span class="badge">60%</span></p>
			</div>
		</div>
		</div>
	</div>
  
	
	<div class="col-md-12">
		<div id="sm-admin-courses" class="panel">
		  <div class="panel-heading">
			<h3 class="panel-title">{{panel_title}}</h3>
		  </div>
		  <div class="panel-body">
			  
			  <div id="sm-courses-group" class="sm-courses panel-group" role="tablist" aria-multiselectable="true">
			  <div v-for="course in courses" class="sm-course panel panel-default">
			  	<div v-bind:id="coursePanelTitleID(course)" class="panel-heading" role="tab">
					<h4 class="panel-title">
						<a v-bind:href="coursePanelID(course, true)" 
						   class="collapsed" 
						   data-toggle="collapse" 
						   role="button" 
						   aria-expanded="false" 
						   aria-controls="coursePanelID(course)">{{coursePanelTitle(course)}}</a>
					</h4>
				</div>
				<div v-bind:id="coursePanelID(course)" 
					 class="panel-collapse collapse" 
					 role="tabpanel" 
					 aria-labelledby="coursePanelTitleID(course)">
					<div class="panel-body">
						<div v-for="section in course.sections" class="sm-sections">
							<div class="sm-section-row">
							<div class="sm-section-coursecode sm-section">{{course.course_code}}</div>
							<div class="sm-section-coursetitle sm-section">{{course.course_title}}</div>
							<div class="sm-section-code sm-section">{{section.section_code}}</div>
							<div class="sm-section-instruct sm-section">
								<span v-if="section.instructors[0] != ''">{{section.instructors | join}}</span>
								<span v-else class="sm-no-data"><?php _e('No instructors', 'syllabus_manager'); ?></span>
							</div>
							<div class="sm-section-level sm-section">{{ selected_level | formatTermValue('level') }}</div>
							<div class="sm-section-semester sm-section">{{ selected_level | formatTermValue('semester') }}</div>
							<div class="sm-section-status sm-section">
								<span class="sm-no-data"><?php _e('Not Published', 'syllabus_manager'); ?></span>
							</div>
							<div class="sm-section-action sm-section">
								<button 
									type="button" 
									@click="add_syllabus(section, $event)" 
									class="btn btn-primary has-spinner" 
									autocomplete="off">
									<span v-if="false"><?php _e('Remove Syllabus', 'syllabus_manager'); ?></span>
									<span v-else-if="false"><span class="glyphicon glyphicon-repeat fast-right-spinner"></span> <?php _e('Loading...', 'syllabus_manager'); ?></span>
									<span v-else><?php _e('Add Syllabus', 'syllabus_manager'); ?></span>									
								</button>
							</div>
							</div>
						</div>
					</div>	
				</div>
			  </div>
			  </div>

		  </div>
		</div>
	</div>

</div>