<?php 
	
	global $wp_customize;

	$zerif_latest_news_show = get_theme_mod('zerif_latest_news_show');

	if( !empty($zerif_latest_news_show) ):

		zerif_before_latest_news_trigger();
	
		$zerif_latestnews_count_posts = get_theme_mod('zerif_latestnews_count_posts', 10);
		$zerif_latestnews_count_open_posts = get_theme_mod('zerif_latestnews_count_open_posts', 4);

		$zerif_latestnews_category = get_theme_mod('zerif_latestnews_category','news');

		$cat_latestnews = get_category_by_slug($zerif_latestnews_category);

		$zerif_latestnews_ancore = get_theme_mod('zerif_latestnews_ancore', 'news');

		$zerif_latestnews_post_link = get_theme_mod('zerif_latestnews_post_link', true);

		echo '<a name="'.$zerif_latestnews_ancore.'"></a>';

		echo '<section class="latest-news" id="latestnews">';
			
		zerif_top_latest_news_trigger();
	
			echo '<div class="container">';

				/* SECTION HEADER */
				
				echo '<div class="section-header">';
					/* subtitle */
					$zerif_latestnews_subtitle = get_theme_mod('zerif_latestnews_subtitle');

					if( !empty($zerif_latestnews_subtitle) ):
						echo '<div class="section-subtitle">';
						echo '<h6>'.wp_kses_post($zerif_latestnews_subtitle).'</h6>';
						echo '</div>';
					endif;

					$zerif_latestnews_title = get_theme_mod('zerif_latestnews_title');

					/* title */
					if( !empty($zerif_latestnews_title) ):
						echo '<div class="section-title h1">';
						echo wp_kses_post($zerif_latestnews_title);
						echo '</div>';	
						
					endif;


				
				echo '</div><!-- END .section-header -->';

				echo '<div class="clear"></div>';
				

				$zerif_latest_loop = new WP_Query( apply_filters( 'zerif_latest_news_parameters', array( 'post_type' => 'post', 'posts_per_page' => $zerif_latestnews_count_posts, 'order' => 'DESC','ignore_sticky_posts' => true, 'cat' => $cat_latestnews->cat_ID )) );
				
				$is_mobile =  wp_is_mobile();

					/* Wrapper for slides */
									
						echo $newSlide;
						$i=0;
						while ( $zerif_latest_loop->have_posts() ) : $zerif_latest_loop->the_post();

							$i++;
							$custom_link = get_field( 'link', $post->ID);	

							$custom_link = ($custom_link) ? $custom_link : NULL;

							$custom_link_attr = get_field( 'link_attr', $post->ID);	
						
							$custom_link_attr = ($custom_link_attr) ? $custom_link_attr : '';
				
							$post_format = get_post_format($post->ID) ;

							$post_format = $post_format ? $post_format : 'post';


						switch ($post_format):  
				
							case 'video':
								$custom_link_css = 'play';
								$custom_link_attr = '';
								
							break;
				
							case 'image':
								$custom_link_css = 'lightbox';
								$custom_link_attr = '';
							break;
					
							case 'link':
								$custom_link_css = ''; 
								$custom_link_attr .= ' target="_blank" rel="nofollow"';
							break;
					
							default:
								$custom_link_css = '';
								$custom_link_attr = '';
							break;
				
						endswitch;
						
						$odd = ($i % 2 != 0) ? 'left' : 'right';
						
						/*--------display full item----*/
						
							echo '<div class="collapse media news-item '.$odd;
							echo ($i <= $zerif_latestnews_count_open_posts) ? ' in' : "";
							echo '"';
							//echo ($i <= $zerif_latestnews_count_open_posts) ? 'style="display:none"' : "";
							echo ' id="news'.$post->ID.'"';
							echo '>';
							if ($odd == 'left'):
								echo '<div class="media-left media-middle">';
								echo get_the_post_thumbnail($post->ID, 'full',array('class'=>'media-object')); 
								echo '</div>';
							endif;
							echo '<div class="media-body media-middle">';
							echo '<h2 class="media-heading">'.get_the_title().'</h2>';
							$content = get_extended(wpautop($post->post_content));
							echo '<div class="text">';
							echo apply_filters('the_content', $content['main']);

							if ($post_format == 'post'):
								echo '<a href="'.$custom_link.'" class="btn btn-md btn-blue '.$custom_link_css.'" '.$custom_link_attr.' title="'.get_the_title().'">';
								echo __('Learn more','zerif');
								echo '</a>';
							endif;
							echo '</div>';
							echo '</div>';
							if ($odd == 'right'):
								echo '<div class="media-right media-middle">';
								echo get_the_post_thumbnail($post->ID, 'full',array('class'=>'media-object')); 
								echo '</div>';
							endif;
							echo '</div>';
						
						/*--------display short item----*/
						if($i > $zerif_latestnews_count_open_posts):
							echo '<div class="media news-item-short hideonclick" data-toggle="collapse" data-target="#news'.$post->ID.'" aria-expanded="false"><div class="media-left media-middle">';
							echo get_the_post_thumbnail($post->ID, array('100','100'),array('class'=>'media-object img-circle')); 
							echo '</div>';
							echo '<div class="media-body media-middle"><h2 class="media-heading text-left">'.get_the_title().'</h2></div>';
							echo '<div class="media-right media-middle">';
							//echo '<a class="news-item-show row-down " role="button" data-toggle="collapse" href="#news'.$post->ID.'" aria-expanded="false">';
							echo '<img src="'.get_template_directory_uri().'/images/row-down.png"/>';
							//echo '</a>';
							echo '</div> </div>';
						endif;
		
						
						endwhile;
						

						// if there are less than 10 posts
/*						if($i_latest_posts % 4!=0){
							echo $newSlideClose;
						}*/


						wp_reset_postdata(); 
						
				
					$zerif_latestnews_footer = get_theme_mod('zerif_latestnews_footer');

					/* footer */
					if( !empty($zerif_latestnews_footer) ):
						echo '<div class="section-footer text-center">';
						echo wp_kses_post($zerif_latestnews_footer);
						echo '</div>';						
					endif;

			echo '</div><!-- .container -->';

			zerif_bottom_latest_news_trigger();

		echo '</section>';
	endif;

	zerif_after_latest_news_trigger();
