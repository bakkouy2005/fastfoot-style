<?php 
/** 
 * Theme Functions
 * 
 */

 function fastfoot_style_enqueue_assets() {
    // Material Design Bootstrap
    wp_enqueue_style('mdbootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/8.2.0/mdb.min.css', array(), '8.2.0', 'all');

    // Custom styles
    wp_enqueue_style('unique-style', get_template_directory_uri() . '/css/unique.style.css', array(), '1.0', 'all');
    wp_enqueue_style('unique-globals', get_template_directory_uri() . '/css/unique.globals.css', array(), '1.0', 'all');
    wp_enqueue_style('unique-animations', get_template_directory_uri() . '/css/unique.animations.css', array(), '1.0', 'all');

    // Custom scripts
    wp_enqueue_script('unique-script', get_template_directory_uri() . '/js/unique.script.js', array('jquery'), '1.0', true);
}

// Add custom classes to menu items

// Default menu fallback