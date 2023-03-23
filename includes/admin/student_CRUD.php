<?php
/* ---------------------------------------------------------------------------------------------
 * Add new Student, Update Exisitng Student, Delete single or Multuple Students
 * Script enqueue and Ajax handler
 * sec-1 script initialization (all operations)
 * sec-2 script commit (all operations)
 * sec-3 Ajax handler (add)
 * sec-4 Ajax handler (update)
 * sec-5 Ajax handler (show)
 * sec-6 Ajax handler (zip create for files)
 * sec-7 Ajax handler (delete / single)
 * sec-8 Ajax handler (delete / multi)
 ---------------------------------------------------------------------------------------------- */

/*--------------------------------------------------------------------------------------------------
 * Adminside Student Script Localization
 --------------------------------------------------------------------------------------------------*/

function admin_students_crud(){

	wp_register_script('admin-students', get_template_directory_uri() . '/_js/admin/student_CRUD.js', array('jquery', 'wp-i18n'), '1.0.0', true );
	wp_enqueue_script('admin-students');
	
	wp_localize_script( 'admin-students', 'student_admin', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'fill_all_error' => __('Please fill all fields', 'study-doc'),
		'zip_download' => __('Download', 'study-doc'),
		'add_message' => __('Senden der Benutzerinformationen, bitte warten...', 'study-doc'),
		'update_message' => __('Aktualisierung der Benutzerinformationen, bitte warten...', 'study-doc'),
		'delete_message' => __('Löschen, bitte warten...', 'study-doc'),
		'multiple_delete_message' => __('Löschen der Benutzerinformationen, bitte warten...', 'study-doc'),
	));

	// Enable the user with no privileges to run ajax_login() in AJAX
	add_action( 'wp_ajax_add_student', 'study_doc_add_student' );
	add_action( 'wp_ajax_update_student', 'study_doc_update_student' );
	add_action( 'wp_ajax_show_student_details', 'study_doc_student_details' );
	add_action( 'wp_ajax_files_zip_create', 'study_doc_zip_create' );
	add_action( 'wp_ajax_delete_student', 'study_doc_delete_student' );
	add_action( 'wp_ajax_delete_students', 'study_doc_delete_students' );
}


// Execute the action only if the user isn't logged in
if (is_user_logged_in()) {
	add_action('init', 'admin_students_crud');
}

