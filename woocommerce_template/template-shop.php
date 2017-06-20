<?php
/**
 * Template Name: Alt Shop Template
 *
 * The template for shop page.
 *
 * @package coffeeisle
 * @since 1.0
 */

get_header();

if ( class_exists( 'WooCommerce' ) ) :
?>

	<div id="primary" class="content-area woocommerce-page woocommerce">
		<div id="main" class="site-main" role="main">
			<?php
			$section_1 = get_theme_mod( 'coffeeisle_featured_products_category_1' );
			$category_name = get_term_by( 'id', $section_1, 'product_cat' );
			if ( $category_name ) {
				coffeeisle_display_woo_cat_title( $category_name->name );
			}
			coffeeisle_display_woo_cat( $section_1 ); ?>
		</div><!-- #main -->
	</div><!-- #primary -->
</div><!-- container content-wrapper -->

	<?php
	$offer_product_category = get_theme_mod( 'coffeeisle_offer_product_category' );
	coffeeisle_display_offer_product( $offer_product_category );
	?>

<div class="container content-wrapper">
	<div id="primary" class="content-area woocommerce-page woocommerce">
		<div id="main" class="site-main" role="main">

			<?php
			$section_2 = get_theme_mod( 'coffeeisle_featured_products_category_2' );
			$category_name = get_term_by( 'id', $section_2, 'product_cat' );
			if ( $category_name ) {
				coffeeisle_display_woo_cat_title( $category_name->name );
			}
			coffeeisle_display_woo_cat( $section_2 ); ?>

			<?php
			$section_3 = get_theme_mod( 'coffeeisle_featured_products_category_3' );
			$category_name = get_term_by( 'id', $section_3, 'product_cat' );
			if ( $category_name ) {
				coffeeisle_display_woo_cat_title( $category_name->name );
			}
			coffeeisle_display_woo_cat( $section_3 ); ?>

            <?php
            $hide_blog_on_alt = get_theme_mod( 'coffeeisle_hide_blog_on_alt_shop' );
            if ( ! $hide_blog_on_alt ) {
	            coffeeisle_display_alt_shop_blog_section();
            }
            ?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php
else: ?>
    <a href="<?php echo esc_attr( 'https://wordpress.org/plugins/woocommerce/' ); ?>" target="_blank"><h2 class="need-woocommerce"><?php echo esc_html__( 'Please install WooCommerce plugin' ); ?></h2></a>

<?php
endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
