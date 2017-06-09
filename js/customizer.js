/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
/* global wp*/
( function( $ ) {
    'use strict';
// Site title and description.

    wp.customize('entry_titles', function(value) {
        value.bind(function( to ) {
            if( to !== '' ) {
                $('.home article.post div.post-inner a.entry-content-link').css('color', to );
            }
        });
    });

} )( jQuery );