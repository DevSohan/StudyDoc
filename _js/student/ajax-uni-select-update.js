jQuery(document).ready(function($) {
	
// hide or show universities acconrding to selected semester
	if($("#selected_semester").children(":selected").val() == 'SS'){

		$('.no-ss').hide();
	}else{
		$('.no-ss').show();
	}

	$('#selected_semester').on('change', function(){
		
		if($("#selected_semester").children(":selected").val() == 'SS'){
	
			$('.no-ss').hide();
		}else{
			$('.no-ss').show();
		}
		
	});
	
	
// show confirmation message on form submit
	$('#submit_select').on('click',  function(e){
		
		var packageID = $("#packageID").val();
		if(packageID == '1711'){
			var maxAllowed = 10;  
		}else if(packageID == '1712'){
			var maxAllowed = 20;
		}else{
			var maxAllowed = 100;
		}
		
		if($(".multiselect input[type=checkbox]:checked").length == 0){
			$('#univarsities_select p.status').removeAttr('class').addClass("status alert alert-danger").text("Bitte wählen Sie Universitäten aus.");
			return false;
		}
		if($(".multiselect input[type=checkbox]:checked").length > maxAllowed){
			$('#univarsities_select p.status').removeAttr('class').addClass("status alert alert-danger").text("Bitte wählen Sie " + maxAllowed + " Universitäten aus.");
			return false;
		}
		
		$("#selected_semester, #selected_year").removeAttr('disabled');
		 
		// re-disabled the set of inputs that you previously enabled
		$("#selected_semester, #selected_year").attr('disabled', 'disabled');
				
		$('input[name="selected_university[]"]:checked').each(function(){
			$(this).attr('disabled', 'disabled');
			var sel_uni;
			switch ($(this).val()){
				case 'HAM': sel_uni = 'Hamburg'
					break;
				case 'WI': sel_uni = 'Wien'
					break;
				default: sel_uni = ''
					
			}
			$('.sel_unis').append('<li>' + sel_uni + '</li>');
		});
		$('.sel_year_txt').text($('#selected_year').val());
		$('.sel_semster_txt').text(($('#selected_semester').val() == 'WS') ? 'Winter' : 'Sommer');
		
		$('#confirm-selection').modal({
			keyboard: false,
			backdrop: 'static',
		});	

		e.preventDefault();	
	});
	
	
	// sumbit the form on click of 'Confirm' button
	
		$('#confirm_selction_btn').click(function(ev){
		ev.preventDefault();
			
		var year = $('#selected_year').val();
		var semester = $('#selected_semester').val();
		var unis = [];
		$('input[name="selected_university[]"]:checked').each(function(){
// 			$(this).attr('disabled', 'disabled');
// 			var sel_uni;
// 			switch ($(this).val()){
// 				case 'HAM': sel_uni = 'Hamburg'
// 					break;
// 				case 'WI': sel_uni = 'Wien'
// 					break;
// 				default: sel_uni = ''
					
// 			}
// 			$('.sel_unis').append('<li>' + sel_uni + '</li>');
		unis.push($(this).val());
		});
// 		var datas = $("#univarsities_select").serialize();
			var unserializesData = {'year': year , 'semester': semester, 'unis': unis, 'security': $('input[name="security"]').val(), '_wp_http_referer': $('input[name="_wp_http_referer"]').val() };
			
		console.log(unserializesData);
		
		$.ajax({
 			type: 'POST',
			dataType: 'json',
 			url: ajax_unisubmit_object.ajaxurl,
			data: {
 				'action': 'ajaxunisubmit', //calls wp_ajax_nopriv_ajaxlogin
 				'datas': unserializesData },
 			success: function(data){
 				if(data.type == "success"){
				$('#univarsities_select p.status').removeAttr('class').addClass("status alert alert-success").text(data.message);
				//setTimeout(function(){ location.reload(); },1000);
 				}else{
					$('#univarsities_select p.status').removeAttr('class').addClass("status alert alert-danger").text(data.message);
 				}
 			}
		});
	});
	
	
});