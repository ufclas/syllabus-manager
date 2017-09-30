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
				id: 'biology',
				label: 'Biology'
			},
			{
				id: 'languages',
				label: 'Languages'
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
