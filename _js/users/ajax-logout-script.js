jQuery(document).ready(function(){
	$(document).on('click','#logout_btn', function(e) {
	e.preventDefault();
	$.ajax({
		type: 'POST',
		url: ajax_object.ajax_url,
		data: {
			'action': 'custom_ajax_logout', //calls wp_ajax_nopriv_ajaxlogout
			'ajaxsecurity': ajax_object.logout_nonce
		},
		success: function(r){
			$('#login_btn').css('display','block');
			$('#login_btn .elementor-button-link').attr('href','#elementor-action%3Aaction%3Dpopup%3Aopen%26settings%3DeyJpZCI6IjE3MzAiLCJ0b2dnbGUiOmZhbHNlfQ%3D%3D');
			$('#profile_btn').css('display','none');
			$('#logout_btn').css('display','none');
		}
	});
});
});

