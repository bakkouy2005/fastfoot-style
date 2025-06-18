<?php
$term = $args['term'] ?? '';
$taxonomy = $args['taxonomy'] ?? 'product_cat';
$title = $args['title'] ?? 'Producten';
$per_page = $args['limit'] ?? 3;

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

<section class="max-w-7xl mx-auto py-12">
  <h2 class="text-3xl font-bold mb-6"><?php echo esc_html($title); ?></h2>
  
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
    <?php while ($query->have_posts()) : $query->the_post(); global $product; ?>
      <div class="bg-white rounded-xl shadow p-4 flex flex-col">
        <a href="<?php the_permalink(); ?>">
          <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'w-full h-64 object-cover mb-4 rounded-md']); ?>
        </a>
        <h3 class="text-xl font-semibold mb-2"><?php the_title(); ?></h3>
        <p class="text-[#12A212] font-bold mb-4"><?php echo $product->get_price_html(); ?></p>
        <a href="<?php the_permalink(); ?>" class="mt-auto text-[#12A212] font-medium hover:underline">Bekijk product</a>
      </div>
    <?php endwhile; wp_reset_postdata(); ?>
  </div>

  <?php if ($query->found_posts > $per_page): ?>
    <div class="text-center mt-8">
      <button 
        class="view-more-btn bg-[#12A212] hover:bg-[#0e8d0e] text-white px-6 py-3 rounded transition"
        data-category="<?php echo esc_attr($term); ?>"
        data-limit="<?php echo esc_attr($per_page); ?>"
      >
        View more
      </button>
    </div>
  <?php endif; ?>
</section>
