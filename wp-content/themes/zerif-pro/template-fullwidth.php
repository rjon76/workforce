<?php
/*
Template Name: Full width template
*/
get_header();
?>

	<div class="clear"></div>
</header> <!-- / END HOME SECTION  -->
<?php zerif_after_header_trigger(); ?>
<div id="content" class="site-content">
	<div class="container">
		<div class="content-left-wrap col-md-12">
			<div id="primary" class="content-area">
				<main id="main" class="site-main" role="main">
					<?php 
						while ( have_posts() ) : 
							the_post();
							get_template_part( 'content', 'page' ); 
							/* If comments are open or we have at least one comment, load up the comment template */
							if ( comments_open() || '0' != get_comments_number() ) :
								comments_template();
							endif;
						endwhile;
					?>
				</main><!-- #main -->
			</div><!-- #primary -->
		</div><!-- .content-left-wrap -->
	</div><!-- .container -->
</div><!-- .site-content -->
<?php
	if(is_active_sidebar( 'sidebar-page-bottom' )):
			echo '<div class="sidebar-page-bottom">';
			dynamic_sidebar( 'sidebar-page-bottom' );
			echo '</div>';
	endif;
	
	get_footer();
?>