<?php
/**
* The template used for displaying Offer Product on Alt Shop Page, Blog section
*
* @package Oblique Coffeeshop
*/
?>
<div class="special-offer-wrapper">
<div class="svg-container svg-block alt-shop-special-offer-top-svg">
	<?php oblique_svg_3(); ?>
</div>
<div class="offer-product-wrapper">
    <?php the_post_thumbnail( 'special_offer_thumbnail_size' ); ?>
    <div class="offer-product-inner">
        <h2 class="offer-product-special-offer">Special Offer</h2>
        <h3 class="offer-product-title"><?php echo get_the_title(); ?></h3>
        <?php
            global $product;
            $oblique_coffeeshop_offer_product_price = $product->get_price_html();
        ?>
        <div class="offer-product-price"><?php echo $oblique_coffeeshop_offer_product_price ?></div>
        <?php woocommerce_template_loop_add_to_cart(); ?>
    </div>
</div>
<div class="svg-container svg-block alt-shop-special-offer-bottom-svg">
	<?php oblique_svg_1(); ?>
</div>
</div>