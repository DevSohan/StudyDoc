<?php
/* ---------------------------------------------------------------------------------------------
 * export single or Multuple Students
 * Script enqueue and Ajax handler
 * script initialization 
 * callback for ajax action
 
 ---------------------------------------------------------------------------------------------- */

/*--------------------------------------------------------------------------------------------------
 * Adminside Student Script Localization
 --------------------------------------------------------------------------------------------------*/

function admin_students_export(){

	wp_register_script('xlsx-script', get_template_directory_uri() . '/_js/xlsx.min.js', array(), '1.0.0', true );
	wp_register_script('FileSaver-script', get_template_directory_uri() . '/_js/FileSaver.min.js', array(), '1.0.0', true );
	wp_register_script('admin-students-exp', get_template_directory_uri() . '/_js/admin/student_export.js', array('jquery', 'wp-i18n'), '1.0.0', true );
	wp_enqueue_script('xlsx-script');
	wp_enqueue_script('FileSaver-script');
	wp_enqueue_script('admin-students-exp');
	
	wp_localize_script( 'admin-students-exp', 'student_admin_exp_obj', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
	));

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_exp_student', 'admin_students_exp_callback' );

}


// Execute the action only if the user isn't logged in
if (is_user_logged_in()) {
	add_action('init', 'admin_students_export');
}



/* --------------------------------------------------------------------------
Students Export (Multiple) Ajax Callback
-------------------------------------------------------------------------- */
function admin_students_exp_callback(){

	global $wpdb;
	
// 	$test = '';
	$ids = $_POST['ids'];

	$student_table = $wpdb->prefix . 'students';
	$sutdent_info = 'title,first_name,last_name,address1,address2,country,city,zip';
	$student_data_to_exp = [['title','first_name','last_name','address1','address2','country','city','zip'],];
	
	foreach ($ids as $id) {
		$user = (int)$id;
		$student_data = $wpdb->get_row( "SELECT $sutdent_info FROM $student_table where user=$user", ARRAY_A );
		array_push($student_data_to_exp, $student_data);
	}
	
	$file_direc =  wp_upload_dir();
	$csv_location = $file_direc['path']. '/student_export.csv';
	$csv_location_url = $file_direc['url']. '/student_export.csv';
	if(file_exists($csv_location)){
		rmdir($csv_location);
	}
	$csv_location = $file_direc['path']. '/student_export.csv';
	$fp = fopen($csv_location, 'w');
	
	foreach ($student_data_to_exp as $fields) {
    	fputcsv($fp, $fields, ';');
	}
	
	
	
	if(!empty($student_data_to_exp)){
		echo json_encode(array('type'=>'success','message'=>$csv_location_url));
	} else{
		echo json_encode(array('type'=>'error','message'=>$file_name, 'data'=>$student_data_to_exp));
	}
// 	$message['success'] = $success;
// 	$message['error'] = $error;
// 	if($message['success']){
// 		echo json_encode(array('type'=>'success','message'=>$message['success']));
// 	}else{
// 		echo json_encode(array('type'=>'error','message'=>$message['error']));
// 	}
// 	


	die();
}

