<!DOCTYPE html>
<html lang="de-DE">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="<?php bloginfo( 'charset'); ?>" />

		<title>
		<?php 
		$endpoint = (WC()->query->get_current_endpoint());																							
		if(is_home() || is_front_page()){
			bloginfo( 'name');
		}elseif ( is_wc_endpoint_url($endpoint) ){
			echo ucfirst($endpoint); echo " - "; bloginfo( 'name');
		}else{
			wp_title( '' ); echo " - "; bloginfo( 'name');
		} ?>
		</title>

		<?php if (get_post_meta( $post->ID, 'noindex', true )) : ?>
		<meta name="robots" content="noindex, nofollow">
		<?php endif; ?>	
		<?php wp_head(); ?>
		<?php																				
if ( is_account_page() || is_cart() || is_checkout() || is_page('fristen') || is_page('reset-password')){ ?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />	
		
<?php } ?>
		

	</head>
	<body <?php body_class( 'class-name' ); ?>>
																				
<!-- <div id="preloader"><div id="loader"></div></div> -->
<!-- 		<div class="spinner-wrap">
			<div class="spinner">Loading...</div>
		</div> -->

		<?php
		// Elementor `header` location
		if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'header' ) ) {

		}
		?>
