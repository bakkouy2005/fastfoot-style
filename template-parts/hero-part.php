<?php 
$hero_group = get_field('hero', get_the_ID());
$search_group = !empty($hero_group['search_group']) ? $hero_group['search_group'] : null;
?>

<?php if (!empty($hero_group['hero_heading']) || !empty($hero_group['hero_subtext']) || !empty($hero_group['hero_background_image'])): ?>
<section 
  class="hero-section"
  style="background-image: url('<?php echo !empty($hero_group['hero_background_image']) ? $hero_group['hero_background_image'] : ''; ?>');"
>
  
  <!-- Logo at the top -->
  <div class="relative z-10 mx-auto pt-4">
    <img src="<?php echo get_template_directory_uri(); ?>/images/image copy.png" alt="Fast Foot Style" class="hero-logo">
  </div>

  <!-- Content at the absolute bottom -->
  <div class="hero-content">
    <div class="container">
      <!-- Heading + subheading -->
      <div class="max-w-5xl mb-8">
        <?php if (!empty($hero_group['hero_heading'])): ?>
        <h2 class="hero-heading text-start">
          <?php echo $hero_group['hero_heading']; ?>
        </h2>
        <?php endif; ?>
        
        <?php if (!empty($hero_group['hero_subtext'])): ?>
        <p class="hero-subtext text-start">
          <?php echo $hero_group['hero_subtext']; ?>
        </p>
        <?php endif; ?>
      </div>

      <!-- Search form -->
      <?php if (!empty($search_group['search_placeholder']) && !empty($search_group['search_button_text'])): ?>
      <form action="/search" method="get" class="search-form">
        <div class="flex-grow flex items-center">
          <svg class="w-5 h-5 text-white/60 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
          <input 
            type="text" 
            name="s"
            class="search-input"
            placeholder="<?php echo $search_group['search_placeholder']; ?>"
          >
        </div>
        <button type="submit" class="search-button">
          <?php echo $search_group['search_button_text']; ?>
        </button>
      </form>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php endif; ?>
