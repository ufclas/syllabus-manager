var vm = new Vue({
	el: '#vue-import',
	data: {
		msg: 'Learning Vue.js',
		url: 'https://www.lynda.com/JavaScript-tutorials/Learning-Vue-js/562924-2.html',
		email: '',
		selectedInterests: [],
		interests: ['Running', 'Cycling', 'Swimming', 'Tennis'],
		selectedDepartment: '',
		departments: [
			{
				id: 1,
				name: 'Anthropology'
			},
			{
				id: 2,
				name: 'Biology'
			},
			{
				id: 3,
				name: 'Chemistry'
			},
			{
				id: 4,
				name: 'Languages'
			},
			{
				id: 5,
				name: 'Statistics'
			}
		],
		fancyDiv: {
			padding: '10px 15px',
			color: '#00f'
		},
		fancierDiv: {
			'font-size': '24px',
			'font-style': 'italic',
			'text-transform': 'uppercase'
		}
	},
	methods: {
		subscribe: function () {
			this.msg = 'You just subscribed!';
		}
	}
});