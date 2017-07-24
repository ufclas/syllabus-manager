var vm = new Vue({
    el: '#soc-courses',
    data: {
        panel_title: syllabus_manager_data.panel_title,
        departments: syllabus_manager_data.departments,
        courses: syllabus_manager_data.courses,
        publishedCourses: 0,
        notice_msg: '',
        notice_class: '',
        row_class: '',
        selectedDept: ''
    },
    computed: {
        totalCourses: function () {
            return this.courses.length;
        }
    },
    methods: {
        add_course: function ( id ) {
            this.notice_msg = 'Syllabus added for ' + id + ' !';
            this.notice_class = 'notice-success';
            this.row_class = 'bg-success';
            this.courses[id].status = 1;
            this.publishedCourses++;
        },
        edit_course: function ( id ) {
            this.notice_msg = '';
            this.row_class = '';
            this.courses[id].status = 0;
            this.publishedCourses--;
        },
        create_course: function ( id ) {
            var course_data = {
                action: 'create_course',
                _ajax_nonce: syllabus_manager_data.ajax_nonce,
                course_id: id,
                course_values: this.courses[id]
            };
            
            jQuery.post( ajaxurl, course_data, function ( response ) {
                console.log(response);
            }, 'json');
        }
    }
});
