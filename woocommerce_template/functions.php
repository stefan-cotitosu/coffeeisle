<?php

/**
 * Display products from category
 * @param $ids_array - category for the products to be shown
 */
function oblique_coffeeshop_display_woo_cat( $ids_array, $posts_per_page = null ) {

    $default_posts_per_page = 3;
    if ( !empty($posts_per_page) ) {
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
	if( !empty( $ids_array ) ){
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
 * @param $wp_customize
 */
function oblique_coffeeshop_alt_woo_register( $wp_customize ) {

	$wp_customize->add_section( 'oblique_coffeeshop_featured_products', array(
		'title'       => esc_html__( 'Featured products', 'oblique-coffeeshop' ),
		'priority'    => apply_filters( 'oblique_coffeeshop_section_priority', 15, 'oblique_coffeeshop_featured_products' ),
	) );

	$wp_customize->add_setting( 'oblique_coffeeshop_featured_products_category_1',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'oblique_coffeeshop_featured_products_category_1',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products first category', 'oblique-coffeeshop' ),
			'section' => 'oblique_coffeeshop_featured_products',
			'choices' => oblique_coffeeshop_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting( 'oblique_coffeeshop_offer_product_category',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'oblique_coffeeshop_offer_product_category',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Offer product category', 'oblique-coffeeshop' ),
			'section' => 'oblique_coffeeshop_featured_products',
			'choices' => oblique_coffeeshop_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting( 'oblique_coffeeshop_featured_products_category_2',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'oblique_coffeeshop_featured_products_category_2',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products second category', 'oblique-coffeeshop' ),
			'section' => 'oblique_coffeeshop_featured_products',
			'choices' => oblique_coffeeshop_get_woo_categories( true ),
		)
	);

	$wp_customize->add_setting( 'oblique_coffeeshop_featured_products_category_3',
		array(
			'default'           => '-',
		)
	);
	$wp_customize->add_control(
		'oblique_coffeeshop_featured_products_category_3',
		array(
			'type' => 'select',
			'label' => esc_html__( 'Products third category', 'oblique-coffeeshop' ),
			'section' => 'oblique_coffeeshop_featured_products',
			'choices' => oblique_coffeeshop_get_woo_categories( true ),
		)
	);

}
add_action( 'customize_register', 'oblique_coffeeshop_alt_woo_register', 20 );

/**
 * Categories to be displayed in customizer
 *
 * @param bool $placeholder
 *
 * @return array
 */
function oblique_coffeeshop_get_woo_categories( $placeholder = true ) {

	$oblique_coffeeshop_prod_categories_array = $placeholder === true ? array(
		'-' => esc_html__( 'Select category','oblique-coffeeshop' ),
	) : array();
	if ( ! class_exists( 'WooCommerce' ) ) {
		return $oblique_coffeeshop_prod_categories_array;
	}
	$oblique_coffeeshop_prod_categories = get_categories( array(
		'taxonomy' => 'product_cat',
		'hide_empty' => 0,
		'title_li' => '',
	) );
	if ( ! empty( $oblique_coffeeshop_prod_categories ) ) {
		foreach ( $oblique_coffeeshop_prod_categories as $oblique_coffeeshop_prod_cat ) {
			if ( ! empty( $oblique_coffeeshop_prod_cat->term_id ) && ! empty( $oblique_coffeeshop_prod_cat->name ) ) {
				$oblique_coffeeshop_prod_categories_array[ $oblique_coffeeshop_prod_cat->term_id ] = $oblique_coffeeshop_prod_cat->name;
			}
		}
	}
	$oblique_coffeeshop_prod_categories_array['none'] = esc_html__( 'None', 'oblique-coffeeshop' );
	return $oblique_coffeeshop_prod_categories_array;
}

/**
 * Display alt shop page category name
 */
function oblique_coffeeshop_display_woo_cat_title( $woo_cat_name ) {

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
 */
function oblique_coffeeshop_display_offer_product( $cat_ids_array ) {

    $params = array(
            'post_type'         => 'product',
            'posts_per_page'    => 1,
            'meta_query'        => array(
                    array(
                            'key' => '_thumbnail_id'
                    )
            )
    );

    if ( ! empty( $cat_ids_array ) ) {

        $params['tax_query'] = array(
                array(
                        'taxonomy'  => 'product_cat',
                        'field'     => 'term_id',
                        'terms'     => $cat_ids_array
                )
        );
    }

    $product_offer_loop = new WP_Query( $params );

    if ( $product_offer_loop->have_posts() ) {
        ?>
            <ul class="products offer_product">
        <?php
            do_action( 'oblique_coffeeshop_before_offer_product' );
            while ( $product_offer_loop->have_posts() ) {
                $product_offer_loop->the_post();
                wc_get_template_part( 'content', 'product' );
            }
            wp_reset_postdata();
            do_action( 'oblique_coffeeshop_after_offer_product' );
        ?>
            </ul>
        <?php
    }

}

/**
 * Blog Section on Alt Shop Template
 */
function oblique_coffeeshop_display_alt_shop_blog_section() {

//    $category_list_args = array(
//            'type' => 'post'
//    );
//    $posts_category_list = get_categories( $category_list_args );
//    var_dump($posts_category_list);

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

        if ( $i==0 ) {
            get_template_part('template-parts/content', 'big');
	        $i++;
        } else {
            if( $has_col == 0 ) {
                echo '<div class="col-md-4 alt-shop-blog-small">';
                $has_col = 1;
            }
	        get_template_part('content' );
            $i++;
            if( $i == 3 ) {
                echo '</div><!-- /.col-md-4 -->';
            }
        }


        endwhile;

        wp_reset_postdata();

    endif;

}

// Change the Blog Section large post thumbnail size
function oblique_coffeeshop_alt_shop_blog_large_thumb_size() {
    remove_image_size( 'oblique-entry-thumb' );
    add_image_size( 'oblique-coffeeshop-blog-large-thumb', 745 );
}
add_action( 'after_setup_theme', 'oblique_coffeeshop_alt_shop_blog_large_thumb_size', 15 );
