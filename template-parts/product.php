<?php
$term = $args['term'] ?? '';
$taxonomy = $args['taxonomy'] ?? 'product_cat';
$title = $args['title'] ?? 'New collection';
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

<h2 class="text-4xl font-bold mb-10"><?php echo esc_html($title); ?></h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
  <?php while ($query->have_posts()) : $query->the_post(); global $product; ?>
    <div class="group relative">
      <div class="relative aspect-[3/4] overflow-hidden bg-[url('/wp-content/themes/fastfoot-style/assets/images/mesh-pattern.png')] bg-cover">
        <a href="<?php the_permalink(); ?>" class="block w-full h-full">
          <?php echo $product->get_image('woocommerce_thumbnail', ['class' => 'w-full h-full object-contain transition-transform duration-300 group-hover:scale-105 rounded-lg']); ?>
        </a>
      </div>
      <div>
        <h3 class="text-xl font-medium text-white"><?php the_title(); ?></h3>
        <p class="text-xl text-[#9EB89E]"><?php echo '€' . $product->get_price(); ?></p>
      </div>
    </div>
  <?php endwhile; wp_reset_postdata(); ?>
</div>

<?php if ($query->found_posts > $per_page): ?>
  <div class="text-center mt-12">
    <button 
      class="view-more-btn inline-flex items-center justify-center px-8 py-3 border border-white text-base font-medium hover:bg-white hover:text-black transition-colors"
      data-category="<?php echo esc_attr($term); ?>"
      data-limit="<?php echo esc_attr($per_page); ?>"
    >
      View all
    </button>
  </div>
<?php endif; ?>
