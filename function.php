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
    
    // Register navigation menus
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'fastfoot-style'),
        )
    );
}
add_action('after_setup_theme', 'fastfoot_style_setup');

function registreer_mijn_menu() {
    register_nav_menu('menu', __('menu'));
}
add_action('after_setup_theme', 'registreer_mijn_menu');


// Enqueue scripts and styles
function fastfoot_style_scripts() {
    wp_enqueue_style('fastfoot-style-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'fastfoot_style_scripts');

// Register Navigation Menus
function register_my_menus() {
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'fastfoot-style'),
    ));
}
add_action('init', 'register_my_menus');

// Add custom classes to menu items
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

// Add custom classes to menu links
function add_menu_link_class($atts, $item, $args) {
    if (property_exists($args, 'link_class')) {
        $atts['class'] = $args->link_class;
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);
