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

// Add AJAX handler for loading more products
add_action('wp_ajax_load_more_products', 'load_more_products');
add_action('wp_ajax_nopriv_load_more_products', 'load_more_products');

function load_more_products() {
    $category = $_POST['category'] ?? '';
    $page = intval($_POST['page']) ?? 1;
    $per_page = intval($_POST['per_page']) ?? 6;

    $args = [
        'post_type' => 'product',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'tax_query' => $category ? [[
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $category,
        ]] : [],
    ];

    $query = new WP_Query($args);
    
    if (!$query->have_posts()) {
        wp_send_json_error(['message' => 'No more products found']);
        return;
    }

    ob_start();
    $counter = 0;

    while ($query->have_posts()) : $query->the_post(); 
        global $product;

        $gallery_images = $product->get_gallery_image_ids();
        $back_image = '';

        foreach ($gallery_images as $image_id) {
            $image_title = strtolower(get_the_title($image_id));
            if (strpos($image_title, 'achterkant') !== false) {
                $back_image = wp_get_attachment_image($image_id, 'full', false, [
                    'class' => 'w-full h-[490px] object-contain rounded-[12px] absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 transform-gpu will-change-transform'
                ]);
                break;
            }
        }

        // Bepaal uitlijning (optioneel, voor variatie)
        $alignment_class = match($counter % 3) {
            0 => 'justify-self-start',
            1 => 'justify-self-center',
            default => 'justify-self-end',
        };
        ?>
        <div class="group relative <?php echo $alignment_class; ?>">
            <div class="relative w-full h-[461px] overflow-hidden bg-[url('/wp-content/themes/fastfoot-style/assets/images/mesh-pattern.png')] bg-cover rounded-[12px]">
                <a href="<?php the_permalink(); ?>" class="block w-full h-full rounded-[12px] overflow-hidden relative">
                    <?php 
                        echo $product->get_image('full', [
                            'class' => 'w-full h-[490px] object-contain rounded-[12px] transition duration-300 group-hover:opacity-0 transform-gpu will-change-transform'
                        ]);
                        if ($back_image) echo $back_image;
                    ?>
                </a>
            </div>
            <div class="mt-4">
                <h3 class="text-xl font-bold text-white"><?php the_title(); ?></h3>
                <p class="text-xl text-[#9EB89E]">€<?php echo $product->get_price(); ?></p>
            </div>
        </div>
        <?php
        $counter++;
    endwhile;
    wp_reset_postdata();

    $html = ob_get_clean();

    wp_send_json_success([
        'html' => $html,
        'page' => $page,
        'found' => $query->found_posts,
        'loaded' => $counter
    ]);
}

// Ensure jQuery is loaded
function enqueue_jquery() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

