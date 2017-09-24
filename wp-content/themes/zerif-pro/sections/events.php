<?php
	global $wp_customize;
	
	$zerif_googlecalendar_show = get_theme_mod('zerif_googlecalendar_show');

	//zerif_before_googlecalendar_trigger();
				
	if( isset($zerif_googlecalendar_show) && $zerif_googlecalendar_show == true ):
	
		echo '<section class="section calendar" id="calendar">';
	
		echo '<div class="container">';
					
					$zerif_googlecalendar_id = get_theme_mod('zerif_googlecalendar_id');
					if( !empty($zerif_googlecalendar_id) ):
						echo do_shortcode('[calendar id="'.$zerif_googlecalendar_id.'"]');
					endif;

					/* text */
/*					$zerif_googlecalendar_address = get_theme_mod('zerif_googlecalendar_address');

					if( !empty($zerif_googlecalendar_address) ):
						echo '<iframe src="https://calendar.google.com/calendar/embed?';
						echo 'src='.$zerif_googlecalendar_address;
						echo '&hl=en&showPrint=0&showTabs=0&showCalendars=0&showTz=0&height=600&wkst=1&bgcolor=%23FFFFFF&color=%232952A3&ctz=America%2FLos_Angeles"';
						echo ' style="border: 0" width="100%" height="600" frameborder="0" scrolling="no">';
						echo '</iframe>';
					endif;*/
				
		
		echo '</div> <!-- / END CONTAINER -->';

		echo '</section> <!-- END googlecalendar SECTION -->';
	
	endif;

	//zerif_after_googlecalendar_trigger();