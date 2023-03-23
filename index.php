<?php get_header(); ?>


	<?php
	// Elementor `single` location
	if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {?>

	<?php if( have_posts() ):

		while( have_posts() ) : the_post(); ?>

	<?php the_content(); ?>
	<?php endwhile; ?>

	<?php endif; ?>
	<?php }
	?>


<?php get_footer(); ?>