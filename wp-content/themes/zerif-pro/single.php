<?php
/**
 * The Template for displaying all single posts.
 *
 * @package zerif
 */
 
 $isAjax = isAjaxRequest();

 if ($isAjax):
	get_header('ajax'); ?>
 ?> 

	<div id="content" class="site-content ajax-content">
		<div class="container-fluid">
				<!--div id="primary" class="content-area"-->
					<!--main id="main" class="site-main" role="main"-->
						<?php while ( have_posts() ) : the_post(); 
								 get_template_part( 'content', 'single-ajax' );
								endwhile; // end of the loop. 
						?>
					<!--/main--><!-- #main -->
				<!--/div--><!-- #primary -->
		</div>
	</div>
</div>    
<?php else:

			get_header(); ?>
			<div class="clear"></div>
		</header> <!-- / END HOME SECTION  -->
		<?php zerif_after_header_trigger(); ?>
		<div id="content" class="site-content">
			<div class="container">
				<div class="content-left-wrap col-md-9">
					<div id="primary" class="content-area">
						<main itemscope itemtype="http://schema.org/WebPageElement" itemprop="mainContentOfPage" id="main" class="site-main" role="main">
							<?php while ( have_posts() ) : the_post(); 
								get_template_part( 'content', 'single' ); 
								zerif_post_nav(); 
								/* If comments are open or we have at least one comment, load up the comment template */
								if ( comments_open() || '0' != get_comments_number() ) :
									comments_template('');
								endif;
							endwhile; // end of the loop. ?>
						</main><!-- #main -->
					</div><!-- #primary -->
				</div>
			<div class="sidebar-wrap col-md-3 content-left-wrap">
			<?php get_sidebar(); ?>
		</div><!-- .sidebar-wrap -->
	</div>
</div>
<?php 
get_footer(); 
endif;
?>