<?php
/* --------------------------------------------------------------------------
   Custom Reset Password Shortcode
   -------------------------------------------------------------------------- */
function custom_reset_password_form() { 
	if ( is_user_logged_in() ) {
		return __( 'Sie sind bereits angemeldet.', 'personalize-login' );
	} else {
		if ( isset( $_REQUEST['login'] ) && isset( $_REQUEST['key'] ) ) {
			$attributes['login'] = $_REQUEST['login'];
			$attributes['key'] = $_REQUEST['key'];

		}
	}
	/*
	$form = '<form id="resetform"  method="post">';
	$form .= '<h4 class="modal-title">Ändern Sie Ihr Passwort</h4>';
	$form .= '<p class="status"></p>';
	$form .= '<input type="hidden" class="form-control" name="login" value="' . $attributes['login'] .'"/>';
	$form .= '<input type="hidden" class="form-control" name="key" value="' . $attributes['key'] .'"/>';
	$form .= '<div class="form-row"><label>Neues Passwort eingeben</label>';
	$form .= '<input type="password" class="form-control" name="new_password" id="new_password"></div>';
	$form .= '<div class="form-row"><label>Neues Passwort bestätigen</label>';
	$form .= '<input type="password" class="form-control"  name="con_newpassword"  id="con_newpassword" /></div>';
	$form .= '<div class="form-row"><input class="submit_button btn" type="submit" value="Change Password" name="submit"></div>';
	$form .= '</form>';
	*/
	$form = '<form id="resetform"  method="post">';
	$form .= '<h4 class="modal-title">'.__('Ändern Sie Ihr Passwort', 'study-doc').'</h4>';
	$form .= '<input type="hidden" class="form-control" name="login" value="' . $attributes['login'] .'"/>';
	$form .= '<input type="hidden" class="form-control" name="key" value="' . $attributes['key'] .'"/>';
	$form .= '<p class="status"></p>';
	$form .= '<div class="form-group email-area">';
	$form .= '<label for="email">'.__('Neues Passwort eingeben', 'study-doc').'</label>';
	$form .= '<input type="password" class="form-control" name="new_password" id="new_password">';
	$form .= '</div>';
	$form .= '<div class="form-group">';
	$form .= '<label for="subjects">'.__('Neues Passwort bestätigen', 'study-doc').'</label>';
	$form .= '<input type="password" class="form-control"  name="con_newpassword"  id="con_newpassword" />';
	$form .= '</div>';
	$form .= '<button type="submit" name="submit" class="submit_button btn">'.__('Passwort ändern', 'study-doc').'</button>';
	$form .= '</form>';
	return $form;
}
// register shortcode
add_shortcode('custom_reset_form', 'custom_reset_password_form');


/* --------------------------------------------------------------------------
   Custom Summer Table for Fristen Page
   -------------------------------------------------------------------------- */
function summer_subjects() { 
	global $wpdb;
	$university_table = $wpdb->prefix . 'universities';

	$universities = $wpdb->get_results( "SELECT * FROM $university_table" );

	$table = "<table class=\"table table-striped\">";
	$table .= "<thead>";
	$table .= "<tr>";
	$table .= "<th>".__('Universität', 'study-doc')."</th>";
	$table .= "<th>".__('Einstiegssemester für Medizin im Sommersemester', 'study-doc')."</th>";
	$table .= "<th>".__('Einstiegssemester für Zahnmedizin im Sommersemester', 'study-doc')."</th>";
	$table .= "<th>".__('Einstiegssemester für Tiermedizin im Sommersemester', 'study-doc')."</th>";
	$table .= "<th>".__('Frist', 'study-doc')."</th>";
	$table .= "</tr>";
	$table .= "</thead>";
	$table .= "<tbody>";
	foreach ( $universities as $university ) {
		if($semester== "SS" || $university->ss_deadline != '0000-00-00'){
			$table .=  "<tr><td>$university->name</td><td>$university->HM_summer</td><td>$university->ZM_summer</td><td>$university->TM_summer</td><td style=\"width:100px;text-align:center;\">$university->ss_deadline</td></tr>";
		}
	}
	$table .= "</tbody>";
	$table .= "</table>";

	return $table;
}
// register shortcode
add_shortcode('summer_subjects', 'summer_subjects');


/* --------------------------------------------------------------------------
   Custom Winter Table for Fristen Page
   -------------------------------------------------------------------------- */
function subject_costs() { 
$table = '<div class="table-responsive">';
$table .= '<table class="table table-winter-universities table-bordered">';
$table .= '<thead>';
$table .= '<tr><th>'.__('Universität', 'study-doc').'</th><th>'.__('Humanmedizin', 'study-doc').'</th><th>'.__('Zahnmedizin', 'study-doc').'</th></tr>';
$table .= '</thead>';
$table .= '<tbody>';
$table .= '<tr><td><strong>'.__('Osijek/Halberstadt (Kroatien/Deutschland)', 'study-doc').'</strong><br>'.__('Josip-Juraj-Strossmayer-Universität Osijek', 'study-doc').'</td><td>8.000€</td><td>-</td></tr>';

$table .= '<tr><td><strong>'.__('Riga (Lettland)', 'study-doc').'</strong><br>'.__('Riga Stradins Universität', 'study-doc').'</td><td>6.000€</td><td>7.000€<br>'.__('ab 3.Studienjahr 7.500€', 'study-doc').'</td></tr>';
$table .= '<tr><td><strong>'.__('Resche (Polen)', 'study-doc').'</strong><br>'.__('Universität Resche', 'study-doc').'</td><td>6.250€</td><td>-</td></tr>';
$table .= '<tr><td><strong>'.__('Breslau (Polen)', 'study-doc').'</strong><br>'.__('Wroclaw Medical University', 'study-doc').'</td><td>5.850€</td><td>6.900€</td></tr>';
$table .= '<tr><td><strong>'.__('Vilnius (Litauen)', 'study-doc').'</strong><br>'.__('Universität Vilnius', 'study-doc').'</td><td>5.500€</td><td>6.480€</td></tr>';
$table .= '<tr><td><strong>'.__('Rijeka (Kroatien)', 'study-doc').'</strong><br>'.__('Universität Rijeka', 'study-doc').'</td><td>5.000€</td><td>5.000€</td></tr>';
$table .= '<tr><td><strong>'.__('Bratislava (Slowakei)', 'study-doc').'</strong><br>'.__('Comenius-Universität Bratislava', 'study-doc').'</td><td>4.750€</td><td>5.500€</td></tr>';
$table .= '<tr><td><strong>'.__('Neumarkt (Rumänien)', 'study-doc').'</strong><br>'.__('University of Medicine and Pharmacy of Targu Mures', 'study-doc').'</td><td>3.750€</td><td>3.750€</td></tr>';
$table .= '</tbody>';
$table .= '</table>';
$table .= '</div>';

	return $table;
}
// register shortcode
add_shortcode('subject_costs', 'subject_costs');