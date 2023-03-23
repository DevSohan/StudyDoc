<?php
/*
	 * functions.php
	 * 
	 */


/* --------------------------------------------------------------------------
	   Include necessary files
	   -------------------------------------------------------------------------- */

// user.php from wp-admin/includes
require_once( ABSPATH.'wp-admin/includes/user.php' );
// Database Tables
require_once(get_template_directory().'/includes/table_db.php');
// MPDF
require_once(get_template_directory().'/includes/MPDF/autoload.php');
// Woocommerce hooks
require_once(get_template_directory().'/includes/wc/custom_wc_hooks.php');
require_once(get_template_directory().'/includes/wc/wc_profile_hooks.php');
// General Users funtions
require_once(get_template_directory().'/includes/users/ajax-dp.php');
require_once(get_template_directory().'/includes/users/ajax-login-logout.php');
require_once(get_template_directory().'/includes/users/reset-pass.php');
require_once(get_template_directory().'/includes/users/lost-password.php');
//Admin Functions
require_once(get_template_directory().'/includes/admin/student_CRUD.php');
require_once(get_template_directory().'/includes/admin/student_export.php');
require_once(get_template_directory().'/includes/admin/university_CRUD.php');
// require_once(get_template_directory().'/includes/admin/update-status.php');
//Students Functions
// require_once(get_template_directory().'/includes/student/student-registration-frontend.php');
require_once(get_template_directory().'/includes/student/stu-info-update.php');
// require_once(get_template_directory().'/includes/student/uni-select-update.php');
require_once(get_template_directory().'/includes/student/stu-permission.php');
require_once(get_template_directory().'/includes/student/docs-upload.php');
//Misc
require_once(get_template_directory().'/includes/custom_shortcode.php');
require_once(get_template_directory().'/includes/tabslide.php');
require_once(get_template_directory().'/includes/emailcomp.php');
require_once(get_template_directory().'/includes/style-script-enqueue.php');

require_once (get_template_directory() . '/includes/googleapi/vendor/autoload.php');


function study_doc_load_theme_textdomain() {
	load_theme_textdomain( 'study-doc', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'study_doc_load_theme_textdomain' );



/* --------------------------------------------------------------------------
	   Theme Support
	   -------------------------------------------------------------------------- */
add_theme_support( 'menus' );
if ( ! function_exists( 'register_nav_menu' ) ) {

	function register_nav_menu(){
		register_nav_menus( array(
			'primary_menu' => __( 'Primary Menu', 'study-doc' ),
			'footer_menu'  => __( 'Footer Menu', 'study-doc' ),
		) );
	}
	add_action( 'after_setup_theme', 'register_nav_menu', 0 );
}

/* --------------------------------------------------------------------------
	   Elementor Hooq for header and footer
	   -------------------------------------------------------------------------- */
function theme_prefix_register_elementor_locations( $elementor_theme_manager ) {

	$elementor_theme_manager->register_all_core_location();

}

add_action( 'elementor/theme/register_locations', 'theme_prefix_register_elementor_locations' );

/* --------------------------------------------------------------------------
	   Remove admin bar
	   -------------------------------------------------------------------------- */
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
		show_admin_bar(false);
	}
}

//function hide_admin_bar(){ return false; }
//add_filter( 'show_admin_bar', 'hide_admin_bar' );
/* --------------------------------------------------------------------------
	   Logout Refirect
	   -------------------------------------------------------------------------- */
add_action('wp_logout','logout_redirect');
function logout_redirect(){
	wp_redirect( home_url() );  
	exit;
}

/* --------------------------------------------------------------------------
	   New User Role
	   -------------------------------------------------------------------------- */

add_role(
	'student',
	__( 'Student' ),
	array(
		'read'         => true,  // true allows this capability
		'edit_posts'   => true,
	)
);

/* --------------------------------------------------------------------------
	   User Role class to body tag
	   -------------------------------------------------------------------------- */
add_filter('body_class','user_role_class');

add_filter('body_class','user_role_class');
function user_role_class($classes) {
	$current_user = new WP_User(get_current_user_id());
	$user_role = array_shift($current_user->roles);
	if ( is_user_logged_in() ) {
		$classes[] = 'role-'. $user_role;
	}
	return $classes;
}

/* --------------------------------------------------------------------------
	   User Directory Create
	   -------------------------------------------------------------------------- */

// $current_user = wp_get_current_user();
// $upload_dir   = wp_upload_dir();
// if ( isset( $current_user->user_lastname ) && ! empty( $upload_dir['basedir'] ) ) {
// 	$user_dirname = $upload_dir['basedir'].'/students/'.$current_user->user_login;
// 	if ( ! file_exists( $user_dirname ) ) {
// 		wp_mkdir_p( $user_dirname );
// 	}
// }


function custom_upload_dir( $dirs ) {

	$current_user = wp_get_current_user();
	$dirs['subdir'] = '/display_image/'.$current_user->user_login;
	$dirs['path'] = $dirs['basedir'] .'/display_image/'.$current_user->user_login;
	$dirs['url'] = $dirs['baseurl'] .'/display_image/'.$current_user->user_login;
	return $dirs;
}


