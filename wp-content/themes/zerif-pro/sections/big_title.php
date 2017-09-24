
<div class="home-header-wrap">

<?php

	global $wp_customize;

	$zerif_parallax_img1 = get_theme_mod('zerif_parallax_img1',get_template_directory_uri() . '/images/background1.jpg');
	$zerif_parallax_img2 = get_theme_mod('zerif_parallax_img2',get_template_directory_uri() . '/images/background2.png');
	$zerif_parallax_use = get_theme_mod('zerif_parallax_show');

	if ( $zerif_parallax_use == 1 && (!empty($zerif_parallax_img1) || !empty($zerif_parallax_img2)) ) {
		echo '<ul id="parallax_move">';
	
			if( !empty($zerif_parallax_img1) ) { 
				echo '<li class="layer layer1" data-depth="0.10" style="background-image: url(' . esc_url($zerif_parallax_img1) . ');"></li>';
			}
			if( !empty($zerif_parallax_img2) ) { 
				echo '<li class="layer layer2" data-depth="0.20" style="background-image: url(' . esc_url($zerif_parallax_img2) . ');"></li>';
			}

		echo '</ul>';
	
	}

	$zerif_bigtitle_show = get_theme_mod('zerif_bigtitle_show');
	
	if( isset($zerif_bigtitle_show) && $zerif_bigtitle_show != 1 ):
	
		echo '<div class="header-content-wrap">';
	
	elseif ( isset( $wp_customize ) ):
	
		echo '<div class="header-content-wrap zerif_hidden_if_not_customizer">';
	
	endif;

	if( (isset($zerif_bigtitle_show) && $zerif_bigtitle_show != 1) || isset( $wp_customize ) ):

		echo '<div class="container big-title-container">';
		echo '<div class="row">';
		echo '<div class=" col-md-7 col-md-offset-5 col-lg-6 col-lg-offset-6">';

		/* Big title */
		
		$zerif_bigtitle_title = get_theme_mod( 'zerif_bigtitle_title', __('To add a title here please go to Customizer, "Big title section"','zerif') );
	
		$zerif_bigtitle_text = get_theme_mod( 'zerif_bigtitle_text');	
	
		if( !empty($zerif_bigtitle_title) ||  !empty($zerif_bigtitle_text)):

			echo '<h1 class="title">'.wp_kses_post($zerif_bigtitle_title).'</h1>';
		    echo '<div class="text">'.wp_kses_post($zerif_bigtitle_text).'</div>';
			
		elseif ( isset( $wp_customize ) ):
		
			echo '<h1 class="intro-text zerif_hidden_if_not_customizer"></h1>';
			echo '<div class="text zerif_hidden_if_not_customizer"></div>';

		endif;	

		/* Buttons */
		
		$zerif_bigtitle_redbutton_label = get_theme_mod( 'zerif_bigtitle_redbutton_label',__('One button','zerif') );
		$zerif_bigtitle_redbutton_url = get_theme_mod( 'zerif_bigtitle_redbutton_url','#' );

		$zerif_bigtitle_greenbutton_label = get_theme_mod( 'zerif_bigtitle_greenbutton_label',__('Another button','zerif') );
		$zerif_bigtitle_greenbutton_url = get_theme_mod( 'zerif_bigtitle_greenbutton_url','#' );

		$zerif_bigtitle_button3_label = get_theme_mod( 'zerif_bigtitle_button3_label' );
		$zerif_bigtitle_button3_url = get_theme_mod( 'zerif_bigtitle_button3_url');
	
		$zerif_accessibility = get_theme_mod( 'zerif_accessibility' );

		if( (!empty($zerif_bigtitle_redbutton_label) && !empty($zerif_bigtitle_redbutton_url)) ||

		(!empty($zerif_bigtitle_greenbutton_label) && !empty($zerif_bigtitle_greenbutton_url)) ||

		(!empty($zerif_bigtitle_button3_label) && !empty($zerif_bigtitle_button3_url))):


			echo '<div class="buttons" data-scrollreveal="enter right move 60px after 0.00s over 1s">';

				zerif_big_title_buttons_top_trigger();

				/* Red button */
			
				if (!empty($zerif_bigtitle_redbutton_label) && !empty($zerif_bigtitle_redbutton_url)):

					if(isset($zerif_accessibility) && $zerif_accessibility == 1){
						echo '<button class="btn btn-primary custom-button btn-blue btn-xss-block" onclick="window.location=\''.esc_url($zerif_bigtitle_redbutton_url).'\';"><span class="screen-reader-text">'.wp_kses_post($zerif_bigtitle_redbutton_label).'</span>'.wp_kses_post($zerif_bigtitle_redbutton_label).'</button>';
					} else {
						echo '<a href="'.esc_url($zerif_bigtitle_redbutton_url).'" class="btn btn-primary custom-button btn-blue btn-xss-block">'.wp_kses_post($zerif_bigtitle_redbutton_label).'</a>';
					}

				elseif ( isset( $wp_customize ) ):
					if(isset($zerif_accessibility) && $zerif_accessibility == 1) {
						echo '<button class="btn btn-primary custom-button red-btn zerif_hidden_if_not_customizer"><span class="screen-reader-text">'.esc_html_e('Edit left button.','zerif').'</span></button>';
					} else {
						echo '<a href="" class="btn btn-primary custom-button btn-blue btn-xs-block zerif_hidden_if_not_customizer"></a>';
					}

				endif;

				/* Green button */

				if (!empty($zerif_bigtitle_greenbutton_label) && !empty($zerif_bigtitle_greenbutton_url)):

					if(isset($zerif_accessibility) && $zerif_accessibility == 1) {
						echo '<button class="btn btn-primary custom-button btn-orange btn-xss-block" onclick="window.location=\''.esc_url($zerif_bigtitle_greenbutton_url).'\';"><span class="screen-reader-text">'.wp_kses_post($zerif_bigtitle_greenbutton_label).'</span>'.wp_kses_post($zerif_bigtitle_greenbutton_label).'</button>';
					} else {
						echo '<a href="' . esc_url( $zerif_bigtitle_greenbutton_url ) . '" class="btn btn-primary custom-button btn-orange btn-xss-block">' . wp_kses_post( $zerif_bigtitle_greenbutton_label ) . '</a>';
					}

				elseif ( isset( $wp_customize ) ):

					if(isset($zerif_accessibility) && $zerif_accessibility == 1) {
						echo '<button class="btn btn-primary custom-button btn-orange btn-xss-block zerif_hidden_if_not_customizer"><span class="screen-reader-text">'.esc_html_e('Edit right button.','zerif').'</span></button>';
					} else {
						echo '<a href="" class="btn btn-primary custom-button btn-orange btn-xss-block zerif_hidden_if_not_customizer"></a>';
					}

				endif;

				/* button 3 */

				if (!empty($zerif_bigtitle_button3_label) && !empty($zerif_bigtitle_button3_url)):

					if(isset($zerif_accessibility) && $zerif_accessibility == 1) {
						echo '<button class="btn btn-empty btn-xss-block" onclick="window.location=\''.esc_url($zerif_bigtitle_button3_url).'\';"><span class="screen-reader-text">'.wp_kses_post($zerif_bigtitle_button3_label).'</span>'.wp_kses_post($zerif_bigtitle_button3_label).'</button>';
					} else {
						echo '<a href="' . esc_url( $zerif_bigtitle_button3_url ) . '" class="btn btn-empty btn-xss-block">' . wp_kses_post( $zerif_bigtitle_button3_label ) . '</a>';
					}

				elseif ( isset( $wp_customize ) ):

					if(isset($zerif_accessibility) && $zerif_accessibility == 1) {
						echo '<button class="btn  btn-empty btn-xss-block zerif_hidden_if_not_customizer"><span class="screen-reader-text">'.esc_html_e('Edit right button.','zerif').'</span></button>';
					} else {
						echo '<a href="" class="btn btn-empty btn-xss-block zerif_hidden_if_not_customizer"></a>';
					}

				endif;
				zerif_big_title_buttons_bottom_trigger();


			echo '</div>';


		endif;

		echo '</div>';
		echo '</div>';
		echo '</div>';
	echo '</div><!-- .header-content-wrap -->';
	
	endif;

	echo '<div class="clear"></div>';


?>

</div><!--.home-header-wrap -->
