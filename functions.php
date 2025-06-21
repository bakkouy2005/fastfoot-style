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

// Add custom product fields for personalization options
add_action('woocommerce_product_options_general_product_data', 'add_personalization_fields');
function add_personalization_fields() {
    global $woocommerce, $post;

    echo '<div class="options_group">';
    
    // Personalization Costs
    woocommerce_wp_text_input(array(
        'id' => '_name_number_price',
        'label' => 'Name/Number Price',
        'description' => 'Extra cost for adding a name and/or number (leave empty for no charge)',
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '0.01',
            'min' => '0'
        ),
        'desc_tip' => true,
        'placeholder' => '0.00'
    ));

    woocommerce_wp_text_input(array(
        'id' => '_league_badge_price',
        'label' => 'League Badge Price',
        'description' => 'Extra cost for adding a league badge (leave empty for no charge)',
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '0.01',
            'min' => '0'
        ),
        'desc_tip' => true,
        'placeholder' => '0.00'
    ));

    woocommerce_wp_text_input(array(
        'id' => '_ucl_badge_price',
        'label' => 'UCL Badge Price',
        'description' => 'Extra cost for adding a UCL badge (leave empty for no charge)',
        'type' => 'number',
        'custom_attributes' => array(
            'step' => '0.01',
            'min' => '0'
        ),
        'desc_tip' => true,
        'placeholder' => '0.00'
    ));

    // Available Sizes
    $size_options = array(
        'XS' => 'XS',
        'S' => 'S',
        'M' => 'M',
        'L' => 'L',
        'XL' => 'XL',
        'XXL' => 'XXL'
    );
    
    // Get saved sizes
    $saved_sizes = get_post_meta($post->ID, '_available_sizes', true);
    if (!is_array($saved_sizes)) {
        $saved_sizes = array();
    }
    
    echo '<p class="form-field _available_sizes_field">
        <label for="_available_sizes">Available Sizes</label>
        <select name="_available_sizes[]" id="_available_sizes" class="select2-field" multiple="multiple" style="width: 50%;">';
    
    foreach ($size_options as $key => $label) {
        echo '<option value="' . esc_attr($key) . '" ' . (in_array($key, $saved_sizes) ? 'selected="selected"' : '') . '>' . esc_html($label) . '</option>';
    }
    
    echo '</select>
        <span class="description">Select which sizes are available for this product</span>
    </p>';

    // Available Badges
    $badge_options = array(
        'no_badge' => 'No badge',
        'league_badge' => 'League badge',
        'ucl_badge' => 'UCL badge'
    );
    
    // Get saved badges
    $saved_badges = get_post_meta($post->ID, '_available_badges', true);
    if (!is_array($saved_badges)) {
        $saved_badges = array();
    }
    
    echo '<p class="form-field _available_badges_field">
        <label for="_available_badges">Available Badges</label>
        <select name="_available_badges[]" id="_available_badges" class="select2-field" multiple="multiple" style="width: 50%;">';
    
    foreach ($badge_options as $key => $label) {
        echo '<option value="' . esc_attr($key) . '" ' . (in_array($key, $saved_badges) ? 'selected="selected"' : '') . '>' . esc_html($label) . '</option>';
    }
    
    echo '</select>
        <span class="description">Select which badges are available for this product</span>
    </p>';

    echo '</div>';
}

// Add Select2 for multiple select
add_action('admin_footer', 'personalization_admin_script');
function personalization_admin_script() {
    if (get_post_type() !== 'product') return;
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('.select2-field').select2({
                width: '100%',
                dropdownAutoWidth: true,
                placeholder: 'Select options...',
                allowClear: true
            });
            
            // Fix for select2 inside WooCommerce tabs
            $('#woocommerce-product-data').on('woocommerce_variations_loaded', function() {
                $('.select2-field').select2({
                    width: '100%',
                    dropdownAutoWidth: true,
                    placeholder: 'Select options...',
                    allowClear: true
                });
            });
        });
    </script>
    <style type="text/css">
        .select2-container {
            min-width: 400px !important;
        }
        .select2-container--default .select2-selection--multiple {
            border-color: #8c8f94 !important;
        }
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #2271b1 !important;
        }
    </style>
    <?php
}

