<?php

/**
 * zerif Theme Customizer
 *
 * @package zerif
 */
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */

function wp_themeisle_customize_register( $wp_customize ) {

    class Zerif_Customize_Alpha_Color_Control extends WP_Customize_Control {

        public $type = 'alphacolor';
        public $palette = true;
        public $default = '#3FADD7';

        protected function render() {
            $id = 'customize-control-' . str_replace( '[', '-', str_replace( ']', '', $this->id ) );
            $class = 'customize-control customize-control-' . $this->type; ?>
            <li id="<?php echo esc_html( $id ); ?>" class="<?php echo esc_html( $class ); ?>">
                <?php $this->render_content(); ?>
            </li>
            <?php
        }

        public function render_content() { ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="text" data-palette="<?php echo $this->palette; ?>" data-default-color="<?php echo $this->default; ?>" value="<?php echo intval( $this->value() ); ?>" class="pluto-color-control" <?php $this->link(); ?>  />
            </label>
            <?php
        }
    }
	class Zerif_Video_Sound extends WP_Customize_Control {
		public function render_content() {
			echo '<label><span class="customize-control-title">'.__('Enable video sound?','zerif-lite').'</span></label>';
		}
	}

    class Zerif_Customizer_Number_Control extends WP_Customize_Control {
        public $type = 'number';
        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <input type="number" <?php $this->link(); ?> value="<?php echo intval( $this->value() ); ?>" />
            </label>
            <?php
        }
    }
    class Zerif_Customize_Textarea_Control extends WP_Customize_Control {
        public $type = 'textarea';

        public function render_content() {
            ?>
            <label>
                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
                <textarea rows="5" id="customize_textarea" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
            </label>
            <?php
        }
    }

    class Zerif_Html_Support extends WP_Customize_Control {
        public function render_content() {
            echo __('You can insert any HTML code in here, to create links, google maps or anything else.','zerif');
        }
    }

    class Zerif_LatestNews extends WP_Customize_Control {
        public function render_content() {
            echo __('The main content of this section consists of blog posts.','zerif');
        }
    }

    class Zerif_Colors_Panel extends WP_Customize_Control {
        public function render_content() {
            echo __('To have full control over the colors on homepage sections please visit each section options in Customizer.','zerif');
        }
    }

    class Zerif_Intergeo_Panel extends WP_Customize_Control {
        public function render_content() {
            echo __('You can install <a href="https://wordpress.org/plugins/intergeo-maps/" taget="_blank">WordPress Google Maps Plugin</a> to get more advanced maps option.','zerif');
        }
    }

    $wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->remove_section('colors');

    /**********************************************/
    /*************** ORDER ************************/
    /**********************************************/
	$section_choices = array(
			//'0' => __( 'Not selected','zerif' ),
			'our_focus' => __( 'Our focus','zerif' ),
            'portofolio' => __( 'Portfolio','zerif' ),
            'about_us' => __( 'About us','zerif' ),
            'our_team' => __( 'Our team','zerif' ),
            'testimonials' => __( 'Testimonials','zerif' ),
            'bottom_ribbon' => __( 'Bottom ribbon','zerif' ),
            'right_ribbon' => __( 'Right ribbon','zerif' ),
            'contact_us' => __( 'Contact us','zerif' ),
            'packages' => __(' Packages','zerif' ),
            'google_map' => __( 'Google map','zerif' ),
            'subscribe' => __( 'Subscribe','zerif' ),
            'latest_news' => __( 'Latest news','zerif' ),
            'shortcodes' => __('Shortcodes','zerif'),
			'events' => __('Calendar','zerif'),
			
		);
    $wp_customize->add_section( 'zerif_order_section' , array(
        'title'       => __( 'Sections order', 'zerif' ),
        'description' => __( 'Here is where you can rearrange the homepage sections.','zerif' ),
        'priority'    => 29
    ) );
	
	$wp_customize->add_setting( 'zerif_section_choices', array(
        'default' => count($section_choices),
        'sanitize_callback' => 'zerif_sanitize_input'
    ) );

	$wp_customize->add_control( 'zerif_section_choices', array(
            //'type' => 'textarea',
			//'label'    => __( 'Sections', 'zerif' ),
            'section'  => 'zerif_order_section',
            'priority'    => 1,
			'type'	=> 'hidden',
        ) );
	
	$i=1;	
	
	foreach($section_choices as $key => $value):
		$wp_customize->add_setting( 'section'.$i, array(
        	'default' => $key,
        	//'sanitize_callback' => 'zerif_sanitize_section_name'
			'sanitize_callback' => 'zerif_sanitize_input'
    	) );

    	$wp_customize->add_control( 'section'.$i, array(
        'type' => 'select',
        'label' => 'Section '.$i,
        'section' => 'zerif_order_section',
        'choices' => $section_choices,
        'priority' => $i+1
    ) );
		$i++;
	endforeach;




    /***********************************************/
    /************** COLORS OPTIONS  ****************/
    /***********************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ):

        $wp_customize->add_panel( 'panel_1', array(
            'priority' => 30,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Colors', 'zerif' )
        ) );

        /* COLORS HOMEPAGE */

        $wp_customize->add_section( 'zerif_hp_color_section' , array(
            'title'       => __( 'Homepage sections', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_1'
        ));

        $wp_customize->add_setting( 'zerif_hp_color_section' );

        $wp_customize->add_control( new Zerif_Colors_Panel( $wp_customize, 'zerif_hp_color_section', array(
                'section' => 'zerif_hp_color_section',
        ) ) );

        /* COLORS FOOTER */

        $wp_customize->add_section( 'zerif_footer_color_section' , array(
            'title'       => __( 'Footer colors', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_1'
        ) );

        /* zerif_footer_background */
        $wp_customize->add_setting( 'zerif_footer_background', array(
            'default' => '#272727',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_background', array(
            'label'      => __( 'Footer background color', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 1
        ) ) );

        /* zerif_footer_socials_background */
        $wp_customize->add_setting( 'zerif_footer_socials_background', array(
            'default' => '#171717',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color',
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_socials_background', array(
            'label'      => __( 'Footer socials background color', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 2
        ) ) );

        /* zerif_footer_text_color */
        $wp_customize->add_setting( 'zerif_footer_text_color', array(
            'default' => '#939393',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_text_color', array(
            'label'      => __( 'Footer text color', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 3
        ) ) );
		
		/* zerif_footer_text_color_hover */
        $wp_customize->add_setting( 'zerif_footer_text_color_hover', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_text_color_hover', array(
            'label'      => __( 'Footer text color - hover', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 4
        ) ) );

        /* zerif_footer_socials */
        $wp_customize->add_setting( 'zerif_footer_socials', array(
            'default' => '#939393',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_socials', array(
            'label'      => __( 'Footer social icons color', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 5
        ) ) );

        /* zerif_footer_socials_hover */
        $wp_customize->add_setting( 'zerif_footer_socials_hover', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_socials_hover', array(
            'label'      => __( 'Footer socials icons color - hover', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 6
        ) ) );
		
		/* zerif_footer_widgets_title */
        $wp_customize->add_setting( 'zerif_footer_widgets_title', array(
            'default' => '#fff',
			'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_widgets_title', array(
            'label'      => __( 'Footer widgets title color', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 7
        ) ) );
		
		/* zerif_footer_widgets_title_border_bottom */
        $wp_customize->add_setting( 'zerif_footer_widgets_title_border_bottom', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_footer_widgets_title_border_bottom', array(
            'label'      => __( 'Footer widgets title bottom border color', 'zerif' ),
            'section'    => 'zerif_footer_color_section',
            'priority'   => 8
        ) ) );

        /* COLORS FOOTER */

        $wp_customize->add_section( 'zerif_general_color_section' , array(
            'title'       => __( 'General colors', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_1'
        ));


        $wp_customize->add_setting( 'zerif_menu_item_color', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_menu_item_color', array(
            'label'      => __( 'Menu item color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 1
        ) ) );

        $wp_customize->add_setting( 'zerif_menu_item_hover_color', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_menu_item_hover_color', array(
            'label'      => __( 'Menu item color hover', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 2
        ) ) );

        /* zerif_background_color */
        $wp_customize->add_setting( 'zerif_background_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_background_color', array(
            'label'      => __( 'Background color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 3
        ) ) );

        /* zerif_navbar_color */
        $wp_customize->add_setting( 'zerif_navbar_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_navbar_color', array(
            'label'      => __( 'Navbar background color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 4
        ) ) );

        /* zerif_titles_color */
        $wp_customize->add_setting( 'zerif_titles_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_titles_color', array(
            'label'      => __( 'Titles color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 5
        ) ) );

        /* zerif_titles_bottomborder_color */
        $wp_customize->add_setting( 'zerif_titles_bottomborder_color', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_titles_bottomborder_color', array(
            'label'      => __( 'Titles bottom border color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 6
        ) ) );

        /* zerif_texts_color */
        $wp_customize->add_setting( 'zerif_texts_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color' )
        );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_texts_color', array(
            'label'      => __( 'Text color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 7
        ) ) );

        /* zerif_links_color */
        $wp_customize->add_setting( 'zerif_links_color', array(
            'default' => '#808080',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_links_color', array(
            'label'      => __( 'Links color', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 8
        ) ) );

        /* zerif_links_color_hover */
        $wp_customize->add_setting( 'zerif_links_color_hover', array(
            'default' => '#e96656',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_links_color_hover', array(
            'label'      => __( 'Links color hover', 'zerif' ),
            'section'    => 'zerif_general_color_section',
            'priority'   => 9
        ) ) );

        /* COLORS BUTTONS */

        $wp_customize->add_section( 'zerif_buttons_color_section' , array(
            'title'       => __( 'Buttons colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_1'
        ));

        /* zerif_buttons_background_color */
        $wp_customize->add_setting( 'zerif_buttons_background_color', array(
            'default' => '#e96656',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_buttons_background_color', array(
            'label'      => __( 'Buttons background color', 'zerif' ),
            'section'    => 'zerif_buttons_color_section',
            'priority'   => 1
        ) ) );

        /* zerif_buttons_background_color_hover */
        $wp_customize->add_setting( 'zerif_buttons_background_color_hover', array(
            'default' => '#cb4332',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_buttons_background_color_hover', array(
            'label'      => __( 'Buttons background color - hover', 'zerif' ),
            'section'    => 'zerif_buttons_color_section',
            'priority'   => 2
        ) ) );

        /* zerif_buttons_text_color */
        $wp_customize->add_setting( 'zerif_buttons_text_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_buttons_text_color', array(
            'label'      => __( 'Buttons text color', 'zerif' ),
            'section'    => 'zerif_buttons_color_section',
            'priority'   => 3
        ) ) );

   
    endif;

    /***********************************************/
    /************** GENERAL OPTIONS  ***************/
    /***********************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ):

        $wp_customize->add_panel( 'panel_2', array(
            'priority' => 31,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'General options', 'zerif' )
        ) );

        $wp_customize->add_section( 'zerif_general_section' , array(
            'title'       => __( 'General options', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_2'
        ));
		
		/* safe font */
        $wp_customize->add_setting( 'zerif_use_safe_font', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_use_safe_font', array(
            'type'      => 'checkbox',
            'label'     => __( 'Use safe font?','zerif' ),
            'section'   => 'zerif_general_section',
            'priority'  => 1
        ) );

        /* zerif_disable_preloader */
        $wp_customize->add_setting( 'zerif_disable_preloader',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_disable_preloader', array(
            'type' => 'checkbox',
            'label' => __( 'Disable preloader?','zerif' ),
            'section' => 'zerif_general_section',
            'priority'    => 2,
        ) );

        /* Disable smooth scroll */
        $wp_customize->add_setting( 'zerif_disable_smooth_scroll', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_disable_smooth_scroll', array(
            'type' 		=> 'checkbox',
            'label' 	=> __( 'Disable smooth scroll?','zerif' ),
            'section' 	=> 'zerif_general_section',
            'priority'	=> 3,
        ) );

        $wp_customize->add_setting( 'zerif_accessibility', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_accessibility', array(
            'type' 		=> 'checkbox',
            'label' 	=> __( 'Enable accessibility?','zerif' ),
            'section' 	=> 'zerif_general_section',
            'priority'	=> 4,
        ) );

        /* zerif_logo */
        $wp_customize->add_setting( 'zerif_logo',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_logo', array(
            'label'    => __( 'Logo', 'zerif' ),
            'section'  => 'zerif_general_section',
            'settings' => 'zerif_logo',
            'priority'    => 5,
        ) ) );

        /* zerif_copyright */
        $wp_customize->add_setting( 'zerif_copyright', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_copyright', array(
            'label'    => __( 'Footer Copyright', 'zerif' ),
            'section'  => 'zerif_general_section',
            'priority'    => 6,
        ) );

        /* zerif_google_anaytics */
        $wp_customize->add_setting( 'zerif_google_anaytics', array(
            'sanitize_callback' => 'force_balance_tags'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_google_anaytics', array(
            'label'   => __( 'Google analytics code', 'zerif' ),
            'section' => 'zerif_general_section',
            'priority' => 7
        ) ) ) ;
		
		/* Change the template to full width for page.php */
        $wp_customize->add_setting( 'zerif_change_to_full_width', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_change_to_full_width', array(
            'type' 		=> 'checkbox',
            'label' 	=> __( 'Change the template to Full width for all the pages?','zerif' ),
            'section' 	=> 'zerif_general_section',
            'priority'	=> 8
        ) );

        $wp_customize->add_section( 'zerif_footer_section' , array(
            'title'       => __( 'Footer sections', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_2'
        ) );

        $wp_customize->add_setting( 'zerif_html_note' );

        $wp_customize->add_control( new Zerif_Html_Support( $wp_customize, 'zerif_html_note', array(
            'section' => 'zerif_footer_section',
            'priority' => '1'
        ) ) );

        /* email - ICON */
        $wp_customize->add_setting( 'zerif_email_icon', array(
            'default' => get_template_directory_uri().'/images/envelope4-green.png',
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_email_icon', array(
            'label'    => __( 'Email section - icon', 'zerif' ),
            'section'  => 'zerif_footer_section',
            'priority'    => 2,
        ) ) );

        /* email */
        $wp_customize->add_setting( 'zerif_email', array(
            'default'        => '<a href="mailto:contact@site.com">contact@site.com</a>',
            'sanitize_callback' => 'zerif_sanitize_input'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_email', array(
            'label'   => __( 'Email', 'zerif' ),
            'section' => 'zerif_footer_section',
            'priority' => 3
        ) ) );

        /* phone number - ICON */
        $wp_customize->add_setting( 'zerif_phone_icon', array(
            'default' => get_template_directory_uri().'/images/telephone65-blue.png',
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_phone_icon', array(
            'label'    => __( 'Phone number section - icon', 'zerif' ),
            'section'  => 'zerif_footer_section',
            'priority'    => 4,
        ) ) );

        /* phone number */
        $wp_customize->add_setting( 'zerif_phone', array(
            'default'        => '<a href="tel:0 332 548 954">0 332 548 954</a>',
            'sanitize_callback' => 'zerif_sanitize_input'
        ) );

        $wp_customize->add_control(new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_phone', array(
            'label'   => __( 'Phone number', 'zerif' ),
            'section' => 'zerif_footer_section',
            'priority' => 5
        ) ) );

        /* address - ICON */
        $wp_customize->add_setting( 'zerif_address_icon', array(
            'default' => get_template_directory_uri().'/images/map25-redish.png',
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_address_icon', array(
            'label'    => __( 'Address section - icon', 'zerif' ),
            'section'  => 'zerif_footer_section',
            'priority'    => 6,
        ) ) );

        /* address */
        $wp_customize->add_setting( 'zerif_address', array(
            'default'        => __('Company address','zerif'),
            'sanitize_callback' => 'zerif_sanitize_input'
        ) );
        $wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_address', array(
            'label'   => __( 'Address', 'zerif' ),
            'section' => 'zerif_footer_section',
            'priority' => 7
        )) ) ;

        $wp_customize->add_section( 'zerif_general_socials_section' , array(
            'title'       => __( 'Socials options', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_2'
        ));

        /* facebook */
        $wp_customize->add_setting( 'zerif_socials_facebook', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => '#'
        ) );

        $wp_customize->add_control( 'zerif_socials_facebook', array(
            'label'    => __( 'Facebook link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 1,
        ));

        /* twitter */
        $wp_customize->add_setting( 'zerif_socials_twitter', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => '#'
        ) );

        $wp_customize->add_control( 'zerif_socials_twitter', array(
            'label'    => __( 'Twitter link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 2,
        ));

        /* linkedin */
        $wp_customize->add_setting( 'zerif_socials_linkedin', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => '#'
        ) );

        $wp_customize->add_control( 'zerif_socials_linkedin', array(
            'label'    => __( 'Linkedin link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 3,
        ) );

        /* behance */
        $wp_customize->add_setting( 'zerif_socials_behance', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => '#'
        ) );

        $wp_customize->add_control( 'zerif_socials_behance', array(
            'label'    => __( 'Behance link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 4,
        ) );

        /* dribbble */
        $wp_customize->add_setting( 'zerif_socials_dribbble', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => '#'
        ) );

        $wp_customize->add_control( 'zerif_socials_dribbble', array(
            'label'    => __( 'Dribbble link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 5,
        ) );

        /* Google+ */
        $wp_customize->add_setting( 'zerif_socials_googleplus', array(
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( 'zerif_socials_googleplus', array(
            'label'    => __( 'Google+ link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 6,
        ) );

        /* Pinterest */
        $wp_customize->add_setting( 'zerif_socials_pinterest', array(
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( 'zerif_socials_pinterest', array(
            'label'    => __( 'Pinterest link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 7,
        ) );

        /* Tumblr */
        $wp_customize->add_setting( 'zerif_socials_tumblr', array(
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( 'zerif_socials_tumblr', array(
            'label'    => __( 'Tumblr link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 8,
        ) );

        /* Reddit */
        $wp_customize->add_setting( 'zerif_socials_reddit', array(
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( 'zerif_socials_reddit', array(
            'label'    => __( 'Reddit link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 9,
        ) );

        /* YouTube */
        $wp_customize->add_setting( 'zerif_socials_youtube', array(
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( 'zerif_socials_youtube', array(
            'label'    => __( 'YouTube link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 10,
        ) );

        /* Instagram */
        $wp_customize->add_setting( 'zerif_socials_instagram', array(
            'sanitize_callback' => 'esc_url_raw'
        ) );

        $wp_customize->add_control( 'zerif_socials_instagram', array(
            'label'    => __( 'Instagram link', 'zerif' ),
            'section'  => 'zerif_general_socials_section',
            'priority'    => 11,
        ) );

   
    endif;

    /*****************************************************/
    /**************	BIG TITLE SECTION *******************/
    /****************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_3', array(
            'priority' => 32,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Big title section', 'zerif' )
        ) );

        /* BIG TITLE SETTINGS */

        $wp_customize->add_section( 'zerif_bigtitle_settings_section' , array(
            'title' => __( 'Settings', 'zerif' ),
            'priority' => 1,
            'panel' => 'panel_3'
        ) );

        /* zerif_bigtitle_show */
        $wp_customize->add_setting( 'zerif_bigtitle_show', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide big title section?','zerif' ),
            'description' => __( 'If you check this box, the Big title section will disappear from homepage.','zerif' ),
            'section' => 'zerif_bigtitle_settings_section',
            'priority' => 1,
        ) );

        /* BIG TITLE CONTENT */

        $wp_customize->add_section( 'zerif_bigtitle_texts_section' , array(
            'title' => __( 'Content', 'zerif' ),
            'priority' => 2,
            'panel' => 'panel_3'
        ) );

        /* zerif_bigtitle_title */
        $wp_customize->add_setting( 'zerif_bigtitle_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'To add a title here please go to Customizer, "Big title section"','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_title', array(
            'label'    => __( 'Big title', 'zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 2
        ) );

	        /* zerif_bigtitle_text */
        $wp_customize->add_setting( 'zerif_bigtitle_text', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'We accomplish this by providing essential job skills training and supportive services','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_text', array(
            'label'    => __( 'Text', 'zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 4,
			'tytpe' => 'textarea'
        ) );
	
        /* zerif_bigtitle_redbutton_label */
        $wp_customize->add_setting( 'zerif_bigtitle_redbutton_label', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Button 1','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_redbutton_label', array(
            'label'    => __( 'Button 1 label', 'zerif' ),
            //'description' => __( 'This is the text that will appear on the button 1','zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 6,
        ) );

        /* zerif_bigtitle_redbutton_url */
        $wp_customize->add_setting( 'zerif_bigtitle_redbutton_url', array(
            'sanitize_callback' => 'esc_url',
            'default' => '#',
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_redbutton_url', array(
            'label'    => __( 'Button 1 link', 'zerif' ),
            //'description' => __( 'The button 1 is linked to this URL','zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 8,
        ));

        /* zerif_bigtitle_greenbutton_label */
        $wp_customize->add_setting( 'zerif_bigtitle_greenbutton_label', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Button 2','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_greenbutton_label', array(
            'label'    => __( 'Button 2 label', 'zerif' ),
            //'description' => __( 'This is the text that will appear on the button 2','zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 10,
        ));

        /* zerif_bigtitle_greenbutton_url */
        $wp_customize->add_setting( 'zerif_bigtitle_greenbutton_url', array(
            'sanitize_callback' => 'esc_url',
            'default' => '#',
            'transport' => 'postMessage'
        ));

        $wp_customize->add_control( 'zerif_bigtitle_greenbutton_url', array(
            'label'    => __( 'Button 2 link', 'zerif' ),
           // 'description' => __( 'The button 2 is linked to this URL','zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 12,
        ));
/* zerif_bigtitle_greenbutton_label */
        $wp_customize->add_setting( 'zerif_bigtitle_button3_label', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Button 3','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bigtitle_button3_label', array(
            'label'    => __( 'Button 3 label', 'zerif' ),
           // 'description' => __( 'This is the text that will appear on the second button 3','zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 14,
        ));

        /* zerif_bigtitle_greenbutton_url */
        $wp_customize->add_setting( 'zerif_bigtitle_button3_url', array(
            'sanitize_callback' => 'esc_url',
            'default' => '#',
            'transport' => 'postMessage'
        ));

        $wp_customize->add_control( 'zerif_bigtitle_button3_url', array(
            'label'    => __( 'Button 3 link', 'zerif' ),
            //'description' => __( 'The button 3 is linked to this URL','zerif' ),
            'section'  => 'zerif_bigtitle_texts_section',
            'priority'    => 16,
        ));

        /* BIG TITLE COLORS */

        $wp_customize->add_section( 'zerif_bigtitle_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_3'
        ));

        /* zerif_bigtitle_background */
        $wp_customize->add_setting( 'zerif_bigtitle_background', array(
            'default' => 'rgba(0, 0, 0, 0.5)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ));

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_bigtitle_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_bigtitle_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_bigtitle_header_color */
        $wp_customize->add_setting( 'zerif_bigtitle_header_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_header_color', array(
            'label'      => __( 'Big title color', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_bigtitle_1button_background_color */
        $wp_customize->add_setting( 'zerif_bigtitle_1button_background_color', array(
            'default' => '#e96656',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_1button_background_color', array(
            'label'      => __( 'First button background color', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_bigtitle_1button_background_color_hover */
        $wp_customize->add_setting( 'zerif_bigtitle_1button_background_color_hover', array(
            'default' => '#cb4332',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_1button_background_color_hover', array(
            'label'      => __( 'First button background color - hover', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_bigtitle_1button_color */
        $wp_customize->add_setting( 'zerif_bigtitle_1button_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_1button_color', array(
            'label'      => __( 'First button text color', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 5
        ) ) );

        /* zerif_bigtitle_1button_color_hover */
        $wp_customize->add_setting( 'zerif_bigtitle_1button_color_hover', array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_1button_color_hover', array(
            'label'      => __( 'First button text color - hover', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 6
        ) ) );

        /* zerif_bigtitle_2button_background_color */
        $wp_customize->add_setting( 'zerif_bigtitle_2button_background_color', array(
            'default' => '#20AA73',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_2button_background_color', array(
            'label'      => __( 'Second button background color', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 7
        ) ) );

        /* zerif_bigtitle_2button_background_color_hover */
        $wp_customize->add_setting( 'zerif_bigtitle_2button_background_color_hover', array(
            'default' => '#069059',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_2button_background_color_hover', array(
            'label'      => __( 'Second button background color - hover', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 8
        ) ) );

        /* zerif_bigtitle_2button_color */
        $wp_customize->add_setting( 'zerif_bigtitle_2button_color', array(
            'default' => '#fff',
            'transport' =>'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_2button_color', array(
            'label' => __( 'Second button text color', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 9
        ) ) );

        /* zerif_bigtitle_2button_color_hover */
        $wp_customize->add_setting( 'zerif_bigtitle_2button_color_hover', array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_bigtitle_2button_color_hover', array(
            'label'      => __( 'Second button text color - hover', 'zerif' ),
            'section'    => 'zerif_bigtitle_colors_section',
            'priority'   => 10
        ) ) );

        /* BIG TITLE PARALLAX */
        $wp_customize->add_section( 'zerif_bigtitle_parallax_section' , array(
            'title'		=> __( 'Parallax effect', 'zerif' ),
            'priority'	=> 4,
            'panel' 	=> 'panel_3'
        ) );

        /* show/hide  parallax */
        $wp_customize->add_setting( 'zerif_parallax_show', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_parallax_show', array(
            'type' 		=> 'checkbox',
            'label' 	=> __( 'Use parallax effect?','zerif' ),
            'section' 	=> 'zerif_bigtitle_parallax_section',
            'priority'	=> 1,
        ) );

        /* IMAGE 1*/
        $wp_customize->add_setting( 'zerif_parallax_img1', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => get_template_directory_uri() . '/images/background1.jpg'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_parallax_img1', array(
            'label'    	=> __( 'Image 1', 'zerif' ),
            'section'  	=> 'zerif_bigtitle_parallax_section',
            'settings'  => 'zerif_parallax_img1',
            'priority'	=> 1,
        ) ) );

        /* IMAGE 2 */
        $wp_customize->add_setting( 'zerif_parallax_img2', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => get_template_directory_uri() . '/images/background2.png'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_parallax_img2', array(
            'label'    	=> __( 'Image 2', 'zerif' ),
            'section'  	=> 'zerif_bigtitle_parallax_section',
            'settings'  => 'zerif_parallax_img2',
            'priority'	=> 2,
        ) ) );

   
    endif;

    /****************************************************/
    /*************  OUR FOCUS SECTION *******************/
    /****************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_4', array(
            'priority' => 33,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'What we do', 'zerif' )
        ) );

        /* OUR FOCUS SETTINGS */

        $wp_customize->add_section( 'zerif_ourfocus_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_4'
        ));

        /* zerif_ourfocus_show */
        $wp_customize->add_setting( 'zerif_ourfocus_show', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_ourfocus_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide section?','zerif' ),
            'description' => __( 'If you check this box, the section will disappear from homepage.','zerif' ),
            'section' => 'zerif_ourfocus_settings_section',
            'priority'    => 1,
        ) );

        /* OUR FOCUS CONTENT */

        $wp_customize->add_section( 'zerif_ourfocus_texts_section' , array(
            'title'       => __( 'Header', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_4'
        ) );

        /* zerif_ourfocus_title */
        $wp_customize->add_setting( 'zerif_ourfocus_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'WHAT WE DO','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ourfocus_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_ourfocus_texts_section',
            'priority'    => 2,
        ) );

        /* zerif_ourfocus_subtitle */
        $wp_customize->add_setting( 'zerif_ourfocus_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'VOCATIONAL TRAINING','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ourfocus_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_ourfocus_texts_section',
            'priority'    => 3,
        ) );

	        /* zerif_ourfocus_text */
        $wp_customize->add_setting( 'zerif_ourfocus_text', array(
            'sanitize_callback' => 'zerif_sanitize_input',
           // 'default' => __( 'VOCATIONAL TRAINING','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ourfocus_text', array(
            'label'    => __( 'Text', 'zerif' ),
            'section'  => 'zerif_ourfocus_texts_section',
            'priority'    => 4,
			'type' => 'textarea'
        ) );
	
	        /* zerif_ourfocus_text2 */
        $wp_customize->add_setting( 'zerif_ourfocus_text2', array(
            'sanitize_callback' => 'zerif_sanitize_input',
           // 'default' => __( 'VOCATIONAL TRAINING','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ourfocus_text2', array(
            'label'    => __( 'Text2', 'zerif' ),
            'section'  => 'zerif_ourfocus_texts_section',
            'priority'    => 5,
			'type' => 'textarea'
        ) );	
	
	
	 /* IMAGE 1*/
	        $wp_customize->add_section( 'zerif_ourfocus_image_section' , array(
            'title'       => __( 'Image', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_4'
        ) );

        $wp_customize->add_setting( 'zerif_ourfocus_img1', array(
            'sanitize_callback' => 'esc_url_raw',
            'default' => get_template_directory_uri() . '/images/background1.jpg'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'themeslug_ourfocus_img1', array(
            'label'    	=> __( 'Image 1', 'zerif' ),
            'section'  	=> 'zerif_ourfocus_image_section',
            'settings'  => 'zerif_ourfocus_img1',
            'priority'	=> 1,
        ) ) );

	
        /* OUR FOCUS COLORS */

        $wp_customize->add_section( 'zerif_ourfocus_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_4'
        ) );

        /* zerif_ourfocus_background */
        $wp_customize->add_setting( 'zerif_ourfocus_background', array(
            'default' => 'rgba(255, 255, 255, 1)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_ourfocus_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_ourfocus_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_ourfocus_header */
        $wp_customize->add_setting( 'zerif_ourfocus_header', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_header', array(
            'label'      => __( 'Main title and subtitle colors', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_ourfocus_box_title_color */
        $wp_customize->add_setting( 'zerif_ourfocus_box_title_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_box_title_color', array(
            'label'      => __( 'Box title color', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_ourfocus_box_text_color */
        $wp_customize->add_setting( 'zerif_ourfocus_box_text_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_box_text_color', array(
            'label'      => __( 'Box text color', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_ourfocus_1box */
        $wp_customize->add_setting( 'zerif_ourfocus_1box', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_1box', array(
            'label'      => __( 'First box border color hover', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 5
        ) ) );

        /* zerif_ourfocus_2box */
        $wp_customize->add_setting( 'zerif_ourfocus_2box', array(
            'default' => '#34d293',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_2box', array(
            'label'      => __( 'Second box border color hover', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 6
        ) ) );

        /* zerif_ourfocus_3box */
        $wp_customize->add_setting( 'zerif_ourfocus_3box', array(
            'default' => '#3ab0e2',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_3box',array(
            'label'      => __( 'Third box border color hover', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 7
        ) ) );

        /* zerif_ourfocus_4box */
        $wp_customize->add_setting( 'zerif_ourfocus_4box', array(
            'default' => '#f7d861',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourfocus_4box', array(
            'label'      => __( 'Fourth box border color hover', 'zerif' ),
            'section'    => 'zerif_ourfocus_colors_section',
            'priority'   => 8
        ) ) );

    
    endif;

    /************************************/

    /******** PORTFOLIO SECTION ********/

    /***********************************/


    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_5', array(
            'priority' => 34,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Portfolio section', 'zerif' )
        ) );

        /* PORTFOLIO SETTINGS */

        $wp_customize->add_section( 'zerif_portofolio_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_5'
        ));

        /* zerif_portofolio_show */
        $wp_customize->add_setting( 'zerif_portofolio_show', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_portofolio_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide portfolio section?','zerif' ),
            'description' => __( 'If you check this box, the Portfolio section will disappear from homepage.','zerif' ),
            'section' => 'zerif_portofolio_settings_section',
            'priority'    => 1,
        ) );

        /* zerif_portofolio_show_modal */
        $wp_customize->add_setting( 'zerif_portofolio_show_modal', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_portofolio_show_modal', array(
            'type' => 'checkbox',
            'label' => __( 'Open portfolio in a lightbox?','zerif' ),
            'section' => 'zerif_portofolio_settings_section',
            'priority'    => 2,
        ) );

        /* zerif_portofolio_number */
        $wp_customize->add_setting( 'zerif_portofolio_number', array(
            'sanitize_callback' => 'absint',
            'default' => '8'
        ) );

        $wp_customize->add_control( 'zerif_portofolio_number', array(
            'label'    => __( 'Maximum number of portfolios to display on homepage', 'zerif' ),
            'section'  => 'zerif_portofolio_settings_section',
            'priority'    => 3,
        ));

        /* PORTFOLIO CONTENT */

        $wp_customize->add_section( 'zerif_portofolio_texts_section' , array(
            'title'       => __( 'Content', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_5'
        ));

        /* zerif_portofolio_title */
        $wp_customize->add_setting( 'zerif_portofolio_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Portfolio','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_portofolio_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_portofolio_texts_section',
            'priority'    => 3,
        ));

        /* zerif_portofolio_subtitle */
        $wp_customize->add_setting( 'zerif_portofolio_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Portfolio subtitle','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_portofolio_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_portofolio_texts_section',
            'priority'    => 4,
        ));

        /* PORTFOLIO SINGLE PAGE */

        $wp_customize->add_section( 'zerif_portofolio_single_section' , array(
            'title'       => __( 'Single page', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_5'
        ));

        $wp_customize->add_setting( 'zerif_portofolio_single_full', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_portofolio_single_full', array(
            'type' => 'checkbox',
            'label' => __( 'Full width page?','zerif' ),
            'description' => __( 'If you check this box, the single portfolio page will be full width, with no sidebar.','zerif' ),
            'section' => 'zerif_portofolio_single_section',
            'priority'    => 1,
        ) );

        /* PORTFOLIO COLORS */

        $wp_customize->add_section( 'zerif_portofolio_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_5'
        ) );

        /* zerif_portofolio_background */
        $wp_customize->add_setting( 'zerif_portofolio_background', array(
            'default' => 'rgba(255, 255, 255, 1)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_portofolio_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_portofolio_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_portofolio_header */
        $wp_customize->add_setting( 'zerif_portofolio_header', array(
            'default' => '#404040',
            'transport' =>'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_portofolio_header', array(
            'label'      => __( 'Main title and subtitle colors', 'zerif' ),
            'section'    => 'zerif_portofolio_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_portofolio_text */
        $wp_customize->add_setting( 'zerif_portofolio_text', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_portofolio_text', array(
            'label'      => __( 'Portfolio box texts', 'zerif' ),
            'section'    => 'zerif_portofolio_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_portofolio_box_underline_color */
        $wp_customize->add_setting( 'zerif_portofolio_box_underline_color', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_portofolio_box_underline_color', array(
            'label'      => __( 'Portfolio box title undeline color', 'zerif' ),
            'section'    => 'zerif_portofolio_colors_section',
            'priority'   => 4
        ) ) );

    
    endif;


    /************************************/

    /******* ABOUT US SECTION ***********/

    /************************************/


    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_6', array(
            'priority' => 35,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'About us section', 'zerif' )
        ) );

        /* ABOUT US SETTINGS */
        $wp_customize->add_section( 'zerif_aboutus_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_6'
        ));

        /* zerif_aboutus_show */
        $wp_customize->add_setting( 'zerif_aboutus_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_aboutus_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide about us section?','zerif' ),
            'description' => __( 'If you check this box, the About us section will disappear from homepage.','zerif' ),
            'section' => 'zerif_aboutus_settings_section',
            'priority'    => 1,
        ) );

        /* ABOUT US CONTENT */

        $wp_customize->add_section( 'zerif_aboutus_texts_section' , array(
            'title'       => __( 'Main content', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_6'
        ));

        /* zerif_aboutus_title */
        $wp_customize->add_setting( 'zerif_aboutus_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'WHO WE ARE','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_aboutus_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_aboutus_texts_section',
            'priority'    => 1,
        ));

        /* zerif_aboutus_subtitle */
        $wp_customize->add_setting( 'zerif_aboutus_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'ABOUT' ),
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_aboutus_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_aboutus_texts_section',
            'priority'    => 2,
        ));

        /* zerif_aboutus_text */
        $wp_customize->add_setting( 'zerif_aboutus_text', array(
            'sanitize_callback' => 'zerif_sanitize_input',
           // 'default' => __( 'You can add here a large piece of text. For that, please go in the Admin Area, Customizer, "About us section"', 'zerif' )
        ) );

        $wp_customize->add_control( new Zerif_Customize_Textarea_Control( $wp_customize, 'zerif_aboutus_text', array(
            'label'   => __( 'Text', 'zerif' ),
            'section' => 'zerif_aboutus_texts_section',
            'priority' => 4
        ) ) ) ;


    endif;



    /******************************************/

    /**********	OUR TEAM SECTION **************/

    /******************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_7', array(
            'priority' => 36,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Our team section', 'zerif' )
        ) );

        /* OUR TEAM SETTINGS */

        $wp_customize->add_section( 'zerif_ourteam_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_7'
        ));

        /* zerif_ourteam_show */
        $wp_customize->add_setting( 'zerif_ourteam_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_ourteam_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide our team section?','zerif' ),
            'description' => __( 'If you check this box, the Our team section will disappear from homepage.','zerif' ),
            'section' => 'zerif_ourteam_settings_section',
            'priority'    => 1,
        ) );

        /* OUR TEAM HEADER */

        $wp_customize->add_section( 'zerif_ourteam_texts_section' , array(
            'title'       => __( 'Header', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_7'
        ) );

        /* zerif_ourteam_title */
        $wp_customize->add_setting( 'zerif_ourteam_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Our Team','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ourteam_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_ourteam_texts_section',
            'priority'    => 2,
        ) );

        /* zerif_ourteam_subtitle */
        $wp_customize->add_setting( 'zerif_ourteam_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Add a subtitle in Customizer, "Our team section"','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ourteam_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_ourteam_texts_section',
            'priority'    => 3,
        ));

        /* OUR TEAM COLORS */

        /* zerif_ourteam_colors_section */
        $wp_customize->add_section( 'zerif_ourteam_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_7'
        ));

        /* zerif_ourteam_background */
        $wp_customize->add_setting( 'zerif_ourteam_background', array(
            'default' => 'rgba(255, 255, 255, 1)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_ourteam_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_ourteam_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_ourteam_header */
        $wp_customize->add_setting( 'zerif_ourteam_header', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_header', array(
            'label'      => __( 'Titles color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 2,
        ) ) );

        /* zerif_ourteam_text */
        $wp_customize->add_setting( 'zerif_ourteam_text', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_text', array(
            'label'      => __( 'Team member hover description color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 3
        ) ) );
		
		/* zerif_ourteam_hover_background */
        $wp_customize->add_setting( 'zerif_ourteam_hover_background', array(
            'default' => '#333',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_hover_background', array(
            'label'      => __( 'Team member hover description background color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_ourteam_socials */
        $wp_customize->add_setting( 'zerif_ourteam_socials', array(
            'default' => '#808080',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_socials', array(
            'label'      => __( 'Social icons colors', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 5
        ) ) );

        /* zerif_ourteam_socials_hover */
        $wp_customize->add_setting( 'zerif_ourteam_socials_hover', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_socials_hover', array(
            'label'      => __( 'Social icons colors - hover', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 6
        ) ) );
		
		 /* zerif_ourteam_1box */
        $wp_customize->add_setting( 'zerif_ourteam_1box', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_1box', array(
            'label'      => __( 'First box title underline color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 7
        ) ) );

        /* zerif_ourteam_2box */
        $wp_customize->add_setting( 'zerif_ourteam_2box', array(
            'default' => '#34d293',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_2box', array(
            'label'      => __( 'Second box title underline color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 8
        ) ) );

        /* zerif_ourteam_3box */
        $wp_customize->add_setting( 'zerif_ourteam_3box', array(
            'default' => '#3ab0e2',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_3box',array(
            'label'      => __( 'Third box title underline color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 9
        ) ) );

        /* zerif_ourteam_4box */
        $wp_customize->add_setting( 'zerif_ourteam_4box', array(
            'default' => '#f7d861',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ourteam_4box', array(
            'label'      => __( 'Fourth box title underline color', 'zerif' ),
            'section'    => 'zerif_ourteam_colors_section',
            'priority'   => 10
        ) ) );

   
    endif;

    /**********************************************/
    /**********	TESTIMONIALS SECTION **************/
    /**********************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_8', array(
            'priority' => 37,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Testimonials section', 'zerif' )
        ) );

        /* TESTIMONIALS SETTINGS */

        $wp_customize->add_section( 'zerif_testimonials_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_8'
        ));

        /* zerif_testimonials_show */
        $wp_customize->add_setting( 'zerif_testimonials_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_testimonials_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide testimonials section?','zerif' ),
            'description' => __( 'If you check this box, the Testimonials section will disappear from homepage.','zerif' ),
            'section' => 'zerif_testimonials_settings_section',
            'priority'    => 1,
        ) );

        $wp_customize->add_setting( 'zerif_testimonials_pinterest_style', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_testimonials_pinterest_style', array(
            'type' 			=> 'checkbox',
            'label' 		=> __( 'Use pinterest layout?','zerif' ),
            'description' 	=> __( 'If you check this box, the Testimonials section will use pinterest-style layout.','zerif' ),
            'section' 		=> 'zerif_testimonials_settings_section',
            'priority'    	=> 2,
        ) );


        /* TESTIMONIALS HEADER */

        $wp_customize->add_section( 'zerif_testimonials_texts_section' , array(
            'title'       => __( 'Header', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_8'
        ));

        /* zerif_testimonials_title */
        $wp_customize->add_setting( 'zerif_testimonials_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Testimonials','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_testimonials_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_testimonials_texts_section',
            'priority'    => 2,
        ));

        /* zerif_testimonials_subtitle */
        $wp_customize->add_setting( 'zerif_testimonials_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_testimonials_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_testimonials_texts_section',
            'priority'    => 3,
        ));

        /* TESTIMONIALS COLORS */

        $wp_customize->add_section( 'zerif_testimonials_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_8'
        ));

        /* zerif_testimonials_background */
        $wp_customize->add_setting( 'zerif_testimonials_background', array(
            'default' => 'rgba(219, 191, 86, 1)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_testimonials_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_testimonials_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_testimonials_header */
        $wp_customize->add_setting( 'zerif_testimonials_header', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_testimonials_header', array(
            'label'      => __( 'Title and subtitle colors', 'zerif' ),
            'section'    => 'zerif_testimonials_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_testimonials_text */
        $wp_customize->add_setting( 'zerif_testimonials_text', array(
            'default' => '#909090',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_testimonials_text', array(
            'label'      => __( 'Testimonial text color', 'zerif' ),
            'section'    => 'zerif_testimonials_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_testimonials_author */
        $wp_customize->add_setting( 'zerif_testimonials_author', array(
            'default' => '#909090',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_testimonials_author', array(
            'label'      => __( 'Testimonial author name color', 'zerif' ),
            'section'    => 'zerif_testimonials_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_testimonials_quote */
        $wp_customize->add_setting( 'zerif_testimonials_quote', array(
            'default' => '#e96656',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_testimonials_quote', array(
            'label'      => __( 'Testimonial quote color', 'zerif' ),
            'section'    => 'zerif_testimonials_colors_section',
            'priority'   => 5
        ) ) );
		
		/* zerif_testimonials_box_color */
        $wp_customize->add_setting( 'zerif_testimonials_box_color', array(
            'default' => '#FFFFFF',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_testimonials_box_color', array(
            'label'      => __( 'Testimonial box background color', 'zerif' ),
            'section'    => 'zerif_testimonials_colors_section',
            'priority'   => 6
        ) ) );

   

    endif;

    /***********************************************************/

    /********* RIBBONS ****************************************/

    /**********************************************************/


    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_9', array(
            'priority' => 38,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Ribbon sections', 'zerif' )
        ) );

        $wp_customize->add_section( 'zerif_bottombribbon_section' , array(
            'title'       => __( 'BottomButton Ribbon', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_9'
        ) );

        /* RIBBON SECTION WITH BOTTOM BUTTON */

        /* zerif_bottomribbon_text */
        $wp_customize->add_setting( 'zerif_bottomribbon_text', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bottomribbon_text', array(
            'label'    => __( 'Main text', 'zerif' ),
            'section'  => 'zerif_bottombribbon_section',
            'priority'    => 1,
        ) );

        /* zerif_bottomribbon_buttonlabel */
        $wp_customize->add_setting( 'zerif_bottomribbon_buttonlabel', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bottomribbon_buttonlabel', array(
            'label'    => __( 'Button label', 'zerif' ),
            'description' => __( 'The button link must be filled too, for the button to show up.', 'zerif' ),
            'section'  => 'zerif_bottombribbon_section',
            'priority'    => 2,
        ) );

        /* zerif_bottomribbon_buttonlink */
        $wp_customize->add_setting( 'zerif_bottomribbon_buttonlink', array(
            'sanitize_callback' => 'esc_url',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_bottomribbon_buttonlink', array(
            'label'    => __( 'Button link', 'zerif' ),
            'description' => __( 'The button label must be filled too, for the button to show up.', 'zerif' ),
            'section'  => 'zerif_bottombribbon_section',
            'priority'    => 3,
        ));

        /* zerif_ribbon_background */
        $wp_customize->add_setting( 'zerif_ribbon_background', array(
            'default' => 'rgba(52, 210, 147, 0.8)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_ribbon_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_bottombribbon_section',
            'priority'   => 4
        ) ) );

        /* zerif_ribbon_text_color */
        $wp_customize->add_setting( 'zerif_ribbon_text_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbon_text_color', array(
            'label'      => __( 'Text color', 'zerif' ),
            'section'    => 'zerif_bottombribbon_section',
            'priority'   => 5
        ) ) );

        /* zerif_ribbon_button_background */
        $wp_customize->add_setting( 'zerif_ribbon_button_background', array(
            'default' => '#20AA73',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbon_button_background', array(
            'label'      => __( 'Button background color', 'zerif' ),
            'section'    => 'zerif_bottombribbon_section',
            'priority'   => 6
        ) ) );

        /* zerif_ribbon_button_background_hover */
        $wp_customize->add_setting( 'zerif_ribbon_button_background_hover', array(
            'default' => '#14a168',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbon_button_background_hover', array(
            'label'      => __( 'Button background color hover', 'zerif' ),
            'section'    => 'zerif_bottombribbon_section',
            'priority'   => 7
        ) ) );

        /* zerif_ribbon_button_button_color */
        $wp_customize->add_setting( 'zerif_ribbon_button_button_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbon_button_button_color', array(
            'label'      => __( 'Button text color', 'zerif' ),
            'section'    => 'zerif_bottombribbon_section',
            'priority'   => 8
        ) ) );
		
		/* zerif_ribbon_button_button_color_hover */
        $wp_customize->add_setting( 'zerif_ribbon_button_button_color_hover', array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbon_button_button_color_hover', array(
            'label'      => __( 'Button text color hover', 'zerif' ),
            'section'    => 'zerif_bottombribbon_section',
            'priority'   => 9
        ) ) );

        /* RIBBON SECTION WITH BUTTON IN THE RIGHT SIDE */

        $wp_customize->add_section( 'zerif_rightbribbon_section' , array(
            'title'       => __( 'RightButton Ribbon', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_9'
        ));

        /* zerif_ribbonright_text */
        $wp_customize->add_setting( 'zerif_ribbonright_text', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ribbonright_text', array(
            'label'    => __( 'Main text', 'zerif' ),
            'section'  => 'zerif_rightbribbon_section',
            'priority'    => 1,
        ) );

        /* zerif_ribbonright_buttonlabel */
        $wp_customize->add_setting( 'zerif_ribbonright_buttonlabel', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ribbonright_buttonlabel', array(
            'label'    => __( 'Button label', 'zerif' ),
            'description' => __( 'The button link must be filled too, for the button to show up.', 'zerif' ),
            'section'  => 'zerif_rightbribbon_section',
            'priority'    => 2,
        ) );

        /* zerif_ribbonright_buttonlink */
        $wp_customize->add_setting( 'zerif_ribbonright_buttonlink', array(
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_ribbonright_buttonlink', array(
            'label'    => __( 'Button link', 'zerif' ),
            'description' => __( 'The button label must be filled too, for the button to show up.', 'zerif' ),
            'section'  => 'zerif_rightbribbon_section',
            'priority'    => 3,
        ) );

        /* zerif_ribbonright_background */
        $wp_customize->add_setting( 'zerif_ribbonright_background', array(
            'default' => 'rgba(233, 102, 86, 1)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_ribbonright_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_rightbribbon_section',
            'priority'   => 4
        ) ) );

        /* zerif_ribbonright_text_color */
        $wp_customize->add_setting( 'zerif_ribbonright_text_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbonright_text_color', array(
            'label'      => __( 'Text color', 'zerif' ),
            'section'    => 'zerif_rightbribbon_section',
            'priority'   => 5
        ) ) );

        /* zerif_ribbonright_button_background */
        $wp_customize->add_setting( 'zerif_ribbonright_button_background', array(
            'default' => '#db5a4a',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbonright_button_background', array(
            'label'      => __( 'Button background color', 'zerif' ),
            'section'    => 'zerif_rightbribbon_section',
            'priority'   => 6
        ) ) );

        /* zerif_ribbonright_button_background_hover */
        $wp_customize->add_setting( 'zerif_ribbonright_button_background_hover', array(
            'default' => '#bf3928',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbonright_button_background_hover', array(
            'label'      => __( 'Button background color hover', 'zerif' ),
            'section'    => 'zerif_rightbribbon_section',
            'priority'   => 7
        ) ) );
		
		/* zerif_ribbonright_button_button_color */
        $wp_customize->add_setting( 'zerif_ribbonright_button_button_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbonright_button_button_color', array(
            'label'      => __( 'Button text color', 'zerif' ),
            'section'    => 'zerif_rightbribbon_section',
            'priority'   => 8
        ) ) );

        /* zerif_ribbonright_button_button_color_hover */
        $wp_customize->add_setting( 'zerif_ribbonright_button_button_color_hover', array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_ribbonright_button_button_color_hover', array(
            'label'      => __( 'Button text color hover', 'zerif' ),
            'section'    => 'zerif_rightbribbon_section',
            'priority'   => 9
        ) ) );



        require_once ( 'class/zerif-general-control.php');


        $wp_customize->add_section( 'zerif_shortcodes_section' , array(
            'title'       => esc_html__( 'Shortcodes section', 'zerif' ),
            'priority'    => 38,
        ));

        $wp_customize->add_setting( 'zerif_shortcodes_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox',
        ) );

        $wp_customize->add_control( 'zerif_shortcodes_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide shortcodes section?','zerif' ),
            'description' => __( 'If you check this box, the Shortcodes section will disappear from homepage.','zerif' ),
            'section' => 'zerif_shortcodes_section',
            'priority'    => 1,
        ) );

        $wp_customize -> add_setting('zerif_shortcodes_settings', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_repeater'
        ));
        $wp_customize -> add_control (new Zerif_General_Repeater ( $wp_customize , 'zerif_shortcodes_settings' , array(
            'label' => esc_html__('Edit the shortcode options','zerif'),
            'section' => 'zerif_shortcodes_section',
            'priority' => 2,
            'zerif_title_control'    => true,
            'zerif_subtitle_control'    => true,
            'zerif_shortcode_control' => true,
            'zerif_color_control'   =>  true,
            'zerif_opacity_control' =>  true,
            'zerif_text_color_control'  =>  true
        ) ) );

    

    endif;

    /*******************************************************/

    /************	CONTACT US SECTION *********************/

    /*******************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_10', array(
            'priority' => 39,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Contact us section', 'zerif' )
        ) );

        /* CONTACT US SETTINGS */

        $wp_customize->add_section( 'zerif_contactus_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_10'
        ));

        /* zerif_contactus_show */
        $wp_customize->add_setting( 'zerif_contactus_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_contactus_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide contact us section?','zerif' ),
            'description' => __( 'If you check this box, the Contact us section will disappear from homepage.','zerif' ),
            'section' => 'zerif_contactus_settings_section',
            'priority'    => 1,
        ) );

        /* zerif_contactus_email */
        $wp_customize->add_setting( 'zerif_contactus_email', array(
            'sanitize_callback' => 'zerif_sanitize_input'
        ) );

        $wp_customize->add_control( 'zerif_contactus_email', array(
            'label'    => __( 'Email address', 'zerif' ),
            'description' => __( 'The contact us form is submitted to this email address.','zerif' ),
            'section'  => 'zerif_contactus_settings_section',
            'priority'    => 4,
        ));

        /* zerif_contactus_recaptcha_show */
        $wp_customize->add_setting( 'zerif_contactus_recaptcha_show', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_contactus_recaptcha_show', array(
            'type' => 'checkbox',
            'label' => __( 'Hide reCaptcha?','zerif' ),
            'description' => __( 'If you check this box, the reCaptcha will not be enabled on the Contact us form.','zerif' ),
            'section' => 'zerif_contactus_settings_section',
            'priority'    => 10,
        ) );

        /* zerif_contactus_sitekey */
        $wp_customize->add_setting( 'zerif_contactus_sitekey', array(
            'sanitize_callback' => 'zerif_sanitize_input'
        ) );

        $wp_customize->add_control( 'zerif_contactus_sitekey', array(
            'label'    => __( 'Site key', 'zerif' ),
            'description' => '<a href="https://www.google.com/recaptcha/admin#list" target="_blank">'.__( 'Create an account here','zerif' ).'</a>'.__( ' to get the Site key and the Secret key for the reCaptcha.','zerif' ),
            'section'  => 'zerif_contactus_settings_section',
            'priority'    => 11,
        ) );

        /* zerif_contactus_secretkey */
        $wp_customize->add_setting( 'zerif_contactus_secretkey', array(
            'sanitize_callback' => 'zerif_sanitize_input'
        ) );

        $wp_customize->add_control( 'zerif_contactus_secretkey', array(
            'label'    => __( 'Secret key', 'zerif' ),
            'section'  => 'zerif_contactus_settings_section',
            'priority'    => 12,
        ) );

        /* CONTACT US MAIN CONTENT */

        $wp_customize->add_section( 'zerif_contactus_texts_section' , array(
            'title'       => __( 'Main content', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_10'
        ) );

        /* zerif_contactus_title */
        $wp_customize->add_setting( 'zerif_contactus_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Get in touch','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_contactus_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 2,
        ) );

        /* zerif_contactus_subtitle */
        $wp_customize->add_setting( 'zerif_contactus_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_contactus_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 3,
        ) );

        /* zerif_contactus_name_placeholder */
        $wp_customize->add_setting( 'zerif_contactus_name_placeholder', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Your Name','zerif' ),
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_contactus_name_placeholder', array(
            'label'    => __( 'Placeholder for "Your Name" input ', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 4,
        ));

        /* zerif_contactus_email_placeholder */
        $wp_customize->add_setting( 'zerif_contactus_email_placeholder', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Your Email','zerif' ),
            'transport' =>'postMessage'));

        $wp_customize->add_control( 'zerif_contactus_email_placeholder', array(
            'label'    => __( 'Placeholder for "Your Email" input', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 5,
        ));

        /* zerif_contactus_subject_placeholder */
        $wp_customize->add_setting( 'zerif_contactus_subject_placeholder', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Subject','zerif' ),
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_contactus_subject_placeholder', array(
            'label'    => __( 'Placeholder for "Subject" input', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 6,
        ));

        /* zerif_contactus_message_placeholder */
        $wp_customize->add_setting( 'zerif_contactus_message_placeholder', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Your Message','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_contactus_message_placeholder', array(
            'label'    => __( 'Placeholder for "Message" input', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 7,
        ));

        /* zerif_contactus_button_label */
        $wp_customize->add_setting( 'zerif_contactus_button_label', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Send Message','zerif' ),
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_contactus_button_label', array(
            'label'    => __( 'Send message button label', 'zerif' ),
            'section'  => 'zerif_contactus_texts_section',
            'priority'    => 8,
        ));

        /* CONTACT US MAIN COLORS */

        $wp_customize->add_section( 'zerif_contactus_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_10'
        ));

        /* zerif_contacus_background */
        $wp_customize->add_setting( 'zerif_contacus_background', array(
            'default' => 'rgba(0, 0, 0, 0.5)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_contacus_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_contactus_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_contacus_header */
        $wp_customize->add_setting( 'zerif_contacus_header', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_contacus_header', array(
            'label'      => __( 'Title and subtitle color', 'zerif' ),
            'section'    => 'zerif_contactus_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_contacus_button_background */
        $wp_customize->add_setting( 'zerif_contacus_button_background', array(
            'default' => '#e96656',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_contacus_button_background', array(
            'label'      => __( 'Submit button background color', 'zerif' ),
            'section'    => 'zerif_contactus_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_contacus_button_background_hover */
        $wp_customize->add_setting( 'zerif_contacus_button_background_hover', array(
            'default' => '#cb4332',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_contacus_button_background_hover', array(
            'label'      => __( 'Submit button background color - hover', 'zerif' ),
            'section'    => 'zerif_contactus_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_contacus_button_color */
        $wp_customize->add_setting( 'zerif_contacus_button_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_contacus_button_color', array(
            'label'      => __( 'Submit button color', 'zerif' ),
            'section'    => 'zerif_contactus_colors_section',
            'priority'   => 5
        ) ) );
		
		/* zerif_contacus_button_color_hover */
        $wp_customize->add_setting( 'zerif_contacus_button_color_hover', array(
            'default' => '#fff',
            'sanitize_callback' => 'sanitize_hex_color'
        ) ); 

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_contacus_button_color_hover', array(
            'label'      => __( 'Submit button color - hover', 'zerif' ),
            'section'    => 'zerif_contactus_colors_section',
            'priority'   => 6
        ) ) );

    

    endif;

    /*******************************************************/
    /************	PACKAGES SECTION ***********************/
    /*******************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_11', array(
            'priority' => 40,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Packages section', 'zerif' )
        ) );

        /* PACKAGES SETTINGS */

        $wp_customize->add_section( 'zerif_packages_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_11'
        ));

        /* zerif_packages_show */
        $wp_customize->add_setting( 'zerif_packages_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_packages_show', array(
            'type' => 'checkbox',
            'label' => __( 'Show packages section?','zerif' ),
            'description' => __( 'If you check this box, the Packages section will appear on homepage.','zerif' ),
            'section' => 'zerif_packages_settings_section',
            'priority'    => 1,
        ) );

        /* PACKAGES HEADER */

        $wp_customize->add_section( 'zerif_packages_texts_section' , array(
            'title'       => __( 'Header', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_11'
        ));

        /* zerif_packages_title */
        $wp_customize->add_setting( 'zerif_packages_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'PACKAGES','zerif' ),
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_packages_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_packages_texts_section',
            'priority'    => 2,
        ));

        /* zerif_packages_subtitle */
        $wp_customize->add_setting( 'zerif_packages_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'We have 4 friendly packages for you. Check all the packages and choose the right one for you.','zerif' ),
            'transport' =>'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_packages_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_packages_texts_section',
            'priority'    => 3,
        ));

        /* PACKAGES COLORS */

        $wp_customize->add_section( 'zerif_packages_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_11'
        ));

        /* zerif_packages_background */
        $wp_customize->add_setting( 'zerif_packages_background', array(
            'default' => 'rgba(0, 0, 0, 0.5)',
            'transport' =>'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba' ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_packages_background', array(
            'label'      => __( 'Background color', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_packages_header */
        $wp_customize->add_setting( 'zerif_packages_header', array(
            'default' => '#fff',
            'transport' =>'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_packages_header', array(
            'label'      => __( 'Title and subtitle colors', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_package_title_color */
        $wp_customize->add_setting( 'zerif_package_title_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_package_title_color', array(
            'label'      => __( 'Package title color', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_package_text_color */
        $wp_customize->add_setting( 'zerif_package_text_color', array(
            'default' => '#808080',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_package_text_color', array(
            'label'      => __( 'Package text color', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_package_button_text_color */
        $wp_customize->add_setting( 'zerif_package_button_text_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_package_button_text_color', array(
            'label'      => __( 'Package button text color', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 5
        ) ) );

        /* zerif_package_price_background_color */
        $wp_customize->add_setting( 'zerif_package_price_background_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_package_price_background_color', array(
            'label'      => __( 'Package price background color', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 6
        ) ) );

        /* zerif_package_price_color */
        $wp_customize->add_setting( 'zerif_package_price_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_package_price_color', array(
            'label'      => __( 'Package price color', 'zerif' ),
            'section'    => 'zerif_packages_colors_section',
            'priority'   => 7
        ) ) );

    

    endif;

    /*******************************************************/

    /************	GOOGLE MAP SECTION *********************/

    /*******************************************************/

    $wp_customize->add_section( 'zerif_googlemap_section' , array(
        'title'       => __( 'Google map section', 'zerif' ),
        'priority'    => 41
    ));

    /* zerif_googlemap_show */
    $wp_customize->add_setting( 'zerif_googlemap_show', array(
        'sanitize_callback' => 'zerif_sanitize_checkbox'
    ) );

    $wp_customize->add_control( 'zerif_googlemap_show', array(
        'type' => 'checkbox',
        'label' => __('Show google map section?','zerif'),
        'description' => __('If you check this box, the Google map section will appear on homepage.','zerif'),
        'section' => 'zerif_googlemap_section',
        'priority'    => 1,
    ) );

    /* zerif_googlemap_address */
    $wp_customize->add_setting( 'zerif_googlemap_address', array(
        'sanitize_callback' => 'zerif_sanitize_input',
        'default' => __( 'New York, Leroy Street','zerif' )
    ) );

    $wp_customize->add_control( 'zerif_googlemap_address', array(
        'label'    => __( 'Google map address', 'zerif' ),
        'section'  => 'zerif_googlemap_section',
        'priority'    => 2,
    ));

    /* zerif_googlemap_static */
    $wp_customize->add_setting( 'zerif_googlemap_static', array(
        'sanitize_callback' => 'zerif_sanitize_checkbox'
    ) );

    $wp_customize->add_control( 'zerif_googlemap_static', array(
        'type' => 'checkbox',
        'label' => __('Show STATIC google map ?','zerif'),
        'description' => __('If you check this box, the Google map section will display as a static google map.','zerif'),
        'section' => 'zerif_googlemap_section',
        'priority'    => 3,
    ) );
    
    if(defined('INTERGEO_PLUGIN_NAME')) :

		/* zerif_googlemap_shortcode */
		$wp_customize->add_setting( 'zerif_googlemap_shortcode', array(
			'sanitize_callback' => 'zerif_sanitize_input'
		) );

		$wp_customize->add_control( 'zerif_googlemap_shortcode', array(
			'label'    => __( 'Intergeo Shortcode', 'zerif' ),
			'section'  => 'zerif_googlemap_section',
			'priority'    => 4,
		));

    else:

		$wp_customize->add_setting( 'zerif_googlemap_shortcode' );

        $wp_customize->add_control( new Zerif_Intergeo_Panel( $wp_customize, 'zerif_googlemap_shortcode', array(
			'section'  => 'zerif_googlemap_section',
			'priority'    => 4,
        ) ) );

    endif;

/*******************************************************/

    /************	GOOGLE CALENDAR SECTION *********************/

    /*******************************************************/

    $wp_customize->add_section( 'zerif_googlecalendar_section' , array(
        'title'       => __( 'Calendar section', 'zerif' ),
        'priority'    => 130
    ));

    /* zerif_googlecalendar_show */
    $wp_customize->add_setting( 'zerif_googlecalendar_show', array(
        'sanitize_callback' => 'zerif_sanitize_checkbox'
    ) );

    $wp_customize->add_control( 'zerif_googlecalendar_show', array(
        'type' => 'checkbox',
        'label' => __('Show google calendar section?','zerif'),
        'description' => __('If you check this box, the section will appear on homepage.','zerif'),
        'section' => 'zerif_googlecalendar_section',
        'priority'    => 1,
    ) );

	
    /* zerif_googlemap_address */
    $wp_customize->add_setting( 'zerif_googlecalendar_address', array(
        'sanitize_callback' => 'zerif_sanitize_input',
        'default' => 'ojm2eqb87feaainqc5v5nhqr3s@group.calendar.google.com'
    ) );

    $wp_customize->add_control( 'zerif_googlecalendar_address', array(
        'label'    => __( 'Google calendar address', 'zerif' ),
        'section'  => 'zerif_googlecalendar_section',
        'priority'    => 2,
		'type' => 'textarea'
    ));
    /* zerif_googlemap_id */
    $wp_customize->add_setting( 'zerif_googlecalendar_id', array(
        'sanitize_callback' => 'zerif_sanitize_input',
        'default' => '98'
    ) );

    $wp_customize->add_control( 'zerif_googlecalendar_id', array(
        'label'    => __( 'ID Calendar of plagin ', 'zerif' ),
        'section'  => 'zerif_googlecalendar_section',
        'priority'    => 3,
		//'type' => 'textarea'
    ));
   
    
    if(defined('INTERGEO_PLUGIN_NAME')) :

		/* zerif_googlemap_shortcode */
		$wp_customize->add_setting( 'zerif_googlemap_shortcode', array(
			'sanitize_callback' => 'zerif_sanitize_input'
		) );

		$wp_customize->add_control( 'zerif_googlemap_shortcode', array(
			'label'    => __( 'Intergeo Shortcode', 'zerif' ),
			'section'  => 'zerif_googlemap_section',
			'priority'    => 4,
		));

    else:

		$wp_customize->add_setting( 'zerif_googlemap_shortcode' );

        $wp_customize->add_control( new Zerif_Intergeo_Panel( $wp_customize, 'zerif_googlemap_shortcode', array(
			'section'  => 'zerif_googlemap_section',
			'priority'    => 4,
        ) ) );

    endif;
	
    /********************************************************/

    /************	LATEST NEWS SECTION *********************/

    /********************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_14', array(
            'priority' => 135,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Latest news section', 'zerif' )
        ) );

        /* LATEST NEWS SETTINGS */

        $wp_customize->add_section( 'zerif_latest_news_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_14'
        ));

        /* zerif_latest_news_show */
        $wp_customize->add_setting( 'zerif_latest_news_show', array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_latest_news_show', array(
            'type' => 'checkbox',
            'label' => __( 'Show latest news section?','zerif' ),
            'description' => __( 'If you check this box, the Latest news section will appear on homepage.','zerif' ),
            'section' => 'zerif_latest_news_settings_section',
            'priority'    => 1,
        ) );

        /* LATEST NEWS HEADER */

        $wp_customize->add_section( 'zerif_latest_news_section' , array(
            'title'       => __( 'Header', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_14'
        ));
/* zerif_latest_news_category */
        $wp_customize->add_setting( 'zerif_latestnews_category', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'CATEGORY','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_latestnews_category', array(
           
            'label' => __( 'Category','zerif' ),
            'description' => __( 'Category of the posts','zerif' ),
            'section' => 'zerif_latest_news_settings_section',
            'priority'    => 2,
        ) );

		/* zerif_latest_news_count_posts */
        $wp_customize->add_setting( 'zerif_latestnews_count_posts', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( '4','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_latestnews_count_posts', array(
            'label' => __( 'Count post','zerif' ),
            'description' => __( 'Count of the posts','zerif' ),
            'section' => 'zerif_latest_news_settings_section',
            'priority'    => 3,
        ) );
	
		/* zerif_latest_news_count_posts */
        $wp_customize->add_setting( 'zerif_latestnews_count_open_posts', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => 3,
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_latestnews_count_open_posts', array(
            'label' => __( 'Count open post','zerif' ),
            'description' => __( 'Count of the open posts','zerif' ),
            'section' => 'zerif_latest_news_settings_section',
            'priority'    => 4,
        ) );	
        /* zerif_latestnews_title */
        $wp_customize->add_setting( 'zerif_latestnews_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'LATEST NEWS','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_latestnews_title', array(
            'label'    		=> __( 'Main title', 'zerif' ),
            'section'  		=> 'zerif_latest_news_section',
            'priority'    	=> 5,
        ));

        /* zerif_latestnews_subtitle */
        $wp_customize->add_setting( 'zerif_latestnews_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Add a subtitle in Customizer, "Latest news section"','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_latestnews_subtitle', array(
            'label'    		=> __( 'Subtitle', 'zerif' ),
            'section'  		=> 'zerif_latest_news_section',
            'priority'   	=> 6,
        ));

        /* LATEST NEWS CONTENT */

        $wp_customize->add_section( 'zerif_latest_news_content_section' , array(
            'title'       => __( 'Main content', 'zerif' ),
            'priority'    => 3,
            'panel' => 'panel_14'
        ));

        $wp_customize->add_setting( 'zerif_latest_news_content_section' );

        $wp_customize->add_control( new Zerif_LatestNews( $wp_customize, 'zerif_latest_news_content_section', array(
            'section' => 'zerif_latest_news_content_section'
        )));

        /* LATEST NEWS COLORS */

        $wp_customize->add_section( 'zerif_latest_news_colors_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_14'
        ));

        /* zerif_latestnews_background */
        $wp_customize->add_setting( 'zerif_latestnews_background', array(
            'default' => 'rgba(255, 255, 255, 1)',
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_rgba'
        ) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_latestnews_background', array(
            'label'    => __( 'Background color', 'zerif' ),
            'palette' => true,
            'section'  => 'zerif_latest_news_colors_section',
            'priority'   => 1
        ) ) );

        /* zerif_latestnews_header_title_color */
        $wp_customize->add_setting( 'zerif_latestnews_header_title_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_header_title_color', array(
            'label'      => __( 'Title color', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 2
        ) ) );

        /* zerif_latestnews_header_subtitle_color */
        $wp_customize->add_setting( 'zerif_latestnews_header_subtitle_color', array(
            'default' => '#808080',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_header_subtitle_color', array(
            'label'      => __( 'Subtitle color', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 3
        ) ) );

        /* zerif_latestnews_post_title_color */
        $wp_customize->add_setting( 'zerif_latestnews_post_title_color', array(
            'default' => '#404040',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_post_title_color', array(
            'label'      => __( 'Post title color', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 4
        ) ) );

        /* zerif_latestnews_post_underline_color1 */
        $wp_customize->add_setting( 'zerif_latestnews_post_underline_color1', array(
            'default' => '#e96656',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_post_underline_color1', array(
            'label'      => __( 'Post title underline color - first box', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 5
        ) ) );

        /* zerif_latestnews_post_underline_color2 */
        $wp_customize->add_setting( 'zerif_latestnews_post_underline_color2', array(
            'default' => '#34d293',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_post_underline_color2', array(
            'label'      => __( 'Post title underline color - second box', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 6
        ) ) );

        /* zerif_latestnews_post_underline_color3 */
        $wp_customize->add_setting( 'zerif_latestnews_post_underline_color3', array(
            'default' => '#3ab0e2',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_post_underline_color3', array(
            'label'      => __( 'Post title underline color - third box', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 7
        ) ) );

        /* zerif_latestnews_post_underline_color4 */
        $wp_customize->add_setting( 'zerif_latestnews_post_underline_color4', array(
            'default' => '#f7d861',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_post_underline_color4', array(
            'label'      => __( 'Post title underline color - fourth box', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 8
        ) ) );

        /* zerif_latestnews_post_text_color */
        $wp_customize->add_setting( 'zerif_latestnews_post_text_color', array(
            'default' => '#909090',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_latestnews_post_text_color', array(
            'label'      => __( 'Post content color', 'zerif' ),
            'section'    => 'zerif_latest_news_colors_section',
            'priority'   => 9
        ) ) );

    
    endif;

    /*******************************************************/
    /************	SUBSCRIBE SECTION **********************/
    /*******************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel( 'panel_13', array(
            'priority' => 140,
            'capability' => 'edit_theme_options',
            'theme_supports' => '',
            'title' => __( 'Subscribe section', 'zerif' )
        ) );

        /* SUBSCRIBE SETTINGS */

        $wp_customize->add_section( 'zerif_subscribe_settings_section' , array(
            'title'       => __( 'Settings', 'zerif' ),
            'priority'    => 1,
            'panel' => 'panel_13'
        ));

        /* zerif_subscribe_show */
        $wp_customize->add_setting( 'zerif_subscribe_show',array(
            'transport' => 'postMessage',
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_subscribe_show', array(
            'type' => 'checkbox',
            'label' => __('Show subscribe section?','zerif'),
            'description' => __('If you check this box, the Subscribe section will appear on homepage.','zerif'),
            'section' => 'zerif_subscribe_settings_section',
            'priority'    => 1,
        ) );

        /* SUBSCRIBE HEADER */

        $wp_customize->add_section( 'zerif_subscribe_section' , array(
            'title'       => __( 'Header', 'zerif' ),
            'priority'    => 2,
            'panel' => 'panel_13'
        ));

        /* zerif_subscribe_title */
        $wp_customize->add_setting( 'zerif_subscribe_title', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'STAY IN TOUCH','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_subscribe_title', array(
            'label'    => __( 'Main title', 'zerif' ),
            'section'  => 'zerif_subscribe_section',
            'priority'    => 1,
        ));

        /* zerif_subscribe_subtitle */
        $wp_customize->add_setting( 'zerif_subscribe_subtitle', array(
            'sanitize_callback' => 'zerif_sanitize_input',
            'default' => __( 'Sign Up for Email Updates on on News & Offers','zerif' ),
            'transport' => 'postMessage'
        ) );

        $wp_customize->add_control( 'zerif_subscribe_subtitle', array(
            'label'    => __( 'Subtitle', 'zerif' ),
            'section'  => 'zerif_subscribe_section',
            'priority'    => 2,
        ) );

        /* SUBSCRIBE COLORS */

        $wp_customize->add_section( 'zerif_subscribe_color_section' , array(
            'title'       => __( 'Colors', 'zerif' ),
            'priority'    => 4,
            'panel' => 'panel_13'
        ));
		
		/* zerif_subscribe_background */
        $wp_customize->add_setting( 'zerif_subscribe_background', array(
            'default' => 'rgba(0, 0, 0, 0.5)',
            'transport' =>'postMessage' ,
            'sanitize_callback' => 'zerif_sanitize_rgba'
		) );

        $wp_customize->add_control( new Zerif_Customize_Alpha_Color_Control( $wp_customize, 'zerif_subscribe_background', array(
            'label'      => __( 'Background color', 'zerif' ),
            'section'    => 'zerif_subscribe_color_section',
            'priority'   => 1
        ) ) );

        /* zerif_subscribe_header_color */
        $wp_customize->add_setting( 'zerif_subscribe_header_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_subscribe_header_color', array(
            'label'      => __( 'Title and subtitle colors', 'zerif' ),
            'section'    => 'zerif_subscribe_color_section',
            'priority'   => 2
        ) ) );

        /* zerif_subscribe_button_background_color */
        $wp_customize->add_setting( 'zerif_subscribe_button_background_color', array(
            'default' => '#e96656',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_subscribe_button_background_color', array(
            'label'      => __( 'Button background color', 'zerif' ),
            'section'    => 'zerif_subscribe_color_section',
            'priority'   => 3
        ) ) );

        /* zerif_subscribe_button_background_color_hover */
        $wp_customize->add_setting( 'zerif_subscribe_button_background_color_hover', array(
            'default' => '#cb4332',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_subscribe_button_background_color_hover', array(
            'label'      => __( 'Button background color - hover', 'zerif' ),
            'section'    => 'zerif_subscribe_color_section',
            'priority'   => 4
        ) ) );

        /* zerif_subscribe_button_color */
        $wp_customize->add_setting( 'zerif_subscribe_button_color', array(
            'default' => '#fff',
            'transport' => 'postMessage',
            'sanitize_callback' => 'sanitize_hex_color'
        ) );

        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'zerif_subscribe_button_color', array(
            'label'      => __( 'Button text color', 'zerif' ),
            'section'    => 'zerif_subscribe_color_section',
            'priority'   => 5
        ) ) );

    

    endif;

    /****************************************************/
    /****************** BACKGROUND **********************/
    /****************************************************/

    if ( class_exists( 'WP_Customize_Panel' ) ) :

        $wp_customize->add_panel(
            'panel_background',
            array(
                'priority' 			=> 145,
                'capability' 		=> 'edit_theme_options',
                'theme_supports' 	=> '',
                'title' 			=> __( 'Background', 'zerif' )
            )
        );

        /* Background settings */
        $wp_customize->add_section( 'zerif_background_settings_section', array(
            'title'       	=> __( 'Background settings', 'zerif' ),
            'priority'    	=> 1,
            'panel'			=> 'panel_background',
        ) );

        $wp_customize->add_setting( 'zerif_background_settings', array(
            'sanitize_callback' => 'zerif_sanitize_background_type'
        ) );

        $wp_customize->add_control( 'zerif_background_settings', array(
            'type' => 'radio',
            'label' => __('Type of background','zerif'),
            'description' => __("Select the type of background you want. <b>Make sure you also set up the images/video in their corresponding places, down below.</b>",'zerif'),
            'section' => 'zerif_background_settings_section',
            'choices' => array(
                'zerif-background-image' => __( 'Background image','zerif' ),
                'zerif-background-slider' => __( 'Background slider','zerif' ),
                'zerif-background-video' => __( 'Background video', 'zerif' )
            ),
            'priority'    => 1,
        ) );

        /* Background image */
        $wp_customize->get_section('background_image')->panel = 'panel_background';
        $wp_customize->get_section('background_image')->priority = 2;

        /* Background slider */
        $wp_customize->add_section( 'zerif_background_slider_section', array(
            'title'       	=> __( 'Background slider', 'zerif' ),
            'priority'    	=> 3,
            'panel'			=> 'panel_background',
        ) );

        /* slider image 1 */
        $wp_customize->add_setting( 'zerif_bgslider_1', array(
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_bgslider_1', array(
            'label'    => __( 'Image 1', 'zerif' ),
            'section'  => 'zerif_background_slider_section',
            'priority'    => 1,
        ) ) );

        $wp_customize->add_setting( 'zerif_vposition_bgslider_1', array(
            'default' => 'top',
            'sanitize_callback' => 'zerif_sanitize_position'
        ) );

        $wp_customize->add_control( 'zerif_vposition_bgslider_1', array(
            'type' 		=> 'select',
            'label' 	=> 'Image Vertical align',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'top' 		=> __('Top','zerif'),
                'center'	=> __('Center','zerif'),
                'bottom' 	=> __('Bottom','zerif'),
            ),
            'priority' 	=> 2,
        ) );

        $wp_customize->add_setting( 'zerif_hposition_bgslider_1', array( 'default' => 'left' ) );

        $wp_customize->add_control( 'zerif_hposition_bgslider_1', array(
            'type' 		=> 'select',
            'label' 	=> 'Image Horizontal align',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'left' 		=> __('Left','zerif'),
                'center'	=> __('Center','zerif'),
                'right' 	=> __('Right','zerif'),
            ),
            'priority' 	=> 3,
        ) );

        $wp_customize->add_setting( 'zerif_bgsize_bgslider_1', array(
            'default' => 'cover',
            'sanitize_callback' => 'zerif_sanitize_background_size'
        ) );

        $wp_customize->add_control( 'zerif_bgsize_bgslider_1', array(
            'type' 		=> 'select',
            'label' 	=> 'Background size',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'cover' 	=> __('Cover','zerif'),
                'width' 	=> __('width 100%','zerif'),
                'height'	=> __('Height 100%','zerif'),
            ),
            'priority' 	=> 4,
        ));

        /* slider image 2 */
        $wp_customize->add_setting( 'zerif_bgslider_2', array(
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_bgslider_2', array(
            'label'    	=> __( 'Image 2', 'zerif' ),
            'section'  	=> 'zerif_background_slider_section',
            'priority'	=> 5,
        ) ) );

        $wp_customize->add_setting( 'zerif_vposition_bgslider_2', array(
            'default' => 'top',
            'sanitize_callback' => 'zerif_sanitize_position'
        ) );

        $wp_customize->add_control( 'zerif_vposition_bgslider_2', array(
            'type' 		=> 'select',
            'label' 	=> 'Image Vertical align',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'top' 		=> __('Top','zerif'),
                'center'	=> __('Center','zerif'),
                'bottom' 	=> __('Bottom','zerif'),
            ),
            'priority' 	=> 6,
        ) );

        $wp_customize->add_setting( 'zerif_hposition_bgslider_2', array(
            'default' => 'left',
            'sanitize_callback' => 'zerif_sanitize_horizontal'
        ) );

        $wp_customize->add_control( 'zerif_hposition_bgslider_2', array(
            'type' 		=> 'select',
            'label' 	=> 'Image Horizontal align',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'left' 		=> __('Left','zerif'),
                'center'	=> __('Center','zerif'),
                'right' 	=> __('Right','zerif'),
            ),
            'priority' 	=> 7,
        ) );

        $wp_customize->add_setting( 'zerif_bgsize_bgslider_2', array(
            'default' => 'cover',
            'sanitize_callback' => 'zerif_sanitize_background_size'
        ) );

        $wp_customize->add_control( 'zerif_bgsize_bgslider_2', array(
            'type' 		=> 'select',
            'label' 	=> 'Background size',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'cover' 	=> __('Cover','zerif'),
                'width' 	=> __('width 100%','zerif'),
                'height'	=> __('Height 100%','zerif'),
            ),
            'priority' 	=> 8,
        ) );

        /* slider image 3 */
        $wp_customize->add_setting( 'zerif_bgslider_3', array(
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_bgslider_3', array(
            'label'    	=> __( 'Image 3', 'zerif' ),
            'section'  	=> 'zerif_background_slider_section',
            'priority'	=> 9,
        ) ) );

        $wp_customize->add_setting( 'zerif_vposition_bgslider_3', array(
            'sanitize_callback' => 'zerif_sanitize_position',
            'default' => 'top'
        ) );

        $wp_customize->add_control( 'zerif_vposition_bgslider_3', array(
            'type' 		=> 'select',
            'label' 	=> 'Image Vertical align',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'top' 		=> __('Top','zerif'),
                'center'	=> __('Center','zerif'),
                'bottom' 	=> __('Bottom','zerif'),
            ),
            'priority' 	=> 10,
        ) );

        $wp_customize->add_setting( 'zerif_hposition_bgslider_3', array(
            'sanitize_callback' => 'zerif_sanitize_background_size',
            'default' => 'left'
        ) );

        $wp_customize->add_control( 'zerif_hposition_bgslider_3', array(
            'type' 		=> 'select',
            'label' 	=> 'Image Horizontal align',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'left' 		=> __('Left','zerif'),
                'center'	=> __('Center','zerif'),
                'right' 	=> __('Right','zerif'),
            ),
            'priority' 	=> 11,
        ) );

        $wp_customize->add_setting( 'zerif_bgsize_bgslider_3', array(
            'default' => 'cover',
            'sanitize_callback' => 'zerif_sanitize_background_size'
        ) );

        $wp_customize->add_control( 'zerif_bgsize_bgslider_3', array(
            'type' 		=> 'select',
            'label' 	=> 'Background size',
            'section' 	=> 'zerif_background_slider_section',
            'choices' 	=> array(
                'cover' 	=> __('Cover','zerif'),
                'width' 	=> __('width 100%','zerif'),
                'height'	=> __('Height 100%','zerif'),
            ),
            'priority' 	=> 12,
        ) );

        /* Video Background */
        $wp_customize->add_section( 'zerif_background_video_section', array(
            'title'       	=> __( 'Background Video', 'zerif' ),
            'priority'    	=> 4,
            'panel'			=> 'panel_background',
        ) );

        /* Video */
        $wp_customize->add_setting( 'zerif_background_video', array(
            'sanitize_callback' => 'esc_url'
        ) );

        $wp_customize->add_control( new WP_Customize_Upload_Control( $wp_customize, 'zerif_background_video', array(
            'label'      => __( 'Video file', 'zerif' ),
            'description'=> __( 'mp4 format file', 'zerif' ),
            'section'    => 'zerif_background_video_section',
            'priority'   => 1
        ) ) );

        /* Thumbnail */
        $wp_customize->add_setting( 'zerif_background_video_thumbnail', array(
            'sanitize_callback' => 'esc_url'
        ) );
        $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'zerif_background_video_thumbnail', array(
            'label'    	=> __( 'Video thumbnail', 'zerif' ),
            'description' => __( 'This image will appear while the video is downloading. If this is not included, the first frame of the video will be used instead.', 'zerif' ),
            'section'  	=> 'zerif_background_video_section',
            'priority'	=> 2,
        ) ) );
		
		/* zerif_enable_video_sound_title */
		$wp_customize->add_setting( 'zerif_enable_video_sound_title', array(
			'sanitize_callback' => 'zerif_sanitize_pro_version'
		));
		$wp_customize->add_control( new Zerif_Video_Sound( $wp_customize, 'zerif_enable_video_sound_title', array(
			'section' => 'zerif_background_video_section',
			'priority' => 3,
		)));
		
		/* zerif_enable_video_sound */
        $wp_customize->add_setting( 'zerif_enable_video_sound', array(
            'sanitize_callback' => 'zerif_sanitize_checkbox'
        ) );

        $wp_customize->add_control( 'zerif_enable_video_sound', array(
            'type' => 'checkbox',
            'label' => __( 'Enable sound','zerif' ),
            'section' => 'zerif_background_video_section',
            'priority'    => 4,
        ) );
		
    

    endif;

}

