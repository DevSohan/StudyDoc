jQuery(document).ready(function($) {
	
	$('#permission_form').submit(function(e){
		e.preventDefault();
		
		var permission = $('input[id="input-grant-permission"]:checked').val();
		
		if(permission == ''){
			$('.status').addClass('text-danger');
			$('.status').text('Die Erlaubnis muss erteilt werden');
			$('.status').show();
		} else {
			$('.status').hide();
			if(permission != 'POK'){
				$('.status').addClass('text-danger');
				$('.status').text('Ungültige Eingabe');
				$('.status').show();
			} else{
				$('.status').hide();
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: ajax_student_permission_object.ajaxurl,
					data: {
						'action': 'student_permission', //calls wp_ajax_nopriv_ajaxlogin
						'permission': permission },
					success: function(data){
						if(data.type == "success"){
							$('.status').addClass('text-success');
							$('.status').text(data.message);
							$('.status').show();
							setTimeout(function(){ $('.status').hide(); }, 1000);
							location.reload();
						}else{
							$('.status').addClass('text-danger');
							$('.status').text(data.message);
							$('.status').show();
						}
					}
				});
			}
		}
		
		
	});
	
	
});