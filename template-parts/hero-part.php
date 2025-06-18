<?php 
$hero_group = get_field('hero', get_the_ID());
$search_group = !empty($hero_group['search_group']) ? $hero_group['search_group'] : null;
?>

<?php if (!empty($hero_group['hero_heading']) || !empty($hero_group['hero_subtext']) || !empty($hero_group['hero_background_image'])): ?>
<section 
  class="relative w-full min-h-screen bg-cover bg-center rounded-lg p-8 md:p-12" 
  style="background-image: url('<?php echo !empty($hero_group['hero_background_image']) ? $hero_group['hero_background_image'] : ''; ?>');"
>
  <div class="max-w-7xl mx-auto h-full relative">
    <!-- Logo at the top -->
    <div class="relative z-10 pt-4">
      <h1 class="text-5xl md:text-6xl font-bold text-start">
        <span class="text-white block">Fast Foot</span>
        <span class="text-white/90 block">Style</span>
      </h1>
    </div>

    <!-- Content at the absolute bottom -->
    <div class="absolute bottom-0 left-0 right-0 z-10">
      <!-- Heading + subheading -->
      <div class="max-w-5xl mb-8">
        <?php if (!empty($hero_group['hero_heading'])): ?>
        <h2 class="text-5xl md:text-7xl font-bold mb-4 leading-tight text-white text-start">
          <?php echo $hero_group['hero_heading']; ?>
        </h2>
        <?php endif; ?>
        
        <?php if (!empty($hero_group['hero_subtext'])): ?>
        <p class="text-2xl md:text-6xl text-white/90 mb-8 text-start leading-tight">
          <?php echo $hero_group['hero_subtext']; ?>
        </p>
        <?php endif; ?>
      </div>

      <!-- Search form -->
      <?php if (!empty($search_group['search_placeholder']) && !empty($search_group['search_button_text'])): ?>
      <form action="/search" method="get" class="w-full max-w-2xl flex items-center bg-[#1C261C] rounded-lg p-1">
        <div class="flex-grow flex items-center">
          <svg class="w-5 h-5 text-white/60 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            type="text" 
            name="s"
            class="w-full px-4 py-3 bg-[#1C261C] text-white placeholder-white/60 text-base focus:outline-none focus:ring-0 border-none"
            placeholder="<?php echo $search_group['search_placeholder']; ?>"
          >
        </div>
        <button 
          type="submit"
          class="px-8 py-3 bg-[#12A212] hover:bg-green-700 text-white font-medium rounded-md transition-all duration-200"
        >
          <?php echo $search_group['search_button_text']; ?>
        </button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>
