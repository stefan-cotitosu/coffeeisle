<?php
/**
 * Template Name: Alt Shop Template
 *
 * The template for shop page.
 *
 * @package oblique-coffeeshop
 * @since 1.0
 */
get_header(); ?>

    <div id="primary" class="content-area woocommerce-page woocommerce">
        <div id="main" class="site-main" role="main">
            <?php
            $section_1 = get_theme_mod('oblique_coffeeshop_featured_products_category_1' );
            if( $category_name = get_term_by( 'id', $section_1, 'product_cat' ) ){
                //var_dump($category_name->name);
                oblique_coffeeshop_display_woo_cat_title( $category_name->name );
            }
            oblique_coffeeshop_display_woo_cat( $section_1 ); ?>
        </div><!-- #main -->
    </div><!-- #primary -->
</div><!-- container content-wrapper -->

	<!-- TODO: Display product -->
    <?php
    $offer_product_category = get_theme_mod( 'oblique_coffeeshop_offer_product_category' );
    oblique_coffeeshop_display_offer_product( $offer_product_category );
    ?>

<div class="container content-wrapper">
    <div id="primary" class="content-area woocommerce-page woocommerce">
        <div id="main" class="site-main" role="main">

            <?php
            $section_2 = get_theme_mod( 'oblique_coffeeshop_featured_products_category_2' );
            if( $category_name = get_term_by( 'id', $section_2, 'product_cat' ) ) {
                oblique_coffeeshop_display_woo_cat_title( $category_name->name );
            }

            oblique_coffeeshop_display_woo_cat( $section_2 ); ?>

            <?php
            $section_3 = get_theme_mod( 'oblique_coffeeshop_featured_products_category_3' );
            if( $category_name = get_term_by( 'id', $section_3, 'product_cat' ) ) {
                oblique_coffeeshop_display_woo_cat_title( $category_name->name );
            }
            //add_filter( 'oblique_coffeeshop_cat_item_number', 4 );
            oblique_coffeeshop_display_woo_cat( $section_3 ); ?>

            <!-- TODO: Display 3 Blog Posts -->
            <?php oblique_coffeeshop_display_alt_shop_blog_section(); ?>

        </div><!-- #main -->
    </div><!-- #primary -->


<?php get_footer(); ?>
