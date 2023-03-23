<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>

<div class="container admin_dash">
	
	<div class="row">
		<div class="col-md-12 admin-welcome">
<!-- 			<h5><?php
				/* translators: 1: user display name 2: logout url */
// 				printf(
// 					__( 'Hallo %1$s', 'study-doc' ),
// 					'<strong>' . esc_html( $current_user->first_name ) .' '. esc_html( $current_user->last_name ) .'</strong>'
// 				);
				?></h5> -->
			<p><?php
				printf(
					__( ' Von Ihrem Konto-Dashboard aus können Sie die Daten aller <a href="%1$s">Studenten</a> und <a href="%2$s">Universitäten</a> verwalten.', 'study-doc' ),
					esc_url( wc_get_endpoint_url( 'students' ) ),
					esc_url( wc_get_endpoint_url( 'universities' ) )
				);
				?></p>
		</div>
	</div>



	<!--************************ CHART.JS *********************************/-->
<?php
	global $wpdb;

$student_table = $wpdb->prefix . 'students';
$query1 = "SELECT COUNT(*) FROM $student_table";
$registered = $wpdb->get_var($query1);

$query2 = "SELECT COUNT(user) FROM $student_table WHERE packageID > 0";
$enrolled = $wpdb->get_var($query2);

$sql = "SELECT COUNT(gender) FROM $student_table WHERE gender = 'männlich'" ;
$male = $wpdb-> get_var($sql);


$sql1 = "SELECT COUNT(gender) FROM $student_table WHERE gender = 'weiblich'" ;
$female = $wpdb-> get_var($sql1);

$sqlhm = "SELECT COUNT(user) FROM $student_table WHERE subject = 'Humanmedizin'" ;
$hm = $wpdb-> get_var($sqlhm);
$sqlzn = "SELECT COUNT(user) FROM $student_table WHERE subject = 'zahnmedizin'" ;
$zm = $wpdb-> get_var($sqlzn);
$sqltr = "SELECT COUNT(user) FROM $student_table WHERE subject = 'TM'" ;
$tm = $wpdb-> get_var($sqltr);


/*********** ********************/

$sql2 = "SELECT COUNT(user) FROM $student_table WHERE selected_semester = 'Winter' AND selected_year = 2021 " ;
$ws2021 = $wpdb-> get_var($sql2);
//$sql3 = "SELECT COUNT(user) FROM $student_table WHERE selected_semester = 'Sommer' AND selected_year = 2021 " ;
//$ss1 = $wpdb-> get_var($sql3);

$sql4 = "SELECT COUNT(user) FROM $student_table WHERE selected_semester = 'Winter' AND selected_year = 2022 " ;
$ws2022 = $wpdb-> get_var($sql4);
$sql5 = "SELECT COUNT(user) FROM $student_table WHERE selected_semester = 'Sommer' AND selected_year = 2022 " ;
$ss2022 = $wpdb-> get_var($sql5);
?>
		
	
	
	<div class="row chart-row">
		<div class="col-md-6">
			<div class="card shadow-sm" >
				<div class="card-body">
					<h5 class="card-title"><?php _e('Anzahl der', 'study-doc'); ?></h5>
						<h6 class="card-subtitle mb-2 text-muted"><?php _e('Eingeschriebene Studenten', 'study-doc'); ?></h6>
<!-- 					<canvas id="pieChart" data-registered="<?php echo $registered ?>" data-enrolled="<?php echo $enrolled ?>"></canvas> -->
					<div class="student-number">
						<p class="student-number-text">
							<?php echo $registered ; ?>
						</p>
					</div>
				</div>
			</div>

		</div>


		<div class="col-md-6">
			<div class="card shadow-sm" >
				<div class="card-body">
					<h5 class="card-title"><?php _e('Anzahl der', 'study-doc'); ?> </h5>
					<h6 class="card-subtitle mb-2 text-muted"><?php _e('Studenten in den folgenden Katagorien', 'study-doc'); ?></h6>
					<canvas id="hmtChart" data-hm="<?php echo $hm ?>" data-zm="<?php echo $zm ?>" data-tm="<?php echo $tm ?>"></canvas>
				</div>
			</div>

		</div>


		


	</div>

	<!--  UNI CHART------------>
	<div class="row chart-row">
<!-- 		<div class="col-md-4">

			<a class="weatherwidget-io" href="https://forecast7.com/de/53d559d99/hamburg/" data-label_1="HAMBURG" data-label_2="WEATHER" data-icons="Climacons Animated" data-days="5" data-theme="pure" ><?php // _e('HAMBURG WEATHER', 'study-doc'); ?></a>
		</div> -->
		
		<div class="col-md-6">
			<div class="card shadow-sm" >
				<div class="card-body">
					<h5 class="card-title"><?php _e('Anzahl der', 'study-doc'); ?></h5>
					<h6 class="card-subtitle mb-2 text-muted"><?php _e('Männliche und weibliche Studenten', 'study-doc'); ?></h6>
					<canvas id="mixedChart" data-male="<?php echo $male ?>" data-female="<?php echo $female ?>"></canvas>
				</div>
			</div>

		</div>
		<div class="col-md-6">
			<div class="card shadow-sm">
				<div class="card-body">
					<h5 class="card-title"><?php _e('Anzahl der', 'study-doc'); ?></h5>
					<h6 class="card-subtitle mb-2 text-muted"><?php _e('Studenten in den folgenden Semestern', 'study-doc'); ?></h6>
					<canvas id="uniChart" data-ws2021="<?php echo $ws2021 ?>" data-ss2022="<?php echo $ss2022 ?>" data-ws2022="<?php echo $ws2022 ?>"></canvas>
				</div>
			</div>
		</div>
	</div>

</div>
<?php 
get_footer();


