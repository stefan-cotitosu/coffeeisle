
/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
/* global wp*/
( function( $ ) {
    'use strict';

    // Header text color.
    wp.customize( 'footer_text_color', function( value ) {
        value.bind( function( to ) {
            jQuery('.footer.site-footer, footer.site-footer a').css('color',to);
        } );
    } );

} )( jQuery );