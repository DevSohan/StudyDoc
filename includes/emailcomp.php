<?php
/***************************** EMAIL COMPOSER ************************************/


function ajax_emailComp_init(){

	wp_register_script('ajax-emailComp-script', get_template_directory_uri() . '/_js/admin/emailcomp.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('ajax-emailComp-script');

	wp_enqueue_script('tiny_mce');

	wp_localize_script( 'ajax-emailComp-script', 'ajax_settemp_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' )
	));
	wp_localize_script( 'ajax-emailComp-script', 'ajax_emailComp_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url(),
		'loadingmessage' => __('Sending...')
	));
	/*wp_localize_script( 'ajax-emailComp-script', 'ajax_human_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url()

	));*/
	wp_localize_script( 'ajax-emailComp-script', 'ajax_emailview_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url()
	));

	wp_localize_script( 'ajax-emailComp-script', 'ajax_emailtemp_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url()
	));

	wp_localize_script( 'ajax-emailComp-script', 'ajax_tempview_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url()
	));

	wp_localize_script( 'ajax-emailComp-script', 'ajax_tempedit_object', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'redirecturl' => home_url()
	));

	//add_action( 'wp_ajax_ajaxhuman', 'ajax_human' );
	add_action( 'wp_ajax_ajaxsettemp', 'ajax_settemp' );
	add_action( 'wp_ajax_ajaxemailComp', 'ajax_emailComp' );
	add_action( 'wp_ajax_ajaxemailview', 'ajax_emailview' );
	add_action( 'wp_ajax_ajaxemailtemp', 'ajax_emailtemplate' );
	add_action( 'wp_ajax_ajaxtempview', 'ajax_tempview' );
	add_action( 'wp_ajax_ajaxtempedit', 'ajax_tempedit' );
}

if (is_user_logged_in()) {
	add_action('init', 'ajax_emailComp_init');
}


/***************************** EMAIL FILTER AJAX ***********************************
function ajax_human(){

	global $wpdb;

	$subject = $_POST['subject'];
	$subject = ucfirst($subject);

	$student_table = $wpdb->prefix . 'student_test_1';
	$resulto = $wpdb->get_results( "SELECT * FROM $student_table WHERE `subject` = '$subject'" );
	$table = "<thead>";
	$table .= "<tr style=\"background-color: #eeeeee;\">";
	$table .= "<th class=\"disableFilterBy disableSort\">  <span class=\"custom-checkbox\">";
	$table .= "<input type=\"checkbox\" id=\"selectAll\" class=\"selectAll\" value=\"$row->email\">";
	$table .= "<label for=\"selectAll\"></label>";
	$table .= "</span>";
	$table .= "</th>";
	$table .= "<th class=\"disableSort\">Name</th>";
	$table .= "<th class=\"disableSort\">Email</th>";
	$table .= "<th class=\"disableSort hide\">Subject</th>";
	$table .= "</tr>";
	$table .= "</thead>";
	$table .= "<tbody>";

	if(!empty($resulto)){
		foreach ($resulto as $row) {

			$table .= "<tr id=\"$row->user;\">";
			$table .= "<td>";
			$table .= "<span class=\"custom-checkbox\">";
			$table .= "<input type=\"checkbox\" class=\"user_checkbox\" data-user-id=\"$row->user\" value=\"$row->email\">";
			$table .= "<label for=\"checkbox2\"></label>";
			$table .= "</span>";
			$table .= "</td>";
			$table .= "<td>$row->first_name</td>";
			$table .= "<td>$row->email</td>";
			$table .= "<td class=\"hide\">$row->subject</td>";
			$table .= "</tr>";

			$i++;
		}

		$table .= "</tbody>";
		echo json_encode(array('message'=>__($table)));


	}
	else {
		echo json_encode(array('message'=>__('NO DATA FOUND')));
	}

	die();

}
*/

/***************************** Set Template Content to Mail COMPOSER AJAX ************************************/
function ajax_settemp(){
	global $wpdb;
	$email_template_table = $wpdb->prefix . 'mail_templates';

	$id = $_POST['id'];
	$template = $wpdb->get_row( "SELECT * FROM $email_template_table where id = $id");
	$name = $template->name;
	$subject = $template->subject;
	$content = htmlspecialchars_decode(stripslashes($template->content));
	if ($template != false){
		echo json_encode(array('type'=> 'success','message'=>'Vorlage erfolgreich hinzugefügt!', 'name' => $name, 'subject' => $subject, 'content' => $content));
	} else {
		echo json_encode(array('type'=> 'error','message'=>'Erfolglos!'));
	}

	die();
}

