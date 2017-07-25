jQuery(function($){
	
});


var vm = new Vue({
    el: '#soc-courses',
    data: {
        panel_title: syllabus_manager_data.panel_title,
        departments: syllabus_manager_data.departments,
        courses: syllabus_manager_data.courses,
        publishedCourses: 0,
        notice_msg: '',
        notice_class: '',
        selected_department: '011690003',
        selected_semester: '20178',
        selected_level: 'UGRD',
    },
    computed: {
    },
    methods: {
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
    }
});
