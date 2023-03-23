<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<?php
$userID = get_current_user_id();
global $wpdb;
$user = get_current_user_id();
$student_table = $wpdb->prefix . 'students';

$file_array = $wpdb->get_row( "SELECT * FROM $student_table where user = $user" );
$array = $file_array->documents;
$lpa = $file_array->lpa;
$upload_dir   = wp_upload_dir();
$default_dp = $upload_dir['baseurl'] . '/display_image/default_dp.png';
$user_dp = (!empty(get_user_meta($userID, 'dp_link', true))) ? get_user_meta($userID, 'dp_link', true) : $default_dp;
?>

<div class="container-fluid">
	<div class="row width_1600">
		<div class="col-md-3">

			<div class="wc-student-info-wrapper">
				<div class="wc-student-info-dp">
					<div class="wc-sip-image">		
						<img id="profile-stu" class="rounded mx-auto d-block" src="<?php echo $user_dp ?>" alt="<?php echo $file_array->last_name . ', ' . $file_array->first_name ;?>" width="150" height="150">
						<a href="#" id="add_dp_stu" class="change_dp" data-toggle="modal" data-target="#modalChangeDP"><?php // _e('Change', 'study-doc'); ?> <i class="fas fa-plus change_dp_icon"></i></a>
						<br>
						<h3 class="text-center section_hrading">
							<?php echo $file_array->first_name . ' ' . $file_array->last_name; ?>
						</h3>
						<p class="text-center">
							<?php _e('ID:', 'study-doc'); ?> <?php
							global $current_user; wp_get_current_user();
							echo $current_user->user_login; 
							?>
						</p>
					</div>
				</div>

			</div>

			<div class="dashboard_section">
				<h3 class="dashboard_section_heading">
					Persönliche Infos
				</h3>

				<div class="wc-student-info-contents">

					<p class="wc-sic-email">
						<span class="dashboard_section_subheading"><?php _e('Email:', 'study-doc'); ?></span><br><?php echo $file_array->email;?>
					</p>
					<div class="dashboard_section_gap"></div>
					<p class="wc-sic-address">
						<span class="dashboard_section_subheading"><?php _e('Address:', 'study-doc'); ?></span><br> 
						<?php echo $file_array->address1; ?><br>
						<?php echo ($file_array->address2 != '') ? $file_array->address2 .'<br>' : null; ?>
						<?php echo $file_array->city . ', ' . $file_array->country; ?>
					</p>


				</div>
			</div>



		</div>

		<div class="col-md-9">
			<div class="row">
				<div class="col-md-6">
					<div class="documents_upload">

						<form id="dokument_upload" class="upload_document_form">
							<h4><?php _e('Dokument hochladen', 'study-doc'); ?></h4> <br>

							<div class="form-row">

								<div class="form-group col-md-12">
									<div class="custom-file">
										<input type="file" class="custom-file-input" id="dokumente_file" name="dokumente_file" accept="image/*,application/pdf">
										<label class="custom-file-label" for="dokumente_file"><?php _e('Datei auswählen', 'study-doc'); ?></label>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-12">
									<select class="form-control" id="dokumente_name" name="dokumente_name">
										<option value=""><?php _e('Dokumententyp auswählen', 'study-doc'); ?></option>
										<option value="abiturzeugnis"><?php _e('Abiturzeugnis', 'study-doc'); ?></option>
										<option value="abiturzeugnis-eng"><?php _e('Abiturzeugnis ins Englische', 'study-doc'); ?></option>
										<option value="abiturzeugnis-rum"><?php _e('Abiturzeugnis ins Rumänische', 'study-doc'); ?></option>
										<option value="abiturzeugnis-slo"><?php _e('Abiturzeugnis ins Slowakische', 'study-doc'); ?></option>
										<option value="abiturzeugnis-pol"><?php _e('Abiturzeugnis ins Polnische', 'study-doc'); ?></option>
										<option value="reisepass-ausweis"><?php _e('Reisepass/Personalausweis', 'study-doc'); ?></option>
										<option value="passfoto"><?php _e('Passfoto', 'study-doc'); ?></option>
										<option value="bewerbungsformular"><?php _e('Bewerbungsformular', 'study-doc'); ?></option>
										<option value="hochsulzugangsberechtigung"><?php _e('Hochsulzugangsberechtigung', 'study-doc'); ?></option>
										<option value="motivationsschreiben"><?php _e('Motivationsschreiben', 'study-doc'); ?></option>
										<option value="empfehlungsschreiben"><?php _e('Empfehlungsschreiben', 'study-doc'); ?></option>
										<option value="bewerbungsgebühr"><?php _e('Nachweis über Zahlung der Bewerbungsgebühr', 'study-doc'); ?></option>
										<option value="daten-eltern"><?php _e('Daten der Eltern', 'study-doc'); ?></option>
										<option value="englischkenntnisse"><?php _e('Nachweis der Englischkenntnisse', 'study-doc'); ?></option>
										<option value="geburtsurkunde"><?php _e('Geburtsurkunde', 'study-doc'); ?></option>
										<option value="geburtsurkunde-rum"><?php _e('Geburtsurkunde ins Rumänische', 'study-doc'); ?></option>
										<option value="geburtsurkunde-slo"><?php _e('Geburtsurkunde ins Slowakische', 'study-doc'); ?></option>
										<option value="arztliches"><?php _e('Arztliches Attest', 'study-doc'); ?></option>
										<option value="impfpasses"><?php _e('Impfpasses', 'study-doc'); ?></option>
										<option value="krankenversicherung"><?php _e('Krankenversicherung', 'study-doc'); ?></option>
										<option value="lebenslaus"><?php _e('Lebenslaus/Persönlich unterschrieben', 'study-doc'); ?></option>
										<option value="datenschutzerlkärung"><?php _e('Datenschutzerlkärung', 'study-doc'); ?></option>
										<option value="sprachtest"><?php _e('Sprachtest', 'study-doc'); ?></option>
										<option value="notfallkontakt"><?php _e('Notfallkontakt', 'study-doc'); ?></option>
										<option value="medizinischer-test"><?php _e('Medizinischer Test', 'study-doc'); ?></option>
										<option value="medi-test-eu"><?php _e('MediTest EU', 'study-doc'); ?></option>
										<option value="power-attorney-eu"><?php _e('Power of Attorney', 'study-doc'); ?></option>
										<option value="praktikumsnachweise"><?php _e('Praktikumsnachweise', 'study-doc'); ?></option>
										<option value="recognition-form"><?php _e('Recognition Form', 'study-doc'); ?></option>
										<option value="hepatitis"><?php _e('Nachweis über Hepatitis B-Impfung', 'study-doc'); ?></option>
										<option value="halbjahresabschlusszeugnis-9"><?php _e('Halb-jahresabschlusszeugnis (9 Klasse)', 'study-doc'); ?></option>
										<option value="halbjahresabschlusszeugnis-9-rum"><?php _e('Halb-jahresabschlusszeugnis in Rumänische (9 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-9"><?php _e('Jahresabschlusszeugnis (9 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-9-eng"><?php _e('Jahresabschlusszeugnis in Englische (9 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-9-rum"><?php _e('Jahresabschlusszeugnis in Rumänische (9 Klasse)', 'study-doc'); ?></option>

										<option value="halbjahresabschlusszeugnis-10"><?php _e('Halb-jahresabschlusszeugnis (10 Klasse)', 'study-doc'); ?></option>
										<option value="halbjahresabschlusszeugnis-10-rum"><?php _e('Halb-Jahresabschlusszeugnis in Rumänische (10 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-10"><?php _e('Jahresabschlusszeugnis (10 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-10-eng"><?php _e('Jahresabschlusszeugnis ins Englische (10 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-10-pol"><?php _e('Jahresabschlusszeugnis ins Polnische (10 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-10-rum"><?php _e('Jahresabschlusszeugnis in Rumänische (10 Klasse)', 'study-doc'); ?></option>
										<option value="halbjahresabschlusszeugnis-11"><?php _e('Halb-Jahresabschlusszeugnis (11 Klasse)', 'study-doc'); ?></option>
										<option value="halbjahresabschlusszeugnis-11-rum"><?php _e('Halb-Jahresabschlusszeugnis in Rumänische (11 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-11"><?php _e('Jahresabschlusszeugnis (11 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-11-eng"><?php _e('Jahresabschlusszeugnis ins Englische (11 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-11-pol"><?php _e('Jahresabschlusszeugnis ins Polnische (11 Klasse)', 'study-doc'); ?></option>
										<option value="jahresabschlusszeugnis-11-rum"><?php _e('Jahresabschlusszeugnis in Rumänische (11 Klasse)', 'study-doc'); ?></option>
										<option value="abschlusszeugnis"><?php _e('Abschlusszeugnis', 'study-doc'); ?></option>
										<option value="abschlusszeugnis-rum"><?php _e('Abschlusszeugnis in Rumänische', 'study-doc'); ?></option>
										<option value="finanzielle-erlarung"><?php _e('Erklärung über Finnazielle Unterstützung', 'study-doc'); ?></option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class=" form-group col-md-12">

									<select class="selectpicker form-control" multiple data-actions-box="true" title="<?php _e('Universität auswählen', 'study-doc'); ?>" data-style="btn-primary" id="upload-doc-universitat" name="upload-doc-universitat">

										<?php 
										global $wpdb;
										$university_table = $wpdb->prefix . 'universities';
										$university_array = 'shortname,name';
										$universities = $wpdb->get_results( "SELECT $university_array FROM $university_table" );
										foreach($universities as $uni){	
											echo "<option value=\"$uni->shortname\" /> $uni->name</option>";			
										}
										?>


										?>

									</select>
									<p class="hints">
										<?php _e('*mehrere Universitäten können ausgewählt werden', 'study-doc'); ?>
									</p>
								</div>

								<div class="form-group col-md-3">
									<input class="submit_button btn doc_upload_btn" type="submit" value="<?php _e('Hochladen', 'study-doc'); ?>" name="submit">
								</div>
							</div>

							<p class="status-up"></p>

						</form>


						<?php if($lpa == "Nein"){ ?>


						<!-- 			<form id="dokument_vorklinik_upload" class="upload_document_form">

<h4><?php _e('Vorklinik Dokumente hochladen', 'study-doc'); ?></h4>

<div class="form-row">

<div class="form-group col-md-6">
<div class="custom-file">
<input type="file" class="custom-file-input" id="dokumente_vorklinik_file" name="dokumente_vorklinik_file" accept="image/*,application/pdf">
<label class="custom-file-label" for="dokumente_vorklinik_file"><?php _e('Datei auswählen', 'study-doc'); ?></label>
</div>
</div>
<div class="form-group col-md-6">
<select class="form-control" id="dokumente_vorklinik_name" name="dokumente_vorklinik_name">
<option value="Anatomie - Makroskopische Anatomie (Bewegungsapparat)"><?php// _e('Anatomie - Makroskopische Anatomie (Bewegungsapparat)', 'study-doc'); ?></option>
<option value="Anatomie - Makroskopische Anatomie (innere Organe)"><?php //_e('Anatomie - Makroskopische Anatomie (innere Organe)', 'study-doc'); ?></option>
<option value="Anatomie - Makroskopische Anatomie (Nervensystem)"><?php //_e('Anatomie - Makroskopische Anatomie (Nervensystem)', 'study-doc'); ?></option>
<option value="Anatomie - Mikroskopische Anatomie (Histologie)"><?php //_e('Anatomie - Mikroskopische Anatomie (Histologie)', 'study-doc'); ?></option>
<option value="Anatomie - Embryologie"><?php// _e('Anatomie - Embryologie', 'study-doc'); ?></option>
<option value="Physiologie"><?php //_e('Physiologie', 'study-doc'); ?></option>
<option value="Biochemie"><?php// _e('Biochemie', 'study-doc'); ?></option>
<option value="Chemie"><?php// _e('Chemie', 'study-doc'); ?></option>
<option value="Physik"><?php //_e('Physik', 'study-doc'); ?></option>
<option value="Biologie"><?php// _e('Biologie', 'study-doc'); ?></option>
<option value="Med. Psychologie"><?php //_e('Med. Psychologie', 'study-doc'); ?></option>
<option value="Med. Soziologie"><?php //_e('Med. Soziologie', 'study-doc'); ?></option>
<option value="Med. Terminologie"><?php// _e('Med. Terminologie', 'study-doc'); ?></option>
<option value="Einführung in die Klinische Medizin"><?php// _e('Einführung in die Klinische Medizin', 'study-doc'); ?></option>
<option value="Wahlfach"><?php// _e('Wahlfach', 'study-doc'); ?></option>
<option value="90-tägiges Pflegepraktikum"><?php// _e('90-tägiges Pflegepraktikum', 'study-doc'); ?></option>
</select>
</div>
<div class="form-group col-md-3">
<input class="submit_button btn doc_upload_btn" type="submit" value="<?php// _e('Hochladen', 'study-doc'); ?>" name="submit">
</div>
</div>

<p class="status"></p>

</form> -->





						<!-- 			<form id="dokument_klinik_upload" class="upload_document_form">

<h4><?php _e('Klinik (nach ÄAppO) Dokumente hochladen', 'study-doc'); ?></h4>

<div class="form-row">

<div class="form-group col-md-6">
<div class="custom-file">
<input type="file" class="custom-file-input" id="dokumente_klinik_file" name="dokumente_klinik_file" accept="image/*,application/pdf">
<label class="custom-file-label" for="dokumente_klinik_file"><?php _e('Datei auswählen', 'study-doc'); ?></label>
</div>
</div>
<div class="form-group col-md-6">
<select class="form-control" id="dokumente_klinik_name" name="dokumente_klinik_name">
<option value="Allgemeinmedizin"><?php// _e('Allgemeinmedizin', 'study-doc'); ?></option>
<option value="Anästhesiologie"><?php// _e('Anästhesiologie', 'study-doc'); ?></option>
<option value="Arbeitsmedizin und Sozialmedizin"><?php _e('Arbeitsmedizin und Sozialmedizin', 'study-doc'); ?></option>
<option value="Augenheilkunde"><?php// _e('Augenheilkunde', 'study-doc'); ?></option>
<option value="Chirurgie"><?php// _e('Chirurgie', 'study-doc'); ?></option>
<option value="Dermatologie, Venerologie"><?php// _e('Dermatologie, Venerologie', 'study-doc'); ?></option>
<option value="Frauenheilkunde, Geburtshilfe"><?php// _e('Frauenheilkunde, Geburtshilfe', 'study-doc'); ?></option>
<option value="Hals-Nasen-Ohrenheilkunde"><?php// _e('Hals-Nasen-Ohrenheilkunde', 'study-doc'); ?></option>
<option value="Humangenetik"><?php// _e('Humangenetik', 'study-doc'); ?></option>
<option value="Hygiene, Mikrobiologie, Virologie"><?php// _e('Hygiene, Mikrobiologie, Virologie', 'study-doc'); ?></option>
<option value="Innere Medizin"><?php// _e('Innere Medizin', 'study-doc'); ?></option>
<option value="Kinderheilkunde"><?php// _e('Kinderheilkunde', 'study-doc'); ?></option>
<option value="Klinische Chemie und Laboratoriumsdiagnostik"><?php //_e('Klinische Chemie und Laboratoriumsdiagnostik', 'study-doc'); ?></option>
<option value="Neurologie"><?php //_e('Neurologie', 'study-doc'); ?></option>
<option value="Orthopädie"><?php// _e('Orthopädie', 'study-doc'); ?></option>
<option value="Pathologie"><?php //_e('Pathologie', 'study-doc'); ?></option>
<option value="Pharmakologie und Toxikologie"><?php //_e('Pharmakologie und Toxikologie', 'study-doc'); ?></option>
<option value="Psychiatrie und Psychotherapie"><?php //_e('Psychiatrie und Psychotherapie', 'study-doc'); ?></option>
<option value="Psychosomatische Medizin und Psychotherapie"><?php// _e('Psychosomatische Medizin und Psychotherapie', 'study-doc'); ?></option>
<option value="Rechtsmedizin"><?php //_e('Rechtsmedizin', 'study-doc'); ?></option>
<option value="Urologie"><?php// _e('Urologie', 'study-doc'); ?></option>
<option value="Epidemiologie, medizinische Biometrie und medizinische Informatik"><?php// _e('Epidemiologie, medizinische Biometrie und medizinische Informatik', 'study-doc'); ?></option>
<option value="Geschichte, Theorie, Ethik der Medizin"><?php// _e('Geschichte, Theorie, Ethik der Medizin', 'study-doc'); ?></option>
<option value="Gesundheitsökonomie, Gesundheitssystem, Öffentliches Gesundheitswesen"><?php// _e('Gesundheitsökonomie, Gesundheitssystem, Öffentliches Gesundheitswesen', 'study-doc'); ?></option>
<option value="Infektiologie, Immunologie"><?php //_e('Infektiologie, Immunologie', 'study-doc'); ?></option>
<option value="Klinisch-pathologische Konferenz"><?php //_e('Klinisch-pathologische Konferenz', 'study-doc'); ?></option>
<option value="Klinische Umweltmedizin"><?php //_e('Klinische Umweltmedizin', 'study-doc'); ?></option>
<option value="Medizin des Alterns und des alten Menschen"><?php //_e('Medizin des Alterns und des alten Menschen', 'study-doc'); ?></option>
<option value="Notfallmedizin"><?php// _e('Notfallmedizin', 'study-doc'); ?></option>
<option value="Klinische Pharmakologie/Pharmakotherapie"><?php //_e('Klinische Pharmakologie/Pharmakotherapie', 'study-doc'); ?></option>
<option value="Prävention, Gesundheitsförderung"><?php// _e('Prävention, Gesundheitsförderung', 'study-doc'); ?></option>
<option value="Bildgebende Verfahren, Strahlenbehandlung, Strahlenschutz"><?php //_e('Bildgebende Verfahren, Strahlenbehandlung, Strahlenschutz', 'study-doc'); ?></option>
<option value="Rehabilitation, Physikalische Medizin, Naturheilverfahren"><?php// _e('Rehabilitation, Physikalische Medizin, Naturheilverfahren', 'study-doc'); ?></option>
<option value="Allgemeinmedizin"><?php// _e('Palliativmedizin', 'study-doc'); ?></option>
<option value="Allgemeinmedizin"><?php// _e('Schmerzmedizin', 'study-doc'); ?></option>
<option value="Allgemeinmedizin"><?php// _e('Wahlfach', 'study-doc'); ?></option>
</select>
</div>
<div class="form-group col-md-3">
<input class="submit_button btn doc_upload_btn" type="submit" value="<?php //_e('Hochladen', 'study-doc'); ?>" name="submit">
</div>
</div>

<p class="status"></p>

</form> -->



						<?php } ?>
					</div>
				</div>

				<div class="col-md-6">
					<div class="container student_documents">


						<?php
						$table = '<div><h4>' . __('Documenten', 'study-doc') . '</h4>
			<table class="table_dokumenten table">';
						global $wpdb;
						$user = get_current_user_id();
						$student_table = $wpdb->prefix . 'students';

						$file_array = $wpdb->get_row( "SELECT * FROM $student_table where user = $user" );
						$array = $file_array->documents;
						$lpa = $file_array->lpa;
						if(empty($array)){
							echo '<p class="status alert alert-danger">' . __('Es wird keine Datei angezeigt.', 'study-doc') . '</p>';
						}else{
							$unserialize = unserialize($array);
							foreach($unserialize as $key => $value){
								$key = str_replace("_", " ", $key);
								$key = ucwords($key, " ");
								$table .= "<tr><td>$key</td><td><a href=\"$value\">" . __('Betrachten', 'study-doc') . "</a></td></tr>";
							}
							$table .= "</table></div>";
							echo $table;
						}

						if($lpa == "Nein"){
							$vorklinik_table = '<div><h4>' . __('Vorklinik Documenten', 'study-doc') . '</h4><table class="table_dokumenten table">';
							$array = $file_array->vorklinik_documents;
							if(empty($array)){
								echo '<p class="status alert alert-danger">' . __('Es wird keine Vorklinik Datei angezeigt.', 'study-doc') . '</p>';
							}else{
								$unserialize = unserialize($array);
								foreach($unserialize as $key => $value){
									$key = str_replace("_", " ", $key);
									$key = ucwords($key, " ");
									$vorklinik_table .= "<tr><td>$key</td><td><a href=\"$value\">" . __('Betrachten', 'study-doc') . "</a></td></tr>";
								}
								$vorklinik_table .= "</table></div>";
								echo $vorklinik_table;
							}

							$klinik_table = '<div><h4>' . __('Klinik Documenten', 'study-doc') . '</h4><table class="table_dokumenten table">';
							$array = $file_array->klinik_documents;
							if(empty($array)){
								echo '<p class="status alert alert-danger">' . __('Es wird keine Klinik Datei angezeigt.', 'study-doc') . '</p>';
							}else{
								$unserialize = unserialize($array);
								foreach($unserialize as $key => $value){
									$key = str_replace("_", " ", $key);
									$key = ucwords($key, " ");
									$klinik_table .= "<tr><td>$key</td><td><a href=\"$value\">" . __('Betrachten', 'study-doc') . "</a></td></tr>";
								}
								$klinik_table .= "</table></div>";
								echo $klinik_table;
							}
						}
						?>


					</div>
				</div>

			</div>


		</div>
	</div>
</div>




<!-- Edit Modal HTML -->
<div id="modalChangeDP" class="modal fade">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-body">
				<?php // echo do_shortcode('[elementor-template id="1885"]'); ?>
				<div class="container">


					<div class="modal-header">
						<h4 class="modal-title"><?php _e('Profilbild aktualisieren', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="row">
						<div class="col-lg-6 col-md-12" id="dp-container">
							<form id="update_dp" action="uniadd" method="post">
								<p class="status"></p>
								<div class="form-row">
									<div class="form-group">
										<label for="dp_update"></label>
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="dp_update" name="dp_update" accept="image/*">
											<label class="custom-file-label" for="dp_update"><?php _e('Datei auswählen', 'study-doc'); ?></label>
										</div>
									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<input class="submit_button btn adlo" type="submit" value="<?php _e('Hochladen', 'study-doc'); ?>" name="submit">
									</div>
								</div>
							</form>
						</div>
						<div class="col-lg-6 col-md-12 text-center">
							<div id="display_dp"></div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>






