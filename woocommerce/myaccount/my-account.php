<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
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

defined( 'ABSPATH' ) || exit;
?>

<div class="container-fluid profile-header">
	<div class="row width_1600">
		<div class="col-md-3">
			<div class="profile-logo">
				<?php
				$logo = wp_get_attachment_image_src(6981, 'full');
				if ( $logo ) : ?>
    				<a href="<?php echo site_url(); ?>"><img class="profile-logo-img" src="<?php echo $logo[0]; ?>" /></a>
				<?php endif; ?>
				<a id="mobtogg"><i class="fas fa-align-justify fa-2x mobtogg"></i></a>
			</div>
			
		</div>
		
		<div class="col-md-9 wc-nav-section">
			<div class="wc-custom-menu" id="webmen">
				<?php do_action( 'woocommerce_account_navigation' ); ?>
			</div >	
			
		</div>
	</div>
</div>


<div class="woocommerce-MyAccount-content">
	<?php
		/**
		 * My Account content.
		 *
		 * @since 2.6.0
		 */
		do_action( 'woocommerce_account_content' );
	?>

</div>