/***************************** EMAIL COMPOSER AJAX ************************************/
function ajax_emailComp(){

	if (!function_exists('wp_handle_upload')) {
		require_once(ABSPATH . 'wp-admin/includes/file.php');
	}

	global $wpdb;

	// Get the submited email addresses into an array
	$email_arr = explode(',', $_POST['email']);

	// Implode that array into a comma-delimited string
	foreach($email_arr as $email){
		$to = $email;
		$user = get_user_by( 'email', $to );
		$id = $user->ID;

		$subjects = $_POST["subjects"];

		$messagetext = $_POST["messagetext"];
		//$messagetexts = strip_tags($messagetext);
		$messagetexts = str_replace('&#13;', '<br />', $messagetext);
		$messagetexts = htmlspecialchars_decode(stripslashes($messagetexts));

		$student_table = $wpdb->prefix . 'students';
		$student = $wpdb->get_row( "SELECT * FROM $student_table WHERE user = $id" );
		$title = $student->title;
		$first_name = $student->first_name;
		$last_name = $student->last_name;
		$address1 = $student->address1;
		$address2 = $student->address2;
		$country = $student->country;
		$state = $student->state;
		$city = $student->city;
		$zip = $student->zip;

		$pattern = "^\[(.*?)\]^";
		//preg_match_all(pattern, input, matches, (flags, offset)) 
		if(preg_match_all($pattern, $messagetexts, $matches)) {
			foreach($matches[0] as $match){
				switch ($match) {
					case "[Anrede]":
						$messagetexts = str_replace($match, $title, $messagetexts );
						break;
					case "[Vorname]":
						$messagetexts = str_replace($match, $first_name, $messagetexts );
						break;
					case "[Nachname]":
						$messagetexts = str_replace($match, $last_name, $messagetexts );
						break;
					case "[Strasse-und-Hausnummer]":
						$messagetexts = str_replace($match, $address1, $messagetexts );
						break;
					case "[Adresszusatz]":
						$messagetexts = str_replace($match, $address2, $messagetexts );
						break;
					case "[Bundesland]":
						$messagetexts = str_replace($match, $state, $messagetexts );
						break;
					case "[Ort]":
						$messagetexts = str_replace($match, $city, $messagetexts );
						break;
					case "[Land]":
						$messagetexts = str_replace($match, $country, $messagetexts );
						break;
					case "[Postleitzahl]":
						$messagetexts = str_replace($match, $zip, $messagetexts );
						break;
				}
			}
		}



		$from = "info@studydoc.de";

		$headers[] = 'Content-Type: text/html;';
		$headers[] = 'From: StudyDoc <'.$from.'> ' . "\r\n";

		$update_time = current_time('mysql');
		$email_array = array(
			'email' => $to,
			'subjects'=>$_POST['subjects'],
			'messagetext'=>$messagetexts,
			'update_time' => $update_time,
		);

		$attachments = $_FILES['attachments'];
		$upload_overrides = array('test_form' => false);
		$count = count($attachments['name']);

		if($count > 0){
			foreach ($attachments['name'] as $key => $value) {
				if ($attachments['name'][$key]) {
					$attachment = array(
						'name'     => $attachments['name'][$key],
						'type'     => $attachments['type'][$key],
						'tmp_name' => $attachments['tmp_name'][$key],
						'error'    => $attachments['error'][$key],
						'size'     => $attachments['size'][$key]
					);

					add_filter( 'upload_dir', 'files_upload_dir' );
					add_filter( 'sanitize_file_name', 'files_hash_name', 10 );

					$movefile = wp_handle_upload($attachment, $upload_overrides);

					remove_filter( 'sanitize_file_name', 'files_hash_name', 10 );
					remove_filter( 'upload_dir', 'files_upload_dir' );

					if ($movefile && !isset($movefile['error'])) {
						$attachments_file[] = $movefile['file'];
						$attachments_url[] = $movefile['url'];
						$test .= $movefile['file'] . '</br>';
					} else {
						$test .= $movefile['error'] . '</br>';
					}
				}
			}

			$attachments_fileString = implode (",", $attachments_file);
			$attachments_urlString = implode (",", $attachments_url);
			$email_array['attachments'] = $attachments_fileString;
			$email_array['attachments_url'] = $attachments_urlString;
		}

		$email_table = $wpdb->prefix . 'emails';
		$insertRow = $wpdb -> insert($email_table,$email_array,$format=NULL);

		if($count > 0){
			$sentMailResult = wp_mail($to, $subjects, $messagetexts, $headers, $attachments_file);
		}else{
			$sentMailResult = wp_mail($to, $subjects, $messagetexts, $headers);
		}

		if ($insertRow != false && $sentMailResult){
			$mail[$to] = 'Erfolg';
		} else {
			$mail[$to] = 'Erfolglos';
		}
	}
	if ($mail){
		echo json_encode(array('type'=> 'success','message'=>'Mail erfolgreich gesendet!', 'mail_list'=>$mail));
	} else {
		echo json_encode(array('type'=> 'error','message'=>'Erfolglos!'));
	}

	die();

}




function files_upload_dir( $dirs ) {

	$current_user = wp_get_current_user();
	$dirs['subdir'] = '/display_image/'.$current_user->user_login;
	$dirs['path'] = $dirs['basedir'] .'/display_image/'.$current_user->user_login;
	$dirs['url'] = $dirs['baseurl'] .'/display_image/'.$current_user->user_login;
	return $dirs;
}