// Save the custom fields
add_action('woocommerce_process_product_meta', 'save_personalization_fields');
function save_personalization_fields($post_id) {
    // Save prices
    $name_number_price = isset($_POST['_name_number_price']) && $_POST['_name_number_price'] !== '' ? (float) $_POST['_name_number_price'] : '';
    $league_badge_price = isset($_POST['_league_badge_price']) && $_POST['_league_badge_price'] !== '' ? (float) $_POST['_league_badge_price'] : '';
    $ucl_badge_price = isset($_POST['_ucl_badge_price']) && $_POST['_ucl_badge_price'] !== '' ? (float) $_POST['_ucl_badge_price'] : '';
    
    update_post_meta($post_id, '_name_number_price', $name_number_price);
    update_post_meta($post_id, '_league_badge_price', $league_badge_price);
    update_post_meta($post_id, '_ucl_badge_price', $ucl_badge_price);
    
    // Save available sizes
    $available_sizes = isset($_POST['_available_sizes']) ? (array) $_POST['_available_sizes'] : array();
    update_post_meta($post_id, '_available_sizes', $available_sizes);
    
    // Save available badges
    $available_badges = isset($_POST['_available_badges']) ? (array) $_POST['_available_badges'] : array();
    update_post_meta($post_id, '_available_badges', $available_badges);
}

// Calculate extra costs for personalization
function calculate_personalization_costs($product_id, $personalization) {
    $extra_cost = 0;
    
    // Only add name/number cost if either field is actually filled in
    if (!empty($personalization['name']) || !empty($personalization['number'])) {
        $name_number_price = get_post_meta($product_id, '_name_number_price', true);
        if ($name_number_price !== '') {
            $extra_cost += (float) $name_number_price;
        }
    }
    
    // Only add badge cost if a badge is selected (not "No badge")
    if (!empty($personalization['badge'])) {
        if ($personalization['badge'] === 'League badge') {
            $league_badge_price = get_post_meta($product_id, '_league_badge_price', true);
            if ($league_badge_price !== '') {
                $extra_cost += (float) $league_badge_price;
            }
        } elseif ($personalization['badge'] === 'UCL badge') {
            $ucl_badge_price = get_post_meta($product_id, '_ucl_badge_price', true);
            if ($ucl_badge_price !== '') {
                $extra_cost += (float) $ucl_badge_price;
            }
        }
    }
    
    return $extra_cost;
}

// Add personalization data and costs to cart item
add_filter('woocommerce_add_cart_item_data', 'add_personalization_to_cart_item', 10, 3);
function add_personalization_to_cart_item($cart_item_data, $product_id, $variation_id) {
    if (isset($_POST['personalization'])) {
        $cart_item_data['personalization'] = array(
            'name' => sanitize_text_field($_POST['personalization']['name'] ?? ''),
            'number' => sanitize_text_field($_POST['personalization']['number'] ?? ''),
            'size' => sanitize_text_field($_POST['personalization']['size'] ?? ''),
            'badge' => sanitize_text_field($_POST['personalization']['badge'] ?? '')
        );
        
        // Calculate extra costs
        $cart_item_data['personalization_cost'] = calculate_personalization_costs($product_id, $cart_item_data['personalization']);
        
        // Make each personalized item unique in cart
        $cart_item_data['unique_key'] = md5(serialize($cart_item_data['personalization']));
    }
    
    return $cart_item_data;
}

// Adjust item price in cart
add_filter('woocommerce_get_cart_item_from_session', 'add_personalization_cost_from_session', 10, 2);
function add_personalization_cost_from_session($cart_item, $values) {
    if (isset($values['personalization_cost'])) {
        $cart_item['personalization_cost'] = $values['personalization_cost'];
    }
    return $cart_item;
}

add_filter('woocommerce_cart_item_price', 'adjust_cart_item_price', 10, 3);
function adjust_cart_item_price($price, $cart_item, $cart_item_key) {
    if (isset($cart_item['personalization_cost']) && $cart_item['personalization_cost'] > 0) {
        $product = $cart_item['data'];
        $adjusted_price = $product->get_price() + $cart_item['personalization_cost'];
        return wc_price($adjusted_price);
    }
    return $price;
}

// Display personalization data and costs in cart
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
        
        // Add personalization costs if any
        if (isset($cart_item['personalization_cost']) && $cart_item['personalization_cost'] > 0) {
            $item_data[] = array(
                'key' => 'Personalization Cost',
                'value' => wc_price($cart_item['personalization_cost'])
            );
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

