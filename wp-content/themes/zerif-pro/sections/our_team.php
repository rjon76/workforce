<?php	

	global $wp_customize;
	
	$zerif_ourteam_show = get_theme_mod('zerif_ourteam_show');

	zerif_before_our_team_trigger();
				
	if( isset($zerif_ourteam_show) && $zerif_ourteam_show != 1 ):
	
		echo '<section class="our-team" id="team">';
	
	elseif ( isset( $wp_customize ) ):
	
		echo '<section class="our-team zerif_hidden_if_not_customizer" id="team">';
	
	endif;

	zerif_top_our_team_trigger();

	if( (isset($zerif_ourteam_show) && $zerif_ourteam_show != 1) || isset( $wp_customize ) ):	

				echo '<div class="container">';

					echo '<div class="section-header">';
					
						/* subtitle */

						$zerif_ourteam_subtitle = get_theme_mod('zerif_ourteam_subtitle','Add a subtitle in Customizer, "Our team section"');

						if( !empty($zerif_ourteam_subtitle) ):
							echo '<div class="section-subtitle">';
							echo '<h6>'.wp_kses_post($zerif_ourteam_subtitle).'</h6>';
							echo '</div>';	
							
						endif;

					/* title */

						$zerif_ourteam_title = get_theme_mod('zerif_ourteam_title','Our Team');
					
						if( !empty($zerif_ourteam_title) ):
							echo '<div class="section-title h1">';						
							echo wp_kses_post($zerif_ourteam_title);
							echo '</div>';	
						endif;


					echo '</div>';


					if(is_active_sidebar( 'sidebar-ourteam' )):
						echo '<div class="row" >';
							dynamic_sidebar( 'sidebar-ourteam' );
						echo '</div> ';
					else:
						echo '<div class="row" data-scrollreveal="enter left after 0s over 2s">';
							the_widget( 'zerif_team_widget','name=Member 1&position=CEO&description=text about this member&fb_link=#&tw_link=#&bh_link=#&db_link=#&ln_link=#&image_uri='.get_template_directory_uri().'/images/product-bg.png' );
							the_widget( 'zerif_team_widget','name=Member 2&position=dev&description=text about this member&fb_link=#&tw_link=#&bh_link=#&db_link=#&ln_link=#&image_uri='.get_template_directory_uri().'/images/product-bg.png' );
							the_widget( 'zerif_team_widget','name=Member 3&position=hr&description=text about this member&fb_link=#&tw_link=#&bh_link=#&db_link=#&ln_link=#&image_uri='.get_template_directory_uri().'/images/product-bg.png' );
							the_widget( 'zerif_team_widget','name=Member 4&position=CEO&description=text about this member&fb_link=#&tw_link=#&bh_link=#&db_link=#&ln_link=#&image_uri='.get_template_directory_uri().'/images/product-bg.png' );
						echo '</div>';
					endif;

				echo '</div>';

				zerif_bottom_our_team_trigger();

			echo '</section>';
			
	endif;

	zerif_after_our_team_trigger();
?>			