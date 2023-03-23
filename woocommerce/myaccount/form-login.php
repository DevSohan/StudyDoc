<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.9.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>


		
<?php if ( 'yes' != get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
			
		<div class="container login-register">
	<div class="row justify-content-center">
		<div class="col-md-6 col-sm-12 login">
			

			<?php echo do_shortcode( '[elementor-template id="2334"]' ); ?>
			<div class="forgetpass_custom"><?php printf(__('Passwort vergessen? <a href="%s">Here</a> Password zurücksetzen', 'study-doc'), esc_url( 'https://studydoc.de/lost-password' )); ?></div>

		</div>
		
	</div>
</div>

<?php endif; ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

<div class="container login-register">
	<div class="row justify-content-center">
		<div class="col-md-6 col-sm-12 login">
			<img src="https://studydoc.de/wp-content/uploads/2021/02/studydoc-logo-small.png" alt="logo" class="logostu">

			<?php echo do_shortcode( '[elementor-template id="2334"]' ); ?>
			<div class="forgetpass_custom"><?php printf(__('Passwort vergessen? <a href="%s">Here</a> Password zurücksetzen', 'study-doc'), esc_url( 'https://studydoc.de/lost-password' )); ?></div>

		</div>
		
	</div>
</div>


<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


