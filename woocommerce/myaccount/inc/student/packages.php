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
$student = $stundent_info[0];
$info_gap = array();
foreach($student as $key => $value){
	$empty = (empty($value)) ? '1' : '0';
	array_push($info_gap, $empty);
}
$package_info = $wpdb->get_results ( "SELECT package FROM $student_table where user = $userID", ARRAY_A );

$package = (empty($package_info[0]['package'])) ? '0' : '1';
?>
<div class="personal_data student-profile-packages">
	<div class="account-page-header">
		<div class="container">
			<div class="row">
				<h1 class="text-left"><?php _e('Paket', 'study-doc'); ?></h1>
			</div>
		</div>
	</div>
	<div class="student_profile">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php
					$current_user = wp_get_current_user();
					$customer_email = $current_user->user_email;
					$user_id = $current_user->ID;
// 					$product_id = 1711;

					$product_ids = array( 1711, 1712, 1713 );
					$product_bought = array();
					foreach($product_ids as $product_id){
						$is_bought = (wc_customer_bought_product($customer_email, $user_id, $product_id)) ? '1' : '0';
						array_push($product_bought, $is_bought);
					}
					

					if (in_array('1', $product_bought)) {

						include('my-orders.php');
					}else{
						echo do_shortcode( '[elementor-template id="2271"]' );
					}

					?>

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

