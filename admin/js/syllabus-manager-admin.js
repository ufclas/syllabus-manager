(function ($) {
	'use strict';
	
	var $table = $('#soc-table').DataTable();
	
	$('#filter-dept').val('011690003');
	$('#filter-term').val('20178');
	$('#filter-level').val('ugrd');
	
	$('#filter-form').submit(function (e) {
		e.preventDefault();
		
	}); 
	
	
})( jQuery );
