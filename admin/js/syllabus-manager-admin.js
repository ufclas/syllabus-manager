(function ($) {
	'use strict';
	
	var $table = $('#soc-table').DataTable();
	
	$('#filter-form').submit(function (e) {
		e.preventDefault();
		
		// Gets values from form selects
		var dept = $('#filter-dept').val();
		var term = $('#filter-term').val();
		var level = $('#filter-level').val();
		
		console.log('dept: ' + dept + ', term: ' + term + ', level: ' + level);
		
		// Apply filters to table columns based on value
		
		
	});

})( jQuery );
