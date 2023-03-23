<?php
/*------------------------- updatestatus AJAX FUNCTION ---------------------------*/


function ajax_updatestatus_init(){

	wp_register_script('ajax-updatestatus-script', get_template_directory_uri() . '/_js/admin/ajax-updatestatus-script.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('ajax-updatestatus-script');

	wp_localize_script( 'ajax-updatestatus-script', 'ajax_updatestatus_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url(),
		'loadingmessage' => __('Aktualisierung der Beschreibung, bitte warten...')
	));

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_ajaxupdatestatus', 'ajax_updatestatus' );
}

// Execute the action only if the user isn't logged in
if (is_user_logged_in()) {
	add_action('init', 'ajax_updatestatus_init');
}




function ajax_updatestatus() {

	// Ensure we have the data we need to continue
	if( ! isset( $_POST ) || empty( $_POST ) || ! is_user_logged_in() ) {

		// If we don't - return custom error message and exit
		header( __('HTTP/1.1 400 Empty POST Values', 'study-doc') );
		_e('Could Not Verify POST Values.', 'study-doc');
		exit;
	}

	$user_id        = get_current_user_id();                            // Get our current user ID
	$um_val         = sanitize_text_field( $_POST['status'] );      // Sanitize our user meta value
	$um_user_email  = sanitize_text_field( $_POST['user_email'] );      // Sanitize our user email field

	$updato =  update_user_meta( $user_id, 'status', $um_val );                // Update our user meta
	wp_update_user( array(
		'ID'            => $user_id,
		'user_email'    => $um_user_email,
	) );
	if (!empty($updato)){
		echo json_encode(array('type'=>'success','message'=>__('Beschreibung Aktualisiert', 'study-doc')));
	} else {
		echo json_encode(array('type'=>'error','message'=>__('Erfolglos', 'study-doc')));
	}
	die();
}