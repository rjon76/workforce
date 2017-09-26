<?php 

$custom_link = get_field('custom_link', get_the_ID());

$custom_link = ($custom_link) ? $custom_link : get_the_permalink();

$custom_link_attr = get_field('custom_link_attr',  get_the_ID());	 

$date_start = get_field('date_start', get_the_ID());

$date_stop = get_field('date_stop', get_the_ID());

$col_md = get_field('col-md', get_the_ID());

$col_md = empty($col_md) ? 6 : $col_md;

$post_format = get_post_format();

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

<div class="col-sm-6 col-md-<?php echo $col_md; ?>  blog-post ">
	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="thumbnail">
    	<div class="thumbnail-img">
        
	    <?php

			 if($post_format == 'video'): ?>
				<span class="play-button glyphicon glyphicon-play-circle"></span>
			<?php endif; 

			 if($post_format == 'image'): ?>
				<span class="play-button glyphicon glyphicon-zoom-in"></span>
			<?php endif; 

			//echo get_the_post_thumbnail($post->ID, 'full',array('class'=>'media-object')); 
        	
				$meta = get_post_meta( get_the_ID() , '_thumbnail_id');
				if ($meta[0]):
					the_post_thumbnail('full', array('class' => 'img-responsive'));
				endif;
			
			?>
      </div>
      <div class="caption">
          	<h3 class="entry-title">
        	<?php the_title();?>	
	        </h3>
		 
        <div class="entry-content"> 
        
		 <?php 

			//echo wp_trim_words( get_the_content(), 20, '...' );

		 	//$pageExtended = get_extended( wpautop(get_the_content($more_text)));
            //echo $pageExtended['main'];
			//echo wp_trim_words( apply_filters('the_content', $pageExtended['main']), 20, '...' );
			//echo get_the_content('');
			echo apply_filters('the_content', get_the_content(''));
			
			if($date_start || $date_stop):
			
				echo '<div class="dates">';
				echo '<table width="100%">';
                if($date_start ):
				 	echo '<tr><td >'.__('NEXT START DATE:').'</td><td><span class="badge">'.dateFormat($date_start,3).'</span></td></tr>';
				endif;
				
				echo '<tr><td>'.__('APPLICATION DEADLINE: ').'</td><td>';
				if($date_stop) :
					echo '<span class="badge">'.dateFormat($date_stop, 3 ).'</span>';
				else:
					echo '<span class="infin">&infin;</span>';
				endif;
				echo '</td></tr>';
				echo '</table>';
                echo '</div>';
			endif;
			
			if($custom_link):
				echo '<div class="buttons">';
	        	echo '<a href="'.$custom_link.'" class="btn btn-md btn-block btn-orange '.$custom_link_css.'" '.$custom_link_attr.'>';
				echo __('APPLY NOW', 'zerif');
				echo '</a>';
				echo '</div>';
			endif;
		?>
       
        </div>
       </div>
    </div>
    </div><!-- #post-## -->
</div>
