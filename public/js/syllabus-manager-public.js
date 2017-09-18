(function ($) {
	'use strict';
	
	$(function () {
		var table = $('#sm-archive-table').DataTable({
			"processing": true,
			"dom": "<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
		});
		
		// Use a custom search input
		$('#sm-search-filter').on('keyup', function () {
			table.search(this.value).draw();
		});
	});

})(jQuery);
