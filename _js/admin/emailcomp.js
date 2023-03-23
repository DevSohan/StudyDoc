jQuery(document).ready(function($) {
	$('.view').on('click', function(e) {
		var emailid=$(this).attr("data-emailid");
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_emailview_object.ajaxurl,
			data: {'action': 'ajaxemailview',
				   'emailid': emailid},
			success: function(data){

				$('#viewEmailModal .mail-body').html(data.message);


			}
		});
		e.preventDefault();
	});

	$('#emailComp #template').on('change', function (e) {
		var optionSelected = $("option:selected", this);
		var valueSelected = this.value;
		if(valueSelected == "--"){
			$('#emailComp #subjects').val("");
			tinymce.get("messagetext").setContent("");
			return;
		}
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_settemp_object.ajaxurl,
			data: {'action': 'ajaxsettemp',
				   'id': valueSelected},
			success: function(data){
				$('#emailComp #subjects').val(data.subject);
				tinymce.get("messagetext").setContent(data.content);
			}
		});
		e.preventDefault();
	});

	$('form#emailComp .email_button').on('click',  function(e){
		$('#emailComp p.status').show().removeAttr('class').addClass("status alert alert-warning").text(ajax_emailComp_object.loadingmessage);

		var form_data = new FormData();
		var attachment_count = $('#attachments').prop('files').length;
		if(attachment_count != 0){
			for (var x = 0; x < attachment_count; x++) {
				form_data.append("attachments[]", $('#attachments').prop('files')[x]);
			}
		}

		form_data.append('action', 'ajaxemailComp');
		form_data.append('email', $('#emailComp #email').val());
		form_data.append('subjects', $('#emailComp #subjects').val());
		form_data.append('messagetext', tinymce.get('messagetext').getContent());

		$.ajax({
			type: 'POST',
			dataType: 'json',
			cache: false,
			url: ajax_emailComp_object.ajaxurl,
			contentType: false,
			processData: false,
			data: form_data, 
			success: (data) => {
				$('#emailComp p.status').removeAttr('class').addClass("status alert alert-success").html('');
				if (data.type == "success") {
					$.each( data.mail_list, function( key, value ) {
						//alert( key + ": " + value );
						$('#emailComp p.status').append(value + ': ' + key + '<br>');
					});
					tinymce.get("messagetext").setContent("");
					$('#emailComp')[0].reset();
				} else {
					$('#emailComp p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);

				}
			}
		});

		e.preventDefault();

	});

	$('#email-template .email_button').on('click',  function(e){
		//$('#email-template .status').show().removeAttr('class').addClass("status alert alert-warning").text(ajax_emailComp_object.loadingmessage);

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_emailtemp_object.ajaxurl,
			data: {
				'action': 'ajaxemailtemp', //calls wp_ajax_nopriv_ajaxlogin
				'name': $('#email-template #tempalte_name').val(),
				'subject': $('#email-template #tempalte_subject').val(),
				'content': tinymce.get('template_content').getContent()
			}, 
			success: (data) => {
				if (data.type == "success") {
					$('#email-template .status').removeAttr('class').addClass("status alert alert-success").text(data.message);
					setTimeout(function(){ $('#email-template .status').fadeOut(); },2000);
					var table = $('.table_vorlagen');
					var tablebody = $('.table_vorlagen tbody');
					if(table.length != 0){
						$('.table_vorlagen tbody').append(data.content);
					}else{
						$(".emails_templates .status").remove();
						$(".emails_templates").append("<div><h2>Vorlagen</h2><table class=\"table_vorlagen table table-striped\"><thead><tr><th>Namen</th><th style=\"text-align: center;\">Aktion</th></tr></thead><tbody>" + data.content + "</tbody></table><div>");
					}
					tinymce.get("template_content").setContent("");
					$('#email-template')[0].reset();
				} else {
					$('#email-template .status').removeAttr('class').addClass("status alert alert-danger").text(data.message);

				}
			}
		});

		e.preventDefault();

	});

	$('.table_vorlagen .edit').on('click',  function(e){
		var id = $(this).attr("data-id");

		$('#template_update #tempalte_update_name').val("");
		$('#template_update #tempalte_update_subject').val("");
		tinymce.get("template_update_content").setContent("");
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_tempedit_object.ajaxurl,
			data: {
				'action': 'ajaxtempedit', //calls wp_ajax_nopriv_ajaxlogin
				'id': id
			}, 
			success: (data) => {
				if (data.type == "success") {
					$('#template_update #tempalte_update_name').val(data.name);
					$('#template_update #tempalte_update_subject').val(data.subject);
					tinymce.get("template_update_content").setContent(data.content);
				} else {
					$('#template_update .status').show().removeAttr('class').addClass("status alert alert-danger").text(data.message);
				}
			}
		});

		e.preventDefault();

	});

	$('.table_vorlagen .view').on('click',  function(e){
		var id = $(this).attr("data-id");
		$('.template-body .template_name').text("");
		$('.template-body .template_subject').text("");
		$('.template-body .template_content').html("");
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: ajax_tempview_object.ajaxurl,
			data: {
				'action': 'ajaxtempview', //calls wp_ajax_nopriv_ajaxlogin
				'id': id
			}, 
			success: (data) => {
				if (data.type == "success") {
					$('#viewTemplateModal .template-body .template_view_name').text(data.name);
					$('#viewTemplateModal .template-body .template_view_thema').text(data.subject);
					$('#viewTemplateModal .template-body .template_view_content').html(data.content);
				}
			}
		});

		e.preventDefault();

	});

});