add_action( 'customize_register', 'wp_themeisle_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function wp_themeisle_customize_preview_js() {
    wp_enqueue_script( 'wp_themeisle_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.1', true );
    wp_localize_script( 'wp_themeisle_customizer', 'requestpost', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ));
}

add_action( 'customize_preview_init', 'wp_themeisle_customize_preview_js' );

function zerif_sanitize_section_name( $input ){
    $zerif_posible_sections = array('our_focus','bottom_ribbon','portofolio','about_us','our_team','testimonials','right_ribbon','contact_us','map','packages','subscribe','latest_news','shortcodes');
    if( in_array( $input, $zerif_posible_sections ) ){
        return $input;
    }
    return $zerif_posible_sections[0];
}


function zerif_sanitize_repeater($input){
    $input_decoded = json_decode($input,true);
    if(!empty($input_decoded)) {
        foreach ($input_decoded as $boxk => $box ){
            foreach ($box as $key => $value) {
                if ( $key == 'text_color' || $key == 'color' ) {
                    $value                          = html_entity_decode( $value );
                    $input_decoded[ $boxk ][ $key ] = sanitize_hex_color( $value );
                } elseif( $key == 'opacity' ){
                    $input_decoded[$boxk][$key] = (is_numeric( $value )? $value : 1);
                } else {
                    $input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );
                }
            }
        }
        return json_encode($input_decoded);
    }
    return $input;
}

