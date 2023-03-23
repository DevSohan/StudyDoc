jQuery(document).ready(function($) {

	$('#resetform .submit_button').on('click',  function(e){
			var datas = $("#resetform").serialize();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: ajax_resetpass_object.ajaxurl,
				data: {
					'action': 'ajaxresetpass', //calls wp_ajax_nopriv_ajaxlogin
					'datas': datas},
				success: function(data){
					if(data.type == "success"){
						$('#resetform p.status').removeAttr('class').addClass("status alert alert-success").text(data.message);
						setTimeout(function(){ window.location.href = 'https://studydoc.de/profil/'; },1000);
					}else{
						$('#resetform p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();
		});

});