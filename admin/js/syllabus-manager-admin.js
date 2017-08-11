jQuery(function($){
	
});


var vm = new Vue({
    el: '#sm-admin',
    data: {
        panel_title: syllabus_manager_data.panel_title,
        departments: syllabus_manager_data.departments,
        courses: syllabus_manager_data.courses,
        publishedCourses: 0,
        notice_msg: 'Default message to display for the notice.',
        notice_class: 'notice-info',
        selected_department: '011690003',
        selected_semester: '20178',
        selected_level: 'UGRD',
    },
    filters: {
		 /**
		 * Convert an array to a comma-separated string
		 * 
		 * @param array value
		 * @return string
		 */
		join: function (value) {
			return value.join(', ');
		},
		
		/**
		 * Convert term to appropriate string value
		 * 
		 * @param string value
		 * @param string type
		 * @return string
		 */
		formatTermValue: function (value, type) {
			if (type == 'level'){
				return 'Undergraduate';
			}
			else if (type == 'semester'){
				return 'Fall 2017';
			}
		}
	},
	methods: {
        /**
		 * Course title with added course code
		 * 
		 * @param object course
		 * @return string
		 */
		coursePanelTitle: function ( course ) {
			return course.course_code + ' ' + course.course_title;
		},
		
		/**
		 * Unique id for each course panel title, used for aria-labelledby
		 * 
		 * @param boolean isSelector Whether to add '#' to refer to the ID
		 * @return string
		 */
		coursePanelTitleID: function ( course, isSelector ) {
			var prefix = (isSelector)? '#' : '';
			return prefix + 'sm-course-heading-' + course.course_id;
		},
		
		/**
		 * Unique id for each course panel body, used for expand-collapse
		 * 
		 * @param boolean isSelector Whether to add '#' to refer to the ID
		 * @return string
		 */
		coursePanelID: function ( course, isSelector ) {
			var prefix = (isSelector)? '#' : '';
			return prefix + 'sm-course-panel-' + course.course_id;
		},
		
		sectionClassSuccess: function ( section ) {
			return (section.post_id != null);
		},
		add_syllabus: function ( id, event ) {
			// Update the button  while loading
			var course_data = this.courses[id];
			course_data.id = id;
			course_data.action = (!course_data.status)? 'add_syllabus':'remove_syllabus';
			course_data.department = this.selected_department;
			course_data.semester = this.selected_semester;
			course_data.level = this.selected_level;
			console.log(course_data);
			
			// Set status to a temporary value
			this.courses[id].status = '-1';
			
			// Send post data
			var post_data = {
                action: course_data.action,
                _ajax_nonce: syllabus_manager_data.ajax_nonce,
                course_data: course_data
            };
            
            jQuery.post( ajaxurl, post_data, function ( response ) {
				console.log(response);
				
				// Update counts, backgrounds, and button text
				if (response.success){
					this.courses[id].status = !post_data.status;
					this.publishedCourses++;
					this.notice_class = 'notice-success';
					this.notice_msg = response.data.msg;
				}
				else {
					this.courses[id].status = post_data.status;
					this.notice_class = 'notice-error';
				}
            }.bind(this), 'json');	
        }
    },
	beforeMount: function () {
		console.log(this.courses);
	}
});
