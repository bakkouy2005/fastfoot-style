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
    add_theme_support('menus');
}
add_action('after_setup_theme', 'fastfoot_style_setup');

function fastfoot_style_enqueue_assets() {
    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio', array(), '3.4.1', false);

    // Custom styles
    wp_enqueue_style('unique-style', get_template_directory_uri() . '/css/unique.style.css', array(), '1.0', 'all');
    wp_enqueue_style('unique-globals', get_template_directory_uri() . '/css/unique.globals.css', array(), '1.0', 'all');
    wp_enqueue_style('unique-animations', get_template_directory_uri() . '/css/unique.animations.css', array(), '1.0', 'all');

    // Custom scripts
    wp_enqueue_script('unique-script', get_template_directory_uri() . '/js/unique.script.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'fastfoot_style_enqueue_assets');

function registreer_mijn_menu() {
    register_nav_menu('menu', __('menu'));
}
add_action('after_setup_theme', 'registreer_mijn_menu');