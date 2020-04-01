<?php
add_action( 'wp_enqueue_scripts', 'beebo_enqueue_scripts' );
function beebo_enqueue_scripts() {
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array(),
        wp_get_theme()->get('Version')
    );
    // wp_dequeue_style( 'wp-block-library' );
    // wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'beebo_enqueue_scripts_last', 100);
function beebo_enqueue_scripts_last() {
    wp_dequeue_style( 'twentynineteen-print-style' );
}
?>