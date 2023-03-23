<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wpdb;
$university_table = $wpdb->prefix . 'universities';
$university_array = 'shortname,name,city';
$universities = $wpdb->get_results( "SELECT $university_array FROM $university_table" );





?>


<div class="container admin_students">
	<p id="success"></p>
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
					<h2 class="admin_students_title"><b><?php _e( 'Bewerber', 'study-doc' ); ?></b></h2>
				</div>
				<div class="col-sm-6">
					<button type="button" class="btn add_user float-right" data-toggle="modal" data-target="#addStudentModal"><?php _e( 'Neuen Studenten', 'study-doc' ); ?></button>
					<button class="btn multidelete studentsdelete float-right" data-toggle="modal" data-target="#deleteStudentsModal">
						<i class="fas fa-minus-circle"></i><span><?php _e( 'Löschen', 'study-doc' ); ?></span>
					</button>
					<button class="btn multiexport students_export float-right" id="student-exp">
						<?php _e( 'Exportieren', 'study-doc' ); ?>
					</button>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table id="table-students" class="table table-striped table-hover tablemanager">
				<thead>
					<tr>
						<th class="disableSort disableFilterBy">
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th><?php _e( 'Name', 'study-doc' ); ?></th>
						<th><?php _e( 'E-Mail-Adresse', 'study-doc' ); ?></th>
						<th><?php _e( 'Fach', 'study-doc' ); ?></th>
						<th class="disableSort disableFilterBy"><?php _e( 'LPA', 'study-doc' ); ?></th>
						<th class="disableSort disableFilterBy"><?php  _e( 'Erlaubnis', 'study-doc' ); ?></th>
						<!--<th class="disableSort disableFilterBy">Fortschrittsbericht</th>-->
						<th class="disableSort disableFilterBy"><?php _e( 'Aktion', 'study-doc' ); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php
					global $wpdb;
					$student_table = $wpdb->prefix . 'students';
					$students = $wpdb->get_results ( "SELECT * FROM $student_table where user<>0" );
					$i=1;
					foreach ( $students as $row ) {
					?>
					<tr id="<?php echo $row->user ?>">
						<td>
							<span class="custom-checkbox">
								<input type="checkbox" class="multicheck" name="multicheck" data-id="<?php echo $row->user ?>">
								<label for="multicheck"></label>
							</span>
						</td>
						
						<td><?php echo $row->last_name . ', ' . $row->first_name ?></td>
						
						<td><?php echo $row->email ?></td>
						<td><?php echo $row->subject ?></td>
						<td><?php echo $row->lpa ?></td>
						<td class="text-center"><?php echo ($row->permission == 'POK') ? '<i class="fas fa-check sub_available"></i>' : '<i class="fas fa-times sub_navailable"></i>' ; ?></td>
						<!--<td>
						<?php echo $row->Progress_report ?>
                     </td>-->
						<td style="text-align: center;">
							<a href="#viewStudentModal" class="btn-student-view" data-toggle="modal" data-user="<?php echo $row->user ?>"><i class="fas fa-user"></i></a>
							<a href="#editStudentModal" class="btn-student-edit" data-toggle="modal" 
							   data-user="<?php echo $row->user ?>"
							   data-title="<?php echo $row->title ?>"
							   data-first_name="<?php echo $row->first_name ?>"
							   data-last_name="<?php echo $row->last_name ?>"
							   data-address1="<?php echo $row->address1 ?>"
							   data-address2="<?php echo $row->address2 ?>"
							   data-city="<?php echo $row->city ?>"
							   data-country="<?php echo $row->country ?>"
							   data-zip="<?php echo $row->zip ?>"
							   data-citizenship="<?php echo $row->citizenship ?>"
							   data-telephone="<?php echo $row->telephone ?>"
							   data-mobile="<?php echo $row->mobile ?>"
							   data-email="<?php echo $row->email ?>"
							   data-date_of_birth="<?php echo $row->date_of_birth ?>"
							   data-place_of_birth="<?php echo $row->place_of_birth ?>"
							   data-gender="<?php echo $row->gender ?>"
							   data-Progress_report="<?php echo $row->Progress_report ?>" 
							   data-syear="<?php echo $row->selected_year ?>"
							   data-semester="<?php echo $row->selected_semester ?>"
							   data-subject="<?php echo $row->subject ?>"
							   data-sunis="<?php echo $row->selected_university ?>"

							   ><i class="fas fa-pen"></i></a>
							<a href="#deleteStudentModal" class="btn-student-delete" data-id="<?php echo $row->user ?>" data-toggle="modal"><i class="fas fa-trash"></i></a>
						</td>
					</tr>
					<?php
						$i++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<!-- View STUDENT FORM  -->
<div id="viewStudentModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<h4 class="modal-title"></h4>

					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="nav nav-pills nav-fill" id="v-pills-tab" role="tablist" aria-orientation="horizontal">
								<a class="nav-link active" id="sutdent_info-tab" data-toggle="pill" href="#sutdent_info" role="tab" aria-controls="sutdent_info" aria-selected="true"><?php _e( 'Profil', 'study-doc' ); ?></a>
								<a class="nav-link" id="student_contact-tab" data-toggle="pill" href="#student_contact" role="tab" aria-controls="student_contact" aria-selected="false"><?php _e( 'Kontakt', 'study-doc' ); ?></a>
								<a class="nav-link" id="study_info-tab" data-toggle="pill" href="#study_info" role="tab" aria-controls="study_info" aria-selected="false"><?php _e( 'Studieninfo', 'study-doc' ); ?></a>
								<a class="nav-link" id="package-tab" data-toggle="pill" href="#package" role="tab" aria-controls="package" aria-selected="false"><?php _e( 'Paket und Universität', 'study-doc' ); ?></a>
								<a class="nav-link" id="uploads-tab" data-toggle="pill" href="#uploads" role="tab" aria-controls="uploads" aria-selected="false"><?php _e( 'Dokumente', 'study-doc' ); ?></a>
							</div>      
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="sutdent_info" role="tabpanel" aria-labelledby="sutdent_info-tab">

								</div>
								<div class="tab-pane fade" id="student_contact" role="tabpanel" aria-labelledby="student_contact-tab">

								</div>
								<div class="tab-pane fade" id="study_info" role="tabpanel" aria-labelledby="study_info-tab">

								</div>
								<div class="tab-pane fade" id="package" role="tabpanel" aria-labelledby="package-tab">

								</div>
								<div class="tab-pane fade" id="uploads" role="tabpanel" aria-labelledby="uploads-tab">

								</div>
							</div>  
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<!-- ADD STUDENT FORM  -->
<div id="addStudentModal" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-body">
				<form id="add-student" action="add_student" method="post">

					<div class="modal-header">
						<h4 class="modal-title"><?php _e( 'Student hinzufügen', 'study-doc' ); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input-add-title"><?php _e( 'Anrede', 'study-doc' ); ?></label>
							<select id="input-add-title" name ="input-add-title" class="form-control" required >
							<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
							<option><?php _e( 'Herr', 'study-doc' ); ?></option>
							<option><?php _e( 'Frau', 'study-doc' ); ?></option>
							</select>
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-first_name"><?php _e( 'Vorname', 'study-doc' ); ?></label>
						<input type="text" name ="input-add-first_name" class="form-control" id="input-add-first_name" placeholder="First Name" required />
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-last_name"><?php _e( 'Nachname', 'study-doc' ); ?></label>
						<input type="text" name ="input-add-last_name" class="form-control" id="input-add-last_name" placeholder="Last Name" required />
					</div>
					</div>
				<div class="form-row">

					<div class="form-group col-md-4">
						<label for="input-add-address1"><?php _e( 'Straße und Hausnummer', 'study-doc' ); ?></label>
						<input type="text" name ="input-add-address1" class="form-control" id="input-add-address1" placeholder="Street & No.">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-address2"><?php _e( 'Postanschrift Optional', 'study-doc' ); ?></label>
						<input type="text" name ="input-add-address2" class="form-control" id="input-add-address2" placeholder="Address Line 2">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-city"><?php _e( 'Ort', 'study-doc' ); ?></label>
						<input type="text" name="input-add-city" class="form-control" id="input-add-city" placeholder="City">
					</div>
				</div>
				<div class="form-row">

					<div class="form-group col-md-4">
						<label for="input-add-country"><?php _e( 'Land', 'study-doc' ); ?></label>
						<input type="text" name="input-add-country" class="form-control" id="input-add-country" placeholder="Country">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-zip"><?php _e( 'Postleitzahl', 'study-doc' ); ?></label>
						<input type="text" name="input-add-zip" class="form-control" id="input-add-zip" placeholder="Zipcode">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-citizenship"><?php _e( 'Staatsangehörigkeit', 'study-doc' ); ?></label>
						<input type="text" name="input-add-citizenship" class="form-control" id="input-add-citizenship" placeholder="Citizenship">
					</div>
				</div>

				<div class="form-row">

					<div class="form-group col-md-4">
						<label for="input-add-telephone"><?php _e( 'Telefonnummer', 'study-doc' ); ?></label>
						<input type="mobile" name="input-add-telephone" class="form-control" id="input-add-telephone" placeholder="Telephone">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-mobile"><?php _e( 'Handynummer', 'study-doc' ); ?></label>
						<input type="mobile" name="input-add-mobile" class="form-control" id="input-add-mobile" placeholder="Mobile">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-email"><?php _e( 'E-Mail', 'study-doc' ); ?></label>
						<input type="email" name="input-add-email" class="form-control" id="input-add-email" placeholder="Email">
					</div>
				</div>


				<div class="form-row">

					<div class="form-group col-md-4">
						<label for="input-add-date_of_birth"><?php _e( 'Geburtsdatum', 'study-doc' ); ?></label>
						<input type="date" name="input-add-date_of_birth" class="form-control" id="input-add-date_of_birth" placeholder="D.O.B">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-place_of_birth"><?php _e( 'Geburtsort', 'study-doc' ); ?></label>
						<input type="text" name="input-add-place_of_birth" class="form-control" id="input-add-place_of_birth" placeholder="Place Of Birth">
					</div>
					<div class="form-group col-md-4">
						<label for="input-add-gender"><?php _e( 'Geschlecht', 'study-doc' ); ?></label>
						<select id="input-add-gender" name="input-add-gender" class="form-control">
							<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
							<option><?php _e( 'Männlich', 'study-doc' ); ?></option>
							<option><?php _e( 'Weiblich', 'study-doc' ); ?></option>
						</select>
					</div>
					
					<div class="form-group col-md-4">
						<label for="input-add-year"><?php _e( 'Jahr', 'study-doc' ); ?></label>
						<select id="input-add-year" name="input-add-year" class="form-control">
							<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
							<option><?php _e( '2021', 'study-doc' ); ?></option>
							<option><?php _e( '2022', 'study-doc' ); ?></option>
						</select>
					</div>
					
					<div class="form-group col-md-4">
						<label for="input-add-semester"><?php _e( 'Fachsemester', 'study-doc' ); ?></label>
						<select id="input-add-semester" name="input-add-semester" class="form-control">
							<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
							<option><?php _e( 'Sommer', 'study-doc' ); ?></option>
							<option><?php _e( 'Winter', 'study-doc' ); ?></option>
						</select>
					</div>
					
					<div class="form-group col-md-4">
						<label for="input-add-subject"><?php _e( 'Studienfach', 'study-doc' ); ?></label>
						<select id="input-add-subject" name="input-add-subject" class="form-control">
							<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
							<option><?php _e( 'Humanmedizin', 'study-doc' ); ?></option>
							<option><?php _e( 'Zahnmedizin', 'study-doc' ); ?></option>
						</select>
					</div>
					
	
					<div class="form-group col-md-12">
						<p class="universities-label"><?php _e( 'Universitäten', 'study-doc' ); ?></p>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="all" name="input-add-universities-all" id="input-uni-all">
						  <label class="form-check-label" for="input-uni-all">
							All
						  </label>
						</div>
					
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="<?php echo $universities[0]->shortname;  ?>" name="input-add-universities-osijek-halbersdtadt" id="input-uni-osj">
						  <label class="form-check-label" for="input-uni-osj">
							<?php echo $universities[0]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="RIG" name="input-add-universities-riga" id="input-uni-rig">
						  <label class="form-check-label" for="input-uni-rig">
							<?php echo $universities[1]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="RES" name="input-add-universities-resche" id="input-uni-res">
						  <label class="form-check-label" for="input-uni-res">
							<?php echo $universities[2]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="BRE" name="input-add-universities-breslau" id="input-uni-bre">
						  <label class="form-check-label" for="input-uni-bre">
							<?php echo $universities[3]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="VIL" name="input-add-universities-vilnius" id="input-uni-vil">
						  <label class="form-check-label" for="input-uni-vil">
							<?php echo $universities[4]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="RIJ" name="input-add-universities-rijeka" id="input-uni-rij">
						  <label class="form-check-label" for="input-uni-rij">
							<?php echo $universities[5]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="BRA" name="input-add-universities-bratislava" id="input-uni-bra">
						  <label class="form-check-label" for="input-uni-bra">
							<?php echo $universities[6]->city;  ?>
						  </label>
						</div>
						
						<div class="form-check form-check-inline uni-sel">
						  <input class="form-check-input" type="checkbox" value="NUM" name="input-add-universities-neumarkt" id="input-uni-num">
						  <label class="form-check-label" for="input-uni-num">
							<?php echo $universities[7]->city;  ?>
						  </label>
						</div>
						
					</div>
									
				</div>
				<input class="submit_button btn" type="submit" value="Hinzufügen" name="submit">
				<?php wp_nonce_field( 'add-student-nonce', 'input-add-security' ); ?>
					<p class="status alert"></p>
				</form>
		</div>
	</div>
</div>
</div>


<!-- Edit Modal HTML -->
<div id="editStudentModal" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-body">
				<form id="update-student" action="update_student" method="post">
					<div class="modal-header">
						<h4 class="modal-title">Benutzer bearbeiten<?php _e( 'Studentendaten', 'study-doc' ); ?></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<input type="hidden" id="input-update-user" name="user" class="form-control" required />

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input-update-title">Anrede<?php _e( 'Studentendaten', 'study-doc' ); ?></label>
							<select id="input-update-title" name="input-update-title" class="form-control" required>
								<option selected>Wählen Sie...<?php _e( 'Studentendaten', 'study-doc' ); ?></option>
								<option><?php _e( 'Herr', 'study-doc' ); ?></option>
								<option><?php _e( 'Frau', 'study-doc' ); ?></option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-first_name"><?php _e( 'Vorname', 'study-doc' ); ?></label>
							<input type="text" name="input-update-first_name" class="form-control" id="input-update-first_name" placeholder="First Name" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-last_name"><?php _e( 'Nachname', 'study-doc' ); ?></label>
							<input type="text" name="input-update-last_name" class="form-control" id="input-update-last_name" placeholder="Last Name" required />
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input-update-address1"><?php _e( 'Straße und Hausnummer', 'study-doc' ); ?></label>
							<input type="text" name="input-update-address1" class="form-control" id="input-update-address1" placeholder="Street & No." required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-address2"><?php _e( 'Postanschrift Optional', 'study-doc' ); ?></label>
							<input type="text" name="input-update-address2" class="form-control" id="input-update-address2" placeholder="Address Line 2" />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-city"><?php _e( 'Ort', 'study-doc' ); ?></label>
							<input type="text" name="input-update-city" class="form-control" id="input-update-city" placeholder="City" required />
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input-update-country"><?php _e( 'Land', 'study-doc' ); ?></label>
							<input type="text" name="input-update-country" class="form-control" id="input-update-country" placeholder="Country" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-zip"><?php _e( 'Postleitzahl', 'study-doc' ); ?></label>
							<input type="text" name="input-update-zip" class="form-control" id="input-update-zip" placeholder="Zipcode" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-citizenship"><?php _e( 'Staatsangehörigkeit', 'study-doc' ); ?></label>
							<input type="text" name="input-update-citizenship" class="form-control" id="input-update-citizenship" placeholder="Citizenship" required />
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input-update-telephone"><?php _e( 'Telefonnummer', 'study-doc' ); ?></label>
							<input type="mobile" name="input-update-telephone" class="form-control" id="input-update-telephone" placeholder="Telephone" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-mobile"><?php _e( 'Handynummer', 'study-doc' ); ?></label>
							<input type="mobile" name="input-update-mobile" class="form-control" id="input-update-mobile" placeholder="Mobile" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-email"><?php _e( 'E-Mail', 'study-doc' ); ?></label>
							<input type="email" name="input-update-email" class="form-control" id="input-update-email" placeholder="Email" required />
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input-update-date_of_birth"><?php _e( 'Geburtsdatum', 'study-doc' ); ?></label>
							<input type="date" name="input-update-date_of_birth" class="form-control" id="input-update-date_of_birth" placeholder="D.O.B" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-place_of_birth"><?php _e( 'Geburtsort', 'study-doc' ); ?></label>
							<input type="text" name="input-update-place_of_birth" class="form-control" id="input-update-place_of_birth" placeholder="Place Of Birth" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input-update-gender"><?php _e( 'Geschlecht', 'study-doc' ); ?></label>
							<select id="input-update-gender" name="input-update-gender" class="form-control" required>
								<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
								<option><?php _e( 'Männlich', 'study-doc' ); ?></option>
								<option><?php _e( 'Weiblich', 'study-doc' ); ?></option>
							</select>
						</div>
						
						<div class="form-group col-md-4">
							<label for="input-update-year"><?php _e( 'Jahr', 'study-doc' ); ?></label>
							<select id="input-update-year" name="input-update-year" class="form-control">
								<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
								<option><?php _e( '2021', 'study-doc' ); ?></option>
								<option><?php _e( '2022', 'study-doc' ); ?></option>
							</select>
						</div>
					
						<div class="form-group col-md-4">
							<label for="input-update-semester"><?php _e( 'Fachsemester', 'study-doc' ); ?></label>
							<select id="input-update-semester" name="input-update-semester" class="form-control">
								<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
								<option><?php _e( 'Sommer', 'study-doc' ); ?></option>
								<option><?php _e( 'Winter', 'study-doc' ); ?></option>
							</select>
						</div>
					
						<div class="form-group col-md-4">
							<label for="input-update-subject"><?php _e( 'Studienfach', 'study-doc' ); ?></label>
							<select id="input-update-subject" name="input-update-subject" class="form-control">
								<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
								<option><?php _e( 'Humanmedizin', 'study-doc' ); ?></option>
								<option><?php _e( 'Zahnmedizin', 'study-doc' ); ?></option>
							</select>
						</div>
						
						<div class="form-group col-md-12">
							<p class="universities-label"><?php _e( 'Universitäten', 'study-doc' ); ?></p>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="all" name="input-update-universities-all-update" id="input-uni-all-update">
							  <label class="form-check-label" for="input-uni-all-update">
								All
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[0]->shortname;  ?>" name="input-add-universities-osijek-halbersdtadt-update" id="input-uni-osj-update">
							  <label class="form-check-label" for="input-uni-osj-update">
								<?php echo $universities[0]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[1]->shortname;  ?>" name="input-add-universities-riga-update" id="input-uni-rig-update">
							  <label class="form-check-label" for="input-uni-rig-update">
								<?php echo $universities[1]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[2]->shortname;  ?>" name="input-add-universities-resche-update" id="input-uni-res-update">
							  <label class="form-check-label" for="input-uni-res-update">
								<?php echo $universities[2]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[3]->shortname;  ?>" name="input-add-universities-breslau-update" id="input-uni-bre-update">
							  <label class="form-check-label" for="input-uni-bre-update">
								<?php echo $universities[3]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[4]->shortname;  ?>" name="input-add-universities-vilnius-update" id="input-uni-vil-update">
							  <label class="form-check-label" for="input-uni-vil-update">
								<?php echo $universities[4]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[5]->shortname;  ?>" name="input-add-universities-rijeka-update" id="input-uni-rij-update">
							  <label class="form-check-label" for="input-uni-rij-update">
								<?php echo $universities[5]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[6]->shortname;  ?>" name="input-add-universities-bratislava-update" id="input-uni-bra-update">
							  <label class="form-check-label" for="input-uni-bra">
								<?php echo $universities[6]->city;  ?>
							  </label>
							</div>

							<div class="form-check form-check-inline uni-sel">
							  <input class="form-check-input" type="checkbox" value="<?php echo $universities[7]->shortname;  ?>" name="input-add-universities-neumarkt-update" id="input-uni-num-update">
							  <label class="form-check-label" for="input-uni-num-update">
								<?php echo $universities[7]->city;  ?>
							  </label>
							</div>

						</div>
						
					</div>

                    <div class="form-row">
						<div class="form-group col-md-6">
							<label for="input-update-Progress_report"><?php _e( 'Fortschrittsbericht', 'study-doc' ); ?></label>
							<select id="input-update-Progress_report" name="input-update-Progress_report" class="form-control" required>
								<option selected><?php _e( 'Wählen Sie...', 'study-doc' ); ?></option>
								<option><?php _e( 'wir haben Ihre Dokumente erhalten', 'study-doc' ); ?></option>
								<option><?php _e( 'Datei ist in Bearbeitung', 'study-doc' ); ?></option>
								<option><?php _e( 'Einige Dokumente fehlen', 'study-doc' ); ?></option>
								<option><?php _e( 'Warten auf die Erlaubnis zur Anwendung', 'study-doc' ); ?></option>
								<option><?php _e( 'Datei an die Universität gesendet', 'study-doc' ); ?></option>
							</select>
						</div>
					</div>
					<p class="status alert"></p>
					<input class="submit_button btn" type="submit" value="Aktualisieren" name="submit" />
				</form>
			</div>


		</div>
	</div>
</div>



<!-- Delete Modal HTML -->
<div id="deleteStudentModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="delete-student" action="delete_student" method="DELETE">

					<div class="modal-header">
						<h4 class="modal-title"><?php _e( 'Studenten löschen', 'study-doc' ); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<input type="hidden" id="input-delete-user" name="user" class="form-control" required />
					<p><?php _e( 'Sind Sie sich sicher, dass Sie diesen Eintrag löschen wollen?', 'study-doc' ); ?></p>
					<p class="text-warning"><small><?php _e( 'Diese Ausführung kann nicht Rückgängig gemacht werden.', 'study-doc' ); ?></small></p>

					<p class="status alert"></p>
					<input class="delete_button btn" type="submit" value="Löschen" name="submit">

				</form>
			</div>
		</div>
	</div>
</div>



<!-- Delete Modal HTML -->
<div id="deleteStudentsModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="delete-students" action="delete" method="DELETE">

					<div class="modal-header">
						<h4 class="modal-title"><?php _e( 'Studenten löschen', 'study-doc' ); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<input type="hidden" name="input-delete-students" class="form-control" required />
					<p><?php _e( 'Sind Sie sich sicher, dass Sie diesen Eintrag löschen wollen?', 'study-doc' ); ?></p>
					<p class="text-warning"><small><?php _e( 'Diese Ausführung kann nicht Rückgängig gemacht werden.', 'study-doc' ); ?></small></p>

					<p class="status alert"></p>
					<input class="delete_button btn" type="submit" value="Löschen" name="submit">

				</form>
			</div>
		</div>
	</div>
</div>


