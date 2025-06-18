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
  class="relative w-full h-[85vh] bg-cover bg-center rounded-xl p-8 my-8"
  style="background-image: url('<?php echo esc_url($hero_group['hero_background_image']); ?>');"
  id="hero-<?php echo $hero_index; ?>"
>
  <div class="max-w-7xl mx-auto">

    <!-- Logo -->
    <div class="relative z-10 mx-auto pt-4">
      <img 
        src="<?php echo get_template_directory_uri(); ?>/images/image copy 2.png" 
        alt="Fast Foot Style" 
        class="h-24 sm:h-28 md:h-32 lg:h-36 xl:h-40 w-auto object-contain"
      >
    </div>

    <!-- Content -->
    <div class="absolute bottom-0 left-0 right-0 z-10 md:p-12">
      <div class="max-w-7xl mx-auto">
        <!-- Heading -->
        <div class="max-w-5xl mb-8">
          <?php if (!empty($hero_group['hero_heading'])): ?>
            <h2 class="text-5xl md:text-7xl font-bold mb-4 leading-tight text-white text-start">
              <?php echo esc_html($hero_group['hero_heading']); ?>
            </h2>
          <?php endif; ?>

          <?php if (!empty($hero_group['hero_subtext'])): ?>
            <p class="text-3xl md:text-6xl font-bold text-white/90 mb-8 text-start leading-tight">
              <?php echo esc_html($hero_group['hero_subtext']); ?>
            </p>
          <?php endif; ?>
        </div>

        <!-- Search -->
        <?php if (!empty($search_group['search_placeholder']) && !empty($search_group['search_button_text'])): ?>
          <form action="/search" method="get" class="w-full max-w-2xl flex items-center bg-gradient-search backdrop-blur-lg rounded-lg p-1 border border-white/10 transition-all duration-300 group focus-within:border-white/20">
            <div class="flex-grow flex items-center relative z-10">
              <svg class="w-5 h-5 text-white/60 ml-3 transition-colors duration-300 group-focus-within:text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <input 
                type="text" 
                name="s"
                class="w-full px-4 py-3 bg-transparent text-white placeholder-white/60 text-base focus:outline-none focus:ring-0 border-none transition-colors duration-300 focus:placeholder-white/80"
                placeholder="<?php echo esc_attr($search_group['search_placeholder']); ?>"
              >
            </div>
            <button 
              type="submit"
              class="px-8 py-3 bg-[#12A212]/90 hover:bg-[#12A212] text-white font-medium rounded-md transition-all duration-200 backdrop-blur-sm relative z-10"
            >
              <?php echo esc_html($search_group['search_button_text']); ?>
            </button>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

      <?php
      break;
    endif;
    $current_index++;
  endwhile;
endif;
?>
