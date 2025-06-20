<?php
/* Template Name: Product Archive */

get_header();

// Get current category
$current_category = get_queried_object();
?>

<div class="container mx-auto px-4 py-8">
    <div class="mb-12">
        <h1 class="text-5xl font-bold text-white mb-4"><?php echo esc_html($current_category->name); ?></h1>
        <?php if ($current_category->description): ?>
            <p class="text-xl text-[#9EB89E]"><?php echo esc_html($current_category->description); ?></p>
        <?php endif; ?>
    </div>

    <?php
    if (woocommerce_product_loop()) {
        ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php
            while (have_posts()) : the_post();
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
            ?>
        </div>

        <?php
        // Pagination
        $total_pages = wc_get_loop_prop('total_pages');
        if ($total_pages > 1) {
            ?>
            <div class="mt-12 flex justify-center">
                <?php
                $current_page = max(1, get_query_var('paged'));
                
                echo paginate_links(array(
                    'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'format' => '?paged=%#%',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text' => '&larr; Previous',
                    'next_text' => 'Next &rarr;',
                    'type' => 'list',
                    'end_size' => 3,
                    'mid_size' => 3,
                ));
                ?>
            </div>
            <?php
        }
    } else {
        ?>
        <div class="text-center py-12">
            <p class="text-xl text-white">No products found in this category.</p>
        </div>
        <?php
    }
    ?>
</div>

<?php
get_footer();
?> 