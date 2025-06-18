<?php
/**
 * Theme Functions
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme setup function
function fastfoot_style_setup() {
    // Basic theme supports
    add_theme_support('title-tag'); 
    add_theme_support('post-thumbnails'); 
    add_theme_support('block-templates'); 
    add_theme_support('menus');
    

    // Navigation menus
    register_nav_menus(array(
        'menu' => __('Primary Menu', 'fastfoot-style'),
        'footer-menu'  => __('Footer Menu', 'fastfoot-style'),
    ));
}
add_action('init', 'fastfoot_style_setup');
add_action('after_setup_theme', 'fastfoot_style_setup');

// Enqueue styles and scripts
function fastfoot_style_scripts() {
    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio', array(), '3.4.1', false);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4');
    
    // Theme stylesheet
    wp_enqueue_style('fastfoot-style-style', get_stylesheet_uri(), array(), '1.0.0');

    // Tailwind Config
    wp_add_inline_script('tailwindcss', "
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand': '#181d18',
                        'brand-light': '#1f241f'
                    }
                }
            }
        }
    ");
}
add_action('wp_enqueue_scripts', 'fastfoot_style_scripts');

