var vm = new Vue({
    el: '#soc-courses-panel',
    data: {
        panel_title: syllabus_manager_data.panel_title,
        departments: syllabus_manager_data.departments,
        courses: syllabus_manager_data.courses,
        notice_msg: '',
        notice_class: '',
        row_class: ''
    },
    methods: {
        add_course: function ( id ) {
            this.notice_msg = 'Syllabus added for ' + id + ' !';
            this.notice_class = 'notice-success';
            this.row_class = 'bg-success';
            this.courses[id].status = 1;
        },
        edit_course: function ( id ) {
            this.notice_msg = '';
            this.row_class = '';
            this.courses[id].status = 0;
        }
    }
});