function zerif_sanitize_position( $input ){
    $zerif_posible_positions = array('top','center','bottom');
    if( in_array( $input, $zerif_posible_positions ) ){
        return $input;
    }
    return $zerif_posible_positions[0];
}


function zerif_sanitize_background_size( $input ){
    $zerif_posible_sizes = array('cover','width','height');
    if( in_array( $input, $zerif_posible_sizes ) ){
        return $input;
    }
    return $zerif_posible_sizes[0];
}

function zerif_sanitize_horizontal( $input ){
    $zerif_posible_positions = array('left','center','right');
    if( in_array( $input, $zerif_posible_positions ) ){
        return $input;
    }
    return $zerif_posible_positions[0];
}

function zerif_sanitize_background_type( $input ){
    $zerif_posible_types = array('zerif-background-image','zerif-background-slider','zerif-background-video');
    if( in_array( $input, $zerif_posible_types ) ){
        return $input;
    }
    return $zerif_posible_types[0];
}

function zerif_sanitize_checkbox( $input ){
    return ( isset( $input ) && true == $input ? true : false );
}

function zerif_sanitize_input($input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

/* Sanitize RGBA colors */
function  zerif_sanitize_rgba($value)  {

    // If empty or an array return transparent
    if ( empty( $value ) || is_array( $value ) ) {
        return 'rgba(0,0,0,0)';
    }
    $value = str_replace( ' ', '', $value );
    if(substr( $value, 0, 4 ) == "rgba"){
        sscanf( $value, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
        return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
    }
    return sanitize_hex_color($value);
}




function zerif_registers() {
    wp_enqueue_script( 'zerif_customizer_script', get_template_directory_uri() . '/js/zerif_customizer.js', array("jquery","jquery-ui-core","jquery-ui-draggable"), '20120206', true  );
}

add_action( 'customize_controls_enqueue_scripts', 'zerif_registers' );
