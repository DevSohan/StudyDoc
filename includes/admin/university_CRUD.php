<?php 
/* ---------------------------------------------------------------------------------------------
 * Add new university, Update Exisitng University, Delete single or Multuple Universities
 * Script enqueue and Ajax handler
 * sec-1 script initialization (all operations)
 * sec-2 script commit (all operations)
 * sec-3 Ajax handler (add)
 * sec-4 Ajax handler (update)
 * sec-5 Ajax handler (delete / single)
 * sec-6 Ajax handler (delete / multi)
 ---------------------------------------------------------------------------------------------- */

/*--------------------------------------------------------------------------------------------------
 * Enqueue script for ajax call (init function) for loogin in Users
 --------------------------------------------------------------------------------------------------*/
function ajax_universities_init(){

	// register script 
	// ---------------------------------------------------------------------------
	wp_register_script('admin-universities', get_template_directory_uri() . '/_js/admin/university_CRUD.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('admin-universities');

	
	// Defone localize script for ajax actions
	// ---------------------------------------------------------------------------
	wp_localize_script( 'admin-universities', 'university_admin', array(
		'url' => admin_url( 'admin-ajax.php' ),
		'add_message' => __('Neue Universität hinzufügen, bitte warten...', 'study-doc'),
		'update_message' => __('Editieren der Universität, bitte warten...', 'study-doc'),
		'delete_message' => __('Löschung der Universität, bitte warten...', 'study-doc'),
		'multiple_delete_message' => __('Löschen von Universitäten, bitte warten...', 'study-doc'),
	));

	
	// Action hooks for ajax 
	// ---------------------------------------------------------------------------
	add_action( 'wp_ajax_add_university', 'study_doc_add_university' );
	add_action( 'wp_ajax_update_university', 'study_doc_update_university' );
	add_action( 'wp_ajax_delete_university', 'study_doc_delete_university' );
	add_action( 'wp_ajax_delete_universities', 'study_doc_delete_universities' );

}



/*--------------------------------------------------------------------------------------------------
 * Enqueue script for ajax call (init function) for non users
 --------------------------------------------------------------------------------------------------*/

function non_user_init(){
	
	wp_register_script('universities-action', get_template_directory_uri() . '/_js/admin/university_CRUD.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('universities-action');

}



/*--------------------------------------------------------------------------------------------------
 * Commit ajax call
 --------------------------------------------------------------------------------------------------*/

// Execute the action only if the user isn't logged in
if (is_user_logged_in()) {
	add_action('init', 'ajax_universities_init');
}
// Execute the action for non users
if (!is_user_logged_in()) {
	add_action('init', 'non_user_init');
}



/*--------------------------------------------------------------------------------------------------
 * Ajax handler for ADD UNIVERSITY
 --------------------------------------------------------------------------------------------------*/
function study_doc_add_university(){

	global $wpdb;
 	$shortname = $_POST['input_add_university_short_name'];
	$add_uni_info = array(
		'shortname' => $_POST['input_add_university_short_name'],
		'name' => $_POST['input_add_university_name'],
		'street' => $_POST['input_add_university_address'],
		'address' => $_POST['input_add_university_optional_address'],
		'city' => $_POST['input_add_university_city'],
		'zip' => $_POST['input_add_university_zip'],
		'state' => $_POST['input_add_university_state'],
		'country' => $_POST['input_add_university_country'],
		'ss_deadline' => $_POST['input_add_university_SS'],
		'ws_deadline' => $_POST['input_add_university_WS'],
		'humanmedizin' => $_POST['input_add_university_hm'],
		'zahnmedizin' => $_POST['input_add_university_zm'],
		'tiermedizin' => $_POST['input_add_university_tm'],
		'HM_summer' => $_POST['input_add_university_hm_summer'],
		'ZM_summer' => $_POST['input_add_university_zm_summer'],
		'TM_summer' => $_POST['input_add_university_tm_summer'],
		'HM_winter' => $_POST['input_add_university_hm_winter'],
		'ZM_winter' => $_POST['input_add_university_zm_winter'],
		'TM_winter' => $_POST['input_add_university_tm_winter'],
	);


	$university_table = $wpdb->prefix . 'universities';


	$adduni = $wpdb -> insert($university_table,$add_uni_info);
	if (!empty($adduni)){
		echo json_encode(array('type'=>'success','message'=>__('Erfolgreich hinzugefügt!', 'study-doc')));
	} else {
		echo json_encode(array('type'=>'error','message'=>__('Fehlgeschlagen!', 'study-doc')));
	}

	die();
}



/*--------------------------------------------------------------------------------------------------
 * Ajax handler for UPDATE UNIVERSITY
 --------------------------------------------------------------------------------------------------*/

function study_doc_update_university(){

	global $wpdb;

	$id = $_POST['input_update_university_id'];

	$update_uni_info = array(
		'shortname' => $_POST['input_update_university_short_name'],
		'name' => $_POST['input_update_university_name'],
		'street' => $_POST['input_update_university_address'],
		'address' => $_POST['input_update_university_optional_address'],
		'city' => $_POST['input_update_university_city'],
		'zip' => $_POST['input_update_university_zip'],
		'state' => $_POST['input_update_university_state'],
		'country' => $_POST['input_update_university_country'],
		'ss_deadline' => $_POST['input_update_university_SS'],
		'ws_deadline' => $_POST['input_update_university_WS'],
		'humanmedizin' => $_POST['input_update_university_hm'],
		'zahnmedizin' => $_POST['input_update_university_zm'],
		'tiermedizin' => $_POST['input_update_university_tm'],
		'HM_summer' => $_POST['input_update_university_hm_summer'],
		'ZM_summer' => $_POST['input_update_university_zm_summer'],
		'TM_summer' => $_POST['input_update_university_tm_summer'],
		'HM_winter' => $_POST['input_update_university_hm_winter'],
		'ZM_winter' => $_POST['input_update_university_zm_winter'],
		'TM_winter' => $_POST['input_update_university_tm_winter'],
	);


	$university_table = $wpdb->prefix . 'universities';



	$updateuni = $wpdb -> update($university_table, $update_uni_info, array('id' => $id));
	if (!empty($updateuni)){
		echo json_encode(array('type'=>'success','message'=>__('Erfolgreich aktualisiert!', 'study-doc')));
	} else {
		echo json_encode(array('type'=>'error','message'=>__('Fehlgeschlagen!', 'study-doc')));
	}

	die();
}



/*--------------------------------------------------------------------------------------------------
 * Ajax handler for DELETE UNIVERSITY (single)
 --------------------------------------------------------------------------------------------------*/
function study_doc_delete_university(){

	global $wpdb;

	$uni = $_POST['uni'];


	$university_table = $wpdb->prefix . 'universities';

	$delete = $wpdb->query( "DELETE FROM $university_table WHERE id = $uni" );

	if (!empty($delete)){
		echo json_encode(array('type'=>'success','message'=>__('Erfolgreich gelöscht!', 'study-doc')));
	} else {
		echo json_encode(array('type'=>'error','message'=>__('Fehlgeschlagen!', 'study-doc')));
	}

	die();
}



/*--------------------------------------------------------------------------------------------------
 * Ajax handler for DELETE UNIVERSITIES (Multi)
 --------------------------------------------------------------------------------------------------*/

function study_doc_delete_universities(){

	global $wpdb;

	$unis = $_POST['unis'];

	$university_table = $wpdb->prefix . 'universities';

	foreach ($unis as $uni) {
		$uni = (int)$uni;

		$message['customtable'] = $wpdb->query( "DELETE FROM $university_table WHERE id = $uni" );

		if($message['customtable']){
			$success .= printf(__('Uni Id %d Erfolgreich gelöscht!', 'study-doc'),$uni) . '<br>';
		}else{
			$error .= printf(__('Uni Id %d kann nicht gelöscht werden!', 'study-doc'),$uni) . '<br>';
		}
	}
	$message['success'] = $success;
	$message['error'] = $error;
	if($message['success']){
		echo json_encode(array('type'=>'success','message'=>$message['success']));
	}else{
		echo json_encode(array('type'=>'error','message'=>$message['error']));
	}

	die();
}


