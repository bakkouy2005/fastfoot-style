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
        'primary-menu' => __('Primary Menu', 'fastfoot-style'),
        'footer-menu'  => __('Footer Menu', 'fastfoot-style'),
    ));
}
add_action('after_setup_theme', 'fastfoot_style_setup');

// Add custom class to menu items
function add_additional_class_on_li($classes, $item, $args) {
    if(isset($args->add_li_class)) {
        $classes[] = $args->add_li_class;
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'add_additional_class_on_li', 1, 3);

// Add custom class to menu links
function add_menu_link_class($atts, $item, $args) {
    $atts['class'] = 'text-white hover:text-gray-300';
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_menu_link_class', 1, 3);

// Enqueue styles and scripts
function fastfoot_style_scripts() {
    // Tailwind CSS
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio', array(), '3.4.1', false);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', array(), '5.15.4');
    
    // Global styles
    wp_enqueue_style('fastfoot-style-global', get_template_directory_uri() . '/global.css', array(), time());
    
    // Theme stylesheet
    wp_enqueue_style('fastfoot-style', get_stylesheet_uri(), array('fastfoot-style-global'), time());

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

function enqueue_theme_styles() {
    wp_enqueue_style('theme-styles', get_template_directory_uri() . '/src/style.css', array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'enqueue_theme_styles');

// Add image quality improvements
add_filter('jpeg_quality', function($quality) {
    return 100;
});

add_filter('wp_editor_set_quality', function($quality) {
    return 100;
});

// Enable big image size threshold
add_filter('big_image_size_threshold', '__return_false');

// Ensure jQuery is loaded
function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

// Use custom template for single products
function custom_product_template($template) {
    if (is_singular('product')) {
        $template = get_template_directory() . '/product-template.php';
    }
    return $template;
}
add_filter('template_include', 'custom_product_template');

// Add custom product fields for personalization
add_action('woocommerce_product_options_general_product_data', 'add_personalization_fields');
function add_personalization_fields() {
    global $woocommerce, $post;

    echo '<div class="options_group">';
    
    // Enable personalization checkbox
    woocommerce_wp_checkbox(array(
        'id' => '_allows_personalization',
        'label' => 'Allow Personalization',
        'description' => 'Check this to enable name, number, size and badge options'
    ));

    echo '</div>';
}

// Save the custom fields
add_action('woocommerce_process_product_meta', 'save_personalization_fields');
function save_personalization_fields($post_id) {
    $allows_personalization = isset($_POST['_allows_personalization']) ? 'yes' : 'no';
    update_post_meta($post_id, '_allows_personalization', $allows_personalization);
}

// Add personalization data to cart item
add_filter('woocommerce_add_cart_item_data', 'add_personalization_to_cart_item', 10, 3);
function add_personalization_to_cart_item($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['personalization'])) {
        $cart_item_data['personalization'] = array(
            'name' => sanitize_text_field($_POST['personalization']['name'] ?? ''),
            'number' => sanitize_text_field($_POST['personalization']['number'] ?? ''),
            'size' => sanitize_text_field($_POST['personalization']['size'] ?? ''),
            'badge' => sanitize_text_field($_POST['personalization']['badge'] ?? '')
        );
        
        // Make each personalized item unique in cart
        $cart_item_data['unique_key'] = md5(serialize($cart_item_data['personalization']));
    }
    return $cart_item_data;
}

// Display personalization data in cart
add_filter('woocommerce_get_item_data', 'display_personalization_cart_data', 10, 2);
function display_personalization_cart_data($item_data, $cart_item) {
    if (isset($cart_item['personalization'])) {
        foreach ($cart_item['personalization'] as $key => $value) {
            if (!empty($value)) {
                $item_data[] = array(
                    'key' => ucfirst($key),
                    'value' => wc_clean($value)
                );
            }
        }
    }
    return $item_data;
}

// Save personalization data to order
add_action('woocommerce_checkout_create_order_line_item', 'add_personalization_to_order_items', 10, 4);
function add_personalization_to_order_items($item, $cart_item_key, $values, $order) {
    if (isset($values['personalization'])) {
        foreach ($values['personalization'] as $key => $value) {
            if (!empty($value)) {
                $item->add_meta_data(ucfirst($key), $value);
            }
        }
    }
}

