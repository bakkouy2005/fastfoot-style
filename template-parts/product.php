<?php
$term = $args['term'] ?? '';
$taxonomy = $args['taxonomy'] ?? 'product_cat';
$title = $args['title'] ?? 'New collection';
$per_page = $args['limit'] ?? -1; // Show all products by default

$args = [
  'post_type' => 'product',
  'posts_per_page' => $per_page,
  'tax_query' => $term ? [[
    'taxonomy' => $taxonomy,
    'field' => 'slug',
    'terms' => $term,
  ]] : [],
];

$query = new WP_Query($args);
?>

<div class="px-8">
  <h2 class="text-4xl font-bold mb-10 text-white"><?php echo esc_html($title); ?></h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php 
    while ($query->have_posts()) : $query->the_post(); 
      global $product;

      $gallery_images = $product->get_gallery_image_ids();
      $back_image = '';

      foreach ($gallery_images as $image_id) {
        $image_title = strtolower(get_the_title($image_id));
        if (strpos($image_title, 'achterkant') !== false) {
          $back_image = wp_get_attachment_image($image_id, 'full', false, [
            'class' => 'w-full h-[490px] object-contain absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 transform-gpu will-change-transform'
          ]);
          break;
        }
      } // End foreach
    ?>
      
    <?php 
    endwhile; 
    wp_reset_postdata(); 
    ?>
  </div>

  <div class="text-center mt-12">
    <button class="inline-flex items-center justify-center px-8 py-3 text-base bg-[#324132] rounded-[12px] text-white font-medium hover:bg-white hover:text-black transition-colors">
      View All
    </button>
  </div>
</div>
