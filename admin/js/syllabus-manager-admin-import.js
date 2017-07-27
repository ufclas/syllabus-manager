var vm = new Vue({
	el: '#app',
	data: {
		selected_semester: '',
		selected_department: '',
		semesters: [
			{
				id: '20178',
				label: 'Fall 2017'
			},
			{
				id: '20175',
				label: 'Summer 2017'
			},
			{
				id: '20171',
				label: 'Spring 2017'
			}
		],
		departments: [
			{
				id: '011690003',
				label: 'Biology'
			},
			{
				id: '011606000',
				label: 'Chemistry'
			}
		],
		levels: [
			{
				id: 'ugrd',
				label: 'Undergraduate'
			},
			{
				id: 'grpr',
				label: 'Graduate / Professional'
			}
		]
	}
});
