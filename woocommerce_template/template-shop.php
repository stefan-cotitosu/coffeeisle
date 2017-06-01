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

		$section_1 = get_theme_mod('oblique_coffeeshop_featured_products_category');

		if( $category_name = get_term_by( 'id', $section_1, 'product_cat' ) ){
			//var_dump($category_name->name);
			oblique_coffeeshop_display_woo_cat_title( $category_name->name );
		}

		oblique_coffeeshop_display_woo_cat( $section_1 ); ?>
	</div>

	<!-- TODO: Display product -->

	<div id="main" class="site-main" role="main">

		<?php
//		$section_2 = get_theme_mod('oblique_coffeeshop_cat2');
//		oblique_coffeeshop_display_woo_cat( $section_2 ); ?>

		<?php
//		$section_3 = get_theme_mod('oblique_coffeeshop_cat3');
//		oblique_coffeeshop_display_woo_cat( $section_3 ); ?>

	</div><!-- #main -->
</div><!-- #primary -->


<?php get_footer(); ?>
