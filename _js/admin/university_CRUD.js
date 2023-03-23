/*---------------------------------------------------------------------------------------------
 * Create ajax request to admin-ajax.php 
 * to add new student, Update Exisitng student data, Delete single or Multuple students
 * from Admin Profil End
 * sec-1 Student Add
 * sec-2 Student update
 * sec-3 Student  Delete (single)
 * sec-4 Student  Delete (Multiple)
 -----------------------------------------------------------------------------------------------*/

jQuery(document).ready(function($) {

	//--------------------------------------------------------------------------------------------
	// University Add
	// --------------------------------------------------------------------------------------------

	$('#add-university .submit_button').on('click',  function(e){

		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#add-university .status').show().addClass("alert-danger").text('Please fill all fields');
		}else{
			$('#add-university .status').show().removeClass('alert-danger').addClass("alert-warning").text(university_admin.add_message);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: university_admin.url,
				data: $('#add-university').serialize() + '&action=add_university',
				success: function(data){
					if(data.type == "success"){
						$('#add-university .status').removeClass('alert-warning alert-danger').addClass("alert-success").text(data.message);
						setTimeout("$('#adduniModal').modal('toggle');",1000);
						$("#add-university").trigger("reset");
						location.reload();
					}else{
						$('#add-university .status').removeClass('alert-warning alert-danger').addClass("alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();	
		}

	});



	//----------------------------------------------------------------------------------------------------------------------------------
	// University Update
	// ----------------------------------------------------------------------------------------------------------------------------------

	$('#update-university .submit_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#update-university .status').show().addClass("alert-danger").text('Please fill all fields');
		}else{
			$('#update-university .status').show().removeClass('alert-danger').addClass("alert-warning").text(university_admin.update_message);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: university_admin.url,
				data: $('#update-university').serialize() + '&action=update_university',
				success: function(data){
					if(data.type == "success"){
						$('#update-university .status').removeClass('alert-warning alert-danger').addClass("alert-success").text(data.message);
						setTimeout("$('#updateuniModal').modal('toggle');",1000);
						$("#update-university").trigger("reset");
						location.reload();
					}else{
						$('#update-university .status').removeClass('alert-warning alert-danger').addClass("alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});



	//----------------------------------------------------------------------------------------------------------------------------------
	// University Delete (single)
	// ----------------------------------------------------------------------------------------------------------------------------------

	// set the university to be deleted
	$(document).on('click', '.unidelete', function () {
		var uni = $(this).attr("data-id");
		console.log("test");
		$('#delete-university #input-delete-university-uni').val(uni);
	});

	// Univesrty delete ajax call
	$('#delete-university .delete_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#delete-university .status').show().addClass("alert-danger").text('Please fill all fields');
		}else{
			$('#delete-university .status').show().removeClass('alert-danger').addClass("alert-warning").text(university_admin.delete_message);
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: university_admin.url,
				data: {
					'action': 'delete_university', //calls wp_ajax_nopriv_ajaxlogin
					'uni': $('#delete-university #input-delete-university-uni').val()},
				success: function(data){
					if(data.type == "success"){
						$('#delete-university .status').removeClass('alert-warning alert-danger').addClass("alert-success").text(data.message);
						setTimeout("$('#deleteUniModal').modal('toggle');",1000);
						$("#delete-university").trigger("reset");
						location.reload();
					}else{
						$('#delete-university .status').removeClass('alert-warning alert-danger').addClass("alert-danger").text(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});



	//----------------------------------------------------------------------------------------------------------------------------------
	// University Delete (Multiple)
	// ----------------------------------------------------------------------------------------------------------------------------------
	// set the universities to be deleted
	$(".unisdelete").on("click", function () {  
		var unis =$(this).attr("data-delete");
		$('#delete-universities #input_delete-universities_ids').val(unis);
	});

	// Universities delete ajax call
	$('#delete-universities .delete_button').on('click',  function(e){
		var required = $('input,textarea,select').filter('[required]:visible');
		var allRequired = true;
		required.each(function(){
			if($(this).val() == ''){
				allRequired = false;
			}
		});

		if(!allRequired){
			$('#delete-universities .status').show().addClass("alert-danger").text('Please fill all fields');
		}else{
			$('#delete-universities .status').show().removeClass('alert-danger').addClass("alert-warning").text(university_admin.multiple_delete_message);

			var unis = $('#delete-universities #input_delete-universities_ids').val();
			unis = unis.split(',');
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: university_admin.url,
				data: {
					'action': 'delete_universities', //calls wp_ajax_nopriv_ajaxlogin
					'unis': unis},
				success: function(data){
					if(data.type == "success"){
						$('#delete-universities p.status').removeClass('alert-warning alert-danger').addClass("alert-success").html(data.message);
						setTimeout("$('#deleteUnisModal').modal('toggle');",1000);
						$("#selectAll").prop("checked", false);
						$("#delete-universities").trigger("reset");
						location.reload();
					}else{
						$('#delete-universities .status').removeClass('alert-warning alert-danger').addClass("alert-danger").html(data.message);
					}
				}
			});
			e.preventDefault();
		}
	});


	// University Show for edit
	$(document).on('click', '.uni_edit', function(){
		$('#input_update_university_id').val($(this).attr("data-id"));
		$('#input_update_university_short_name').val($(this).attr("data-shortname"));
		$('#input_update_university_name').val($(this).attr("data-name"));
		$('#input_update_university_address').val($(this).attr("data-street"));
		$('#input_update_university_optional_address').val($(this).attr("data-address"));
		$('#input_update_university_city').val($(this).attr("data-city"));
		$('#input_update_university_zip').val($(this).attr("data-zip"));
		$('#input_update_university_state').val($(this).attr("data-state"));
		$('#input_update_university_country').val($(this).attr("data-country"));
		$('#input_update_university_SS').val($(this).attr("data-ss_deadline"));
		$('#input_update_university_WS').val($(this).attr("data-ws_deadline"));
		$('#input_update_university_hm').val($(this).attr("data-humanmedizin"));
		$('#input_update_university_zm').val($(this).attr("data-zahnmedizin"));
		$('#input_update_university_tm').val($(this).attr("data-tiermedizin"));
		$('#input_update_university_hm_summer').val($(this).attr("data-HM_summer"));
		$('#input_update_university_zm_summer').val($(this).attr("data-ZM_summer"));
		$('#input_update_university_tm_summer').val($(this).attr("data-TM_summer"));
		$('#input_update_university_hm_winter').val($(this).attr("data-HM_winter"));
		$('#input_update_university_zm_winter').val($(this).attr("data-ZM_winter"));
		$('#input_update_university_tm_winter').val($(this).attr("data-TM_winter"));
	});


});