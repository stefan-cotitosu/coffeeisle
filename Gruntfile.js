// jshint node:true

module.exports = function( grunt ) {
    'use strict';

    var loader = require( 'load-project-config' ),
        config = require( 'grunt-theme-fleet' );
    config = config();
    config.files.php.push( '!inc/admin/**/*.php' );
    config.files.php.push( '!class-tgm-plugin-activation.php' );
    config.files.js.push( '!inc/admin/**/*.js' );
    config.files.js.push( '!html5shiv.js' );
    config.files.js.push( '!imagesloaded.pkgd.js' );
    config.files.js.push( '!imagesloaded.pkgd.min.js' );
    config.files.js.push( '!jquery.fitvids.js' );
    config.files.js.push( '!jquery.slicknav.js' );
    config.files.js.push( '!main.js' );
    config.files.js.push( '!masonry-init.js' );
    config.files.js.push( '!navigation.js' );
    config.files.js.push( '!parallax.js' );
    config.files.js.push( '!skip-link-focus-fix.js' );
    loader( grunt, config ).init();
};