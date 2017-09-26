
    <?php 
	$the_slug = 'events-and-descriptions';
	$cat = get_category_by_slug($the_slug);
	$date = date('Ymd');
	$args = array(
		'post_type'   => 'post',
		'post_status' => 'publish',
		'numberposts' => 4,
		'suppress_filters' => false,
		//'orderby' => 'date',
		'order' => 'ASC',
		'cat' => $cat->cat_ID,
		'meta_key' => 'date',
		'orderby'=>'meta_value',
		'meta_query' => array(
        	array  (
           	 	'key' => 'date',
           	 	'value' => $date,
				'compare' => '>='
       		 )
    	)
	);
    $blockPage = get_posts($args);
    if( $blockPage ) : ?>
    	<div class="inner ">
    		<h3><a href="<?php echo get_category_link($cat->cat_ID) ?>"><?php echo $cat->cat_name ?></a></h3>
    		<div class="line_gray_short"></div>
        </div>     
         <?php foreach($blockPage as $event) { 
		 		
				$custom_link = get_field('custom_link', $event->ID);

				$custom_link = ($custom_link) ? $custom_link : get_permalink($event->ID);

				$custom_link_attr = get_field('custom_link_attr',  $event->ID);	
				
				$post_format = get_post_format($event->ID);

				switch ($post_format) {  
				
					case 'video':
						$custom_link_css = 'play';
					break;
				
					case 'image':
						$custom_link_css = 'colorbox';
					break;
					
					case 'link':
						$custom_link_attr .= ' target="_blank"';
					break;
					
					default:
						$custom_link_css = ''; 
					break;
				
				}

		 
		 
		 ?>
            <div class="event-item shadow_hover">
            <?php if($custom_link && $custom_link !== '#'): ?>
                    <a href="<?php echo $custom_link; ?>" class="<?php echo $custom_link_css; ?>"  <?php echo $custom_link_attr; ?>>
             <?php endif; ?>       
                        <div class="col-xs-12 col-sm-10 col-md-10 ev_col1 vcenter">
                            <h4 class="title">
                                <?php echo wp_html_excerpt($event->post_title, 40) ?>
                            </h4>
                            <p class="text">
								<?php 
								 if ($event->post_excerpt!==''){
									echo $event->post_excerpt;
				  				}else{
									echo wp_trim_words( $event->post_content, $num_words = 12, $more = '...' );
				  			}
							//	echo wp_html_excerpt( $event->post_content, 74) ?>
                            </p>
                        </div><div class="col-xs-12 col-sm-2 col-md-2 ev_col2 date vcenter <?php if (get_field('date_stop', $event->ID)):
						echo 'tooline'; endif;?>">
                            <?php if(get_field('date', $event->ID)):
								 	echo bootstrapBasic_EventFormat($event->ID);
									if (get_field('date_stop', $event->ID)):
									echo '<br class="hidden-xs" /> - <br class="hidden-xs" />'.bootstrapBasic_EventFormat($event->ID, '1', 'date_stop');
									endif;
								  else:
								 	echo '<span class="infin">&infin;</span>';
								  endif;	
								  ?>
                        </div>
                         <div class="clearfix"></div>
                    <?php if($custom_link && $custom_link !== '#'): ?>
                    </a>
              		<?php endif; ?> 
            </div>
        <?php }; ?>
<?php 
endif; 
wp_reset_query(); 
?>
