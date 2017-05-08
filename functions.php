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

	// Entry background
	$entry_background = get_theme_mod( 'entry_background', '#ffffff');
	if ( !empty( $entry_background ) ) {
		$custom .= 'div.post-inner { background-color:' . $entry_background . ';}' . "\n";
	}

	// Entry title hover
	$entry_title_hover_color = get_theme_mod( 'entry_title_hover', '#23b6b6');
	if ( !empty( $entry_title_hover_color ) ) {
		$custom .= 'h2.entry-title a:hover{ color:' . $entry_title_hover_color . ';}' . "\n";
	}

	// Entry meta hover
	$entry_meta_hover_color = get_theme_mod( 'entry_meta_hover', '#23b6b6');
	if ( !empty( $entry_meta_hover_color ) ) {
		$custom .= 'div.entry-meta a:hover { color:' . $entry_meta_hover_color . ';}' . "\n";
	}

	// Entry more
	$entry_more_color = get_theme_mod( 'entry_more', '#d1b586');
	if ( !empty( $entry_more_color ) ) {
		$custom .= '.entry-content-link { color:' . $entry_more_color . ';}' . "\n";
	}

	// Entry more hover
	$entry_more_hover_color = get_theme_mod( 'entry_more_hover', '#d1b586' );
	if ( !empty( $entry_more_hover_color ) ) {
		$custom .= '.entry-content-link:hover { color:' . $entry_more_hover_color . ';}' . "\n";
	}

	// Entry Bottom Line
	$entry_bottom_line = get_theme_mod( 'entry_bottom_line', '#d1b586');
	if ( !empty( $entry_bottom_line ) ) {
		$custom .= '.post-bottom-svg-line { stroke: ' . $entry_bottom_line . ';}' . "\n";
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

	// Remove Primary Color
	$wp_customize->remove_control( 'primary_color' );

	// Entry background
	$wp_customize->add_setting(
		'entry_background',
		array(
			'default'           => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_background',
			array(
				'label'     => esc_html__('Entry background', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 15
			)
		)
	);

	// Entry title hover
	$wp_customize->add_setting(
		'entry_title_hover',
		array(
			'default'           => '#23b6b6',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_title_hover',
			array(
				'label'     => esc_html__('Entry title hover', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 16
			)
		)
	);

	// Entry meta hover
	$wp_customize->add_setting(
		'entry_meta_hover',
		array(
			'default'           => '#23b6b6',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_meta_hover',
			array(
				'label'     => esc_html__('Entry meta hover', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 17
			)
		)
	);

	// Entry more
	$wp_customize->add_setting(
		'entry_more',
		array(
			'default'           => '#d1b586',
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

	//Entry more hover
	$wp_customize->add_setting(
		'entry_more_hover',
		array(
			'default'           => '#d1b586',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_more_hover',
			array(
				'label'     => esc_html__('Entry more hover', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 17
			)
		)
	);

	// Post Bottom Line
	$wp_customize->add_setting(
		'entry_bottom_line',
		array(
			'default'           => '#d1b586',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'entry_bottom_line',
			array(
				'label'     => esc_html__('Entry Bottom Line', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 17
			)
		)
	);


}
add_action( 'customize_register', 'oblique_coffeeshop_customize_register', 20 );


function oblique_coffeeshop_post_thumbnail_size () {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'oblique-coffeeshop-entry-thumb', 525);
}
add_action( 'after_setup_theme', 'oblique_coffeeshop_post_thumbnail_size' );


/**
 * Svg1 function.
 */
function svg_new() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1890" y1="0" x2="0" y2="150" width="100%" height="50" class="bottom post-bottom-svg-line" />
			  
		</svg>
	';
}

/**
 * Change post format
 */
function oblique_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'oblique' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$category = get_the_category();
	if ( $category ) {
		$cat = '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '">' . esc_attr( $category[0]->cat_name ) . '</a>';
	}

	$byline = sprintf(
		_x( '%s', 'post author', 'oblique' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	if ( ! is_singular() ) {
		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
	} elseif ( ! get_theme_mod( 'meta_singles' ) ) {
		echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
		if ( 'post' == get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( __( ', ', 'oblique' ) );
			if ( $categories_list ) {
				printf( '<span class="cat-links">' . __( '%1$s', 'oblique' ) . '</span>', $categories_list );
			}
		}
	}
}

/**
 * Change footer credits
 */

function oblique_coffeeshop_footer_credits() {
	printf( __('%s Copyright 2016'), '&copy' );
	echo '<span class="sep"> | </span>';
	printf( __('Oblique Coffeeshop Blog Theme') );
	echo '<span class="sep"> | </span>';
	printf( __('All Rights Reserved.') );
}
add_action( 'oblique_footer', 'oblique_coffeeshop_footer_credits' );

/**
 * Remove overwritten functions from the parent theme
 * Child theme is loaded before the parrent theme
 * This helps overriding some function
 */
function remove_actions(){
	remove_action( 'oblique_footer', 'oblique_footer_credits' );
}
add_action('after_setup_theme', 'remove_actions');

/**
 * Pagination
 */
function rokophotolite_pagination() {

	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<ul class="pagination">' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link('&laquo;') );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link('&raquo;') );

	echo '</ul>' . "\n";

}

function oblique_coffeeshop_custom_pagination() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2) {
		return;
	}

	echo '<nav class="navigation posts-navigation" role="navigation">';

	echo '<h2 class="screen-reader-text">';
	_e( 'Posts navigation', 'oblique' );
	echo '</h2>';

	echo '<div class="nav-links">';
//		if ( get_next_posts_link() ) {
//			echo '<div class="nav-previous">';
//			next_posts_link( __( 'Older posts', 'oblique' ) );
//			echo '</div>';
//		}

		the_posts_pagination(
			array(
				'mid_size' => 1,
				'prev_text' => __( 'Prev' ),
				'next_text' => __( 'Next' ),
				'screen_reader_text' => 'Posts navigation'
			)
		);

//		if ( get_previous_post_link() ) {
//			echo '<div class="nav-next">';
//			previous_posts_link( __( 'Newer posts', 'oblique' ) );
//			echo '</div>';
//		}
	echo '</div>';

	echo '</nav>';
}

