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

<h2 class="text-4xl font-bold mb-10 text-white"><?php echo esc_html($title); ?></h2>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-1">
  <?php 
  $counter = 0;
  while ($query->have_posts()) : $query->the_post(); global $product;

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
  ?>
</div>

<?php if ($query->found_posts > $per_page): ?>
  <div class="text-center mt-12">
    <button 
      class="view-more-btn inline-flex items-center justify-center px-8 py-3 border border-white text-base bg-[#324132] rounded-[12px] border-none text-white font-medium hover:bg-white hover:text-black transition-colors"
      data-category="<?php echo esc_attr($term); ?>"
      data-current-page="1"
      data-products-per-load="6"
      data-total-products="<?php echo esc_attr($query->found_posts); ?>"
    >
      View more
    </button>
  </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const viewMoreBtn = document.querySelector('.view-more-btn');
  if (!viewMoreBtn) return;

  viewMoreBtn.addEventListener('click', async function() {
    const category = this.dataset.category;
    const currentPage = parseInt(this.dataset.currentPage) + 1;
    const productsPerLoad = parseInt(this.dataset.productsPerLoad);
    const totalProducts = parseInt(this.dataset.totalProducts);

    try {
      const response = await fetch(`/wp-admin/admin-ajax.php`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=load_more_products&category=${category}&page=${currentPage}&per_page=${productsPerLoad}`
      });

      const data = await response.json();
      if (data.success) {
        // Insert new products before the text-center div
        const productsGrid = document.querySelector('.grid');
        productsGrid.insertAdjacentHTML('beforeend', data.data.html);

        // Update current page
        this.dataset.currentPage = currentPage;

        // Hide button if we've loaded all products
        const loadedProducts = currentPage * productsPerLoad;
        if (loadedProducts >= totalProducts) {
          this.style.display = 'none';
        }
      }
    } catch (error) {
      console.error('Error loading more products:', error);
    }
  });
});
</script>
