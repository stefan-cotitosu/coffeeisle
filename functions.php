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
 * Remove functions from the parrent theme
 * That are replaced with child theme function
 * Because Child theme is loaded before the parrent theme
 * after_setup_theme
 */
function remove_actions(){

    // Post read more
	remove_action( 'oblique_link_to_single', 'oblique_post_link_to_single' );

	// Header svg
    remove_action( 'oblique_nav_container', 'oblique_nav_svg_container' );

    // Footer svg
	remove_action( 'oblique_footer_svg', 'oblique_footer_svg_container' );

    // Footer credits
	remove_action( 'oblique_footer', 'oblique_footer_credits' );

	// Index posts navigation
    remove_action( 'oblique_posts_navigation', 'oblique_posts_navigation' );

}
add_action('after_setup_theme', 'remove_actions');

/**
 * Dynamic styles
 *
 * @param $custom
 */
function oblique_coffeeshop_custom_styles( $custom ) {

	$custom = '';

	$background_color = get_background_color();
	if( !empty( $background_color ) ){
		$custom .= 'div.svg-block{ fill: #'. $background_color .';}';
    }

    // Primary color
	$primary_color = get_theme_mod( 'primary_color', '#925D34' );
	if ( ! empty( $primary_color ) ) {
		$custom .= 'div.entry-meta a:hover, h2.entry-title a:hover, div.widget-area a:hover, nav.social-navigation li a:hover, a.entry-content-link:hover { color:' . esc_attr( $primary_color ) . ';}' . "\n";
		$rgba 	= oblique_hex2rgba( $primary_color, 0.3 );
		$custom .= '.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";
	}

	$entry_titles = get_theme_mod('entry_titles', '#d1b586' );
	if ( ! empty( $entry_titles ) ) {
		$rgba 	= oblique_hex2rgba( $entry_titles, 0.3 );
		$custom .= 'div.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";

		$custom .= 'h2.entry-title, h2.entry-title a, a.entry-content-link { color:' . esc_attr( $entry_titles ) . ';}' . "\n";
	    $custom .= 'line.post-bottom-svg-line { stroke: '. esc_attr( $entry_titles ) . ';}' . "\n";
	    $custom .= 'div.nav-links .current { background-color:'. esc_attr( $entry_titles ). ';}' . "\n";
	}

	// Footer color
    $footer_background_color = get_theme_mod( 'footer_background', '#f8f9fb' );
	if ( ! empty( $footer_background_color ) ) {
	    $custom .= 'footer.site-footer { background-color:' . esc_attr( $footer_background_color ) . ';}' . "\n";
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

	// Entry more
	$entry_more_color = get_theme_mod( 'entry_more', '#d1b586');
	if ( !empty( $entry_more_color ) ) {
		$custom .= '.entry-content-link { color:' . $entry_more_color . ';}' . "\n";

		$custom .= '.entry-content-link:hover { color:' . $entry_more_color . ';}' . "\n";
	}

	// Output all the styles
	wp_add_inline_style( 'oblique-style', $custom );
}
add_action( 'wp_enqueue_scripts', 'oblique_coffeeshop_custom_styles', 20 );

/**
 * Customizer
 * Register main controls in customize
 * Set default values in the customizer
 */
function oblique_coffeeshop_customize_register( $wp_customize ) {

	// Branding Padding
	$wp_customize->get_setting( 'branding_padding' )->default = '300';
	$wp_customize->get_control('branding_padding' )->description = esc_html__('Top&amp;bottom padding for the branding. Default: 300px','oblique-coffeeshop');

	// Remove Primary Color
	//$wp_customize->remove_control( 'primary_color' );

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

}
add_action( 'customize_register', 'oblique_coffeeshop_customize_register', 20 );

/**
 * Color
 * Background color filter
 */
function oblique_coffeeshop_background_filter($input) {
    $input['default-color'] = 'f8f9fb';
    return $input;
}
add_filter( 'oblique_custom_background_args', 'oblique_coffeeshop_background_filter' );

/**
 * Color
 * Primary Color Filter
 */
function oblique_coffeeshop_default_primary_color(){
	return '#925D34';
}
add_filter('oblique_primary_color', 'oblique_coffeeshop_default_primary_color');

/**
 * Color
 * Body text color
 */
function oblique_coffeeshop_body_text_color() {
	return '#50545C';
}
add_filter( 'oblique_body_text_color', 'oblique_coffeeshop_body_text_color' );

/**
 * Color
 * Site title color
 */
function oblique_coffeeshop_site_title_color() {
	return '#ffffff';
}
add_filter( 'oblique_site_title_color', 'oblique_coffeeshop_site_title_color' );

/**
 * Color
 * Site desc color
 */
function oblique_coffeeshop_site_desc_color() {
	return '#ffffff';
}
add_filter( 'oblique_site_desc_color', 'oblique_coffeeshop_site_desc_color' );

/**
 * Color
 * Entry titles color
 */
function oblique_coffeeshop_entry_titles_color() {
	return '#d1b586';
}
add_filter( 'oblique_entry_titles_color', 'oblique_coffeeshop_entry_titles_color' );

/**
 * Color
 * Entry meta color
 */
function oblique_coffeeshop_entry_meta_color() {
	return '#8c8c8c';
}
add_filter( 'oblique_entry_meta_color', 'oblique_coffeeshop_entry_meta_color' );

/**
 * Color
 * Entry meta color
 */
function oblique_coffeeshop_menu_icon_color() {
	return '#f8f9fb';
}
add_filter( 'oblique_menu_icon_color', 'oblique_coffeeshop_menu_icon_color' );

/**
 * Color
 * Footer background color
 */
function oblique_coffeeshop_footer_background_color() {
    return '#f8f9fb';
}
add_filter( 'oblique_footer_background_color', 'oblique_coffeeshop_footer_background_color' );

/**
 * Image
 * Changing the header image
 * same location, same image name as the parrent
 */
function oblique_coffeeshop_header_image($input) {
	$input['default-image'] = get_stylesheet_directory_uri() . '/images/header.jpg';
	return $input;
}
add_filter('oblique_custom_header_args', 'oblique_coffeeshop_header_image');

/**
 * Post
 * thumbnail size
 */
function oblique_coffeeshop_post_thumbnail_size() {
	remove_image_size('oblique-entry-thumb');
	add_image_size('oblique-entry-thumb', 525);
}
add_action( 'after_setup_theme', 'oblique_coffeeshop_post_thumbnail_size', 15 );

/**
 * Post
 * read more message
 */
function oblique_coffeeshop_post_read_more() {
	return esc_html__( 'Keep Reading &rarr;','oblique' );
}
add_filter( 'oblique_post_read_more', 'oblique_coffeeshop_post_read_more' );

/**
 * Post
 * read more message
 */
function oblique_coffeeshop_post_link_to_single(){
	if ( ! get_theme_mod( 'read_more' ) ) :?>
        <a href="<?php the_permalink(); ?>" class="entry-content-link">
			<?php echo apply_filters( 'oblique_post_read_more' , esc_html__( 'Continue reading &hellip;','oblique' ) ); ?>
        </a>
	<?php endif;
}
add_action( 'oblique_post_entry_content_bottom', 'oblique_coffeeshop_post_link_to_single' );

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
add_action( 'oblique_post_bottom_svg', 'svg_new' );

/**
 * Post
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
 * Footer
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
 * Posts Navigation
 */
function oblique_coffeeshop_custom_pagination() {

	if ( $GLOBALS['wp_query']->max_num_pages < 2) {
		return;
	}

	echo '<nav class="navigation posts-navigation" role="navigation">';

	echo '<h2 class="screen-reader-text">';
	_e( 'Posts navigation', 'oblique' );
	echo '</h2>';

	echo '<div class="nav-links">';

		the_posts_pagination(
			array(
				'mid_size' => 1,
				'prev_text' => __( 'Prev' ),
				'next_text' => __( 'Next' ),
				'screen_reader_text' => 'Posts navigation'
			)
		);


	echo '</div>';

	echo '</nav>';
}
add_action( 'oblique_posts_navigation', 'oblique_coffeeshop_custom_pagination' );
