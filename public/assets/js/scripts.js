$('[data-toggle=collapse]').click(function(){
	
  	// toggle icon
  	$(this).find("i").toggleClass("icon-angle-right icon-angle-down");
  
});

$('.collapse').on('show', function (e) {
  
  	// hide open menus
  	$('.collapse').each(function(){
      if ($(this).hasClass('in')) {
          $(this).collapse('toggle');
      }
    });
  
})


/*
$('#accordion a span').parent().click(function () {
if($('#accordion a span').hasClass('fa fa-chevron-down pull-right'))
{
   $('a').html('<span class="fa fa-chevron-up pull-right"></span> Close'); 
}
else
{      
    $('a').html('<span class="fa fa-chevron-down pull-right"></span> Open'); 
}
});
*/

$(document).ready(function(){
	ko.extenders.trackChange = function (target, track) {
	    if (track) {
	        target.isDirty = ko.observable(false);
	        target.originalValue = target();
	        
	        target.subscribe(function (newValue) {
	            // use != not !== so numbers will equate naturally
	            target.isDirty(newValue != target.originalValue);
	           
	        });
	    }
	    
	    return target;
	};
	
	$(document).ajaxError(function(event, data) {
		if (typeof data.error().responseJSON != 'undefined') {
			var error = data.error().responseJSON.error;
			
			showError(error);
		}
	});
});

function showAlert(status) {
	$('#message_container').html(
		'<div id="message" class="alert alert-' + (status.result == 0 ? 'success' : 'danger') + ' alert-dismissible" role="alert">' +
			'<button type="button" class="close" data-dismiss="alert">' +
				'<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>' +
			'</button>' + status.message +
		'</div>'
	);
	
	window.setTimeout(function() {
	    $("#message").fadeTo(1500, 0).slideUp(500, function() {
	        $(this).remove(); 
	    });
	}, 5000);
};

function showError(error) {
	$('#message_container').html(
		'<div id="message" class="alert alert-' + (status.result == 0 ? 'success' : 'danger') + ' alert-dismissible" role="alert">' +
			'<button type="button" class="close" data-dismiss="alert">' +
				'<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>' +
			'</button>' +
			'Type: ' + error.type + '<br/>' +
			'Message: ' + error.message + '<br/>' +
			'File: ' + error.file + '<br/>' +
			'Line: ' + error.line +
		'</div>'
	);
};