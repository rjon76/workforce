<?php

/**

 * The Header for our theme.

 *

 * Displays all of the <head> section and everything up till <div id="content">

 *

 * @package zerif

 */

?><!DOCTYPE html>

<html <?php language_attributes(); ?>>

<head>

<?php zerif_top_head_trigger(); ?>

<meta charset="<?php bloginfo( 'charset' ); ?>">

<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php

	$zerif_google_anaytics = get_theme_mod('zerif_google_anaytics');
	if( !empty($zerif_google_anaytics) ):
		echo $zerif_google_anaytics;
	endif;
?>

<!--[if lt IE 9]>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/html5.js"></script>
<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/ie.css" type="text/css">
<![endif]-->

<?php 

if ( ! function_exists( '_wp_render_title_tag' ) ) :
    function zerif_pro_old_render_title() {
?>
<title><?php wp_title( '-', true, 'right' ); ?></title>
<?php
    }
    add_action( 'wp_head', 'zerif_pro_old_render_title' );
endif;

wp_head();

?>

<?php zerif_bottom_head_trigger(); ?>

</head>

		<body <?php body_class(); ?> itemscope="itemscope" itemtype="http://schema.org/WebPage">
		<?php
//zerif_top_body_trigger();

