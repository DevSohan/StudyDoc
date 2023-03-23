<?php
/**
 * My Personal Data Page
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/personal-data.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;
$student_table = $wpdb->prefix . 'students';
$userID = get_current_user_id();
$student = array();

$stundent_info = $wpdb->get_results ( "SELECT title, first_name, last_name, address1, country, city, zip, citizenship, gender, date_of_birth, place_of_birth, email, telephone, university, subject, present_semester, lpa FROM $student_table where user = $userID", ARRAY_A );

$student[0] = $stundent_info[0];
$info_gap = array();
foreach($student as $key => $value){
	$empty = (empty($value)) ? '1' : '0';
	array_push($info_gap, $empty);
}
$package_info = $wpdb->get_results ( "SELECT package FROM $student_table where user = $userID", ARRAY_A );

$package = (empty($package_info[0]['package'])) ? '0' : '1';

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
						<img id="profile-stu" class="rounded mx-auto d-block" src="<?php echo $user_dp ?>" alt="<?php echo $student[0]['last_name'] . ', ' . $student[0]['first_name'] ;?>" width="150" height="150">
						
							<a href="#" id="add_dp_stu" class="change_dp" data-toggle="modal" data-target="#modalChangeDP"><?php // _e('Change', 'study-doc'); ?> <i class="fas fa-plus change_dp_icon"></i></a>
					<br>
						<h3 class="text-center section_hrading">
							<?php echo $student[0]['first_name'] . ' ' . $student[0]['last_name']; ?>
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
						<span class="dashboard_section_subheading"><?php _e('Email:', 'study-doc'); ?></span><br><?php echo $student[0]['email'];?>
					</p>
					<div class="dashboard_section_gap"></div>
					<p class="wc-sic-address">
						<span class="dashboard_section_subheading"><?php _e('Address:', 'study-doc'); ?></span><br> 
						<?php echo $student[0]['address1']; ?><br>
						<?php echo ($student[0]['address2'] != '') ? $student[0]['address2'] .'<br>' : null; ?>
						<?php echo $student[0]['city'] . ', ' . $student[0]['country']; ?>
					</p>
					
					
			</div>
			</div>
			
			
			
		</div>
		
		<div class="col-md-9">
			
	
				<div class="wc-student-data-form">
					<?php
					//echo do_shortcode( '[elementor-template id="175"]' );
					echo do_shortcode( '[elementor-template id="11531"]' );
					?>
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