function files_hash_name( $filename ) {
	$random = substr(str_shuffle('1234567890abcefghijklmnopqrstuvwxyz'), 0, 20);
	$append = apply_filters('usp_file_append_random', true, $filename, $random);

	if (!$append) return $filename;

	$info = pathinfo($filename);
	$ext  = (isset($info['extension']) && !empty($info['extension'])) ? '.'. $info['extension'] : '';
	$name = basename($filename, $ext) .'_'. $random;

	return $name . $ext;
}
/***************************** EMAIL VIEW AJAX ************************************/



function ajax_emailview(){

	global $wpdb;
	$email_table = $wpdb->prefix . 'emails';

	$emailid = $_POST['emailid'];

	$email = $wpdb->get_row( "SELECT * FROM $email_table where emailid=$emailid");

	$html = '<div class="mail_item">';
	$html .= '<h6>Gesendet an:</h6>';
	$html .= '<div class="emails">';
	$html .= $email->email;
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="mail_item">';
	$html .= '<h6>Subject: </h6>';
	$html .= '<div class="subject">';
	$html .= $email->subjects;
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="mail_item">';
	$html .= '<h6>Nachricht: </h6>';
	$html .= '<div class="message">';
	$html .= htmlspecialchars_decode(stripslashes($email->messagetext));
	$html .= '</div>';
	$html .= '</div>';
	if(!empty($email->attachments_url)){
		$html .= '<div class="mail_item">';
		$html .= '<h6>Anhänge: </h6>';
		$html .= '<div class="attachments">';
		$attach_arr = explode(",",$email->attachments_url);
		foreach($attach_arr as $id => $attachment){
			$id = $id + 1;
			$html .= '<a href="' . $attachment . '" target="_blank">Attachment ' . $id . '</a>';
		}
		$html .= '</div>';
		$html .= '</div>';
	}
	if (!empty($email)){
		echo json_encode(array('message'=>$html));
	} else {
		echo json_encode(array('message'=>__('Erfolglos!')));
	}

	die();

}


/***************************** EMAIL Template AJAX ************************************/



function ajax_emailtemplate(){

	global $wpdb;
	$email_template_table = $wpdb->prefix . 'mail_templates';

	$name = $_POST['name'];
	$subject = $_POST['subject'];
	$content = $_POST['content'];

	$contents = strip_tags($content);
	$contents = str_replace('&#13;', '<br />', $content);

	$id = current_time('timestamp');

	$template_array = array(
		'id'=>$id,
		'name'=>$name,
		'subject'=>$subject,
		'content'=>$contents
	);

	$insertRow = $wpdb -> insert($email_template_table,$template_array,$format=NULL);

	$action = '<tr id="' . $id . '">
						<td>' . $name . '</td>
						<td>' . $subject . '</td>
						<td style="text-align: center;">
							<a href="#viewTemplateModal" class="view" data-toggle="modal" 
							   data-id="' . $id . '"><i class="fas fa-file-alt"></i></a>
							<a href="#editTemplateModal" class="edit" data-toggle="modal" 
							   data-id="' . $id . '"
							   ><i class="fas fa-pen"></i></a>
							<a href="#deleteTemplateModal" class="delete" data-id="' . $id . '" data-toggle="modal"><i class="fas fa-trash"></i></a>
						</td>
					</tr>';


	if ($insertRow != false){
		echo json_encode(array('type'=> 'success','message'=>'Vorlage erfolgreich hinzugefügt!', 'id' => $id, 'content' => $action));
	} else {
		echo json_encode(array('type'=> 'error','message'=>'Erfolglos!'));
	}

	die();

}

/***************************** Template View AJAX ************************************/



function ajax_tempview(){

	global $wpdb;
	$email_template_table = $wpdb->prefix . 'mail_templates';

	$id = $_POST['id'];
	$template = $wpdb->get_row( "SELECT * FROM $email_template_table where id = $id");
	$name = $template->name;
	$subject = $template->subject;
	$content = htmlspecialchars_decode(stripslashes($template->content));
	if ($template != false){
		echo json_encode(array('type'=> 'success','message'=>'Vorlage erfolgreich hinzugefügt!', 'name' => $name, 'subject' => $subject, 'content' => $content));
	} else {
		echo json_encode(array('type'=> 'error','message'=>'Erfolglos!'));
	}

	die();

}

/***************************** Template Edit AJAX ************************************/



function ajax_tempedit(){

	global $wpdb;
	$email_template_table = $wpdb->prefix . 'mail_templates';

	$id = $_POST['id'];
	$template = $wpdb->get_row( "SELECT * FROM $email_template_table where id = $id");
	$name = $template->name;
	$subject = $template->subject;
	$content = $template->content;
	if ($template != false){
		echo json_encode(array('type'=> 'success','message'=>'Vorlage erfolgreich hinzugefügt!', 'name' => $name, 'subject' => $subject, 'content' => $content));
	} else {
		echo json_encode(array('type'=> 'error','message'=>'Erfolglos!'));
	}

	die();

}