function document_upload_dir( $dirs ) {

	$current_user = wp_get_current_user();
	$dirs['subdir'] = '/students/'.$current_user->user_login;
	$dirs['path'] = $dirs['basedir'] .'/students/'.$current_user->user_login;
	$dirs['url'] = $dirs['baseurl'] .'/students/'.$current_user->user_login;
	return $dirs;
}

function custom_hash_filename( $filename ) {
	$random = substr(str_shuffle('1234567890abcefghijklmnopqrstuvwxyz'), 0, 20);
	$append = apply_filters('usp_file_append_random', true, $filename, $random);

	if (!$append) return $filename;

	$info = pathinfo($filename);
	$ext  = (isset($info['extension']) && !empty($info['extension'])) ? '.'. $info['extension'] : '';
	$name = basename($filename, $ext) .'_'. $random;

	return $name . $ext;
}

add_filter('autoptimize_filter_noptimize','pagebuilder_noptimize',10,0);
function pagebuilder_noptimize() {
	return is_user_logged_in();
}


add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );





add_action( 'elementor_pro/forms/new_record', function( $record, $handler ) {
	$form_name = $record->get_form_settings( 'form_name' );
	if ( 'test' !== $form_name ) {
		return;
	}
	/*
	$raw_fields = $record->get( 'fields' );
	$fields = [];
	foreach ( $raw_fields as $id => $field ) {
		$fields[ $id ] = $field['value'];
	}
	$to = $fields['email'];
	$subject = 'send email with PDF after submit';
	$message = 'this email contains a PDF';
	*/
	$form_data = $record->get_formatted_data();
	$anrede = $form_data['Anrede'];
	$vorname = $form_data['Vorname'];
	$nachname = $form_data['Nachname'];
	$strasse = $form_data['Straße'];
	$strasse_no = $form_data['Nr.'];
	$postleitzahl = $form_data['Postleitzahl'];
	$ort = $form_data['Ort'];
	$telefon = $form_data['Telefon'];
	$email = $form_data['Email'];
	$studiengang = $form_data['Studiengang'];
	$Staatsangehoerigkeit = $form_data['Staatsangehörigkeit'];
	$acceptance_1 = $form_data['Item #14'];
	$acceptance_2 = $form_data['Item #15'];

	if($anrede == 'Herr'){
		$title = 'Lieber';
	}elseif($anrede == 'Frau'){
		$title = 'Liebe';
	}
	$html2 = $title . ' ' . $nachname . ',<br><br>';
	$html2 .= 'wir freuen uns über dein Interesse an einem Medizinstudium mit StudyDoc. Im Anhang von dieser Email findest dein Studien-Guide zum Human- und Zahnmedizinstudium.<br><br>';
	$html2 .= 'In den nächsten Tagen erhältst du auch Informationsunterlagen per Post von uns.<br><br>';
	$html2 .= 'Um deine individuellen Chancen zu besprechen und deine Fragen zu beantworten, ruf uns gerne an unter +49 (0) 40 237 241 980 oder buche deinen kostenfreien Beratungstermin unter <a href="https://studydoc.de/terminvereinbarung/">https://studydoc.de/terminvereinbarung/</a>.<br><br>';
	$html2 .= 'Wir freuen uns darauf dir zu deinem Wunschstudienplatz verhelfen zu können!<br><br>';
	$html2 .= 'Liebe Grüße<br>Dein StudyDoc Team<br><br>';
	$html2 .= '<hr>';
	$html2 .= '<small>StudyDoc GmbH Millerntorplatz 1, D-20354 Hamburg | <span style="">TEL</span> <a href="">+49 (0) 40 237 241 980</a> | <span style="">E-MAIL <a href="">info@studydoc.de</a></small><br>';
	$html2 .= '<small><span style="">Bankverbindung</span> Grenke Bank AG DE 42 2013 0400 0060 0152 52, BIC GREBDEH1</small><br>';
	$html2 .= '<small><span style="">Umsatzsteuer-ID</span> DE 309348429 | <span style="">Sitz</span> Hamburg | <span style="">Handelsregister</span> Hamburg HRB 142646</small>';



	global $wpdb;
	$upload_dir  = wp_upload_dir();
	$directoro = $upload_dir['basedir'].'/sd/'.'StudyDoc_Studien_Guide.pdf';
	$attachments = $directoro;
	$to = $email;
	$headers = array('From: StudyDoc <info@studydoc.de>');
	$subject = 'Studydoc Infomaterial';
	$message = 	$html2;	
	wp_mail( $to, $subject, $message, $headers,$attachments);
	return;

}, 10, 2);

/* --------------------------------------------------------------------------------------------------------------------------

					Elementor Email2

   ------------------------------------------------------------------------------------------------------------------------*/
add_action( 'elementor_pro/forms/new_record',  'registration_form' , 10, 3 ); // This is the hooks of elementor form after form submit

