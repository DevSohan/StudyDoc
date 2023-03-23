jQuery(document).ready(function($) {
	
	$('.status-up').hide();

	$('#fupForm .submit_button').on('click',  function(e){
		var file = $('#exampleFormControlFile1').prop('files')[0];
		$.ajax({
			type: 'post',
			url: ajax_testupload_object.ajaxurl,
			contentType: false,
			processData: false,
			data: {
				'action': 'ajaxtestupload', //calls wp_ajax_nopriv_ajaxlogin
				'file': file,},
			success: function(data){
				if(data.type == "success"){
					$('#fupForm p.status').removeAttr('class').addClass("status alert alert-success").text(data.message);
					//setTimeout(function(){ window.location = ajax_resetpass_object.redirecturl; },1000);
				}else{
					$('#fupForm p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);
				}
			}
		});
		e.preventDefault();
	});
	
	
	$('#dokument_upload .submit_button').on('click', function (e) {

		var file_data = $('#dokumente_file').prop('files')[0];
		var file_name = $('#dokumente_name').val(); 
		var up_university = $('#upload-doc-universitat').val();
		var form_data = new FormData();

		form_data.append('file', file_data);
		form_data.append('file_name', file_name);
		form_data.append('file_unis', up_university);
		form_data.append('action', 'ajaxupload_dokument');

		console.log(form_data,file_data, file_name, up_university);
		
		if(file_data){
			// process form
			if(file_name == ''){
				// error: must choose a file type
				$('.status-up').addClass('text-danger');
				$('.status-up').text('Bitte wählen Sie einen Dokumententyp');
				$('.status-up').show();
				
			} else if (up_university.length == 0){
				// must choose one or more university
				$('.status-up').addClass('text-danger');
				$('.status-up').text('Bitte wählen Sie eine oder mehrere Universitäten aus');
				$('.status-up').show();
			} else{
				// request ajajx
				$('.status-up').text('');
				$('.status-up').hide();
				
				jQuery.ajax({
					url: ajax_upload_dokument_object.ajaxurl,
					type: 'POST',
					dataType: 'json',
					cache: false,
					contentType: false,
					processData: false,
					data: form_data,
					success: function(data){
						if(data.type == "success"){
							$('.status-up').addClass('text-success');
							$('.status-up').text(data.message);
							$('.status-up').show();
							setTimeout(function(){ $('.status-up').hide(); location.reload();}, 1000);
						}else{
							$('.status-up').addClass('text-danger');
							$('.status-up').text(data.message);
							$('.status-up').show();
						}
					}

				});
				
			}
			
		} else{
			
			// error : file must not be empty
			$('.status-up').addClass('text-danger');
			$('.status-up').text('Bitte wählen Sie einen Dokument');
			$('.status-up').show();
		}

		e.preventDefault();
	});


	$('#dokument_vorklinik_upload .submit_button').on('click', function (e) {

		var file_data = $('#dokumente_vorklinik_file').prop('files')[0];
		var file_name = $('#dokumente_vorklinik_name').val();
		var form_data = new FormData();

		form_data.append('file', file_data);
		form_data.append('file_name', file_name);
		form_data.append('action', 'ajaxvorklinik_dokument');

		console.log(form_data);

		jQuery.ajax({
			url: ajax_vorklinik_dokument_object.ajaxurl,
			type: 'POST',
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function(data){
				if(data.type == "success"){
					$('#dokument_vorklinik_upload p.status').removeAttr('class').addClass("status alert alert-success").text(data.message);
					setTimeout(function(){ $('#vorklinik_dokument_upload p.status').fadeOut(); },2000);
					var table = $('.table_vorklinik_dokumenten');
					var tablebody = $('.table_vorklinik_dokumenten tbody');
					if(table.length != 0){
						console.log(data.file_name);
						console.log(data.file_url);
						$('.table_vorklinik_dokumenten tbody').append("<tr><td>" + data.file_name + "</td><td><a hrf=\"" + data.file_url + "\">Betrachten</a></td></tr>");
					}else{
						$(".student_documents .status").remove();
						$(".student_documents").append("<div><h2>Vorklinik Dokumenten</h2><table class=\"table_vorklinik_dokumenten table table-striped\"><tr><td>" + data.file_name + "</td><td><a hrf=\"" + data.file_url + "\">Betrachten</a></td></tr></table><div>");
					}
				}else{
					$('#dokument_vorklinik_upload p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);
				}
			}

		});
		e.preventDefault();
	});


	$('#dokument_klinik_upload .submit_button').on('click', function (e) {

		var file_data = $('#dokumente_klinik_file').prop('files')[0];
		var file_name = $('#dokumente_klinik_name').val();
		var form_data = new FormData();

		form_data.append('file', file_data);
		form_data.append('file_name', file_name);
		form_data.append('action', 'ajaxklinik_dokument');

		console.log(form_data);

		jQuery.ajax({
			url: ajax_klinik_dokument_object.ajaxurl,
			type: 'POST',
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,
			success: function(data){
				if(data.type == "success"){
					$('#dokument_klinik_upload p.status').removeAttr('class').addClass("status alert alert-success").text(data.message);
					setTimeout(function(){ $('#klinik_dokument_upload p.status').fadeOut(); },2000);
					var table = $('.table_klinik_dokumenten');
					var tablebody = $('.table_klinik_dokumenten tbody');
					if(table.length != 0){
						console.log(data.file_name);
						console.log(data.file_url);
						$('.table_klinik_dokumenten tbody').append("<tr><td>" + data.file_name + "</td><td><a hrf=\"" + data.file_url + "\">Betrachten</a></td></tr>");
					}else{
						$(".student_documents .status").remove();
						$(".student_documents").append("<div><h2>Klinik Documenten</h2><table class=\"table_klinik_dokumenten table table-striped\"><tr><td>" + data.file_name + "</td><td><a hrf=\"" + data.file_url + "\">Betrachten</a></td></tr></table></div>");
					}
				}else{
					$('#dokument_klinik_upload p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);
				}
			}

		});
		e.preventDefault();
	});

});