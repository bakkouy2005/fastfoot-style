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
            'primary-menu' => esc_html__('Primary Menu', 'fastfoot-style'),
        )
    );
}
add_action('after_setup_theme', 'fastfoot_style_setup');

// Enqueue scripts and styles
function registreer_mijn_menu() {
    register_nav_menu('menu', __('menu'));
}
add_action('after_setup_theme', 'registreer_mijn_menu');

// Add custom classes to menu items

// Default menu fallback