function registration_form($record,$ajax_handler) // creating function 
{
	$form_name = $record->get_form_settings( 'form_name' );
	if ( 'InfoPaket' !== $form_name ) {
		return;
	}
	$form_data = $record->get_formatted_data();
	$anrede = $form_data['Anrede'];
	$vorname = $form_data['Vorname'];
	$nachname = $form_data['Nachname'];
	$strasse = $form_data['Straße'];
	$strasse_no = $form_data['Nr.'];
	$postleitzahl = $form_data['Postleitzahl'];
	$ort = $form_data['Ort'];
	$telefon = $form_data['Telefon'];
	$email = $form_data['Email'];
	$studiengang = $form_data['Studiengang'];
	$Staatsangehoerigkeit = $form_data['Staatsangehörigkeit'];
	$acceptance_1 = $form_data['Item #14'];
	$acceptance_2 = $form_data['Item #14'];

	if($anrede == 'Herr'){
		$title = 'Lieber';
	}elseif($anrede == 'Frau'){
		$title = 'Liebe';
	}else{
		$title = 'leibe/r';
	}
	$html2 = $title . ' ' . $vorname . ',<br><br>';
	$html2 .= 'wir freuen uns über dein Interesse an einem Medizinstudium mit StudyDoc. Im Anhang von dieser Email findest dein Studien-Guide zum Human- und Zahnmedizinstudium.<br><br>';
	$html2 .= 'In den nächsten Tagen erhältst du auch Informationsunterlagen per Post von uns.<br><br>';
	$html2 .= 'Um deine individuellen Chancen zu besprechen und deine Fragen zu beantworten, ruf uns gerne an unter <a style="color:#FF6600;" href="tel:+49(0)40237241980">+49 (0) 40 237 241 980</a> oder buche deinen kostenfreien Beratungstermin unter <a style="color:#FF6600;" href="https://studydoc.de/terminvereinbarung/">https://studydoc.de/terminvereinbarung/</a>.<br><br>';
	$html2 .= 'Wir freuen uns darauf dir zu deinem Wunschstudienplatz verhelfen zu können!<br><br>';
	$html2 .= 'Liebe Grüße<br>Dein StudyDoc Team<br><br>';
	$html2 .= '<hr style="max-width:500px; margin-left:0;color:#FF6600; border-top:0px">';
	$html2 .= '<small style="font-size:0.8em;">StudyDoc GmbH Millerntorplatz 1, D-20354 Hamburg | <span style="color:#FF6600;">TEL</span> <a href="tel:+49(0)40237241980">+49 (0) 40 237 241 980</a> | <span style="color:#FF6600;">E-MAIL</span> <a href="mailto:info@studydoc.de">info@studydoc.de</a></small><br>';
	$html2 .= '<small style="font-size:0.8em;"><span style="color:#FF6600;">Bankverbindung</span> Grenke Bank AG DE 42 2013 0400 0060 0152 52, BIC GREBDEH1</small><br>';
	$html2 .= '<small style="font-size:0.8em;"><span style="color:#FF6600;">Umsatzsteuer-ID</span> DE 309348429 | <span style="color:#FF6600;">Sitz</span> Hamburg | <span style="color:#FF6600;">Handelsregister</span> Hamburg HRB 142646 | <span style="color:#FF6600;">Geschäftsführerin:</span> Karina Schwarz</small>';



	global $wpdb;
	$upload_dir  = wp_upload_dir();
	$directoro = $upload_dir['basedir'].'/sd/'.'StudyDoc_Studien_Guide.pdf';
	$attachments = $directoro;
	$to = $email;
	$headers = array('From: StudyDoc <info@studydoc.de>','Content-Type: text/html; charset=UTF-8');
	$subject = 'Studydoc Infomaterial';
	$message = 	$html2;	
	wp_mail( $to, $subject, $message, $headers,$attachments);
	
	
	$spreadsheetId = "1-fEFdN7JeqqjrpoZKHnpbcCzqnBohHa3EZRYLxrxKDk";
	
	//add the appointment to google spreadsheet
	$client = new \Google_Client();
	$client->setApplicationName('StudyDoc');
	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS, \Google_Service_Sheets::DRIVE, \Google_Service_Sheets::DRIVE_FILE]);
	$client->setAccessType('offline');
	$client->setAuthConfig(get_template_directory() . '/includes/googleapi/credentials.json');
	$service = new Google_Service_Sheets($client);
	$update_range = "Details";
	
	$values = [[$anrede, $vorname, $nachname, $strasse, $strasse_no, $postleitzahl, $ort, $telefon, $email, $studiengang, $Staatsangehoerigkeit]];
	$body = new Google_Service_Sheets_ValueRange([
		'values' => $values
	]);
	$params = [
		'valueInputOption' => 'USER_ENTERED'
	];
	$spreadsheet_append = $service->spreadsheets_values->append($spreadsheetId, $update_range, $body, $params);
	
	return;
}