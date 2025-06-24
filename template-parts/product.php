<?php
/**
 * Product Grid Template Part
 * 
 * @param string $term - Category term slug
 * @param string $taxonomy - Taxonomy name (default: product_cat)
 * @param string $title - Section title
 * @param int $limit - Number of products to show (-1 for all)
 */

$term = $args['term'] ?? '';
$taxonomy = $args['taxonomy'] ?? 'product_cat';
$title = $args['title'] ?? 'New collection';
$per_page = $args['limit'] ?? -1;

// Query setup
$query_args = [
    'post_type' => 'product',
    'posts_per_page' => $per_page,
];

// Add taxonomy query if term is provided
if ($term) {
    $query_args['tax_query'] = [[
        'taxonomy' => $taxonomy,
        'field' => 'slug',
        'terms' => $term,
    ]];
}

$query = new WP_Query($query_args);
?>

<section class="product-grid">
    <?php if ($title): ?>
        <h2 class="text-4xl font-bold mb-10 text-white"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php 
        while ($query->have_posts()): 
            $query->the_post();
            global $product;

            // Get back image if available
            $back_image = '';
            $gallery_images = $product->get_gallery_image_ids();
            foreach ($gallery_images as $image_id) {
                if (strpos(strtolower(get_the_title($image_id)), 'achterkant') !== false) {
                    $back_image = wp_get_attachment_image($image_id, 'full', false, [
                        'class' => 'absolute inset-0 w-full h-full object-contain opacity-0 group-hover:opacity-100 transition-opacity duration-300'
                    ]);
                    break;
                }
            }
        ?>
            <article class="group">
                <!-- Product Image Container -->
                <div class="relative aspect-[4/5] bg-[#1a1f1a] rounded-[12px]">
                    <a href="<?php the_permalink(); ?>" class="block w-full h-full rounded-[12px]" >
                        <!-- Main Product Image -->
                        <?php echo $product->get_image('full rounded-[12px]' , [
                            'class' => 'w-full h-full object-contain rounded-[12px] group-hover:opacity-0 transition-opacity duration-300'
                        ]); ?>
                        
                        <!-- Back Image (if available) -->
                        <?php if ($back_image) echo $back_image; ?>
                    </a>
                </div>

                <!-- Product Info -->
                <div class="mt-4">
                    <h3 class="text-[15px] font-medium text-white"><?php the_title(); ?></h3>
                    <div class="mt-1 text-[15px] text-[#9EB89E]">
                        €<?php echo $product->get_price(); ?>
                    </div>
                </div>
            </article>
        <?php 
        endwhile; 
        wp_reset_postdata(); 
        ?>
    </div>

    <?php if ($query->found_posts > $per_page && $per_page > 0): ?>
        <div class="text-center mt-12">
            <a href="<?php echo get_term_link($term, $taxonomy); ?>" 
               class="inline-flex items-center justify-center px-8 py-3 text-base bg-[#324132] rounded-[12px] text-white font-medium hover:bg-white hover:text-black transition-colors">
                View All
            </a>
        </div>
    <?php endif; ?>
</section>
