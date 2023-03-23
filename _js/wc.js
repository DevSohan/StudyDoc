jQuery(document).ready(function($) {


	/* --------------------------------------------------------------------------
	Custom File Input
	-------------------------------------------------------------------------- */
	$('.custom-file-input').on('change',function(){
		var fileName = $(this).prop('files')[0].name;
		$(this).next('.custom-file-label').text(fileName);
	});


	/* -----------------------------------------------------------------------------------------------
 Custom Menu button action
 ------------------------------------------------------------------------------------------------*/ 
// 	$('.wc-custom-menu-collapse-icon').click(function(){
// 		var cw = $('#wc-custom-menu').width();

// 		$('#wc-col-ico').toggleClass('fa-chevron-circle-right');
// 		$('#wc-col-ico').toggleClass('fa-chevron-circle-left');
// 		$('#wc-custom-menu').toggleClass('wc-custom-menu-collapsed');
// 		$('#wc-custom-menu').toggleClass('wc-custom-menu-expended');

// 		if(cw == 52){
// 			$('.woocommerce-account .woocommerce-MyAccount-content').css({width: 'calc(100% - 200px)'});
// 		}else{
// 			$('.woocommerce-account .woocommerce-MyAccount-content').css({width: 'calc(100% - 52px)'});
// 		}

// 	});
	
	
/* -------------------------------------------
 * 
 * dp change btn on/off
 * -----------------------------------------*/
	

	
	$(".button-play-again").html("Button New Text");
	
	


	
});
