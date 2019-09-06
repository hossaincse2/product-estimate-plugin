(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function() {
		$('#estimate').DataTable( {
			"order": [[ 3, "desc" ]]
		} );
	} );

	$(document).on('click', '.estimateDelete', function (e) {
		e.preventDefault();
		// var userId = $('#userId').val(); 
		var id = $(this).attr("data-id");
		var nonce = $(this).attr("data-nonce");
		var $tr = $(this).closest('tr');
  
		var data = {
		  'action': 'estimate_delete',
		  'nonce': nonce,
		  'estimateId': id,
		};
		// since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
		jQuery.post(ajax_object.ajax_url, data, function (response) {
		  // alert('Got this from the server: ' + response);
		  if (response) {
			$tr.find('td').fadeOut(1000, function () {
			  $tr.remove();
			});
		  }
  
		});
	  });
	   // Add Color Picker to all inputs that have 'color-field' class
		 $(function() {
			$('#barColor').wpColorPicker();
			$('#font_color').wpColorPicker();
			$('#button_color').wpColorPicker();
			$('#hover_color').wpColorPicker();
	});

})( jQuery );
