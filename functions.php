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
    add_theme_support('custom-logo');
    add_theme_support('automatic-feed-links');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Navigation menus
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'fastfoot-style'),
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

// Add custom class to <li> elements in menu
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

// Add custom class to <a> elements in menu
function add_menu_link_class($atts, $item, $args) {
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

// Default menu fallback
function default_menu_fallback() {
    echo '<ul class="flex space-x-8">';
    echo '<li class="text-white hover:text-gray-300"><a href="#">Men</a></li>';
    echo '<li class="text-white hover:text-gray-300"><a href="#">Women</a></li>';
    echo '<li class="text-white hover:text-gray-300"><a href="#">Kids</a></li>';
    echo '<li class="text-white hover:text-gray-300"><a href="#">Sale</a></li>';
    echo '<li class="text-white hover:text-gray-300"><a href="#">Contact</a></li>';
    echo '</ul>';
}
