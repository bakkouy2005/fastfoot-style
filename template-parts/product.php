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

<h2 class="text-4xl font-bold mb-10 text-white"><?php echo esc_html($title); ?></h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
  <?php 
  while ($query->have_posts()) : $query->the_post(); 
    global $product;

    $gallery_images = $product->get_gallery_image_ids();
    $back_image = '';

    foreach ($gallery_images as $image_id) {
      $image_title = strtolower(get_the_title($image_id));
      if (strpos($image_title, 'achterkant') !== false) {
        $back_image = wp_get_attachment_image($image_id, 'full', false, [
          'class' => 'w-full h-full object-contain absolute inset-0 opacity-0 group-hover:opacity-100 transition duration-300 transform-gpu will-change-transform'
        ]);
        break;
      }
    }
  ?>
    <div class="group">
      <div class="aspect-[4/5] rounded-[20px] overflow-hidden bg-[url('/wp-content/themes/fastfoot-style/assets/images/mesh-pattern.png')] bg-cover">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full relative">
          <?php 
            echo $product->get_image('full', [
              'class' => 'w-full h-full object-contain transition duration-300 group-hover:opacity-0 transform-gpu will-change-transform'
            ]);
            if ($back_image) echo $back_image;
          ?>
        </a>
      </div>
      <div class="mt-6">
        <h3 class="text-[15px] font-medium text-white mb-1"><?php the_title(); ?></h3>
        <p class="text-[15px] text-[#9EB89E]">€<?php echo $product->get_price(); ?></p>
      </div>
    </div>
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
