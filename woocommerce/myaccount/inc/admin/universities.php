<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wpdb;

?>


<div class="container admin_universities">
	<p id="success"></p>
	<div class="table-wrapper">
		<div class="table-title">
			<div class="row">
				<div class="col-sm-6">
				</div>
				<div class="col-sm-6">
					<button type="button" class="btn add_user float-right" data-toggle="modal" data-target="#adduniModal"><?php _e('Neue Universität hinzufügen', 'study-doc'); ?> </button>
					<button class="btn multidelete unisdelete float-right" data-toggle="modal" data-target="#deleteUnisModal">
						<i class="fas fa-minus-circle"></i><span><?php _e('Löschen', 'study-doc'); ?></span>
					</button>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table id="table-universities" class="table table-striped table-hover tablemanager ">
				<thead>
					<tr>
						<th  class="disableSort disableFilterBy">
							<span class="custom-checkbox">
								<input type="checkbox" id="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th class="disableFilterBy disableSort"><?php _e('Uni Code', 'study-doc'); ?></th>
						<th>Name</th>
						<th class="disableFilterBy"><?php _e('SS Deadline', 'study-doc'); ?></th>
						<th class="disableFilterBy"><?php _e('WS Deadline', 'study-doc'); ?></th>
						<th class="text-center disableSort disableFilterBy"><?php _e('HM', 'study-doc'); ?></th>
						<th class="text-center disableSort disableFilterBy"><?php _e('ZM', 'study-doc'); ?></th>
						<th class="text-center disableSort disableFilterBy"><?php _e('TM', 'study-doc'); ?></th>
						<th class="text-center disableSort disableFilterBy"><?php _e('ACTION', 'study-doc'); ?></th>
					</tr>
				</thead>
				<tbody>

					<?php
					$university_table = $wpdb->prefix . 'universities';
					$result = $wpdb->get_results ( "SELECT * FROM $university_table where id<>0" );
					$i=1;
					//`shortname``name``city``ss_deadline``ws_deadline``humanmedizin``zahnmedizin``tiermedizin`
					foreach ( $result as $row ) {
						$humanmedizin = $row->humanmedizin;
						$zahnmedizin = $row->zahnmedizin;
						$tiermedizin = $row->tiermedizin;
					?>
					<tr id="<?php echo $row->id ?>">
						<td>
							<span class="custom-checkbox">
								<input type="checkbox" class="multicheck" name="multicheck" data-id="<?php echo $row->id ?>">
								<label for="multicheck"></label>
							</span>
						</td>
						<td><?php echo $row->shortname; ?></td>
						<td><?php echo $row->name ?></td>
						<td><?php if($row->ss_deadline == "0000-00-00"){ echo "---"; }else{ echo $row->ss_deadline; } ?></td>
						<td><?php echo $row->ws_deadline ?></td>
						<td class="text-center"><?php if($humanmedizin == 1){ ?> <i class="fas fa-check sub_available"></i> <?php }else{ ?><i class="fas fa-times sub_navailable"></i> <?php } ?></td>
						<td class="text-center"><?php if($zahnmedizin == 1){ ?> <i class="fas fa-check sub_available"></i> <?php }else{ ?><i class="fas fa-times sub_navailable sub_navailable"></i> <?php } ?></td>
						<td class="text-center"><?php if($tiermedizin == 1){ ?> <i class="fas fa-check sub_available"></i> <?php }else{ ?><i class="fas fa-times sub_navailable"></i> <?php } ?></td>
						<td class="text-center">
							<a href="#updateuniModal" class="uni_edit" id="uni_edit" data-toggle="modal" 
							   data-id="<?php echo $row->id ?>"
							   data-shortname="<?php echo $row->shortname ?>"
							   data-name="<?php echo $row->name ?>"
							   data-street="<?php echo $row->street ?>"
							   data-address="<?php echo $row->address ?>"
							   data-city="<?php echo $row->city ?>"
							   data-zip="<?php echo $row->zip ?>"
							   data-state="<?php echo $row->state ?>"
							   data-country="<?php echo $row->country ?>"
							   data-ss_deadline="<?php echo $row->ss_deadline ?>"
							   data-ws_deadline="<?php echo $row->ws_deadline ?>"
							   data-humanmedizin="<?php echo $row->humanmedizin ?>"
							   data-zahnmedizin="<?php echo $row->zahnmedizin ?>"
							   data-tiermedizin="<?php echo $row->tiermedizin ?>"
							   data-HM_summer="<?php echo $row->HM_summer ?>"
							   data-ZM_summer="<?php echo $row->ZM_summer ?>"
							   data-TM_summer="<?php echo $row->TM_summer ?>"
							   data-HM_winter="<?php echo $row->HM_winter ?>"
							   data-ZM_winter="<?php echo $row->ZM_winter ?>"
							   data-TM_winter="<?php echo $row->TM_winter ?>"
							   ><i class="fas fa-pen"></i></a>
							<a  data-toggle="modal" data-target="#deleteUniModal" class="delete unidelete" data-id="<?php echo $row->id ?>" data-toggle="modal"><i class="fas fa-trash"></i></a>
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



<!-- ADD STUDENT FORM  -->
<div id="adduniModal" class="modal fade ">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="add-university" action="add_university" method="post">

					<div class="modal-header">
						<h4 class="modal-title "><?php _e('Universität hinzufügen', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="input_add_university_name"><?php _e('Name', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_name" class="form-control" id="input_add_university_name" placeholder="<?php _e('Name', 'study-doc'); ?>"  required />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_short_name"><?php _e('Code Name', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_short_name" class="form-control" id="input_add_university_short_name" placeholder="<?php _e('Short Name', 'study-doc'); ?>" required />
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input_add_university_address"><?php _e('Straßenname und Straßen-Nr.', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_address" class="form-control" id="input_add_university_address" placeholder="<?php _e('Straße', 'study-doc'); ?>" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_optional_address"><?php _e('Zusätzliche Adresse', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_optional_address" id="input_add_university_optional_address" class="form-control"/>
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_city"><?php _e('Ort', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_city" class="form-control" id="input_add_university_city" placeholder="<?php _e('Ort', 'study-doc'); ?>" required />
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input_add_university_zip"><?php _e('Postzahl.', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_zip" class="form-control" id="input_add_university_zip"  required />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_state"><?php _e('Staat', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_state" id="input_add_university_state" class="form-control"/>
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_country"><?php _e('Land', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_country" class="form-control" id="input_add_university_country" required />
						</div>
					</div>


					<div class="form-row">

						<div class="form-group col-md-6">
							<label for="input_add_university_SS"><?php _e('Sommer Deadline', 'study-doc'); ?></label>
							<input type="date" name ="input_add_university_SS" class="form-control" id="input_add_university_SS" value="2021-01-15" min="2021-01-15" max="2021-03-15" required />
						</div>
						<div class="form-group col-md-6">
							<label for="input_add_university_WS"><?php _e('Winter Deadline', 'study-doc'); ?></label>
							<input type="date" name="input_add_university_WS" class="form-control" id="input_add_university_WS" value="2021-07-15" min="2021-07-15" max="2021-09-24" required />
						</div>
					</div>
					<div class="form-row">

						<div class="form-group col-md-4">
							<label for="input_add_university_hm"><?php _e('Humanmedizin', 'study-doc'); ?></label>
							<select id="input_add_university_hm" name="input_add_university_hm" class="form-control" required >
								<option selected><?php _e('Wählen Sie...', 'study-doc'); ?></option>
								<option value="1"><?php _e('Ja', 'study-doc'); ?></option>
								<option value="0"><?php _e('Nein', 'study-doc'); ?></option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_zm"><?php _e('Zahnmedizin', 'study-doc'); ?></label>
							<select id="input_add_university_zm" name="input_add_university_zm" class="form-control" required >
								<option selected><?php _e('Wählen Sie...', 'study-doc'); ?></option>
								<option value="1"><?php _e('Ja', 'study-doc'); ?></option>
								<option value="0"><?php _e('Nein', 'study-doc'); ?></option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_tm"><?php _e('Tiermedizin', 'study-doc'); ?></label>
							<select id="input_add_university_tm" name="input_add_university_tm" class="form-control" required >
								<option selected><?php _e('Wählen Sie...', 'study-doc'); ?></option>
								<option value="1"><?php _e('Ja', 'study-doc'); ?></option>
								<option value="0"><?php _e('Nein', 'study-doc'); ?></option>
							</select>
						</div>
					</div>
					<div class="form-row">

						<div class="form-group col-md-4">
							<label for="input_add_university_hm_summer"><?php _e('Einstiegssemester für Humanmedizin im Sommersemester', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_hm_summer" class="form-control" id="input_add_university_hm_summer" />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_zm_summer"><?php _e('Einstiegssemester für Zahnmedizin im Sommersemester', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_zm_summer" class="form-control" id="input_add_university_zm_summer" />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_tm_summer"><?php _e('Einstiegssemester für Tiermedizin im Sommersemester', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_tm_summer" class="form-control" id="input_add_university_tm_summer" />
						</div>
					</div>
					<div class="form-row">

						<div class="form-group col-md-4">
							<label for="input_add_university_hm_winter"><?php _e('Einstiegssemester für Humanmedizin im Sommersemester', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_hm_winter" class="form-control" id="input_add_university_hm_winter" />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_zm_winter"><?php _e('Einstiegssemester für Zahnmedizin im Sommersemester', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_zm_winter" class="form-control" id="input_add_university_zm_winter" />
						</div>
						<div class="form-group col-md-4">
							<label for="input_add_university_tm_winter"><?php _e('Einstiegssemester für Tiermedizin im Sommersemester', 'study-doc'); ?></label>
							<input type="text" name ="input_add_university_tm_winter" class="form-control" id="input_add_university_tm_winter" />
						</div>
					</div>

					<p class="status alert"></p>
					<input class="submit_button btn" type="submit" value="<?php _e('Hinzufügen', 'study-doc'); ?>" name="submit">
				</form>
			</div>
		</div>
	</div>
</div>


<!-- Edit Modal HTML -->
<div id="updateuniModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">


			<div class="modal-body">

				<form id="update-university" action="update_university" method="post">

					<div class="modal-header">
						<h4 class="modal-title"><?php _e('Universität bearbeiten', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<input type="hidden" id="input_update_university_id" name="input_update_university_id" class="form-control" required />
					<div class="form-row">
						<div class="form-group col-md-8">
							<label for="input_update_university_name"><?php _e('Name', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_name" class="form-control" id="input_update_university_name" placeholder="<?php _e('Name', 'study-doc'); ?>" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_short_name"><?php _e('Code Name', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_short_name" class="form-control" id="input_update_university_short_name" placeholder="<?php _e('Short Name', 'study-doc'); ?>" required />
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input_update_university_address"><?php _e('Straßenname und Straßen-Nr.', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_address" class="form-control" id="input_update_university_address" placeholder="<?php _e('Straße', 'study-doc'); ?>" required />
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_optional_address"><?php _e('Zusätzliche Adresse', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_optional_address" id="input_update_university_optional_address" class="form-control"/>
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_city"><?php _e('Ort', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_city" class="form-control" id="input_update_university_city" placeholder="<?php _e('Ort', 'study-doc'); ?>" required />
						</div>
					</div>

					<div class="form-row">
						<div class="form-group col-md-4">
							<label for="input_update_university_zip"><?php _e('Postzahl.', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_zip" class="form-control" id="input_update_university_zip"  required />
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_state"><?php _e('Staat', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_state" id="input_update_university_state" class="form-control"/>
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_country"><?php _e('Land', 'study-doc'); ?></label>
							<input type="text" name ="input_update_university_country" class="form-control" id="input_update_university_country" required />
						</div>
					</div>



					<div class="form-row">


						<div class="form-group col-md-6">
							<label for="input_update_university_SS"><?php _e('Sommer Deadline', 'study-doc'); ?></label>
							<input type="date" name ="input_update_university_SS" class="form-control" id="input_update_university_SS" placeholder="<?php _e('Summer Deadline', 'study-doc'); ?>" />
						</div>
						<div class="form-group col-md-6">
							<label for="input_update_university_WS"><?php _e('Winter Deadline', 'study-doc'); ?></label>
							<input type="date" name="input_update_university_WS" class="form-control" id="input_update_university_WS" placeholder="<?php _e('Winter Deadline', 'study-doc'); ?>" />
						</div>
					</div>
					<div class="form-row">

						<div class="form-group col-md-4">
							<label for="input_update_university_hm">Humanmedizin<?php _e('Universitäten', 'study-doc'); ?></label>
							<select id="input_update_university_hm" name="input_update_university_hm" class="form-control" >
								<option selected><?php _e('Wählen Sie...', 'study-doc'); ?></option>
								<option value="1"><?php _e('Ja', 'study-doc'); ?></option>
								<option value="0"><?php _e('Nein', 'study-doc'); ?></option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_zm">Zahnmedizin<?php _e('Universitäten', 'study-doc'); ?></label>
							<select id="input_update_university_zm" name="input_update_university_zm" class="form-control" >
								<option selected><?php _e('Wählen Sie...', 'study-doc'); ?></option>
								<option value="1"><?php _e('Ja', 'study-doc'); ?></option>
								<option value="0"><?php _e('Nein', 'study-doc'); ?></option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label for="input_update_university_tm"><?php _e('Tiermedizin', 'study-doc'); ?></label>
							<select id="input_update_university_tm" name="input_update_university_tm" class="form-control" >
								<option selected><?php _e('Wählen Sie...', 'study-doc'); ?></option>
								<option value="1"><?php _e('Ja', 'study-doc'); ?></option>
								<option value="0"><?php _e('Nein', 'study-doc'); ?></option>
							</select>
						</div>
						<div class="form-row">

							<div class="form-group col-md-4">
								<label for="input_update_university_hm_summer"><?php _e('Einstiegssemester für Humanmedizin im Sommersemester', 'study-doc'); ?></label>
								<input type="text" name ="input_update_university_hm_summer" class="form-control" id="input_update_university_hm_summer" />
							</div>
							<div class="form-group col-md-4">
								<label for="input_update_university_zm_summer"><?php _e('Einstiegssemester für Zahnmedizin im Sommersemester', 'study-doc'); ?></label>
								<input type="text" name ="input_update_university_zm_summer" class="form-control" id="input_update_university_zm_summer" />
							</div>
							<div class="form-group col-md-4">
								<label for="input_update_university_tm_summer"><?php _e('Einstiegssemester für Tiermedizin im Sommersemester', 'study-doc'); ?></label>
								<input type="text" name ="input_update_university_tm_summer" class="form-control" id="input_update_university_tm_summer" />
							</div>
						</div>
						<div class="form-row">

							<div class="form-group col-md-4">
								<label for="input_update_university_hm_winter"><?php _e('Einstiegssemester für Humanmedizin im Sommersemester', 'study-doc'); ?></label>
								<input type="text" name ="input_update_university_hm_winter" class="form-control" id="input_update_university_hm_winter" />
							</div>
							<div class="form-group col-md-4">
								<label for="input_update_university_zm_winter"><?php _e('Einstiegssemester für Zahnmedizin im Sommersemester', 'study-doc'); ?></label>
								<input type="text" name ="input_update_university_zm_winter" class="form-control" id="input_update_university_zm_winter" />
							</div>
							<div class="form-group col-md-4">
								<label for="input_update_university_tm_winter"><?php _e('Einstiegssemester für Tiermedizin im Sommersemester', 'study-doc'); ?></label>
								<input type="text" name ="input_update_university_tm_winter" class="form-control" id="input_update_university_tm_winter" />
							</div>
						</div>
					</div>

					<p class="status alert"></p>
					<input class="submit_button btn" type="submit" value="<?php _e('Aktualisieren', 'study-doc'); ?>" name="submit">
				</form>
			</div>


		</div>
	</div>
</div>






<!-- Delete Modal HTML -->
<div id="deleteUniModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="delete-university" method="post">

					<div class="modal-header">
						<h4 class="modal-title"><?php _e('Universität löschen', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<input type="hidden" name="input-delete-university-uni" id="input-delete-university-uni" class="form-control" required />
					<p><?php _e('Sind Sie sicher, dass Sie diesen Datensatz löschen wollen?', 'study-doc'); ?></p>
					<p class="text-warning"><small><?php _e('Diese Aktion kann nicht rückgängig gemacht werden.', 'study-doc'); ?></small></p>

					<p class="status alert"></p>
					<input class="delete_button btn" type="submit" value="<?php _e('Löschen', 'study-doc'); ?>" name="submit">

				</form>
			</div>
		</div>
	</div>
</div>



<!-- Delete Modal HTML -->
<div id="deleteUnisModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<form id="delete-universities" action="delete_universities" method="post">

					<div class="modal-header">
						<h4 class="modal-title"><?php _e('Universitäten löschen', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<input type="hidden" name="input_delete-universities_ids" id="input_delete-universities_ids" class="form-control" required />
					<p><?php _e('Sind Sie sicher, dass Sie diese Datensätze löschen wollen?', 'study-doc'); ?></p>
					<p class="text-warning"><small><?php _e('Diese Aktion kann nicht rückgängig gemacht werden.', 'study-doc'); ?></small></p>

					<p class="status alert"></p>
					<input class="delete_button btn" type="submit" value="<?php _e('Löschen', 'study-doc'); ?>" name="submit">

				</form>
			</div>
		</div>
	</div>
</div>