jQuery(document).ready(function($) {


    // Form submission listener
    $('form#um_form .status_button').on('click',  function(e){
		  $('form#um_form p.stato').show().text(ajax_updatestatus_object.loadingmessage);
        // Grab our post meta value
        var um_val = $( '#um_form #um_key' ).val();

       $.ajax({
                url : ajax_updatestatus_object.ajaxurl,                 // Use our localized variable that holds the AJAX URL
                type: 'POST',  
				dataType: 'json',    // Declare our ajax submission method ( GET or POST )
                data: {                         // This is our data object
                    action  : 'ajaxupdatestatus',          // AJAX POST Action
                    'status': um_val,       // Replace `um_key` with your user_meta key name
                },
          success: function(data){
                if(data.type == "success"){
					$('form#um_form p.stato').removeAttr('class').addClass("status alert alert-success").html(data.message);
					/*$('form#um_form p.stato').text(data.message);*/
				$("#um_form")[0].reset();
				
				}else{
					$('form#um_form p.stato').removeAttr('class').addClass("status alert alert-danger").text(data.message);
					$("#um_form")[0].reset();
				}
          }
            });
              e.preventDefault();

       }); 

      
} );