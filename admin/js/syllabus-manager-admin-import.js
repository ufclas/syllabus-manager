jQuery(function($){
	
	// Only show the upload option for correct sources
	
	var $importUploadField = $('#import-filter-file');
	var $importSourceField = $('#import-source');
	
	$importSourceField.change(function () {
		var selectName = $(this).prop('name');
		
		// Warn about unimplemented features
		if ($(this).val() == 'csv') {
			$(this).parent('.form-group').addClass('has-error', true);
			$('span#help-block-' + selectName).text("Sorry, this feature has not been fully implemented.");
		}
		else {
			$(this).parent('.form-group').removeClass('has-error');
			$('span#help-block-' + selectName).text('');
		}
		
		// Determine the visibility of the file upload field
		if ($(this).val() == 'csv') {
			$importUploadField.fadeIn('slow');
			$importUploadField.prop('required', 'required');
		}
		else {
			$importUploadField.fadeOut('slow');
			$importUploadField.removeProp('required');
		}
	});
	
	// Check upload field when page loads
	$importUploadField.hide();
	$importSourceField.trigger('change');
});
