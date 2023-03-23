<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;
$student_table = $wpdb->prefix . 'students';
$userID = get_current_user_id();
$student = array();
$document = array();

$student_list = 'title, first_name, last_name, address1, country, city, zip, citizenship, gender, date_of_birth, place_of_birth, email, telephone, study_type, university, subject, present_semester, lpa, hzb_type, hzb_date, hzb_city, hzb_country, hzb_school, hzb_grade, hzb_start, hzb_end, selected_year, selected_semester, permission';
$document_list = 'documents';

$stundent_info = $wpdb->get_results ( "SELECT $student_list FROM $student_table where user = $userID", ARRAY_A );
$student = $stundent_info[0];

$uni_info = $wpdb->get_results ( "SELECT selected_university FROM $student_table where user = $userID", ARRAY_A );
$uni = (empty($uni_info[0]['selected_university'])) ? '0' : '1';
$unio = explode(',', $uni_info[0]['selected_university']);

$package_info = $wpdb->get_results ( "SELECT package FROM $student_table where user = $userID", ARRAY_A );
$package = (empty($package_info[0]['package'])) ? '0' : '1';

$documents = $wpdb->get_results ( "SELECT $document_list FROM $student_table where user = $userID", ARRAY_A );
$document = $documents[0];


$pr_id = $wpdb->get_results("SELECT * FROM $student_table where user = $userID", ARRAY_A );
$pr_ido = $pr_id [0];


$info_gap = array();
foreach($student as $key => $value){
	$empty = (empty($value)) ? '0' : '1';
	array_push($info_gap, $empty);
}
$doc_gap = array();
foreach($document as $key => $value){
	$empty = (empty($value)) ? '0' : '1';
	array_push($doc_gap, $empty);
}
$upload_dir   = wp_upload_dir();
$default_dp = $upload_dir['baseurl'] . '/display_image/default_dp.png';
$user_dp = (!empty(get_user_meta($userID, 'dp_link', true))) ? get_user_meta($userID, 'dp_link', true) : $default_dp;


$university_array = 'shortname,name';
$university_table = $wpdb->prefix . 'universities';
$universities = $wpdb->get_results( "SELECT $university_array FROM $university_table", ARRAY_A );
?>


<!----------------------Page contents starts herer-------------------  -->

