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
			  <div class="sm-courses">
			  <div v-for="course in courses" class="sm-course">
			  	<div class="sm-course-code">{{course.course_code}}</div>
			  	<div class="sm-course-title">{{course.course_title}}</div>
			  	<div class="sm-course-status sm-no-data"><?php _e('Not Published', 'syllabus_manager'); ?></div>
			  	<div class="sm-course-arrow"><span class="glyphicon glyphicon-chevron-down"></span></div>
			  </div>
			  </div>

		  </div>
		</div>
	</div>

</div>