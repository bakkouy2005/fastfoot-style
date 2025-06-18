<?php 

// Theme setup function
function fastfoot_style_setup() {
    add_theme_support('title-tag'); 
    add_theme_support('post-thumbnails'); 
    add_theme_support('block-templates'); 
}
add_action('after_setup_theme', 'fastfoot_style_setup');
