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

function oblique_coffeeshop_header_image($input) {
	$input['default-image'] = get_stylesheet_directory_uri() . '/images/header.jpg';
	return $input;
}

add_filter('oblique_custom_header_args', 'oblique_coffeeshop_header_image');

function oblique_coffeeshop_custom_styles( $custom ) {
// Primary color
	$primary_color = get_theme_mod( 'primary_color', '#d1b586' );
	if ( ! empty( $primary_color ) && ( $primary_color != '#d1b586' ) ) {
		$custom .= '.entry-meta a:hover, .entry-title a:hover, .widget-area a:hover, .social-navigation li a:hover, a { color:' . esc_attr( $primary_color ) . '}' . "\n";
		$custom .= '.read-more, .nav-previous:hover, .nav-next:hover, button, .button, input[type="button"], input[type="reset"], input[type="submit"] { background-color:' . esc_attr( $primary_color ) . '}' . "\n";
		$rgba 	= oblique_hex2rgba( $primary_color, 0.3 );
		$custom .= '.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";
	}
	// Output all the styles
	wp_add_inline_style( 'oblique-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'oblique_coffeeshop_custom_styles', 20 );


/**
 * Register main controls in customize
 */
function oblique_coffeeshop_customize_register( $wp_customize ) {

	$wp_customize->get_setting( 'primary_color' )->default = '#d1b586';
	$wp_customize->get_setting( 'body_text_color' )->default = '#8c8c8c';
	$wp_customize->get_setting( 'site_title_color' )->default = '#ffffff';
	$wp_customize->get_setting( 'site_desc_color' )->default = '#ffffff';
	$wp_customize->get_setting( 'entry_titles' )->default = '#d1b586';
	$wp_customize->get_setting( 'entry_meta' )->default = '#8c8c8c';
	$wp_customize->get_setting( 'menu_icon_color' )->default = '#f8f9fb';

}
add_action( 'customize_register', 'oblique_coffeeshop_customize_register', 20 );