/* --------------------------------------------------------------------------
Student Add Ajax Callback
-------------------------------------------------------------------------- */
function study_doc_add_student(){

	// First check the nonce, if it fails the function will break
	check_ajax_referer( 'add-student-nonce', 'security' );
	global $wpdb;
	$year = date("Y");
	$user_count = count_users();
	$avail_roles = $user_count['avail_roles'];
	$students = $avail_roles['student']; 
	$sem = 'SS';
	$error = array();
	$ext = strtoupper($_POST['last_name'][0].$_POST['first_name'][0]);
	$username = $year.$sem.$students;
	$title = $_POST['title'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$address1 = $_POST['address1'];
	$address2 = $_POST['address2'];
	$city = $_POST['city'];
	$country = $_POST['country'];
	$zip = $_POST['zip'];
	$citizenship = $_POST['citizenship'];
	$telephone = $_POST['telephone'];
	$mobile = $_POST['mobile'];
	$email = $_POST['email'];
	$date_of_birth = $_POST['date_of_birth'];
	$place_of_birth = $_POST['place_of_birth'];
	$gender = $_POST['gender'];
	$s_year = $_POST['syear'];
	$s_semester = $_POST['semester'];
	$s_subject = $_POST['subject'];
	$s_unis = $_POST['universities'];
	$s_universities = implode(',', array_filter($s_unis)) ;
	
	
	$upload_dir   = wp_upload_dir();
	$default_dp = $upload_dir['baseurl'] . '/display_image/default_dp.png';
	$update_time = current_time('mysql');

	$password = substr( md5( uniqid( microtime() ) ), 0, 8);

	$user = wp_create_user($username,$password,$email);
	if (is_wp_error($user)){ // if there was an error creating a new user
		$error[] = __('Das Anlegen eines neuen Studenten ist fehlgeschlagen:', 'study-doc') . " " . $user->get_error_message();
	}else{


		wp_update_user(array("ID"=>$user,"first_name"=>$first_name,"last_name"=>$last_name)); // Update the user with the first name and last name

		$role = new WP_User( $user );

		// Replace the current role with 'student' role
		$role->set_role( 'student' );

		$add_array= array(
			'user' => $user,
			'title' => $title,
			'first_name' => $first_name,
			'last_name' => $last_name,
			'address1' => $address1,
			'address2' => $address2,
			'city' => $city,
			'country' => $country,
			'zip' => $zip,
			'citizenship' => $citizenship,
			'telephone' => $telephone,
			'mobile' => $mobile,
			'email' => $email,
			'date_of_birth' => $date_of_birth,
			'place_of_birth' => $place_of_birth,
			'gender' => $gender,
			'update_time' => $update_time,
			'dp_link' => $default_dp
		);

		foreach($add_array as $key => $value) {
			update_user_meta( $user, $key, $value );
		}
	
		
		$add_array['selected_year'] = $s_year;
		$add_array['selected_semester'] = $s_semester; 
		$add_array['subject'] = $s_subject;
		$add_array['selected_university'] = $s_universities;
		
		$student_table = $wpdb->prefix . 'students';
		$rowResult = $wpdb -> insert($student_table,$add_array);
		

		$login_url = filter_var( home_url(),  FILTER_SANITIZE_URL );
		
		$headers[] = 'Content-Type: text/html;';
		$headers[] = 'From: StudyDoc <info@studydoc.de>' . "\r\n";
		
		$subject = sprintf(__('%s - Benutzer-Registrierung'), get_option('blogname'), 'study-doc');
		
		if($title == 'Herr'){
			$titlex = 'Lieber';
		}elseif($title == 'Frau'){
			$titlex = 'Liebe';
		}else{
			$titlex = 'Leibe/r';
		}
		$message = $titlex . ' ' . $first_name . ',<br><br>';
		$message .= __('Ihr Konto wurde vom StudyDoc Team gemäß Ihrer Anfrage erstellt', 'study-doc') . "<br><br>";
		$message .= sprintf(__('Benutzername: %s'), $username, 'study-doc') . "<br><br>";
		$message .= sprintf(__('Passwort: %s'), $password, 'study-doc') . "<br><br>";
		$message .= sprintf(__('So melden Sie sich bei Ihrem Konto an, click %s.'), $login_url.'/profil/', 'study-doc') . "<br><br>";
		$message .= __('Mit freundlichen Grüßen', 'study-doc') . "<br>";
		$message .= __('StudyDoc', 'study-doc') . "<br><br>";
		$message .= '<hr style="max-width:500px; margin-left:0;color:#FF6600; border-top:0px">';
		$message .= '<small style="font-size:0.8em;">StudyDoc GmbH Millerntorplatz 1, D-20354 Hamburg | <span style="color:#FF6600;">TEL</span> <a href="tel:+49(0)40237241980">+49 (0) 40 237 241 980</a> | <span style="color:#FF6600;">E-MAIL</span> <a href="mailto:info@studydoc.de">info@studydoc.de</a></small><br>';
		$message .= '<small style="font-size:0.8em;"><span style="color:#FF6600;">Bankverbindung</span> Grenke Bank AG DE 42 2013 0400 0060 0152 52, BIC GREBDEH1</small><br>';
		$message .= '<small style="font-size:0.8em;"><span style="color:#FF6600;">Umsatzsteuer-ID</span> DE 309348429 | <span style="color:#FF6600;">Sitz</span> Hamburg | <span style="color:#FF6600;">Handelsregister</span> Hamburg HRB 142646 | <span style="color:#FF6600;">Geschäftsführerin:</span> Karina Schwarz</small>';

		$userInfo = get_userdata($user);
		$to = $userInfo->user_email;

		//send email meassage $email
		if (FALSE == wp_mail($to, $subject, $message, $headers)){
			$error[] = __('Die E-Mail konnte nicht gesendet werden.', 'study-doc');
		}
		
		// create directories for new student
		$upload_dir   = wp_upload_dir();
		if ( isset( $current_user->user_lastname ) && ! empty( $upload_dir['basedir'] ) ) {
			$user_dirname = $upload_dir['basedir'].'/students/'.$userInfo->user_login;
			if ( ! file_exists( $user_dirname ) ) {
				wp_mkdir_p( $user_dirname );
			}
		}
		
		// create user university directories for new student
		foreach(array_filter($s_unis) as $uni){
			$upload_dir   = wp_upload_dir();
			$user_dirname = $upload_dir['basedir'].'/students/'.$userInfo->user_login.'/'.$uni;
			if ( ! file_exists( $user_dirname ) ) {
				wp_mkdir_p( $user_dirname );
			}
		}
		
		
	}
	if (!empty($error) ){
		
		echo json_encode(array('type'=>'error','message'=>__($error)));
	} else {
	
		echo json_encode(array('type'=>'success','message'=>__('Erfolgreich hinzugefügt!', 'study-doc'), 'dbresuld'=> $updateData));
	}

	die();
}


/* --------------------------------------------------------------------------
Student Update Ajax Callback
-------------------------------------------------------------------------- */
function study_doc_update_student(){
	global $wpdb;
	$user = $_POST['user'];

	$update_time = current_time('mysql');
	
	$s_year = $_POST['syear'];
	$s_semester = $_POST['semester'];
	$s_subject = $_POST['subject'];
	$s_unis = $_POST['universities'];
	$s_universities = implode(',', array_filter($s_unis)) ;

	$update_array= array(
		'title' => $_POST['title'],
		'first_name'=>$_POST['first_name'],
		'last_name'=>$_POST['last_name'],
		'address1'=>$_POST['address1'],
		'address2'=>$_POST['address2'],
		'city'=>$_POST['city'],
		'country'=>$_POST['country'],
		'zip'=>$_POST['zip'],
		'citizenship'=>$_POST['citizenship'],
		'telephone'=>$_POST['telephone'],
		'mobile'=>$_POST['mobile'],
		'email'=>$_POST['email'],
		'date_of_birth'=>$_POST['date_of_birth'],
		'place_of_birth'=>$_POST['place_of_birth'],
		'gender'=>$_POST['gender'],
		'Progress_report'=>$_POST['Progress_report'],
		'selected_year' => $s_year,
		'selected_semester' => $s_semester, 
		'subject' => $s_subject,
		'selected_university' => $s_universities,
		'update_time' => $update_time,
		
	);


	$student_table = $wpdb->prefix . 'students';

	$rowR = $wpdb -> update($student_table,$update_array,array('user' => $user));
	
	$userInfo = get_userdata($user);
			
		// create user university directories for exiting student
		foreach(array_filter($s_unis) as $uni){
			$upload_dir   = wp_upload_dir();
			$user_dirname = $upload_dir['basedir'].'/students/'.$userInfo->user_login.'/'.$uni;
			if ( ! file_exists( $user_dirname ) ) {
				wp_mkdir_p( $user_dirname );
			}
		}
	
	if (!empty($rowR)){
		echo json_encode(array('type'=>'success','message'=>__('Erfolgreich aktualisiert!', 'study-doc')));
	} else {
		echo json_encode(array('type'=>'error','message'=>__('Fehlgeschlagen!', 'study-doc')));
	}

	die();
}


/* --------------------------------------------------------------------------
Student's Info Shows Ajax Callback
-------------------------------------------------------------------------- */
function study_doc_student_details(){

	global $wpdb;
	$student_table = $wpdb->prefix . 'students';

	$sutdent_info = 'title,first_name,last_name,address1,address2,country,state,city,zip,citizenship,gender,date_of_birth,place_of_birth,dp_link';
	$sutdent_contact = 'email,email2,telephone,mobile';
	$study_info = 'hzb_type,hzb_date,hzb_city,hzb_country,hzb_school,hzb_grade,hzb_start,hzb_end,study_type,university,subject,present_semester,lpa';
	$package = 'selected_year,selected_semester,selected_university,package,orderID,order_time';
	$uploads = 'documents';

	$user = $_POST['user'];


	$student_infos = $wpdb->get_row( "SELECT $sutdent_info FROM $student_table where user=$user", ARRAY_A );
	$name = $student_infos['last_name'].', '.$student_infos['first_name'];
	$dp_link = $student_infos['dp_link'];
	$upload_dir   = wp_upload_dir();
	$default_dp = $upload_dir['baseurl'] . '/display_image/default_dp.png';
	$src = ($dp_link) ? $dp_link : $default_dp;
	$info = '<div class="row"><div class="col-md-3"><img class="dp-responsive" src="'.$src.'"  alt="'.$name.'">';
	$info .= '</div>';
	$info .= '<div class="col-md-9"><div class="table-responsive">';
	$info .= '<table class="table table-striped table-hover">';
	unset($student_infos['dp_link']);
	foreach ( $student_infos as $row => $value ) {
		switch ($row) {
			case "title":
				$row = __('Anrede', 'study-doc');
				break;
			case "first_name":
				$row = __('Vorname', 'study-doc');
				break;
			case "last_name":
				$row = __('Nachname', 'study-doc');
				break;
			case "address1":
				$row = __('Straße und Hausnummer', 'study-doc');
				break;
			case "address2":
				$row = __('Postanschrift Optional', 'study-doc');
				break;
			case "country":
				$row = __('Land', 'study-doc');
				break;
			case "state":
				$row = __('Staat', 'study-doc');
				break;
			case "city":
				$row = __('Ort', 'study-doc');
				break;
			case "zip":
				$row = __('Postleitzahl', 'study-doc');
				break;
			case "citizenship":
				$row = __('Staatsangehörigkeit', 'study-doc');
				break;
			case "gender":
				$row = __('Geschlecht', 'study-doc');
				break;
			case "date_of_birth":
				$row = __('Geburtsdatum', 'study-doc');
				break;
			case "place_of_birth":
				$row = __('Geburtsort', 'study-doc');
				break;
			case "country_of_birth":
				$row = __('Geburtsland', 'study-doc');
				break;
			default:
				$row = $row;
		}
		$row = ucwords(str_replace("_", " ", $row));
		$info .= "<tr><td>$row</td><td>$value</td>";
		$info .= '</tr>';
	}
	$info .= '</table>';
	$info .= '</div></div></div>';

	$student_contacts = $wpdb->get_row( "SELECT $sutdent_contact FROM $student_table where user=$user", ARRAY_A );
	$contact = '<div class="table-responsive">';
	$contact .= '<table class="table table-striped table-hover">';
	foreach ( $student_contacts as $row => $value ) {
		switch ($row) {
			case "email":
				$row = __('E-Mail-Adresse', 'study-doc');
				break;
			case "email2":
				$row = __('E-Mail Optional', 'study-doc');
				break;
			case "telephone":
				$row = __('Telefonnummer', 'study-doc');
				break;
			case "mobile":
				$row = __('Handynummer', 'study-doc');
				break;
			default:
				$row = $row;
		}
		$row = ucwords(str_replace("_", " ", $row));
		$contact .= "<tr><td>$row</td><td>$value</td>";
		$contact .= '</tr>';
	}
	$contact .= '</table>';
	$contact .= '</div>';

	$student_study = $wpdb->get_row( "SELECT $study_info FROM $student_table where user=$user", ARRAY_A );
	$study = '<div class="table-responsive">';
	$study .= '<table class="table table-striped table-hover">';
	foreach ( $student_study as $row => $value ) {
		switch ($row) {
			case "hzb_type":
				$row = __('Art der HZB', 'study-doc');
				break;
			case "hzb_date":
				$row = __('Datum des Erwerbs der HZB', 'study-doc');
				break;
			case "hzb_city":
				$row = __('Stadt/Kreis des Erwerbs der HZB im Inland', 'study-doc');
				break;
			case "hzb_country":
				$row = __('Land des Erwerbs der HZB im Ausland', 'study-doc');
				break;
			case "hzb_school":
				$row = __('Name der letzten Schule', 'study-doc');
				break;
			case "hzb_grade":
				$row = __('Durchschnittsnote', 'study-doc');
				break;
			case "hzb_start":
				$row = __('Ab Datum', 'study-doc');
				break;
			case "hzb_end":
				$row = __('Bis Datum', 'study-doc');
				break;
			case "study_type":
				$row = __('Abschluss', 'study-doc');
				break;
			case "university":
				$row = __('Universität', 'study-doc');
				break;
			case "subject":
				$row = __('Fach', 'study-doc');
				break;
			case "present_semester":
				$row = __('Fachsemester', 'study-doc');
				break;
			case "lpa":
				$row = __('Landesprüfungsamt', 'study-doc');
				break;
			default:
				$row = $row;
		}
		$row = ucwords(str_replace("_", " ", $row));
		$study .= "<tr><td>$row</td><td>$value</td>";
		$study .= '</tr>';
	}
	$study .= '</table>';
	$study .= '</div>';


	$student_package = $wpdb->get_row( "SELECT $package FROM $student_table where user=$user", ARRAY_A );
	$packages = '<div class="table-responsive">';
	$packages .= '<table class="table table-striped table-hover">';
	foreach ( $student_package as $row => $value ) {
		switch ($row) {
			case "selected_year":
				$row = __('Ausgewähltes Jahr', 'study-doc');
				break;
			case "selected_semester":
				$row = __('Ausgewähltes Semester', 'study-doc');
				break;
			case "selected_university":
				$row = __('Ausgewähltes Universität', 'study-doc');
				break;
			case "package":
				$row = __('Paket', 'study-doc');
				break;
			case "orderID":
				$row = __('Bestellnummer', 'study-doc');
				break;
			case "order_time":
				$row = __('Zeit bestellen', 'study-doc');
				break;
			default:
				$row = $row;
		};
		$packages .= "<tr><td>$row</td><td>$value</td>";
		$packages .= '</tr>';
	}
	$packages .= '</table>';
	$packages .= '</div>';


	$student_upload = $wpdb->get_row( "SELECT documents FROM $student_table where user=$user" );
	$document = $student_upload->documents;
	$unserialize = unserialize($document);
	$upload = '<div class="table-responsive">';
	$upload .= '<table class="table table-striped table-hover">';
	foreach ( $unserialize as $row => $value ) {
		if(!empty($value)){

			$row = str_replace("_", " ", $row);
			$row = ucwords($row, " ");
			$upload .= "<tr><td>$row</td><td><a href=\"$value\" target=\"_blank\">" . __('Download', 'study-doc') . "</a></td>";
			$upload .= '</tr>';
		}
	}
	$upload .= '</table>';
	$upload .= '</div>';
	$upload .= "<div class=\"zips\"><a href=\"#\" class=\"submit_button\" data-student_id=\"$user\" id=\"generatezip\" >" . __('ZIP generieren', 'study-doc') . "</a></div>";

	echo json_encode(array(
		'type'=>'success',
		'name'=>$name,
		'student_info'=>__($info),
		'sutdent_contact'=>__($contact),
		'study_info'=>__($study),
		'package'=>__($packages),
		'uploads'=>__($upload)));
	die();
}


/* --------------------------------------------------------------------------
Zip Creation for Download all Student Documents Ajax Callback
-------------------------------------------------------------------------- */
function study_doc_zip_create(){

	$userID = $_POST['user'];
	$userOBJ = get_user_by('id', $userID);
	$user = $userOBJ->user_login;

	$dirs = wp_upload_dir();
	$dirs['subdir'] = '/students/'. $user;
	$dirs['path'] = $dirs['basedir'] .'/students/'. $user;
	$dirs['url'] = $dirs['baseurl'] .'/students/'. $user;

	$zip = new ZipArchive();

	$FileName = $user . ".zip";

	if(file_exists($dirs['path'] .'/'. $FileName)) {

		unlink ($dirs['path'] .'/'. $FileName); 

	}

	if ($zip->open($dirs['path'] .'/'. $FileName, ZIPARCHIVE::CREATE) != TRUE) {
		die (__('Archiv konnte nicht geöffnet werden', 'study-doc'));
	}

	global $wpdb;
	$student_table = $wpdb->prefix . 'students';

	$file_list = $wpdb->get_row( "SELECT documents FROM $student_table where user = $userID");
	$files = $file_list->documents;
	$unserialize = unserialize($files);

	foreach ( $unserialize as $file => $url ) {
		if(!empty($url)){
			$pathinfo = pathinfo($url);
			$basename = $pathinfo['basename'];
			$extension = $pathinfo['extension'];
			$filepath = $dirs['path'] . '/' . $basename;
			$zip->addFile($filepath, $file.'.'.$extension);
		}
	}

	// close and save archive

	$zip->close();
	$zip_path = $dirs['path'] .'/'. $FileName;
	if (file_exists($zip_path)) {
		$zip_url = $dirs['url'] .'/'. $FileName; 
		echo json_encode(array('type'=>'success','message'=>$zip_url));
	}else{
		echo json_encode(array('type'=>'error','message'=>__('Etwas ist schief gelaufen, bitte versuchen Sie es erneut.', 'study-doc')));
	}
	die();
}



/* --------------------------------------------------------------------------
Student Delete (Single) Callback Function
-------------------------------------------------------------------------- */
function study_doc_delete_student(){

	// First check the nonce, if it fails the function will break
	//check_ajax_referer( 'ajax-update-nonce', 'security' );
	global $wpdb;

	$user = (int)$_POST['user'];
	$delete_array= array(
		$user = $_POST['user']
	);


	$student_table = $wpdb->prefix . 'students';
	$meta_table = $wpdb->prefix . 'usermeta';

	$current_user = get_user_by( 'id', $user );
	$upload_dir   = wp_upload_dir();
	$dp_dir = $upload_dir['basedir'].'/display_image/'.$current_user->user_login;
	$files_dir = $upload_dir['basedir'].'/students/'.$current_user->user_login;
	rmdir($dp_dir);
	rmdir($files_dir);

	//$rowR = $wpdb -> delete($table_name,$delete_array);
	$rowR = $wpdb->query( "DELETE FROM $student_table WHERE user = $user" );
	$rowR = $wpdb->query( "DELETE FROM $meta_table WHERE user_id = $user" );
	wp_delete_user( $user );
	if (!empty($rowR)){
		echo json_encode(array('type'=>'success','message'=>__('Erfolgreich gelöscht!', 'study-doc')));
	} else {
		echo json_encode(array('type'=>'error','message'=>__('Fehlgeschlagen!', 'study-doc'), 'user'=> $user, 'status'=> $rowR));
	}

	die();
}


/* --------------------------------------------------------------------------
Students Delete (Multiple) Ajax Callback
-------------------------------------------------------------------------- */
function study_doc_delete_students(){

	global $wpdb;
	$test = '';
	$ids = $_POST['ids'];

	$student_table = $wpdb->prefix . 'students';
	$meta_table = $wpdb->prefix . 'usermeta';

	foreach ($ids as $id) {
		$user = (int)$id;
		$current_user = get_user_by( 'id', $user );
		$upload_dir   = wp_upload_dir();
		$dp_dir = $upload_dir['basedir'].'/display_image/'.$current_user->user_login;
		$files_dir = $upload_dir['basedir'].'/students/'.$current_user->user_login;
		rmdir($dp_dir);
		rmdir($files_dir);
		$message['customtable'] = $wpdb->query( "DELETE FROM $student_table WHERE user = $user" );
		$message['metatable'] = $wpdb->query( "DELETE FROM $meta_table WHERE user_id = $user" );
		$message['user'] = wp_delete_user( $user );
		if($message['customtable'] && $message['metatable'] != 0 && $message['user']){
			$success .= printf(__("Studenten-ID %d Erfolgreich gelöscht!", $id, 'study-doc')) . '<br>';
		}else{
			$error .= printf(__("Studenten-ID %d kann nicht gelöscht werden!", $id, 'study-doc')) . '<br>';
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

