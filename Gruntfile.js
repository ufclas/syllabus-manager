module.exports = function (grunt) {
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		
		
		/**
		 * Sass tasks
		 */
		 sass: {
			dist: {
				options: {
					style: 'compressed'
				},
				files: {
					'public/css/syllabus-manager-public.css': 'public/sass/syllabus-manager-public.scss',
					'admin/css/syllabus-manager-admin.css': 'admin/sass/syllabus-manager-admin.scss'	
				}	
			}	 
		 },
		 
		 /**
		 * Autoprefixer
		 */
		 postcss: {
			options: {
				map: {
					inline: false	
				},
				processors: [
					require('autoprefixer')({browsers: ['last 2 versions']})
				]
			},
			// prefix all css files in the folders
			dist: {
				src: ['public/css/syllabus-manager-public.css','admin/css/syllabus-manager-admin.css']
			}	 
		 },
		
		/**
		 * Watch task
		 */
		 watch: {
			css: {
				files: ['public/**/*.scss', 'admin/**/*.scss'],
				tasks: ['sass','postcss']	
			}
		 }
	});
	
	grunt.loadNpmTasks('grunt-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.registerTask('default',['watch']);
};