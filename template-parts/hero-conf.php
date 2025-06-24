<?php
$hero_index = $args['hero_index'] ?? 1;
$current_index = 1;

if (have_rows('hero_sections')) :
  while (have_rows('hero_sections')) : the_row();
    if ($current_index === $hero_index) :
      $hero_group = get_sub_field('hero');
      $search_group = $hero_group['search_group'] ?? null;
      ?>

<section 
  class="<?php echo $hero_index === 1 ? '-mt-24' : ''; ?> relative w-full h-[140vh] bg-cover bg-center rounded-xl overflow-hidden"
  style="background-image: url('<?php echo esc_url($hero_group['hero_background_image']); ?>');"
  id="hero-<?php echo $hero_index; ?>"
>
  <!-- Dark overlay with gradient -->
  <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/25 to-black/50"></div>
  
  <div class="max-w-7xl mx-auto h-full relative">
    <!-- Content -->
    <div class="absolute top-1/2 left-0 right-0 -translate-y-1/2 z-10 px-1">
      <div class="max-w-7xl mx-auto">
        <!-- Heading -->
        <div class="max-w-5xl mb-8">
          <?php if (!empty($hero_group['hero_heading'])): ?>
            <h2 class="text-5xl md:text-7xl font-bold mb-4 leading-tight text-white text-start">
              <?php echo esc_html($hero_group['hero_heading']); ?>
            </h2>
          <?php endif; ?>

          <?php if (!empty($hero_group['hero_subtext'])): ?>
            <p class="text-3xl md:text-6xl font-bold text-white/80 mb-8 text-start leading-tight">
              <?php echo esc_html($hero_group['hero_subtext']); ?>
            </p>
          <?php endif; ?>
        </div>

        <!-- Search -->
        <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="w-full max-w-2xl">
          <div class="flex items-center bg-white/10 backdrop-blur-md rounded-xl border border-white/20 transition-all duration-300 focus-within:border-white/40">
            <div class="flex-grow flex items-center">
              <i class="fas fa-search text-white/60 ml-4 transition-colors duration-300"></i>
              <input 
                type="text" 
                name="s"
                class="w-full px-4 py-4 bg-transparent text-white placeholder-white/60 text-lg focus:outline-none focus:ring-0 border-none transition-colors duration-300"
                placeholder="Search for products..."
              >
            </div>
            <button 
              type="submit"
              class="px-8 py-4 bg-white/20 hover:bg-white/30 text-white font-medium rounded-r-xl transition-all duration-200 backdrop-blur-sm"
            >
              Search
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

      <?php
    endif;
    $current_index++;
  endwhile;
endif;
?>
