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
<div id="soc-courses" class="wrap">
	<h1 class="wp-heading-inline"><?php _e('CLAS Syllabus Manager', 'syllabus-manager'); ?></h1>
	<hr class="wp-header-end">
	<br>
    
	<!--
	<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php _e('Course Filters', 'syllabus-manager'); ?></h3>
			</div>
			<div class="panel-body">
			<form id="filter-form" action="" method="post">

			<div class="form-group col-md-4">
				<label for="filter-dept" class="control-label"><?php _e('Departments', 'syllabus-manager'); ?></label>
				<?php 
					wp_dropdown_categories(array(
						'taxonomy' => 'syllabus_department',
						'hide_empty' => false,
						'value_field' => 'slug',
						'id' => 'filter-dept',
						'name' => 'filter-dept',
						'class' => 'form-control',
						'show_option_none' => __('Select Department', 'syllabus-manager'),
						'show_option_value' => '',
						'required' => true,
                        'v-model' => 'selectedDept'
					)); 
				 ?>
			 </div>
				
			<div class="form-group col-md-4">
				<label for="filter-term" class="control-label"><?php _e('Semester', 'syllabus-manager'); ?></label>
				<?php 
					wp_dropdown_categories(array(
						'taxonomy' => 'syllabus_semester',
						'hide_empty' => false,
						'value_field' => 'slug',
						'id' => 'filter-term',
						'name' => 'filter-term',
						'class' => 'form-control',
						'show_option_none' => __('Select Semester', 'syllabus-manager'),
						'show_option_value' => '',
						'required' => true,
					)); 
				 ?>
			</div>
				
			<div class="form-group col-md-4">
				<label for="filter-level" class="control-label"><?php _e('Program Level', 'syllabus-manager'); ?></label>
				<?php 
					wp_dropdown_categories(array(
						'taxonomy' => 'syllabus_level',
						'hide_empty' => false,
						'value_field' => 'slug',
						'id' => 'filter-level',
						'name' => 'filter-level',
						'class' => 'form-control',
						'show_option_none' => __('Select Program Level', 'syllabus-manager'),
						'show_option_value' => '',
						'required' => true,
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
	-->
	
    <div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><?php _e('Overview', 'syllabus-manager'); ?></h3>
			</div>
			<div class="panel-body">

			<div class="col-md-4">
				<span>Department</span>
				<h1>Biology (0%)</h1>
			 </div>
				
			<div class="col-md-4">
				<span>Current Semester</span>
				<h1>Fall 2017 (0%)</h1>
			</div>
				
			<div class="col-md-4">
				<span>Published Courses</span>
				<h1>{{publishedCourses}} (0%)</h1>
			  </div>
			
			</div>
		</div>
	</div>
	</div>
    
	<div class="row">
		<div class="col-md-12">
			<div id="soc-courses-panel" class="panel panel-default">
			  <div class="panel-heading">
				<h3 class="panel-title">{{panel_title}}</h3>
			  </div>
			  <div class="panel-body">
				<div class="notice" :class="notice_class">
                    <transition name="fade">
                        <p v-if="notice_msg">{{notice_msg}}</p>
                    </transition>
                </div>  
                <table id="soc-table" class="table table-striped">
					<thead>
						<tr><th>Course</th><th>Section</th><th>Course Title</th><th>Instructor(s)</th><th>Published Status</th><th>Actions</th></tr>
					</thead>
					<tbody>
						<tr v-for="(course, id, index) in courses" :class="{'bg-success': (course.status == 1)}">
                            <td class="course-code" :class="">{{course.code}}</td>
                            <td class="section-number" :class="">{{course.section_number}}</td>
                            <td class="title" :class="">{{course.title}}</td>
                            
                            <td class="instructors" :class="">
                                <span v-if="course.instructors">{{course.instructors}}</span>
                                <span v-else class="no-data"><?php _e('No instructors listed', 'syllabus_manager'); ?></span>
                            </td>
                            
                            <td class="status" :class="">
                                <span v-if="course.status"><?php _e('Published', 'syllabus_manager'); ?></span>
                                <span v-else class="no-data"><?php _e('Not Published', 'syllabus_manager'); ?></span>
                            </td>
                            
                            <td class="action" :class="">
                                <button 
									type="button" 
									@click="add_syllabus(id, $event)"  
									class="btn has-spinner" 
									:class="{'btn-success': course.status, active: -1 == course.status}"
									autocomplete="off">
									<span v-if="1 == course.status"><?php _e('Remove Syllabus', 'syllabus_manager'); ?></span>
									<span v-else-if="-1 == course.status"><span class="glyphicon glyphicon-repeat fast-right-spinner"></span> <?php _e('Loading...', 'syllabus_manager'); ?></span>
									<span v-else><?php _e('Add Syllabus', 'syllabus_manager'); ?></span>									
								</button>
                            </td>
                        </tr>
					</tbody>
				</table>
			  </div>
			</div>
		</div>
	</div>	

</div>