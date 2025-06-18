<?php 
$hero_group = get_field('hero', get_the_ID());
$search_group = !empty($hero_group['search_group']) ? $hero_group['search_group'] : null;
?>

<?php if (!empty($hero_group['hero_heading']) || !empty($hero_group['hero_subtext']) || !empty($hero_group['hero_background_image'])): ?>
<section 
  class="relative w-full h-[85vh] bg-cover bg-center rounded-xl p-8  my-8" 
  style="background-image: url('<?php echo !empty($hero_group['hero_background_image']) ? $hero_group['hero_background_image'] : ''; ?>');"
>
<div class="max-w-7xl mx-auto">
  
  <!-- Logo at the top -->
  <div class="relative z-10 mx-auto pt-4">
    <img 
      src="<?php echo get_template_directory_uri(); ?>/images/image copy 2.png" 
      alt="Fast Foot Style" 
      class="h-24 sm:h-28 md:h-32 lg:h-36 xl:h-40 w-auto object-contain"
    >
  </div>

  <!-- Content at the absolute bottom -->
  <div class="absolute bottom-0 left-0 right-0 z-10  md:p-12">
    <div class="max-w-7xl mx-auto">
      <!-- Heading + subheading -->
      <div class="max-w-5xl mb-8">
        <?php if (!empty($hero_group['hero_heading'])): ?>
        <h2 class="text-5xl md:text-7xl font-bold mb-4 leading-tight text-white text-start">
          <?php echo $hero_group['hero_heading']; ?>
        </h2>
        <?php endif; ?>
        
        <?php if (!empty($hero_group['hero_subtext'])): ?>
        <p class="text-3xl md:text-6xl font-bold text-white/90 mb-8 text-start leading-tight">
          <?php echo $hero_group['hero_subtext']; ?>
        </p>
        <?php endif; ?>
      </div>

      <!-- Search form -->
      <?php if (!empty($search_group['search_placeholder']) && !empty($search_group['search_button_text'])): ?>
      <form action="/search" method="get" class="w-full max-w-2xl flex items-center bg-white/5 backdrop-blur-lg rounded-lg p-1 border border-white/10 transition-all duration-300 group focus-within:bg-white/10 focus-within:border-white/20 relative overflow-hidden">
        <div class="flex-grow flex items-center relative z-10">
          <svg class="w-5 h-5 text-white/60 ml-3 transition-colors duration-300 group-focus-within:text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            type="text" 
            name="s"
            class="w-full px-4 py-3 bg-transparent text-white placeholder-white/60 text-base focus:outline-none focus:ring-0 border-none transition-colors duration-300 focus:placeholder-white/80"
            placeholder="<?php echo $search_group['search_placeholder']; ?>"
          >
        </div>
        <button 
          type="submit"
          class="px-8 py-3 bg-[#12A212]/90 hover:bg-[#12A212] text-white font-medium rounded-md transition-all duration-200 backdrop-blur-sm relative z-10"
        >
          <?php echo $search_group['search_button_text']; ?>
        </button>
        
        <!-- Wave animation elements -->
        <div class="absolute inset-0 opacity-0 group-focus-within:opacity-100 transition-opacity duration-300 overflow-hidden">
          <div class="absolute inset-0 bg-gradient-to-r from-white/30 via-white/20 via-sky-100/10 to-transparent animate-wave-1 rounded-full scale-y-[2.0] -skew-x-12"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-sky-50/25 via-white/15 via-sky-50/10 to-transparent animate-wave-2 rounded-full scale-y-[1.8] -skew-x-6"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-white/20 via-sky-100/15 via-white/10 to-transparent animate-wave-3 rounded-full scale-y-[2.2] -skew-x-3"></div>
          <div class="absolute inset-0 bg-gradient-to-r from-sky-50/20 via-white/20 via-sky-100/5 to-transparent animate-wave-4 rounded-full scale-y-[1.9] -skew-x-9"></div>
        </div>
      </form>
      <?php endif; ?>
    </div>
  </div>
  </div>
</section>
<?php endif; ?>
