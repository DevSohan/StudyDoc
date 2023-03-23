jQuery(document).ready(function($) {
/* --------------------------------------------------------------------------
	Student - Disable Names and Email Button on Student Details Form
	-------------------------------------------------------------------------- */
	$('#student_info #form-field-first_name').attr("disabled", true);
	$('#student_info #form-field-last_name').attr("disabled", true);
	$('#student_info #form-field-user_email').attr("disabled", true);

	$(function(){
		var hash = window.location.hash;
		hash && $('ul.nav.nav-pills a[href="' + hash + '"]').tab('show'); 
		$('ul.nav.nav-pills a').click(function (e) {
			$(this).tab('show');
			var scrollmem = $('body').scrollTop();
			window.location.hash = this.hash;
		});
	});
	
	
	/* -------------------------------------------------------------------------
	 * univesity documnet checklist viewer 
	 * ----------------------------------------------------------------------*/
	var unis = ['OSJ', 'RIG', 'RES', 'RIJ', 'BRE', 'BRA', 'VIL', 'NUM'];
	
	$('#OSJ').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('OSJ');
		hide_checklist('OSJ');
	});	
	$('#RIG').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('RIG');
		hide_checklist('RIG');
	});
	$('#RES').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('RES');
		hide_checklist('RES');
	}); 
	$('#VIL').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('VIL');
		hide_checklist('VIL');
	}); 
	$('#RIJ').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('RIJ');
		hide_checklist('RIJ');
	}); 
	$('#BRE').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('BRE');
		hide_checklist('BRE');
	});
	$('#BRA').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('BRA');
		hide_checklist('BRA');
	});
	$('#NUM').click(function(){
		$(this).addClass('university-li-active');
		remove_active_stat('NUM');
		hide_checklist('NUM');
	});
	
	
	function remove_active_stat (cu){
		for(var uni of unis){
			if(uni != cu){
				$('#' + uni).removeClass('university-li-active');
			}
		}
	}
	
	function hide_checklist(cu){
		$('#checkllist-null').hide();
		for(var uni of unis){
			if(uni == cu){
				$('#checkllist-' + uni).show();
			} else{
				$('#checkllist-' + uni).hide();
			}
		}
	}
	
	
	
	$(function () {
  		$('.cli').popover({
			trigger: 'focus',
			placement: 'auto',
			template: '<div class="popover custom_popover" role="tooltip"><div class="arrow"></div><div class="popover-body"></div></div>'
		});

	});
	
	
	

	
	
	
	
	
	
	
	
});