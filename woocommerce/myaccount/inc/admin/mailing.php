<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wpdb;
//get_header();
?>

<style>
	@media only screen and (max-width: 1000px) {

		.btno3{
			font-size: 12px;
		}

		.tabls{
			font-size: 11px;

		}
		.fomo{
			font-size: 12px;
		}
		.fomo1{
			font-size: 14px;
		}

	}


	.form-control-file{
		width: 30%;
	}
</style>



<div class="container admin_emails">
	<div class="row email_filter">
		<div class="col-md-12">
			<div class="table-responsive tabls" id="email_list">
				<table class="table table-striped table-hover table-email tablemanager ">
					<thead>
						<tr>
							<th class="disableFilterBy disableSort">
								<span class="custom-checkbox">
									<input type="checkbox" id="selectAll">
									<label for="selectAll"></label>
								</span>
							</th>
							<th class="disableSort"><?php _e('Name', 'study-doc'); ?></th>
							<th class="disableSort"><?php _e('Email', 'study-doc'); ?></th>
							<th class="disableSort hide"><?php _e('Subject', 'study-doc'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$student_table = $wpdb->prefix . 'students';
						$result = $wpdb->get_results ( "SELECT * FROM $student_table WHERE user<>0" );
						foreach ( $result as $row ) {
						?>
						<tr id="<?php echo $row->user ?>">
							<td>
								<span class="custom-checkbox">
									<input type="checkbox" class="multicheck" name="multicheck" data-id="<?php echo $row->user ?>" value="<?php echo $row->email?>">
									<label for="multicheck"></label>
								</span>
							</td>
							<td><?php echo $row->last_name . ', ' . $row->first_name ?></td>
							<td><?php echo $row->email ?></td>
							<td class="hide"><?php echo $row->subject ?></td>
						</tr>
						<?php
						}
						?>
					</tbody>
				</table>
				<button type="button" class="btn add_emails btno3"><?php _e('Hinzufügen', 'study-doc'); ?> <i class="fas fa-plus-circle"></i></button>
				<button type="button" class="btn all_emails btno3"><?php _e('Alles auswählen', 'study-doc'); ?> <i class="fas fa-check-double"></i></button>
			</div>
		</div>
	</div>


	<div class="row  email_system">
		<div class="col-md-12">
			<div class="tabs">

				<div class="nav nav-pills" id="v-pills-tab" role="tablist">
					<a class="nav-link active" id="compose-tab" data-toggle="pill" href="#compose" role="tab" aria-controls="compose" aria-selected="true"><?php _e('Verfassen', 'study-doc'); ?> <i class="fas fa-envelope-square"></i></a>
					<a class="nav-link" id="sent-tab" data-toggle="pill" href="#sent" role="tab" aria-controls="sent" aria-selected="true"><?php _e('Senden', 'study-doc'); ?> <i class="fas fa-paper-plane"></i></a>
				</div>
			</div>
			<div class="tab-content">

				<div class="tab-pane fade show active" id="compose" role="tabpanel" aria-labelledby="compose-tab">
					<div class="composer_area shadow_lg">
						<h5 class="fomo1"><?php _e('Verfassen Sie hier Ihre E-Mail:', 'study-doc'); ?></h5>
						<form id="emailComp" class="fomo">
							<p class="status"></p>
							<div class="form-group">
								<label for="email"><?php _e('An:', 'study-doc'); ?></label>
								<input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" required multiple>
							</div>
							<div class="form-group">
								<label for="subjects"><?php _e('Betreff:', 'study-doc'); ?></label>
								<input type="text" class="form-control" id="subjects" name="subjects" placeholder="Mail Subject" required> 
							</div>
							<div class="form-group">
								<div class="form-group">
									<label for="attachments"><?php _e('Dateien anhängen:', 'study-doc'); ?></label>
									<input type="file" class="form-control-file" id="attachments" name="attachments" value="" multiple 
										   accept="image/*,application/pdf">
								</div>
							</div>
							<div class="form-group">
								<label for="template"><?php _e('Vorlage:', 'study-doc'); ?></label>
								<div class="input-group mb-3">
									<select class="custom-select" name="template" id="template" >
										<option value="--" selected>--</option>
										<?php
										global $wpdb;
										$email_template_table = $wpdb->prefix . 'mail_templates';

										$templates = $wpdb->get_results( "SELECT * FROM $email_template_table");
										foreach($templates as $template){
											$id = $template->id;
											$name = $template->name;
											echo "<option value=\"$id\">$name</option>";
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="messagetext"><?php _e('Nachricht:', 'study-doc'); ?></label>
								<textarea type="text" class="form-control" id="messagetext" name="messagetext" rows="15"  required></textarea>
							<p><span class="short_code">[Anrede]</span><span class="short_code">[Vorname]</span><span class="short_code">[Nachname]</span><span class="short_code">[Strasse-und-Hausnummer]</span><span class="short_code">[Adresszusatz]</span><span class="short_code">[Bundesland]</span><span class="short_code">[Ort]</span><span class="short_code">[Land]</span><span class="short_code">[Postleitzahl]</span><span class="short_code">[Footer]</span></p>
							</div>
							<button type="submit" name="submit" class="email_button btn btno3" id="emailbutton"><?php _e('Senden', 'study-doc'); ?><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
				<div class="tab-pane fade tabls" id="sent" role="tabpanel" aria-labelledby="sent-tab">
					<div class="sent_area shadow_lg">
						<h5 class="fomo1"><?php _e('Gesendete E-Mail:', 'study-doc'); ?></h5>
						<div class="table-responsive">
							<table id="sent" class="table table-striped table-hover table-sent tablemanager">
								<thead>
									<tr>
										<th><?php _e('Subject', 'study-doc'); ?></th>
										<th><?php _e('Datum & Uhrzeit', 'study-doc'); ?></th>
										<th class="text-center disableFilterBy"><?php _e('Action', 'study-doc'); ?></th>
									</tr>
								</thead>
								<tbody>

									<?php
									$email_table = $wpdb->prefix . 'emails';
									$result = $wpdb->get_results ( "SELECT * FROM $email_table ORDER BY update_time DESC;" );
									$i=1;
									foreach ( $result as $row ) {
									?>
									<tr id="<?php echo $row->emailid ?>">
										<td><?php echo $row->subjects ?></td>
										<td><?php echo $row->email ?></td>
										<td><?php echo $row->update_time ?></td>
										<td style="text-align: center;">
											<a href="#viewEmailModal" class="view" data-toggle="modal" 
											   data-emailid="<?php echo $row->emailid ?>"><i class="fas fa-envelope-open"></i></a>
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
			</div>
		</div>
	</div>
</div>

<!-- View STUDENT FORM  -->
<div id="viewEmailModal" class="modal fade">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="container">
					<div class="row">

						<div class="col-md-12 mail-body">
							<!-- this part overwrites by ajax -->
						</div>	
					</div>

				</div>
			</div>
		</div>
	</div>
</div>





<?php
//get_footer();
?>