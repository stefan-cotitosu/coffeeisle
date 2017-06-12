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
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function oblique_coffeeshop_customize_preview_js() {
	wp_enqueue_script( 'oblique_coffeeshop_customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'oblique_coffeeshop_customize_preview_js' );

/**
 * Google Fonts
 */
function oblique_coffeeshop_include_google_fonts() {
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Lora:400,700', false );
	wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Athiti:300,400,600', false );
}
add_action( 'wp_enqueue_scripts', 'oblique_coffeeshop_include_google_fonts' );

/**
 * Remove functions from the parrent theme
 * That are replaced with child theme function
 * Because Child theme is loaded before the parrent theme
 * after_setup_theme
 */
function remove_actions() {

    // Post read more
	remove_action( 'oblique_link_to_single', 'oblique_post_link_to_single' );

	// Header svg
    remove_action( 'oblique_nav_container', 'oblique_nav_svg_container' );

    // Footer credits
	remove_action( 'oblique_footer', 'oblique_footer_credits' );

	// Index posts navigation
    remove_action( 'oblique_posts_navigation', 'oblique_posts_navigation' );

    // Archive title bottom svg
    remove_action( 'oblique_archive_title_bottom_svg', 'oblique_archive_title_bottom_svg' );

    // Content single post bottom svg
    remove_action( 'oblique_single_post_bottom_svg', 'oblique_single_post_bottom_svg' );

    // Single post navigation
    remove_action( 'oblique_single_post_navigation', 'oblique_single_post_navigation' );

    // Single page post bottom svg
    remove_action( 'oblique_single_page_post_svg', 'oblique_single_page_post_svg' );

    // Comments title
    remove_action( 'oblique_comments_title', 'oblique_comments_title_text' );

    // Comments list
    remove_action( 'oblique_comments_list', 'oblique_comments_list' );

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

		$custom .= 'div.svg-block{ fill: #'. esc_attr( $background_color ) .';}';

        $custom .= '.search div.search-title-top-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";
        $custom .= '.search div.search-title-bottom-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td { background-color: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_bottom_svg { background-color: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-info { background-color: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment { background: #' . esc_attr( $background_color ) . ';}' . "\n";

		$custom .= 'div.alt-shop-special-offer-top-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";
		$custom .= 'div.alt-shop-special-offer-bottom-svg { fill: #' . esc_attr( $background_color ) . ';}' . "\n";

    }

    // Primary color
	$primary_color = get_theme_mod( 'primary_color', '#925D34' );
	if ( ! empty( $primary_color ) ) {
		$custom .= 'div.entry-meta a:hover, h2.entry-title a:hover, div.widget-area a:hover, nav.social-navigation li a:hover, a.entry-content-link:hover { color:' . esc_attr( $primary_color ) . ';}' . "\n";
		$rgba 	= oblique_hex2rgba( $primary_color, 0.3 );

		$custom .= '.home article.post div.post-inner a.entry-content-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.page .contact-details-list a:hover { color:' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.archive .post-inner a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.page div.comments-area ol.comment-list li.comment div.reply a.comment-reply-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";

		$current_selector = '.comment-form .form-submit input[type="submit"]:hover';
        $custom .=  oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.single a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single .comment-body .reply a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .search-submit:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit:hover { border: 1px solid ' . oblique_coffeeshop_darken_color( $primary_color, 10 ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_archive ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_pages ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_meta ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_nav_menu ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_entries ul li a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.add_to_cart_button:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

        $current_selector = '.woocommerce-page ul.products li.product a.button:hover';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.woocommerce button.button.alt:hover, .single-product .single_add_to_cart_button:hover { background: ' . esc_attr( $primary_color ) . ' !important;}' . "\n";

        $current_selector = '.woocommerce #review_form #respond .form-submit input[type="submit"]:hover';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

        $current_selector = '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a:hover';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

        $current_selector = '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:hover';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

		$current_selector = '.woocommerce-page div.woocommerce-message a.button:hover';
		$custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

		$current_selector = '.woocommerce-page form.woocommerce-form-login input[type="submit"]:hover';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.woocommerce-cart p.return-to-shop a.button:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

        $current_selector = '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"]:hover';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $primary_color );

		$custom .= '.woocommerce-page ul.products li.product a.added_to_cart:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocomerce-form p.lost_password a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-message a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-info a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocommerce-cart-form a:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

		$custom .= '.page div.alt-shop-blog-large article.hentry a.entry-content-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";
		$custom .= '.page div.alt-shop-blog-small article.hentry a.entry-content-link:hover { color: ' . esc_attr( $primary_color ) . ';}' . "\n";

        $custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button:hover { background-color: ' . esc_attr( $primary_color ) . ';}' . "\n";

	}

	// Secondary Color
    $secondary_color = get_theme_mod( 'secondary_color', '#333333' );
	if ( ! empty( $secondary_color ) ) {

        $custom .= '.woocommerce-page ul.products li.product .price { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

        $custom .= '.woocommerce div.product p.price, .woocommerce div.product span.price { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.single-product form.cart p.quantity-title { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.single-product form.cart div.quantity { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce div.product form.cart table.variations td.label { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce div.product .woocommerce-tabs div.woocommerce-Tabs-panel--description h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce div.product .woocommerce-tabs div.woocommerce-Tabs-panel--reviews h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce div.product form.cart table.variations { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

        $custom .= '.woocommerce-cart div.cross-sells>h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce-cart div.cart_totals>h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

        $custom .= '.woocommerce-checkout div.woocommerce-billing-fields>h3 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce-checkout div.woocommerce-additional-fields>h3 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= '.woocommerce-checkout form.woocommerce-checkout h3#order_review_heading { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

        $custom .= '.woocommerce-account div.woocommerce>h2 { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

        $custom .= 'div.offer-product-wrapper div.offer-product-inner h3.offer-product-price { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";
        $custom .= 'div.offer-product-wrapper div.offer-product-inner div.offer-product-price del { color: ' . esc_attr( $secondary_color ) . ';}' . "\n";

    }

    // Entry Titles Color
	$entry_titles = get_theme_mod('entry_titles', '#d1b586' );
	if ( ! empty( $entry_titles ) ) {
		$rgba 	= oblique_hex2rgba( $entry_titles, 0.3 );

        $custom .= '.home article.post div.post-inner a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.archive .post-inner a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'div.entry-thumb:after { background-color:' . esc_attr( $rgba ) . ';}' . "\n";

		$custom .= '.pirate-forms-submit-button { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page div.entry-content li:first-of-type { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.page .contact-details-list a { color:' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.page div.comments-area ol.comment-list li.comment div.reply a.comment-reply-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single_post_bottom_svg { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.comment-respond h3 { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= 'h2.entry-title, h2.entry-title a, .entry-content a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

	    $custom .= 'line.post-bottom-svg-line { stroke: '. esc_attr( $entry_titles ) . ';}' . "\n";
	    $custom .= 'div.nav-links .current { background-color:'. esc_attr( $entry_titles ). ';}' . "\n";

        $current_selector = '.comment-form .form-submit input[type="submit"]';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.single_page_post_svg { stroke:' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single h2.comments-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.page-header .page-title { color: ' . esc_attr( $entry_titles ) . ' !important;}' . "\n";

		$custom .= '.single .comment-body .comment-author { color:' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single .comment-body .reply a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single .comment-list .comment:nth-of-type(even) { border-left: 2px solid ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .widget-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table caption { background: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .search-submit { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
		$custom .= '.single-sidebar .widget .search-submit { border: 1px solid ' . oblique_coffeeshop_darken_color( $entry_titles, 10 ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_categories ul li { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a:hover { color: #ffffff; background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_archive ul li:before, .single-sidebar .widget_archive ul li { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_pages ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_meta ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_nav_menu ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_entries ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_rss ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_comments ul li:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td a { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page h2.comments-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.page .comment-body .comment-author .fn { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.archive_title_svg { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product h2.woocommerce-loop-product__title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.add_to_cart_button { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$current_selector = '.woocommerce-page ul.products li.product a.button';
		$custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.single-product h1.product_title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $current_selector = '.single-product .single_add_to_cart_button, .woocommerce button.button.alt';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

		$custom .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce #reviews #comments ol.commentlist li .comment-text .woocommerce-review__author { color: ' .
		           esc_attr( $entry_titles ) . ';}' . "\n";

		$custom .= '.woocommerce .star-rating span { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $current_selector = '.woocommerce #review_form #respond .form-submit input[type="submit"]';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles);

        $custom .= '.woocommerce #reviews #respond #reply-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.single-product div.single_product_bottom_svg .single_product_bottom_svg_line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.single-product h2.related_products_title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.woocommerce-page h2.alt_shop_cat_title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.single-product div.related-title-bottom-svg .related_title_bottom_svg_line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.woocommerce-page div.alt_shop_cat_title_bottom_svg .alt_shop_cat_title_bottom_svg_line { stroke: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $current_selector = '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

        $custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled:hover { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $current_selector = '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

        $custom .= '.woocommerce-page div.woocommerce-message { border-top-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.woocommerce-page div.woocommerce-message:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $current_selector = '.woocommerce-page div.woocommerce-message a.button';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

        $current_selector = '.woocommerce-page form.woocommerce-form-login input[type="submit"]';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

        $custom .= '.woocommerce form .form-row .required { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-cart p.return-to-shop a.button { background-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-page div.woocommerce-info { border-top-color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.woocommerce-page div.woocommerce-info:before { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods { border-bottom: 1px solid ' .
                   esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods li.woocommerce-info { border-top-color: ' .
                   esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment ul.payment_methods li.woocommerce-info:before { color: ' .
                   esc_attr( $entry_titles ) . ';}' . "\n";
        $current_selector = '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"]';
        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );

        $custom .= '.woocommerce-page ul.products li.product a.added_to_cart { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-page form.woocomerce-form p.lost_password a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-page div.woocommerce-message a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-page div.woocommerce-info a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.woocommerce-page form.woocommerce-cart-form a { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= 'h2.alt-shop-blog-title { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= '.page div.alt-shop-blog-large article.hentry a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";
        $custom .= '.page div.alt-shop-blog-small article.hentry a.entry-content-link { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= 'div.offer-product-wrapper div.offer-product-inner h2.offer-product-special-offer { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

        $custom .= 'div.offer-product-wrapper div.offer-product-inner div.offer-product-price ins { color: ' . esc_attr( $entry_titles ) . ';}' . "\n";

//        $current_selector = 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button';
//        $custom .= oblique_coffeeshop_gradient_on_button( $current_selector, $entry_titles );
        $custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button { background-color:' . esc_attr( $entry_titles ) . ';}' . "\n";

	}

	// Body text color
    $body_text_color = get_theme_mod( 'body_text_color', '#8c8c8c' );
	if ( ! empty( $body_text_color ) ) {

	    $custom .= 'body { color: ' . esc_attr( $body_text_color ) . ' !important;}' . "\n";

	    $custom .= 'form.comment-form p label { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

	    $custom .= 'nav.posts-navigation div.nav-links .page-numbers { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

	    $custom .= '.single .comment-body .comment-metadata a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

	    $custom .= '.single-sidebar .widget select { color: ' . esc_attr( $body_text_color ) . ' !important;}' . "\n";

        $custom .= '.single-sidebar .widget_categories ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

        $custom .= '.single-sidebar .widget_tag_cloud .tagcloud a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

        $custom .= '.single-sidebar .widget_archive ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_pages ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_meta ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_nav_menu ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_recent_entries ul li a { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget .search-form label input.search-field::placeholder { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.woocommerce-page nav.navigation .page-numbers { color: ' . esc_attr( $body_text_color ) . ';}' . "\n";

		$custom .= '.woocommerce div.product .woocommerce-tabs { border: 1px solid ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product .woocommerce-tabs ul.tabs li { border: none; border-right: 1px solid ' . esc_attr( $body_text_color ) . ';}' . "\n";
		$custom .= '.woocommerce div.product .woocommerce-tabs .woocommerce-Tabs-panel { border-top: 1px solid ' . esc_attr( $body_text_color ) . ';}' . "\n";

    }

	// Footer color
    $footer_background_color = get_theme_mod( 'footer_background', '#ffffff' );
	if ( ! empty( $footer_background_color ) ) {
	    $custom .= 'footer.site-footer { background-color:' . esc_attr( $footer_background_color ) . ';}' . "\n";
	    $custom .= 'div.footer-svg.svg-block { fill:' . esc_attr( $footer_background_color ) . ';}' . "\n";
    }

	// Header padding
	$branding_padding = get_theme_mod( 'branding_padding', '300' );
	if ( ! empty( $branding_padding ) ) {
		$custom .= 'div.site-branding { padding:' . intval( $branding_padding ) . 'px 0; }' . "\n";
	}

	// Entry background
	$entry_background = get_theme_mod( 'entry_background', '#ffffff');
	if ( ! empty( $entry_background ) ) {
		$custom .= 'div.post-inner { background-color:' . esc_attr( $entry_background ) . ';}' . "\n";

		// Single Sidebar Page
        $custom .= '.single .hentry { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

        $custom .= '.single .single-post-svg { fill: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.single .comment-body { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single .reply a { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single .comment-form input, .single .comment-form textarea { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table caption { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_calendar .calendar_wrap table td a { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a { background-color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-sidebar .widget_tag_cloud .tagcloud a:hover { color:  ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= 'nav.posts-navigation div.nav-links .current { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .hentry {background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .single-post-svg {fill: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.page .comments-area .comment-body { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .comment-body .reply a { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .comment-form input { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.comment-form .form-submit input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.page .comment-form textarea { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.archive .page-header { background-color:' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.archive div.svg-container.svg-block.page-header-svg { fill:' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.search div.search-title-top-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.search header.page-header { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.search div.search-title-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.button { color: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.woocommerce ul.products li.product,' . ' .woocommerce-page ul.products li.product ' .
                   '{ background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.product .post-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product a.add_to_cart_button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.single-product form.cart p.single-product-add-cart-icon { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page ul.products li.product a.button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product .single_add_to_cart_button { color: ' . esc_attr( $entry_background ) . ' !important;}' . "\n";

		$custom .= '.woocommerce-page ul.products li.product p.shop_page_add_cart_icon { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page nav.navigation .current { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce #reviews #comments ol.commentlist li { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce #review_form #respond .form-submit input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.product .post-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_top_svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_wrapper { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.single_product_bottom_svg { fill:' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.related-title-top-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.alt_shop_cat_title_top_svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product h2.related_products_title { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page h2.alt_shop_cat_title { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.single-product div.related-title-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-page div.alt_shop_cat_title_bottom_svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cross-sells ul.products li.product div.post-svg { fill: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cross-sells ul.products li.product div.post-bottom-svg { fill: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= '.woocommerce-cart form.woocommerce-cart-form input[type="submit"]:disabled:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce div.product .woocommerce-tabs ul.tabs li.active { border-bottom: 1px solid ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce-message a.button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page form.woocommerce-form-login input[type="submit"] { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart p.return-to-shop a.button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-page div.woocommerce form.woocommerce-checkout div#payment div.place-order input[type="submit"] { color: ' .
		           esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= '.woocommerce-cart div.cart_totals div.wc-proceed-to-checkout a:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= 'div.alt-shop-blog-title-top-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= 'h2.alt-shop-blog-title { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= 'div.alt-shop-blog-title-bottom-svg { background-color: ' . esc_attr( $entry_background ) . ';}' . "\n";

		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button { color: ' . esc_attr( $entry_background ) . ';}' . "\n";
		$custom .= 'div.offer-product-wrapper div.offer-product-inner a.add_to_cart_button:hover { color: ' . esc_attr( $entry_background ) . ';}' . "\n";

	}

	// Menu icon/leave color
    $menu_icon_color = get_theme_mod( 'menu_icon_color', '#f8f9fb' );
	if ( ! empty( $menu_icon_color ) ) {
	    $custom .= 'div.sidebar-toggle { color:' . esc_attr( $menu_icon_color ) . ';}' . "\n";
    }

    // Site title
    $site_title_color = get_theme_mod( 'site_title_color', '#f9f9f9' );
    if ( ! empty( $site_title_color ) ) {
        $custom .= 'h1.site-title a, h1.site-title a:hover {color:' . esc_attr( $site_title_color ) . ';}' . "\n" ;
    }

    // Site description
	$site_desc_color = get_theme_mod( 'site_desc_color', '#f9f9f9' );
    if ( ! empty( $site_desc_color ) ) {
        $custom .= 'h2.site-description { color:' . esc_attr( $site_desc_color ) . ';}' . "\n";
    }

    // Social color
    $social_color = get_theme_mod( 'social_color', '#f9f9f9' );
    if ( ! empty( $social_color ) ) {
        $custom .= 'nav.social-navigation li a { color:' . esc_attr( $social_color ) . ';}' . "\n";
    }

    // Sidebar background
    $sidebar_background = get_theme_mod( 'sidebar_bg', '#ffffff' );
    if ( ! empty( $sidebar_background ) ) {

        $custom.= 'div.widget-area-visible { background: ' . esc_attr( $sidebar_background ) . ';}' . "\n";
    }

    // Sidebar color
    $sidebar_color = get_theme_mod( 'sidebar_color', '#000000' );
    if( ! empty( $sidebar_color ) ) {

        $custom .= 'div.widget-area-visible, div.widget-area-visible a { color: ' . esc_attr( $sidebar_color ) . ';}' . "\n";

        $custom .= 'div.widget-area-visible nav.sidebar-nav div.slicknav_menu ul.slicknav_nav li.menu-item { border-bottom: 1px solid ' . esc_attr( $sidebar_color ) . ';}' . '\n';
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

	// Secondary Color
	$wp_customize->add_setting(
		'secondary_color',
		array(
			'default'           => '#333333',
			'sanitize_callback' => 'sanitize_hex_color'
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'secondary_color',
			array(
				'label'     => esc_html__('Secondary color', 'oblique_coffeeshop'),
				'section'   => 'colors',
				'priority'  => 12
			)
		)
	);

}
add_action( 'customize_register', 'oblique_coffeeshop_customize_register', 20 );

/**
 * Color
 * Background default color filter
 */
function oblique_coffeeshop_background_filter($input) {
    $input['default-color'] = 'f8f9fb';
    return $input;
}
add_filter( 'oblique_custom_background_args', 'oblique_coffeeshop_background_filter' );

/**
 * Color
 * Primary default color filter
 */
function oblique_coffeeshop_default_primary_color(){
	return '#925D34';
}
add_filter('oblique_primary_color', 'oblique_coffeeshop_default_primary_color');

/**
 * Color
 * Body text default color
 */
function oblique_coffeeshop_body_text_color() {
	return '#8c8c8c';
}
add_filter( 'oblique_body_text_color', 'oblique_coffeeshop_body_text_color' );

/**
 * Color
 * Site title default color
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
 * Footer background color
 */
function oblique_coffeeshop_footer_background_color() {
    return '#ffffff';
}
add_filter( 'oblique_footer_background_color', 'oblique_coffeeshop_footer_background_color' );

/**
 * Color
 * Menu icon default color
 */
function oblique_coffeeshop_menu_icon_color() {
    return '#f8f9fb';
}
add_filter( 'oblique_menu_icon_color', 'oblique_coffeeshop_menu_icon_color' );

/**
 * Color
 * Social icon default color
 */
function oblique_coffeeshop_social_color() {
    return '#f8f9fb';
}
add_filter( 'oblique_social_color', 'oblique_coffeeshop_social_color' );

/**
 * Color
 * Color darken or lighten
 */
function oblique_coffeeshop_darken_color($color, $filter) {

	$filter = max(-255, min(255, $filter));

	$color = str_replace('#', '', $color);
	if (strlen($color) == 3) {
		$color = str_repeat(substr($color,0,1), 2).str_repeat(substr($color,1,1), 2).str_repeat(substr($color,2,1), 2);
	}

	$color_rgb = str_split($color, 2);
	$darken_color = '#';

	foreach ($color_rgb as $rgb_pair) {
		$rgb_pair   = hexdec($rgb_pair); // Convert to decimal
		$rgb_pair   = max(0,min(255,$rgb_pair + $filter)); // Adjust color
		$darken_color .= str_pad(dechex($rgb_pair), 2, '0', STR_PAD_LEFT); // Make two char hex code
	}

	return $darken_color;
}

/**
 * Color
 * Apply gradient on buttons
 *
 * @param $selector - background-color
 * @param $color - -darken/lighten color filter
 */
function oblique_coffeeshop_gradient_on_button( $selector, $color ) {

	$btn_gradient_style = '';

	$new_color = oblique_coffeeshop_darken_color( $color, 1 );

	$btn_gradient_style .= $selector . ' { background: ' .$color . ';' . "\n";
	$btn_gradient_style .= ' background: -moz-linear-gradient(top, ' . $color . ' 0%, ' . $new_color . ' 100%);' . "\n";
	$btn_gradient_style .= ' background: -webkit-linear-gradient(top, ' . $color . ' 0%,' . $new_color . ' 100%);' . "\n";
	$btn_gradient_style .= ' background: linear-gradient(to bottom, ' . $color . ' 0%,' . $new_color. ' 100%);' . "\n";
	$btn_gradient_style .= " filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='" . $color . "', endColorstr='" . $new_color . "',GradientType=0 ); }" . "\n";

	return $btn_gradient_style;
}

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
 * Svg new
 * Post bottom svg
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
 * Svg
 * Archive page title svg
 */
function oblique_coffeeshop_archive_title_svg() {
	echo '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1950 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="archive_title_svg" />
    </svg>';
}
add_action( 'oblique_archive_title_bottom_svg', 'oblique_coffeeshop_archive_title_svg' );

/**
 * Svg
 * Search Results Page title top svg
 */
function oblique_coffeeshop_search_title_top_svg() {
    ?>
	<div class="svg-container svg-block search-title-top-svg">
        <?php oblique_svg_3(); ?>
    </div>
    <?php
}
add_action( 'oblique_search_before_title', 'oblique_coffeeshop_search_title_top_svg' );

/**
 * Svg
 * Search Results Page title bottom svg
 */
function oblique_search_title_bottom_svg() {
	?>
    <div class="svg-container svg-block search-title-bottom-svg">
		<?php
		echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1890" y1="0" x2="0" y2="150" width="100%" height="50" class="archive_title_svg" />
		</svg>';
        ?>
    </div>
	<?php
}
add_action( 'oblique_search_after_title', 'oblique_search_title_bottom_svg' );

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

/**
 * Single content
 * single post bottom svg
 */
function oblique_coffeeshop_single_post_bottom_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1950 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="bottom single_post_bottom_svg" />
		</svg>
	';
}
add_action( 'oblique_single_post_bottom_svg', 'oblique_coffeeshop_single_post_bottom_svg' );

/**
 * Comments
 * changing the default comment form
 */
function oblique_coffeeshop_comments_template() {
    $req = get_option( 'require_name_email' );
    $aria_req = ( $req ? " aria-required='true'" : '' );
    $commenter = wp_get_current_commenter();
    $args = array(
        'title_reply' => esc_html__('Leave us a Message'),
        'comment_notes_before' => '',
        'comment_notes_after' => '',
        'title_reply_before' => '<h3>',
        'title_reply_after' => '</h3>',
        'label_submit' => esc_html__('Submit'),
        'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' =>
                '<p class="comment-form-author"><label for="author">' . esc_html__( 'Name', 'oblique_coffeeshop' ) . '</label><input id="author" name="author" type="text" value="' .
                esc_attr( $commenter['comment_author'] ) . '" size ="30" ' . esc_html( $aria_req ) . '/></p>',

                'email' =>
                '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'oblique_coffeeshop' ) . '</label><input id="email" type="text" value="' .
                esc_attr( $commenter['comment_author'] ) . '" size="30" ' . esc_html( $aria_req ) . ' /></p>',

                'url' =>
                '<p class="comment-form-url"><label for="url">' . esc_html__('Subject','oblique-coffeeshop') . '</label><input id="url" name="url" type="text" value="' .
                esc_attr( $commenter['comment_author_url'] ) . '" /></p>',

        ) ),
        'comment_field' =>
        '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'oblique_coffeeshop' ) . '</label><textarea id="comment" name="comment" cols="45" rows="15" placeholder="' .
        '" aria-required="true"></textarea></p>'
    );

    return $args;
}
add_filter('oblique_comments_args','oblique_coffeeshop_comments_template');

/**
 * Comment respond
 * moving comment field at the end of fields
 */
function wpb_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;
	return $fields;
}
add_filter( 'comment_form_fields', 'wpb_move_comment_field_to_bottom' );

/**
 * SVG
 * changing post bottom svg on single page
 */
function oblique_coffeeshop_single_page_post_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1920 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1920" y1="0" x2="0" y2="150" width="100%" height="50" class="single_page_post_svg" />
		</svg>
	';
}
add_action( 'oblique_single_page_post_svg', 'oblique_coffeeshop_single_page_post_svg' );

/**
 * Single page post tags message
 */
function oblique_coffeeshop_post_tags_message() {
    $args = 'Tags: %1$s';
    return $args;
}
add_filter( 'oblique_post_tags_message', 'oblique_coffeeshop_post_tags_message' );

/**
 * Comments title text
 */
function oblique_coffeeshop_comments_title_text() {
	echo '<h2 class="comments-title">';
	echo 'Comments';
	echo '</h2>';
}
add_action( 'oblique_comments_title', 'oblique_coffeeshop_comments_title_text' );

/**
 * Comments list
 */
function oblique_coffeeshop_comments_list() {
	wp_list_comments( array(
		'style'      => 'ol',
		'short_ping' => true,
		'avatar_size' => 60,
        'reply_text' => 'Reply',
	) );
}
add_action( 'oblique_comments_list', 'oblique_coffeeshop_comments_list' );

/**
 * Main classes
 *
 */
function oblique_coffeeshop_main_classes( $input ) {
	if ( is_active_sidebar( 'single-sidebar' ) ) :
        $input .= ' col-md-8';
    endif;

	return $input;
}
add_filter( 'oblique_main_classes', 'oblique_coffeeshop_main_classes' );

/**
 * Sidebar
 * Register the second sidebar
 */
function oblique_coffeeshop_single_sidebar() {
	register_sidebar( array(
		'name'          => __( 'Single Sidebar', 'oblique-coffeeshop' ),
		'id'            => 'single-sidebar',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'oblique_coffeeshop_single_sidebar' );

/**
 * Sidebar
 * Show the second sidebar
 */
function oblique_coffeeshop_sidebar_on_single(){
    if ( is_active_sidebar( 'single-sidebar' ) ) : ?>
        <aside id="secondary" class="col-md-4 single-sidebar" role="complementary">
            <?php dynamic_sidebar( 'single-sidebar' ); ?>
        </aside><!-- .sidebar .widget-area -->
        <?php
    endif;
}
add_action('oblique_single_sidebar', 'oblique_coffeeshop_sidebar_on_single');

/**
 * WooCommerce
 */
// Remove pages navigation
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);

// Remove sorting results after loop
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );

// Remove sorting results before loop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove drop down sort before loop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remove description on category page
remove_action('woocommerce_archive_description','woocommerce_taxonomy_archive_description',10);

// Remove cross sells
//remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );

/**
 * Remove page title
 */
function oblique_coffeeshop_remove_woo_title(){
    return false;
}
add_filter( 'woocommerce_show_page_title', 'oblique_coffeeshop_remove_woo_title' );

/**
 * Add custom title on shop page
 * title between svg *
 */
function oblique_coffeeshop_shop_title(){

	do_action('oblique_archive_title_top_svg'); ?>

    <header class="page-header">
        <h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
    </header><!-- .page-header -->
    <?php

    /**
     * woocommerce_archive_description hook.
     *
     * @hooked woocommerce_taxonomy_archive_description - 10
     * @hooked woocommerce_product_archive_description - 10
     */
    do_action( 'woocommerce_archive_description' ); ?>

    <div class="svg-container svg-block page-header-svg">
		<?php do_action( 'oblique_archive_title_bottom_svg' ); ?>
    </div>
    <?php

}
add_action( 'woocommerce_before_main_content', 'oblique_coffeeshop_shop_title', 40);

// Remove product rating on shop page
remove_action('woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5 );

/**
 * Adding top svg for item on shop page
 */
function oblique_coffeeshop_product_top_svg(){ ?>
    <div class="svg-container post-svg svg-block">
            <?php echo oblique_svg_3(); ?>
    </div>
    <?php
}
add_action( 'woocommerce_before_shop_loop_item', 'oblique_coffeeshop_product_top_svg', 5 );

/**
 * Adding bottom svg for item on shop page
 */
function oblique_coffeeshop_product_bottom_svg() { ?>
    <div class="svg-container post-bottom-svg svg-block">
               <?php echo svg_new(); ?>
    </div>
    <?php
}
add_action( 'woocommerce_after_shop_loop_item', 'oblique_coffeeshop_product_bottom_svg', 10 );

/**
 * Number the number of products per row
 */
function oblique_coffeeshop_products_per_row() {
    return 3;
}
add_filter( 'loop_shop_columns', 'oblique_coffeeshop_products_per_row' );

/**
 * Change pagination on shop page
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'oblique_coffeeshop_custom_pagination', 10 );

// Change single product price position
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

// Remove categories information from single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Remove reviews on single product page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

// Remove upsells on single product page
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );

/**
 * Show quantity text before quantity form
 */
function oblique_coffeeshop_single_product_quantity_title() {
    echo '<p class="quantity-title">Quantity</p>';
}
add_action( 'woocommerce_before_add_to_cart_quantity', 'oblique_coffeeshop_single_product_quantity_title' );

/**
 * Change the number of related products
 *
 * posts_per_page - related products per page
 * columns - number of columns for related products
 */
function oblique_coffeeshop_related_products( $args ) {

    $args['posts_per_page'] = 4;
    $args['columns'] = 4;

    return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'oblique_coffeeshop_related_products' );

/**
 * Single Product Wrapper
 */
function oblique_coffeeshop_single_product_wrapper() {
    ?>
        <div class="svg-container svg-block single_product_top_svg">
            <?php do_action( 'single_product_top_svg' ); ?>
        </div>
        <div class="single_product_wrapper">
    <?php
}
add_action( 'woocommerce_before_single_product_summary', 'oblique_coffeeshop_single_product_wrapper' );

/**
 * Related Products Title
 */
function oblique_coffeeshop_related_products_title() {

	global $product;
	$related_products = wc_get_related_products( $product->get_id(), 1, $product->get_upsell_ids() );

    ?>
        <div class="svg-container svg-block single_product_bottom_svg">
            <?php do_action( 'single_product_bottom_svg' ); ?>
        </div>
    </div> <!-- Single Product Wrapper -->

    <?php if( $related_products ) : ?>
    <div class="related_products_title_wrapper">
        <div class="svg-container svg-block related-title-top-svg">
                <?php do_action( 'related_products_title_before' ); ?>
        </div>
        <h2 class="related_products_title"><?php echo __( 'Suggested Items', 'oblique_coffeeshop' ); ?></h2>
        <div class="svg-container svg-block related-title-bottom-svg">
            <?php do_action( 'related_products_title_after' ); ?>
        </div>
    </div>
    <?php
    endif;

}
add_action( 'woocommerce_after_single_product_summary', 'oblique_coffeeshop_related_products_title' );

/**
 * Single Product Top SVG
 */
function oblique_coffeeshop_single_product_top_svg() {
	oblique_svg_3();
}
add_action( 'single_product_top_svg', 'oblique_coffeeshop_single_product_top_svg' );

/**
 * Single Product Bottom SVG
 */
function oblique_coffeeshop_single_product_bottom_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1950 150">
		  <g transform="translate(0,-902.36218)"/>
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z" />
		  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
		  <path d="M 0,150 0,0 1925,0"/>
		  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="single_product_bottom_svg_line" />
		</svg>
	';
}
add_action( 'single_product_bottom_svg', 'oblique_coffeeshop_single_product_bottom_svg' );

/**
 * Related Products Title Top SVG
 */
function oblique_coffeeshop_related_title_top_svg() {
	oblique_svg_3();
}
add_action( 'related_products_title_before', 'oblique_coffeeshop_related_title_top_svg' );

/**
 * Related Products Title Bottom SVG
 */
function oblique_coffeeshop_related_title_bottom_svg() {
	echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="related_title_bottom_svg_line" />
		</svg>
	';
}
add_action( 'related_products_title_after', 'oblique_coffeeshop_related_title_bottom_svg' );

// Include template for alt shop page
require_once get_stylesheet_directory() . '/woocommerce_template/functions.php';

/**
 * Header Search
 * Before
 */
function oblique_coffeeshop_before_header_search() {

}

/**
 * Header Search
 * After
 */
function oblique_coffeeshop_after_eader_search() {

}
