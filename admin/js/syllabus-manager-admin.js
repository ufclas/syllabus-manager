(function( $ ) {
	'use strict';
	
	// Create the data object to pass 
	var data = {};
	data['action'] = syllabus_manager_data.action;
	data[syllabus_manager_data.nonce_name] = syllabus_manager_data.nonce_value;
	
	if ( adminpage == 'toplevel_page_syllabus-manager' ) {
		// use WordPress to fatch the data
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: data
		})
		.done( function(response){
			// Initialize dataTable, use array as the data source
			var responseData = JSON.parse(response);

			$('#soc-table').DataTable({
				data: responseData
			});
		});
	}

})( jQuery );
