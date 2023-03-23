jQuery(document).ready(function($) {

	// create new student from asdmin end
	// select or deselect all universities based on 'All'  checkbox
	$('input[id="input-uni-all"]').change(function(){
		if($('input[id="input-uni-all"]:checked').val() == 'all'){
			$('input[id="input-uni-osj"]').prop( "checked", true );
			$('input[id="input-uni-rig"]').prop( "checked", true );
			$('input[id="input-uni-bre"]').prop( "checked", true );
			$('input[id="input-uni-vil"]').prop( "checked", true );
			$('input[id="input-uni-res"]').prop( "checked", true );
			$('input[id="input-uni-rij"]').prop( "checked", true ); 
			$('input[id="input-uni-bra"]').prop( "checked", true ); 
			$('input[id="input-uni-num"]').prop( "checked", true );
			
		} else{
			$('input[id="input-uni-osj"]').prop( "checked", false );
			$('input[id="input-uni-rig"]').prop( "checked", false );
			$('input[id="input-uni-bre"]').prop( "checked", false );
			$('input[id="input-uni-vil"]').prop( "checked", false );
			$('input[id="input-uni-res"]').prop( "checked", false );
			$('input[id="input-uni-rij"]').prop( "checked", false ); 
			$('input[id="input-uni-bra"]').prop( "checked", false ); 
			$('input[id="input-uni-num"]').prop( "checked", false );
		}
	});
	
	
	$('#add-student .submit_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#add-student .status').show().addClass("alert-danger").text(student_i18n.student_fill_all_error);
		}else{
			$('#add-student .status').show().removeClass('alert-danger').addClass("alert-warning").text(student_admin.loadingmessage);
			
			// get university info
			var unis = [];
			if($('input[id="input-uni-all"]:checked').val() == 'all'){	
				unis = ['OSJ', 'RES', 'RIG', 'BRE', 'BRA', 'VIL', 'RIJ', 'NUM'];
			} else {
				if($('input[id="input-uni-osj"]:checked').val() != ''){
					unis.push($('input[id="input-uni-osj"]:checked').val());
				}
				if($('input[id="input-uni-res"]:checked').val() != ''){
					unis.push($('input[id="input-uni-res"]:checked').val());
				}
				if($('input[id="input-uni-rig"]:checked').val() != ''){
					unis.push($('input[id="input-uni-rig"]:checked').val());
				}
				if($('input[id="input-uni-bre"]:checked').val() != ''){
					unis.push($('input[id="input-uni-bre"]:checked').val());
				}
				if($('input[id="input-uni-vil"]:checked').val() != ''){
					unis.push($('input[id="input-uni-vil"]:checked').val());
				}
				if($('input[id="input-uni-rij"]:checked').val() != ''){
					unis.push($('input[id="input-uni-rij"]:checked').val());
				}
				if($('input[id="input-uni-bra"]:checked').val() != ''){
					unis.push($('input[id="input-uni-bra"]:checked').val());
				}
				if($('input[id="input-uni-num"]:checked').val() != ''){
					unis.push($('input[id="input-uni-num"]:checked').val());
				}
			}
			
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: student_admin.ajaxurl,
				data: {
					'action': 'add_student', //calls wp_ajax_add_student
					'title': $('#add-student #input-add-title').val(),
					'first_name': $('#add-student #input-add-first_name').val(),
					'last_name': $('#add-student #input-add-last_name').val(),
					'address1': $('#add-student #input-add-address1').val(),
					'address2': $('#add-student #input-add-address2').val(),
					'city': $('#add-student #input-add-city').val(),
					'country': $('#add-student #input-add-country').val(),
					'zip': $('#add-student #input-add-zip').val(),
					'citizenship': $('#add-student #input-add-citizenship').val(),
					'telephone': $('#add-student #input-add-telephone').val(),
					'mobile': $('#add-student #input-add-mobile').val(),
					'email': $('#add-student #input-add-email').val(),
					'date_of_birth': $('#add-student #input-add-date_of_birth').val(),
					'place_of_birth': $('#add-student #input-add-place_of_birth').val(),
					'gender': $('#add-student #input-add-gender').val(),
					'syear': $('#input-add-year').val(),
					'subject':  $('#input-add-subject').val(),
					'semester': $('#input-add-semester').val(),
					'universities': unis,
					'security': $('#add-student #input-add-security').val()},
				success: function(data){
					console.log(data);
					if(data.type == "success"){
						$('#add-student .status').removeClass('alert-danger alert-warning').addClass("alert-success").text(data.message);
						setTimeout("$('#addStudentModal').modal('toggle');",1000);
						$("#add-student").trigger("reset");
						location.reload();
					}else{
						$('#add-student .status').removeClass('alert-danger alert-warning').addClass("alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});
	
	
	// select or deselect all universities based on 'All'  checkbox
	$('input[id="input-uni-all-update"]').change(function(){
		if($('input[id="input-uni-all-update"]:checked').val() == 'all'){
			$('input[id="input-uni-osj-update"]').prop( "checked", true );
			$('input[id="input-uni-rig-update"]').prop( "checked", true );
			$('input[id="input-uni-bre-update"]').prop( "checked", true );
			$('input[id="input-uni-vil-update"]').prop( "checked", true );
			$('input[id="input-uni-res-update"]').prop( "checked", true );
			$('input[id="input-uni-rij-update"]').prop( "checked", true ); 
			$('input[id="input-uni-bra-update"]').prop( "checked", true ); 
			$('input[id="input-uni-num-update"]').prop( "checked", true );
			
		} else{
			$('input[id="input-uni-osj-update"]').prop( "checked", false );
			$('input[id="input-uni-rig-update"]').prop( "checked", false );
			$('input[id="input-uni-bre-update"]').prop( "checked", false );
			$('input[id="input-uni-vil-update"]').prop( "checked", false );
			$('input[id="input-uni-res-update"]').prop( "checked", false );
			$('input[id="input-uni-rij-update"]').prop( "checked", false ); 
			$('input[id="input-uni-bra-update"]').prop( "checked", false ); 
			$('input[id="input-uni-num-update"]').prop( "checked", false );
		}
	});
	
	$('.btn-student-edit').on('click', function(e) {
		var user = $(this).attr("data-user");
		var title = $(this).attr("data-title");
		var first_name = $(this).attr("data-first_name");
		var last_name = $(this).attr("data-last_name");
		var address1 = $(this).attr("data-address1");
		var address2 = $(this).attr("data-address2");
		var city = $(this).attr("data-city");
		var country = $(this).attr("data-country");
		var zip = $(this).attr("data-zip");
		var citizenship = $(this).attr("data-citizenship");
		var telephone = $(this).attr("data-telephone");
		var mobile = $(this).attr("data-mobile");
		var email = $(this).attr("data-email");
		var date_of_birth = $(this).attr("data-date_of_birth");
		var place_of_birth = $(this).attr("data-place_of_birth");
		var gender = $(this).attr("data-gender");
		var Progress_report = $(this).attr("data-Progress_report");
		var syear = $(this).attr("data-syear"); 
		var semester = $(this).attr("data-semester"); 
		var subject = $(this).attr("data-subject"); 
		var sunis = $(this).attr("data-sunis");
		sunis = sunis.split(',');
		
	
		$('#input-update-user').val(user);
		$('#input-update-title').val(title);
		$('#input-update-first_name').val(first_name);
		$('#input-update-last_name').val(last_name);
		$('#input-update-address1').val(address1);
		$('#input-update-address2').val(address2);
		$('#input-update-city').val(city);
		$('#input-update-country').val(country);
		$('#input-update-zip').val(zip);
		$('#input-update-citizenship').val(citizenship);
		$('#input-update-telephone').val(telephone);
		$('#input-update-mobile').val(mobile);
		$('#input-update-email').val(email);
		$('#input-update-date_of_birth').val(date_of_birth);
		$('#input-update-place_of_birth').val(place_of_birth);
		$('#input-update-gender').val(gender);
		$('#input-update-Progress_report').val(Progress_report);
		$('#input-update-year').val(syear);
		$('#input-update-semester').val(semester); 
		$('#input-update-subject').val(subject); 
		$.each(sunis, function( index, value ) {		 
			$('input[id="input-uni-'+ value.toLowerCase() + '-update"]').prop( "checked", true );
		});

	});



	// update student info from admin end
	$('#update-student .submit_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#update-student p.status').show().addClass("alert-danger").text(student_i18n.student_fill_all_error);
		}else{
			// get university info
			var sel_unis = [];
			if($('input[id="input-uni-all-update"]:checked').val() == 'all'){	
				sel_unis = ['OSJ', 'RES', 'RIG', 'BRE', 'BRA', 'VIL', 'RIJ', 'NUM'];
			} else {
				if($('input[id="input-uni-osj-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-osj-update"]:checked').val());
				}
				if($('input[id="input-uni-res-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-res-update"]:checked').val());
				}
				if($('input[id="input-uni-rig-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-rig-update"]:checked').val());
				}
				if($('input[id="input-uni-bre-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-bre-update"]:checked').val());
				}
				if($('input[id="input-uni-vil-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-vil-update"]:checked').val());
				}
				if($('input[id="input-uni-rij-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-rij-update"]:checked').val());
				}
				if($('input[id="input-uni-bra-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-bra-update"]:checked').val());
				}
				if($('input[id="input-uni-num-update"]:checked').val() != ''){
					sel_unis.push($('input[id="input-uni-num-update"]:checked').val());
				}
			}
			$('#update-student p.status').show().removeClass('alert-danger').addClass("alert-warning").text(student_admin.loadingmessage);
			console.log(sel_unis);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: student_admin.ajaxurl,
				data: {
					'action': 'update_student', //calls wp_ajax_update_student
					'user': $('#update-student #input-update-user').val(),
					'title': $('#update-student #input-update-title').val(),
					'first_name': $('#update-student #input-update-first_name').val(),
					'last_name': $('#update-student #input-update-last_name').val(),
					'address1': $('#update-student #input-update-address1').val(),
					'address2': $('#update-student #input-update-address2').val(),
					'city': $('#update-student #input-update-city').val(),
					'country': $('#update-student #input-update-country').val(),
					'zip': $('#update-student #input-update-zip').val(),
					'citizenship': $('#update-student #input-update-citizenship').val(),
					'telephone': $('#update-student #input-update-telephone').val(),
					'mobile': $('#update-student #input-update-mobile').val(),
					'email': $('#update-student #input-update-email').val(),
					'date_of_birth': $('#update-student #input-update-date_of_birth').val(),
					'place_of_birth': $('#update-student #input-update-place_of_birth').val(),
					'gender': $('#update-student #input-update-gender').val(),
					'syear': $('#input-update-year').val(),
					'subject':  $('#input-update-subject').val(),
					'semester': $('#input-update-semester').val(),
					'universities': sel_unis,
					'Progress_report': $('#input-update-Progress_report').val()},
				success: function(data){
					if(data.type == "success"){
						$('#update-student .status').removeClass('alert-danger alert-warning').addClass("alert-success").text(data.message);
						setTimeout("$('#editStudentModal').modal('toggle');",1000);
						$("#update-student").trigger("reset");
						location.reload();
					}else{
						$('#update-student .status').removeClass('alert-danger alert-warning').addClass("alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});
	
	// view student info from admin end
	$('.btn-student-view').on('click', function(e) {

		$('.nav-pills a, .tab-pane').removeClass('active');
		$('.nav-pills a:first-child').addClass('active');
		var tab = $('.nav-pills a:first-child').attr('href');
		$(tab).addClass('show active');
		var user=$(this).attr("data-user");
		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: student_admin.ajaxurl,
			data: {'action': 'show_student_details', //wp_ajax_show_student_details
				   'user': user},
			success: function(data){
				$('#viewStudentModal .modal-title').text(data.name);
				$('#viewStudentModal #sutdent_info').html(data.student_info);
				$('#viewStudentModal #student_contact').html(data.sutdent_contact);
				$('#viewStudentModal #study_info').html(data.study_info);
				$('#viewStudentModal #package').html(data.package);
				$('#viewStudentModal #uploads').html(data.uploads);
				$('#generatezip').on('click', function (e) {
					$(this).text('Generating...');

					var userid = $(this).attr("data-student_id");

					jQuery.ajax({
						type: 'POST',
						dataType: 'json',
						url: student_admin.ajaxurl,
						data: {'action': 'files_zip_create', //wp_ajax_files_zip_create
							   'user': userid},
						success: function(data){
							if(data.type == "success"){
								$('#generatezip').hide();
								$( ".zips" ).append( "<a class=\"submit_button\" id=\"donwloadzip\" href=\"" + data.message + "\">Download</a>" );
							}else{
								$('#generatezip').removeClass('alert-danger alert-warning').addClass("alert-danger").text(data.message);
							}
						}

					});
					e.preventDefault();
				});
			}
		});
		e.preventDefault();
	});
	
	
	
	// student delete from admin end
	$('.btn-student-delete').on('click',  function(e){
		var user = $(this).attr("data-id");

		$('#input-delete-user').val(user);
	});
	
	
	$('#delete-student .delete_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#delete-student .status').show().addClass("alert-danger").text(student_i18n.student_fill_all_error);
		}else{
			$('#delete-student .status').show().removeClass('alert-danger').addClass("alert-warning").text(student_admin.loadingmessage);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: student_admin.ajaxurl,
				data: {
					'action': 'delete_student', //calls wp_ajax_delete_student
					'user': $('#input-delete-user').val(),},
				success: function(data){
					if(data.type == "success"){
						$('#delete-student .status').removeClass('alert-danger alert-warning').addClass("alert-success").text(data.message);
						setTimeout("$('#deleteStudentModal').modal('toggle');",1000);
						$("#delete-student").trigger("reset");
						location.reload();
					}else{
						$('#delete-student .status').removeClass('alert-danger alert-warning').addClass("alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});
	
	
	$(".studentsdelete").on("click", function () {  
		var students =$(this).attr("data-delete");
		console.log(students);
		$('#delete-students input[name="students"]').val(students);
	});
	$('#delete-students .delete_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#delete-students .status').show().addClass("alert-danger").text('Please fill all fields');
		}else{
			$('#delete-students .status').show().removeClass('alert-danger').addClass("alert-warning").text(student_admin.loadingmessage);
			var ids = $('#delete-students input[name="input-delete-students"]').val();
			ids = ids.split(',');
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: student_admin.ajaxurl,
				data: {
					'action': 'delete_students', //wp_ajax_delete_students
					'ids': ids
				},
				success: function(data){
					if(data.type == "success"){
						$('#delete-students .status').removeClass('alert-danger alert-warning').addClass("alert-success").html(data.message);
						setTimeout("$('#deleteStudentsModal').modal('toggle');",1000);
						$("#selectAll").prop("checked", false);
						$("#delete-students").trigger("reset");
						location.reload();
					}else{
						$('#delete-students .status').removeClass('alert-danger alert-warning').addClass("alert-danger").html(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});

});