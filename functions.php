<?php
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles',99);
function child_enqueue_styles() {
    $parent_style = 'parent-style';
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ) );
}
if ( get_stylesheet() !== get_template() ) {
    add_filter( 'pre_update_option_theme_mods_' . get_stylesheet(), function ( $value, $old_value ) {
        update_option( 'theme_mods_' . get_template(), $value );
        return $old_value; // prevent update to child theme mods
    }, 10, 2 );
    add_filter( 'pre_option_theme_mods_' . get_stylesheet(), function ( $default ) {
        return get_option( 'theme_mods_' . get_template(), $default );
    } );
}

/**
 * Google Fonts
 */
function oblique_coffeeshop_include_google_fonts() {
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Lora', false );
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Athiti', false );
}
add_action( 'wp_enqueue_scripts', 'oblique_coffeeshop_include_google_fonts' );

/**
 * Function descr.
 *
 * @param array $input Array settings for custom-background theme support
 *
 * @version 1.0
 * @access public
 * @return array
 */
function oblique_coffeeshop_background_filter($input) {
    $input['default-color'] = 'f8f9fb';
    return $input;
}
add_filter('oblique_custom_background_args', 'oblique_coffeeshop_background_filter');


/**
 * Changing the header image
 * same location, same image name as the parrent
 *
 * @param $input
 *
 * @return image path
 */
function oblique_coffeeshop_header_image($input) {
	$input['default-image'] = get_stylesheet_directory_uri() . '/images/header.jpg';
	return $input;
}
add_filter('oblique_custom_header_args', 'oblique_coffeeshop_header_image');


/**
 * Dynamic styles
 *
 * @param $custom
 */
function oblique_coffeeshop_custom_styles( $custom ) {

	$custom = '';

	// Primary color
	$primary_color = get_theme_mod( 'primary_color', '#d1b586' );
	if ( ! empty( $primary_color ) && ( $primary_color != '#d1b586' ) ) {
		$custom .= '.entry-meta a:hover, .entry-title a:hover, .widget-area a:hover, .social-navigation li a:hover, a { color:' . esc_attr( $primary_color ) . '}' . "\n";
		$custom .= '.read-more, .nav-previous:hover, .nav-next:hover, button, .button, input[type="button"], input[type="reset"], input[type="submit"] { background-color:' . esc_attr( $primary_color ) . '}' . "\n";
		$rgba 	= oblique_hex2rgba( $primary_color, 0.3 );
		$custom .= '.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";
	}


	// Header padding
	$branding_padding = get_theme_mod( 'branding_padding', '300' );
	if ( ! empty( $branding_padding ) ) {
		$custom .= 'div.site-branding { padding:' . intval( $branding_padding ) . 'px 0; }' . "\n";
	}

	// Entry more
	$entry_more_color = get_theme_mod( 'entry_more', '#ffffff');
	if ( !empty( $entry_more_color ) ) {
		$custom .= 'div.read-more { color:' . $entry_more_color . ';}' . "\n";
	}

	// Output all the styles
	wp_add_inline_style( 'oblique-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'oblique_coffeeshop_custom_styles', 20 );


/**
 * Register main controls in customize
 * Set default values in the customizer
 */
function oblique_coffeeshop_customize_register( $wp_customize ) {

	// Colors
	$wp_customize->get_setting( 'primary_color' )->default = '#d1b586';
	$wp_customize->get_setting( 'body_text_color' )->default = '#8c8c8c';
	$wp_customize->get_setting( 'site_title_color' )->default = '#ffffff';
	$wp_customize->get_setting( 'site_desc_color' )->default = '#ffffff';
	$wp_customize->get_setting( 'entry_titles' )->default = '#d1b586';
	$wp_customize->get_setting( 'entry_meta' )->default = '#8c8c8c';
	$wp_customize->get_setting( 'menu_icon_color' )->default = '#f8f9fb';

	// Branding Padding
	$wp_customize->get_setting( 'branding_padding' )->default = '300';
	$wp_customize->get_control('branding_padding' )->description = esc_html__('Top&amp;bottom padding for the branding. Default: 300px','oblique-coffeeshop');

	// Entry more
	$wp_customize->add_setting(
		'entry_more',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_more',
			array(
				'label'     => esc_html__('Entry more', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 17
			)
		)
	);
}
add_action( 'customize_register', 'oblique_coffeeshop_customize_register', 20 );


function oblique_coffeeshop_post_thumbnail_size () {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'oblique-entry-thumb', 525);
	add_image_size( 'oblique-single-thumb', 1040 );
}
add_action( 'after_setup_theme', 'oblique_coffeeshop_post_thumbnail_size' );