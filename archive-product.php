<?php
/* Template Name: Product Archive */

get_header();

// Get current category from URL
$category_slug = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$category_slug = str_replace('product-archive/', '', $category_slug);

// Query for products
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1,
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $category_slug
        )
    )
);

$query = new WP_Query($args);

// Debug info
echo "<!-- Debug info: Category slug = " . esc_html($category_slug) . " -->";
echo "<!-- Found " . $query->found_posts . " posts -->";
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-white">Products Archive</h1>
        <p class="text-[#9EB89E]">Category: <?php echo esc_html($category_slug); ?></p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        if ($query->have_posts()) :
            while ($query->have_posts()) : $query->the_post();
                global $product;
                if (!$product) continue;
                ?>
                <div class="bg-[#324132] rounded-lg p-4">
                    <div class="aspect-square mb-4 overflow-hidden rounded-lg">
                        <?php
                        if (has_post_thumbnail()) {
                            echo get_the_post_thumbnail(null, 'large', array(
                                'class' => 'w-full h-full object-cover'
                            ));
                        }
                        ?>
                    </div>
                    <h2 class="text-xl font-bold text-white mb-2"><?php the_title(); ?></h2>
                    <p class="text-[#9EB89E] text-lg">€<?php echo $product->get_price(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="mt-4 inline-block bg-white text-black px-4 py-2 rounded hover:bg-gray-100 transition-colors">
                        View Product
                    </a>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            ?>
            <div class="col-span-full text-center text-white py-8">
                <p>No products found in this category.</p>
            </div>
            <?php
        endif;
        ?>
    </div>
</div>

<?php
get_footer();
?> 