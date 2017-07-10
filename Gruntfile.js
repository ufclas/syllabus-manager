module.exports = function(grunt){
	
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),	
		
		
		/**
		 * Sass tasks
		 */
		 sass: {
			dist: {
				options: {
					style: 'compressed',
					sourcemap: true
				},
				files: {
					'public/css/syllabus-manager-public.css' : 'public/sass/syllabus-manager-public.scss',	
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
			// prefix all css files in the project root
			dist: {
				src: 'public/css/*.css'
			}	 
		 },
		
		/**
		 * Watch task
		 */
		 watch: {
			css: {
				files: ['**/*.scss'],
				tasks: ['sass','postcss']	
			}
		 }
	});
	
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-postcss');
	grunt.registerTask('default',['watch']);
};