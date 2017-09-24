<?php
	global $wp_customize;
	
	$zerif_aboutus_show = get_theme_mod('zerif_aboutus_show');

	zerif_before_about_us_trigger();
				
	if( isset($zerif_aboutus_show) && $zerif_aboutus_show != 1 ):
	
		echo '<section class="about-us" id="aboutus">';
	
	elseif( isset( $wp_customize ) ):
	
		echo '<section class="about-us zerif_hidden_if_not_customizer" id="aboutus">';
	
	endif;
	
	if(( isset($zerif_aboutus_show) && $zerif_aboutus_show != 1 ) || isset( $wp_customize ) ):

			echo '<div class="container">';
		
				/* SECTION HEADER */

				echo '<div class="section-header">';
					
					/* subtitle */

					$zerif_aboutus_subtitle = get_theme_mod('zerif_aboutus_subtitle');


					if( !empty($zerif_aboutus_subtitle) ):
						echo '<div class="section-subtitle">';
						echo '<h6 class="white-text">'.wp_kses_post($zerif_aboutus_subtitle).'</h6>';
						echo '</div>';
					
					endif;
					
					/* title */
					
					$zerif_aboutus_title = get_theme_mod('zerif_aboutus_title');
					
					if( !empty($zerif_aboutus_title) ):
						echo '<div class="section-title h1">';
						echo wp_kses_post($zerif_aboutus_title);
						echo '</div>';
					endif;
					
					/* text */
					$zerif_aboutus_text = get_theme_mod('zerif_aboutus_text');

					if( !empty($zerif_aboutus_text) ):
						echo '<div class="row">';
						echo '<div class="col-md-8 col-md-offset-2 section-text">'.wp_kses_post($zerif_aboutus_text).'</div>';
						echo '</div>';
						echo '<div class="clearfix"></div>';	
					endif;

				echo '</div>';

				
			/* CLIENTS */
		
			if(is_active_sidebar( 'sidebar-aboutus' )):
				
				echo '<div class="client-list">';
					echo '<div data-scrollreveal="enter right move 60px after 0.00s over 2.5s">';
					dynamic_sidebar( 'sidebar-aboutus' );
					echo '</div>';
				echo '</div> ';
			endif;

		echo '</div> <!-- / END CONTAINER -->';

	echo '</section> <!-- END ABOUT US SECTION -->';
	
	endif;

	zerif_after_about_us_trigger();