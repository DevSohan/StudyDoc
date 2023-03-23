jQuery(document).ready(function($) {
	/* --------------------------------------------------------------------------
	Header Login Buttons
	-------------------------------------------------------------------------- */
$( "#mobtogg" ).on( "click", function() {
			
 $('#webmen').toggle();
});


if ($(window).width() < 767) {
    $('#webmen').hide();
	
}
else {
 $('#webmen').show();
}

	
	
	
	
var delay = 100; setTimeout(function() { 
$('.elementor-tab-title').removeClass('elementor-active');
 $('.elementor-tab-content').css('display', 'none'); }, delay); 
	
	
	$('#profile_btn').css('display','none');
	$('#logout_btn').css('display','none');
	if(jQuery('body').hasClass('logged-in')){
		//console.log('logged in');
		$('#login_btn').css('display','none');
		$('#profile_btn').css('display','block');
		$('#logout_btn').css('display','block');
		$("#login_btn .elementor-button").attr("href", "#");
		//$('#login_btn').addClass("logout_link");
	}else{

		$('#login_btn').css('display','block');
		$('#profile_btn').css('display','none');
		$('#logout_btn').css('display','none');
	}
	/* --------------------------------------------------------------------------
	Form Passowrd Strength check
	-------------------------------------------------------------------------- */
	$('form[name="Sign Up"] .elementor-field-type-password, #resetform .email-area').append('<div class="pswd_info"><h4>Das Passwort muss die folgenden Anforderungen erfüllen:</h4><ul><li id="letter" class="invalid"><i class="fas fa-times"></i>Mindestens <strong>ein Buchstabe</strong></li><li id="capital" class="invalid"><i class="fas fa-times"></i>Mindestens <strong>ein Großbuchstabe</strong></li><li id="number" class="invalid"><i class="fas fa-times"></i>Mindestens <strong>eine Zahl</strong></li><li id="special" class="invalid"><i class="fas fa-times"></i>Mindestens <strong>ein Sonderzeichen</strong></li><li id="length" class="invalid"><i class="fas fa-times"></i>Mindestens <strong>8 Zeichen sein</strong></li></ul></div>');

	$('form[name="Sign Up"] .elementor-field-group input[type=password], #resetform #new_password').keyup(function() {
		var pswd = $(this).val();
		//validate the length
		if ( pswd.length < 8 ) {
			$('#length').removeClass('valid').addClass('invalid');
			$('#length .fas').removeClass('fa-check').addClass('fa-times');
		} else {
			$('#length').removeClass('invalid').addClass('valid');
			$('#length .fas').removeClass('fa-times').addClass('fa-check');
		}
		//validate letter
		if ( pswd.match(/[a-z]/) ) {
			$('#letter').removeClass('invalid').addClass('valid');
			$('#letter .fas').removeClass('fa-times').addClass('fa-check');
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
			$('#letter .fas').removeClass('fa-check').addClass('fa-times');
		}

		//validate capital letter
		if ( pswd.match(/[A-Z]/) ) {
			$('#capital').removeClass('invalid').addClass('valid');
			$('#capital .fas').removeClass('fa-times').addClass('fa-check');
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
			$('#capital .fas').removeClass('fa-check').addClass('fa-times');
		}

		//validate number
		if ( pswd.match(/\d/) ) {
			$('#number').removeClass('invalid').addClass('valid');
			$('#number .fas').removeClass('fa-times').addClass('fa-check');
		} else {
			$('number').removeClass('valid').addClass('invalid');
			$('#number .fas').removeClass('fa-check').addClass('fa-times');
		}

		//validate number
		if ( pswd.match(/([~,!,@,#,$,%,^,&,*,-,_,+,=,?,>,<])/) ) {
			$('#special').removeClass('invalid').addClass('valid');
			$('#special .fas').removeClass('fa-times').addClass('fa-check');
		} else {
			$('#special').removeClass('valid').addClass('invalid');
			$('#special .fas').removeClass('fa-check').addClass('fa-times');
		}
	}).focus(function() {
		$('.pswd_info').show();
	}).blur(function() {
		$('.pswd_info').hide();
	});




	/* --------------------------------------------------------------------------
// steaky header
// -------------------------------------------------------------------------- */
	$(window).scroll(function(){
		if(($(window).scrollTop()) < 100){
			$('#steaky-header-fd').removeClass('steaky-header-ns');
			$('#steaky-header-fd2').removeClass('steaky-header-ns');
		}else{
			$('#steaky-header-fd').addClass('steaky-header-ns');
			$('#steaky-header-fd2').addClass('steaky-header-ns');
		}
	});




});




jQuery(document).on('elementor/popup/show', () => {
	$('#pop_reg, #pop_lost').hide();
	$('#pop_login .register_click').click(function(){
		$('#pop_login').slideUp();
		$('#pop_reg').slideDown();
	});
	$('#pop_login .lost_click').click(function(){
		$('#pop_login').slideUp();
		$('#pop_lost').slideDown();
	});
	$('#pop_reg .login_click').click(function(){
		$('#pop_reg').slideUp();
		$('#pop_login').slideDown();
	});
	$('#pop_lost .login_click').click(function(){
		$('#pop_lost').slideUp();
		$('#pop_login').slideDown();
	});

}
				   );



/* --------------------------------------------------------------------------
// Preloader
// -------------------------------------------------------------------------- */
jQuery(window).on('load', function(){
	// 	$("#loader").fadeOut("slow");
	// 	$("#preloader").fadeOut("slow");
	jQuery('.spinner').fadeOut('slow');
	jQuery('.spinner-wrap').fadeOut('slow');
});

// jQuery(window).load(function($) {
//       $('.spinner').fadeOut('slow');
// 	$('.spinner-wrap').fadeOut('slow');
// });



	

