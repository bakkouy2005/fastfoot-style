<?php
/* Template Name: Product Archive */

get_header();

// Get the current category from the URL
$category_slug = get_query_var('product_cat');
$category = get_term_by('slug', $category_slug, 'product_cat');

// Set up the query for products in this category
$args = array(
    'post_type' => 'product',
    'posts_per_page' => -1, // Show all products
    'tax_query' => array(
        array(
            'taxonomy' => 'product_cat',
            'field' => 'slug',
            'terms' => $category_slug
        )
    )
);
$products = new WP_Query($args);
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-12">
        <h1 class="text-5xl font-bold text-white mb-4">
            <?php echo $category ? esc_html($category->name) : 'All Products'; ?>
        </h1>
        <?php if ($category && $category->description): ?>
            <p class="text-xl text-[#9EB89E]"><?php echo esc_html($category->description); ?></p>
        <?php endif; ?>
    </div>

    <?php if ($products->have_posts()): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php
            while ($products->have_posts()) : $products->the_post();
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
                ?>
                <div class="group relative">
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
            endwhile;
            wp_reset_postdata();
            ?>
        </div>
    <?php else: ?>
        <div class="text-center py-12">
            <p class="text-xl text-white">No products found in this category.</p>
        </div>
    <?php endif; ?>
</div>

<?php
get_footer();
?> 