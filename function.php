<?php 

// Theme setup function
function fastfoot_style_setup() {
    add_theme_support('title-tag'); 
    add_theme_support('post-thumbnails'); 
    add_theme_support('block-templates'); 
}
add_action('after_setup_theme', 'fastfoot_style_setup');

function fastfoot_style_enqueue_scripts() {
    wp_enqueue_style('fastfoot-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'fastfoot_style_enqueue_scripts');