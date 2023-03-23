<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<style>

.desc{
width: 100%; 
margin-top: 20px; 
margin-bottom:20px; 


}

.cardo{

width: 100%;
}

.cardfo{
margin-top: 29px;
height: 205px;


}

@media only screen and (max-width: 1000px) {
.colo1{
width: 80%; 
margin-bottom: 30px;
margin-left: 10%;

}
.colo2{

width: 100%;
}
}


</style>

<div class="account-page-header">
	<div class="container">
		<div class="row">
			<h1 class="text-left"><?php _e('Admin Profil', 'study-doc'); ?></h1>
		</div>
	</div>
</div>

<?php 
global $wpdb;

$userID = get_current_user_id();
$first_name = get_user_meta( $userID, 'first_name', true ); 

$gender= get_user_meta($userID, 'gender', true);

$user_info = get_userdata($userID);
$email= $user_info->user_email;

$mobile= get_user_meta($userID, 'mobile', true);

$status= get_user_meta($userID, 'status', true);
$upload_dir   = wp_upload_dir();
$default_dp = $upload_dir['baseurl'] . '/display_image/default_dp.png';
$user_dp = (!empty(get_user_meta($userID, 'dp_link', true))) ? get_user_meta($userID, 'dp_link', true) : $default_dp;
?>

<div class="container admin_profile">
	<div class="row">
		<div class="col-lg-5 colo1">

			<div class="card shadow-lg">
				<div class="card-body">
					<a href="#" id="add_dp" class="add_dp" data-toggle="modal" data-target="#modalChangeDP"><i class="fa fa-plus"></i></a>
					<img class="card-img-top rounded mx-auto d-block" src="<?php echo $user_dp ?>" alt="<?php echo $first_name ;?>" width="150" height="150">
					<h5 class="card-title text-center"><?php

						echo "Welcome"."<br>".$first_name;

						?></h5>
					<div class="card-footer cardfo">
						<h6><?php _e('Beschreibung:', 'study-doc'); ?></h6>
						<p><?php echo $status; ?></p>
					</div>

				</div>
			</div>
		</div>
		<div class="col-lg-7 colo2">
			<div class="row">
				<div class="card cardo">
					<div class="card-header">
						<h6><?php _e('Admin Details:', 'study-doc'); ?></h6>
					</div>
					<div class="card-body">
						<table class="table ">
							<tr>
								<td><i class="fas fa-id-card fa-2x"></i></td>
								<td><?php echo $userID; ?></td>
							</tr>

							<tr>
								<td><i class="fas fa-file-signature fa-2x"></i></td>
								<td><?php echo $first_name; ?></td>
							</tr>

							<!--<tr>
<td><i class="fas fa-venus-mars fa-2x"></i></td>
<td><?php echo $gender; ?></td>
</tr>-->

							<tr>
								<td><i class="fas fa-envelope fa-2x"></i></td>
								<td><?php echo $email; ?></td>
							</tr>

							<!--<tr>
<td><i class="fas fa-mobile-alt fa-2x"></i></td>
<td><?php echo $mobile; ?></td>
</tr>-->
						</table>

						<div class="card-footer">


							<form id="um_form" action="updatestatus" method="POST">

								<h6 for="um_key" ><?php _e('Ihre Beschreibung aktualisieren:', 'study-doc'); ?></h6>
								<p class="stato"></p>
								<textarea type="text" name="um_key" id="um_key" style="width:100%;" class="desc" rows="2" required></textarea>
								<div><button value="done" type="submit" class=" status_button btn " value="Submit"  form="um_form"><?php _e('Aktualisieren', 'study-doc'); ?></button></div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Edit Modal HTML -->
<div id="modalChangeDP" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body">
				<?php // echo do_shortcode('[elementor-template id="1885"]'); ?>
				<div class="container">


					<div class="modal-header">
						<h4 class="modal-title"><?php _e('Profilbild aktualisieren', 'study-doc'); ?></h4>

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="row">
						<div class="col-md-6" id="dp-container">
							<form id="update_dp" action="uniadd" method="post">
								<p class="status"></p>
								<div class="form-row">
									<div class="form-group">
										<div class="custom-file">
											<input type="file" class="custom-file-input" id="dp_update" name="dp_update" accept="image/*">
											<label class="custom-file-label" for="dp_update"><?php _e('Datei auswählen', 'study-doc'); ?></label>
										</div>

									</div>
								</div>
								<div class="form-row">
									<div class="form-group">
										<input class="submit_button btn adlo" type="submit" value="Hochladen" name="submit">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6 text-center">
							<div id="display_dp"></div>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
</div>




