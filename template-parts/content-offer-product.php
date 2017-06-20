<?php
/**
 * The template used for displaying Offer Product on Alt Shop Page, Blog section
 *
 * @package Coffeesile
 * @since 1.0.0
 */
?>
<div class="special-offer-wrapper">
<div class="svg-container svg-block alt-shop-special-offer-top-svg">
	<?php oblique_svg_3(); ?>
</div>
<div class="offer-product-wrapper">
	<?php the_post_thumbnail( 'special_offer_thumbnail_size' ); ?>
	<div class="offer-product-inner">
		<h2 class="offer-product-special-offer"><?php echo esc_html__( 'Special Offer' ); ?></h2>
		<h3 class="offer-product-title"><?php the_title(); ?></h3>
		<?php
			global $product;
			$coffeeisle_offer_product_price = $product->get_price_html();
		?>
		<div class="offer-product-price"><?php if ( ! empty( $coffeeisle_offer_product_price ) ) { echo wp_kses_post( $coffeeisle_offer_product_price ); } ?></div>
		<?php woocommerce_template_loop_add_to_cart(); ?>
	</div>
</div>
<div class="svg-container svg-block alt-shop-special-offer-bottom-svg">
	<?php oblique_svg_1(); ?>
</div>
</div>
