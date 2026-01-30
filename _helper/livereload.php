<?php

/**
 * Grunt livereload helper
 * @author  Patrick Mauersberger
 * @since   1.0.0
 */

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_script( 'livereload', '//' . $_SERVER['SERVER_NAME'] . ':9003/livereload.js', false, null, true );
} );