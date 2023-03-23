<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
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
?>


<?php
// if ( in_array( 'student', (array) $user->roles ) ) {
// 	//require get_template_directory() . '/woocommerce/myaccount/inc/student_dashboard.php';
// }elseif ( is_admin() ) {
// 	//require get_template_directory() . '/woocommerce/myaccount/inc/admin_dashboard.php';
// 	//echo 'admin';
// }
if( current_user_can( 'administrator' ) ) {
 require get_template_directory() . '/woocommerce/myaccount/inc/admin/dashboard.php';
}elseif( current_user_can( 'student' ) ) {
 require get_template_directory() . '/woocommerce/myaccount/inc/student/dashboard.php';
}
?>