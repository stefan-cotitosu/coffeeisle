<?php
/**
 * WooCommerce functions used in child theme.
 *
 * @package coffeeisle
 * @since 1.0.0
 */

/**
 * WooCommerce
 */
/**
 * Replace parent theme functions binded to woo hooks
 *
 * @since 1.0.0
 */
function coffeeisle_remove_woo_functions() {
	/* Shop Page */
	remove_action( 'woocommerce_before_main_content', 'oblique_shop_title', 40 );
	add_action( 'woocommerce_before_shop_loop_item', 'oblique_product_top_svg', 5 );
	add_action( 'woocommerce_after_shop_loop_item', 'oblique_product_bottom_svg', 10 );

	/* Single Product Page */
	remove_action( 'oblique_single_product_bottom_svg', 'oblique_svg_5' );
	remove_action( 'oblique_related_products_title_after', 'oblique_svg_5' );
}
add_action( 'after_setup_theme', 'coffeeisle_remove_woo_functions', 15 );

// Remove pages navigation
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0 );

// Remove sorting results after loop
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_result_count', 20 );

// Remove sorting results before loop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

// Remove drop down sort before loop
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

// Remove description on category page
remove_action( 'woocommerce_archive_description','woocommerce_taxonomy_archive_description',10 );

/**
 * Remove page title
 *
 * @since 1.0.0
 */
function coffeeisle_remove_woo_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'coffeeisle_remove_woo_title' );

/**
 * Add custom title on shop page
 * title between svg
 *
 * @since 1.0.0
 */
