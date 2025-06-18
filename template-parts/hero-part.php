<?php 
$hero_group = get_field('hero', get_the_ID());
$search_group = !empty($hero_group['search_group']) ? $hero_group['search_group'] : null;
?>

<?php if (!empty($hero_group['hero_heading']) || !empty($hero_group['hero_subtext']) || !empty($hero_group['hero_background_image'])): ?>
<section 
  class="relative w-full min-h-screen bg-cover bg-center rounded-lg p-8 md:p-12" 
  style="background-image: url('<?php echo !empty($hero_group['hero_background_image']) ? $hero_group['hero_background_image'] : ''; ?>');"
>
  
  <!-- Logo at the top -->
  <div class="relative z-10 max-w-7xl mx-auto px-8 pt-4">
    <h1 class="text-5xl md:text-6xl font-bold text-start">
      <span class="text-white block">Fast Foot</span>
      <span class="text-white/90 block">Style</span>
    </h1>
  </div>

  <!-- Content at the absolute bottom -->
  <div class="absolute bottom-0 left-0 right-0 z-10 p-8 md:p-12">
    <div class="max-w-7xl mx-auto">
      <!-- Heading + subheading -->
      <div class="max-w-2xl mb-8">
        <?php if (!empty($hero_group['hero_heading'])): ?>
        <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight text-white text-start">
          <?php echo $hero_group['hero_heading']; ?>
        </h2>
        <?php endif; ?>
        
        <?php if (!empty($hero_group['hero_subtext'])): ?>
        <p class="text-xl md:text-2xl text-white/90 mb-8 text-start">
          <?php echo $hero_group['hero_subtext']; ?>
        </p>
        <?php endif; ?>
      </div>

      <!-- Search form -->
      <?php if (!empty($search_group['search_placeholder']) && !empty($search_group['search_button_text'])): ?>
      <form action="/search" method="get" class="w-full max-w-2xl flex items-center bg-black/30 rounded-lg p-1">
        <div class="flex-grow flex items-center">
          <svg class="w-5 h-5 text-white/60 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            type="text" 
            name="s"
            class="w-full px-4 py-3 bg-[#1C261C] text-white placeholder-white/60 text-base focus:outline-none"
            placeholder="<?php echo $search_group['search_placeholder']; ?>"
          >
        </div>
        <button 
          type="submit"
          class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-md transition-all duration-200"
        >
          <?php echo $search_group['search_button_text']; ?>
        </button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>
