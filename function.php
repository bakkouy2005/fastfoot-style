<?php 
/** 
 * Theme Functions
 * 
 */

// Theme setup function
function fastfoot_style_setup() {
    add_theme_support('title-tag'); 
    add_theme_support('post-thumbnails'); 
    add_theme_support('block-templates'); 
    
    // Register navigation menus
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'fastfoot-style'),
        )
    );
}
add_action('after_setup_theme', 'fastfoot_style_setup');

// Enqueue scripts and styles
function fastfoot_style_scripts() {
    wp_enqueue_style('fastfoot-style-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'fastfoot_style_scripts');