function coffeeisle_shop_title() {

	do_action( 'oblique_archive_title_top_svg' ); ?>

	<header class="page-header">
		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>
	</header><!-- .page-header -->
	<?php

	/**
	 * WooCommerce_archive_description hook.
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
add_action( 'woocommerce_before_main_content', 'coffeeisle_shop_title', 40 );

// Remove product rating on shop page
remove_action( 'woocommerce_after_shop_loop_item_title','woocommerce_template_loop_rating', 5 );

/**
 * Adding top svg for item on shop page
 *
 * @since 1.0.0
 */
function coffeeisle_product_top_svg() {
	?>
	<div class="svg-container post-svg svg-block">
		<?php echo oblique_svg_3(); ?>
	</div>
	<?php
}
add_action( 'woocommerce_before_shop_loop_item', 'coffeeisle_product_top_svg', 5 );

/**
 * Adding bottom svg for item on shop page
 *
 * @since 1.0.0
 */
function coffeeisle_product_bottom_svg() {
	?>
	<div class="svg-container post-bottom-svg svg-block">
		<?php echo svg_new(); ?>
	</div>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item', 'coffeeisle_product_bottom_svg', 10 );

/**
 * Number the number of products per row
 *
 * @since 1.0.0
 */
function coffeeisle_products_per_row() {
	return 3;
}
add_filter( 'loop_shop_columns', 'coffeeisle_products_per_row' );

/**
 * Change pagination on shop page
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
add_action( 'woocommerce_after_shop_loop', 'coffeeisle_custom_pagination', 10 );

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
 * Change the number of related products
 *
 * Variables:
 * posts_per_page - related products per page
 * columns - number of columns for related products
 *
 * @since 1.0.0
 */
function coffeeisle_related_products( $args ) {

	$args['posts_per_page'] = 4;
	$args['columns'] = 4;

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'coffeeisle_related_products' );

/**
 * Single Product Bottom SVG
 *
 * @since 1.0.0
 */
function coffeeisle_single_product_bottom_svg() {
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
add_action( 'oblique_single_product_bottom_svg', 'coffeeisle_single_product_bottom_svg' );

/**
 * Related Products Title Bottom SVG
 *
 * @since 1.0.0
 */
function coffeeisle_related_title_bottom_svg() {
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
add_action( 'oblique_related_products_title_after', 'coffeeisle_related_title_bottom_svg' );

/**
 * Header Search Icon
 *
 * @since 1.0.0
 */
function coffeeisle_search_icon() {
	?>
	<div class="nav_search_icon">
	</div>
	<?php
}
add_action( 'oblique_nav_search', 'coffeeisle_search_icon' );

/**
 * Alt Shop Page template
 */

/**
 * Display products from category
 *
 * @param $ids_array - category for the products to be shown
 * @since 1.0.0
 */
function coffeeisle_display_woo_cat( $ids_array, $posts_per_page = null ) {

	$default_posts_per_page = 3;
	if ( ! empty( $posts_per_page ) ) {
		$default_posts_per_page = $posts_per_page;
	}

	$args = array(
		'post_type' => 'product',
		'posts_per_page' => $default_posts_per_page,
		'meta_query'     => array(
			array(
				'key' => '_thumbnail_id',
			),
		),
	);
	if ( ! empty( $ids_array ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'term_id',
				'terms'    => $ids_array,
			),
		);
	}

	$loop = new WP_Query( $args );

	if ( $loop->have_posts() ) { ?>
	<ul class="products"> <?php
	while ( $loop->have_posts() ) {
		$loop->the_post();
		wc_get_template_part( 'content', 'product' );
	}
		wp_reset_postdata();
		?>
	</ul>
	<?php
	}
}

/**
 * Adding control for selecting category
 * Products from this category will be listed in the section
 *
 * @param $wp_customize
 * @since 1.0.0
 */
function coffeeisle_alt_woo_register( $wp_customize ) {

	$wp_customize->add_section( 'coffeeisle_featured_products', array(
		'title'       => esc_html__( 'Featured products', 'coffeeisle' ),
		'priority'    => apply_filters( 'coffeeisle_section_priority', 15, 'coffeeisle_featured_products' ),
	) );

	$wp_customize->add_setting( 'coffeeisle_featured_products_category_1',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_featured_products_category_1',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products first category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting( 'coffeeisle_offer_product_category',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_offer_product_category',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Offer product category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting( 'coffeeisle_featured_products_category_2',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_featured_products_category_2',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products second category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting( 'coffeeisle_featured_products_category_3',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'coffeeisle_featured_products_category_3',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products third category', 'coffeeisle' ),
			'section' => 'coffeeisle_featured_products',
			'choices' => coffeeisle_get_woo_categories( true ),
		)
	);

}
add_action( 'customize_register', 'coffeeisle_alt_woo_register', 20 );

/**
 * Categories to be displayed in customizer
 *
 * @param bool $placeholder
 *
 * @return array
 * @since 1.0.0
 */
function coffeeisle_get_woo_categories( $placeholder = true ) {

	$coffeeisle_prod_categories_array = $placeholder === true ? array(
		'-' => esc_html__( 'Select category','coffeeisle' ),
	) : array();
	if ( ! class_exists( 'WooCommerce' ) ) {
		return $coffeeisle_prod_categories_array;
	}
	$coffeeisle_prod_categories = get_categories( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => 0,
		'title_li' => '',
	) );
	if ( ! empty( $coffeeisle_prod_categories ) ) {
		foreach ( $coffeeisle_prod_categories as $coffeeisle_prod_cat ) {
			if ( ! empty( $coffeeisle_prod_cat->term_id ) && ! empty( $coffeeisle_prod_cat->name ) ) {
				$coffeeisle_prod_categories_array[ $coffeeisle_prod_cat->term_id ] = $coffeeisle_prod_cat->name;
			}
		}
	}
	$coffeeisle_prod_categories_array['none'] = esc_html__( 'None', 'coffeeisle' );
	return $coffeeisle_prod_categories_array;
}

/**
 * Display alt shop page category name
 *
 * @since 1.0.0
 */
function coffeeisle_display_woo_cat_title( $woo_cat_name ) {

	?>

	<div class="svg-container svg-block alt_shop_cat_title_top_svg">
		<?php oblique_svg_3(); ?>
	</div>
	<h2 class="alt_shop_cat_title"><?php echo $woo_cat_name; ?></h2>
	<div class="svg-container svg-block alt_shop_cat_title_bottom_svg">
		<?php
		echo '
		<svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
			<g transform="translate(0,-902.36218)"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
			  <path d="m 1925,0 0,150 -1925,0"/>
			  <line x1="1950" y1="0" x2="0" y2="150" width="100%" height="50" class="alt_shop_cat_title_bottom_svg_line" />
		</svg>';
		?>
	</div>

	<?php
}

/**
 * Offer Product Display
 *
 * @since 1.0.0
 */
function coffeeisle_display_offer_product( $cat_ids_array ) {

	$params = array(
			'post_type'         => 'product',
			'posts_per_page'    => 1,
			'meta_query'        => array(
					array(
							'key' => '_thumbnail_id',
					),
			),
	);

	if ( ! empty( $cat_ids_array ) ) {

		$params['tax_query'] = array(
				array(
						'taxonomy'  => 'product_cat',
						'field'     => 'term_id',
						'terms'     => $cat_ids_array,
				),
		);
	}

	$product_offer_loop = new WP_Query( $params );

	if ( $product_offer_loop->have_posts() ) {
			do_action( 'coffeeisle_before_offer_product' );
		while ( $product_offer_loop->have_posts() ) {
			$product_offer_loop->the_post();

			get_template_part( 'template-parts/content','offer-product' );
		}
			wp_reset_postdata();
			do_action( 'coffeeisle_after_offer_product' );
	}
}

/** Set Special Offer Thumbnail size
 *
 * @since 1.0.0
 */
function coffeeisle_special_offer_thumbnail() {
	add_image_size( 'special_offer_thumbnail_size', 700, 700, true );
}
add_action( 'after_setup_theme', 'coffeeisle_special_offer_thumbnail', 15 );

/**
 * Blog Section on Alt Shop Template
 *
 * @since 1.0.0
 */
function coffeeisle_display_alt_shop_blog_section() {

	// Blog title
	?>
	<div class="svg-container svg-block alt-shop-blog-title-top-svg">
		<?php oblique_svg_3(); ?>
	</div>
	<h2 class="alt-shop-blog-title">Blog</h2>
	<div class="svg-container svg-block alt-shop-blog-title-bottom-svg">
		<?php echo '
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 1890 150">
            <g transform="translate(0,-902.36218)"/>
            <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
            <path d="m 898.41609,-33.21176 0.01,0 -0.005,-0.009 -0.005,0.009 z"/>
            <path d="m 1925,0 0,150 -1925,0"/>
            <line x1="1890" y1="0" x2="0" y2="150" width="100%" height="50" class="archive_title_svg" />
        </svg>';?>
	</div>
	<?php

	$loop = new WP_Query( array(
		'posts_per_page' => 3,
		'ignore_sticky_posts' => true,
	) );

	if ( $loop->have_posts() ) :

		$i = 0;
		$has_col = 0;
		while ( $loop->have_posts() ) : $loop->the_post();

			if ( $i == 0 ) {
				get_template_part( 'template-parts/content', 'big' );
				$i++;
			} else {
				if ( $has_col == 0 ) {
					echo '<div class="col-md-4 alt-shop-blog-small">';
					$has_col = 1;
				}
				get_template_part( 'content' );
				$i++;
				if ( $i == 3 ) {
					echo '</div><!-- /.col-md-4 -->';
				}
			}

		endwhile;

		wp_reset_postdata();

	endif;
}

/**
 * Change the Blog Section large post thumbnail size
 *
 * @since 1.0.0
 */
function coffeeisle_alt_shop_blog_large_thumb_size() {
	remove_image_size( 'oblique-entry-thumb' );
	add_image_size( 'coffeeisle-blog-large-thumb', 745 );
}
add_action( 'after_setup_theme', 'coffeeisle_alt_shop_blog_large_thumb_size', 15 );