<div class="container-fluid">
	<div class="row width_1600">
		<div class="col-md-3">

			<div class="wc-student-info-wrapper">
				<div class="wc-student-info-dp">
					<div class="wc-sip-image">		
						<img id="profile-stu" class="rounded mx-auto d-block" src="<?php echo $user_dp ?>" alt="<?php echo $student['last_name'] . ', ' . $student['first_name'] ;?>" width="150" height="150">
						
							<a href="#" id="add_dp_stu" class="change_dp" data-toggle="modal" data-target="#modalChangeDP"><?php // _e('Change', 'study-doc'); ?> <i class="fas fa-plus change_dp_icon"></i></a>
					<br>
						<h3 class="text-center section_hrading">
							<?php echo $student['first_name'] . ' ' . $student['last_name']; ?>
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
						<span class="dashboard_section_subheading"><?php _e('Email:', 'study-doc'); ?></span><br><?php echo $student['email'];?>
					</p>
					<div class="dashboard_section_gap"></div>
					<p class="wc-sic-address">
						<span class="dashboard_section_subheading"><?php _e('Address:', 'study-doc'); ?></span><br> 
						<?php echo $student['address1']; ?><br>
						<?php echo ($student['address2'] != '') ? $student['address2'] .'<br>' : null; ?>
						<?php echo $student['city'] . ', ' . $student['country']; ?>
					</p>
					
					
			</div>
			</div>
			
			
			
		</div>
		
		<div class="col-md-9">
			
			<div class="row student-status">
			<div class="col-md-8 col-xs-12">
				<div class="student_dash_inner">	

		<div class="row wc-student-udpate-wrapper">
			<div class="col-md-6 col-xs-12">
				<div class="card wc-su-item-card">
					<div class="card-body text-center">
						<div class="card-title">
							<div class="<?php echo (in_array('0', $info_gap)) ? 'card-icon-danger' : 'card-icon'; ?>">
								<i class="fas fa-user fa-3x icon-wc"></i>
							</div>
						</div>
						<?php if (in_array('0', $info_gap)) { ?>
						<p class="card-text wc-db-txt-alert"><i class="fas fa-exclamation"></i><?php printf(__('Bitte füllen Sie alle Daten auf der Seite <a href="%s" class="wc-db-alert-link">Persönliche Daten</a> aus.', 'pietergoosen'), esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) . '/bewerbung/' )); ?></p>
						<?php } else { ?>
						<p class="card-text wc-db-txt"><i class="fas fa-check"></i><?php _e('Persönliche Daten sind aktualisiert.', 'study-doc'); ?></p>
						<?php }  ?>
					</div>
				</div>
			</div>

			<div class="col-md-6 col-xs-12 wc-su-item">
				<div class="card wc-su-item-card">
					<div class="card-body text-center">
						<div class="card-title"><div class="<?php echo (in_array('0', $doc_gap)) ? 'card-icon-danger' : 'card-icon'; ?>">
							<i class="fas fa-folder-open fa-3x icon-wc"></i>
							</div>
						</div>
						<?php if (in_array('0', $doc_gap)) { ?>
						<p class="card-text wc-db-txt-alert"><i class="fas fa-exclamation"></i><?php printf(__('Bitte laden Sie die notwendigen Dokumente auf der Seite <a href="%s" class="wc-db-alert-link">Dokumente</a> hoch.', 'pietergoosen'), esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) . '/dokumente/' )); ?></p>
						<?php } else { ?>
						<p class="card-text wc-db-txt"><i class="fas fa-check"></i><?php _e('Erforderliche Dokumente hochgeladen.', 'study-doc'); ?></p>
						<?php }  ?>

					</div>
				</div>
			</div>


		</div>

		
		
	

	</div>
				
				<div class="row student-status">
			<div class="col-md-12 col-xs-12">
		<h3 class="dashboard_section_heading">
				<?php _e('Fortschritt Status', 'study-doc'); ?>
				</h3>
				<div class="card wc-db-progress-report">
					<?php if(!empty($pr_ido['Progress_report'])){ ?>
				
					<div class="card-body">

						<div class="card-text progress_text">
							<?php  
								echo $pr_ido['Progress_report'];
								//global $wpdb;
								//if ($pr_ido['Progress_report'] == 'wir haben Ihre Dokumente erhalten') { ?>
<!-- 								<?php// _e('wir haben Ihre Dokumente erhalten', 'study-doc'); ?> 
							
							<?php // } else if($pr_ido['Progress_report'] == 'Datei ist in Bearbeitung'){ ?>
								<?php // _e('Datei ist in Bearbeitung', 'study-doc'); ?>	
							
							<?php // } else if($pr_ido['Progress_report'] == 'einige Dokumente fehlen'){ ?>
								<?php// _e('einige Dokumente fehlen', 'study-doc'); ?>
								
							<?php // } else if($pr_ido['Progress_report'] == 'Datei an die Universität gesendet'){ ?>
								<?php // _e('Datei an die Universität gesendet', 'study-doc'); ?>

							<?php// } ?> -->

						</div>  
					</div>
					<?php } else { ?>
						<div class="card-body">
							<div class="card-text progress_text">				
							 <?php _e('Kiene Fortschritt Status', 'study-doc'); ?>
							</div>
						</div>
					<?php } 
					
					if($pr_ido['Progress_report']== 'Warten auf die Erlaubnis zur Anwendung'){
					
					?>
					<div class="dashboard_section_gap"></div>
						<div class="card-body">
							<div class="card-text progress_text">	
							 	<form id="permission_form">		
									<p class="status"></p>
									<div class="form-check form-check-inline uni-sel">
									  <input class="form-check-input" type="checkbox" value="POK" name="input-grant-permission" id="input-grant-permission" <?php if($student['permission'] == 'POK'){echo 'checked disabled';} ?> >
									  <label class="form-check-label" for="input-grant-permission">
										
										  <?php _e('Ich erteile die Erlaubnis zur Antragstellung in meinem Namen', 'study-doc'); ?>
									  </label>
									</div>
									<div>
										<button value="done" type="submit" class=" status_button" value="Submit"  form="permission_form" <?php if($student['permission'] == 'POK'){echo 'disabled';} ?> ><?php _e('absenden', 'study-doc'); ?></button>
									</div>
									

								</form>
							</div>
						</div>
					<?php } ?>
				</div>	
		</div>
	</div>
				
				

			</div>
				<div class="col-md-4 col-xs-12">
					<div class="wc-student-uni-info">

							<p class="wc-sic-subject">
								<span class="dashboard_section_subheading"><?php _e('Subject:', 'study-doc'); ?></span><br><?php echo $student['subject'];?>
							</p>
							<div class="dashboard_section_gap"></div>
							<p class="wc-sic-year">
								<span class="dashboard_section_subheading"><?php _e('Jarh:', 'study-doc'); ?></span><br> 
								<?php echo $student['selected_year']; ?><br>
							</p>
						<div class="dashboard_section_gap"></div>
							<p class="wc-sic-semester">
								<span class="dashboard_section_subheading"><?php _e('Semester:', 'study-doc'); ?></span><br> 
								<?php echo $student['selected_semester']; ?><br>
								
							</p>
						<div class="dashboard_section_gap"></div>
							<div class="wc-sic-universities">
								<span class="dashboard_section_subheading"><?php _e('Universitäten:', 'study-doc'); ?></span> <ul class="wc-sic-universities-ul">
						
						
								<?php  
							
								
								
										foreach($universities as $uni){	
											$uni_name = $uni['name'];
							if(in_array($uni['shortname'], $unio)){ echo "<li>$uni_name</li>"; }
											
										}
								
								?></ul> </div>
								
						


					
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



<?php
get_footer();
?>