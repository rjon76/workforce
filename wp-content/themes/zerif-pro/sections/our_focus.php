<?php

global $wp_customize;

$zerif_ourfocus_show = get_theme_mod('zerif_ourfocus_show');

zerif_before_our_focus_trigger();

if( isset($zerif_ourfocus_show) && $zerif_ourfocus_show != 1 ):

	echo '<section class="focus" id="focus">';

elseif ( isset( $wp_customize ) ):

	echo '<section class="focus zerif_hidden_if_not_customizer" id="focus">';

endif;

if( (isset($zerif_ourfocus_show) && $zerif_ourfocus_show != 1) || isset( $wp_customize ) ):

	echo '<div class="container">';

		/* SECTION HEADER */
		$zerif_ourfocus_img1 = get_theme_mod('zerif_ourfocus_img1');
		echo '<div class="section-header">';
			/* images */
			
				
			if( !empty($zerif_ourfocus_img1) ):
				
				echo '<div class="section-image">';
				echo '<img src="'.$zerif_ourfocus_img1.'" class="img-responsive"/>';
				echo '</div>';
					
			endif;	
			
		/* title */
			$zerif_ourfocus_title = get_theme_mod('zerif_ourfocus_title');
				
			if( !empty($zerif_ourfocus_title) ):
				echo '<div class="section-title h1 text-center">';
				echo wp_kses_post($zerif_ourfocus_title);
				echo '</div>';	
			endif;	
				
			/* subtitle */
			$zerif_ourfocus_subtitle = get_theme_mod('zerif_ourfocus_subtitle');

			if( !empty($zerif_ourfocus_subtitle) ):
				echo '<div class="section-subtitle">';
				echo '<h2>'.wp_kses_post($zerif_ourfocus_subtitle).'</h2>';
				echo '</div>';
			endif;
			
			/* text */
			$zerif_ourfocus_text = get_theme_mod('zerif_ourfocus_text');

			if( !empty($zerif_ourfocus_text) ):
				echo '<div class="clearfix"></div>';	
				echo '<div class="row_">';
				echo '<div class="col-md-10 col-md-offset-1 section-text">'.wp_kses_post($zerif_ourfocus_text).'</div>';
				echo '</div>';
				echo '<div class="clearfix"></div>';	
			endif;

		echo '</div><!-- .section-header -->';

			/* text2 */
			$zerif_ourfocus_text2 = get_theme_mod('zerif_ourfocus_text2');

			if( !empty($zerif_ourfocus_text2) ):
				echo '<div class="row">';
				echo '<div class="col-md-8 col-md-offset-2 section-text2" data-scrollreveal="enter down move 60px after 0.00s over 1s">'.wp_kses_post($zerif_ourfocus_text2).'</div>';
				echo '</div>';
				echo '<div class="clearfix"></div>';
			endif;

		
	echo '</div> <!-- / END CONTAINER -->';

echo '</section>  <!-- / END FOCUS SECTION -->';

endif;

zerif_after_our_focus_trigger();

?>