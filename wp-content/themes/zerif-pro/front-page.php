<?php

get_header();

if ( get_option( 'show_on_front' ) == 'page' ) {
	include( get_page_template() );
} else {



/* BIG TITLE SECTION */


get_template_part( 'sections/big_title' );


?>

</header> <!-- / END HOME SECTION  -->
<?php zerif_after_header_trigger(); ?>
<div id="content" class="site-content zerif-fp-site-content">

	<?php
	
	global $wp_customize;
	
	$zerif_contactus_show = get_theme_mod( 'zerif_contactus_show' );
	
	$section_count = get_theme_mod( 'zerif_section_choices', 20 );

	
	/*$section1  = get_theme_mod( 'section1', 'our_focus' );
	$section2  = get_theme_mod( 'section2', 'bottom_ribbon' );
	$section3  = get_theme_mod( 'section3', 'portfolio' );
	$section4  = get_theme_mod( 'section4', 'about_us' );
	$section5  = get_theme_mod( 'section5', 'our_team' );
	$section6  = get_theme_mod( 'section6', 'testimonials' );
	$section7  = get_theme_mod( 'section7', 'right_ribbon' );
	$section8  = get_theme_mod( 'section8', 'contact_us' );
	$section9  = get_theme_mod( 'section9', 'map' );
	$section10 = get_theme_mod( 'section10', 'packages' );
	$section11 = get_theme_mod( 'section11', 'subscribe' );
	$section12 = get_theme_mod( 'section12', 'latest_news' );
	$section13 = get_theme_mod( 'section13', 'shortcodes' );

	$sections[0]  = $section1;
	$sections[1]  = $section2;
	$sections[2]  = $section3;
	$sections[3]  = $section4;
	$sections[4]  = $section5;
	$sections[5]  = $section6;
	$sections[6]  = $section7;
	$sections[7]  = $section8;
	$sections[8]  = $section9;
	$sections[9]  = $section10;
	$sections[10] = $section11;
	$sections[11] = $section12;
	$sections[12] = $section13;*/

	for ( $i = 1; $i <= $section_count; $i ++ ):
	//var_dump('section'.$i);
		$sections_name = get_theme_mod( 'section'.$i,'0');
	//var_dump($sections_name);
		if($sections_name):
			get_template_part( 'sections/'.$sections_name);
		endif;

	endfor;

	echo '</div><!-- .site-content -->';
	}

	get_footer(); ?>
