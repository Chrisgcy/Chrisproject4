
$(function () {
	'use strict';
	
	// Initialize the jQuery File Upload widget:
	$('#fileupload').fileupload({
		// Uncomment the following to send cross-domain cookies:
		//xhrFields: {withCredentials: true},
		url: 'fileuploadhandler.php',
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|mp4|mp3)$/i,
        maxFileSize: 2000000,
        maxNumberOfFiles: 1,
	}).on('fileuploadalways', function (e, data) {
        //alert("fff"+JSON.stringify(data));
        location.reload();
    }).on('fileuploadadd', function (e, data) {
        $('#addfilebtn').addClass('disabled').find('span').text('Selected');
    });
	
	// Enable iframe cross-domain access via redirect option:
	$('#fileupload').fileupload(
		'option',
		'redirect',
		window.location.href.replace(
			/\/[^\/]*$/,
			'/cors/result.html?%s'
		)
	);
	
	if (window.location.hostname === 'blueimp.github.io') {
		// Demo settings:
	} else {
		// Load existing files:
		$('#fileupload').addClass('fileupload-processing');
	    $.ajax({
		    // Uncomment the following to send cross-domain cookies:
		    //xhrFields: {withCredentials: true},
	        //url: $('#fileupload').fileupload('option', 'url'),
		    url: 'server/php/',
	        dataType: 'json',
	        context: $('#fileupload')[0]
	    }).always(function () {
            //alert('alw');
            $(this).removeClass('fileupload-processing');
	    }).done(function (result) {
            //alert(JSON.stringify(result));
		    $(this)
				.fileupload('option', 'done')
				.call(this, $.Event('done'), {result: result});
		}).success(function () {
            //alert('s');
		}).error(function () {
            //alert('err');
		});
	}
});

