<?php

/**

 * @package zerif

 */

?>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<header class="entry-header">

		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>



		<div class="entry-meta">

			<?php //zerif_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->



	<?php	

	if ( is_singular( 'portofolio' ) ) {

		$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'thumbnail') );

		echo '<img src="'.esc_url($url).'" />';

	}

	?>

	

	<div class="entry-content" itemprop="text">

		<?php the_content(); ?>

		<?php

		/*	wp_link_pages( array(

				'before' => '<div class="page-links">' . __( 'Pages:', 'zerif' ),

				'after'  => '</div>',

			) );*/

		?>

	</div><!-- .entry-content -->



	<footer class="entry-footer">

		<?php

			/* translators: used between list items, there is a space after the comma */

			//$category_list = get_the_category_list( __( ', ', 'zerif' ) );



			/* translators: used between list items, there is a space after the comma */

			//$tag_list = get_the_tag_list( '', __( ', ', 'zerif' ) );



		/*	if ( ! zerif_categorized_blog() ) {

	
				if ( '' != $tag_list ) {

					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'zerif' );

				} else {

					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'zerif' );

				}



			} else {

			

				if ( '' != $tag_list ) {

					$meta_text = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'zerif' );

				} else {

					$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'zerif' );

				}



			} */



			/*printf(

				$meta_text,

				$category_list,

				$tag_list,

				get_permalink()

			);*/

		?>



		<?php edit_post_link( __( 'Edit', 'zerif' ), '<span class="edit-link">', '</span>' ); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->

