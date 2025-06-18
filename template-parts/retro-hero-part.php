<?php 
$hero_group = get_field('retro-hero', get_the_ID());
$search_group = !empty($hero_group['search_group']) ? $hero_group['search_group'] : null;
?>

<?php if (!empty($hero_group['hero_heading']) || !empty($hero_group['hero_subtext']) || !empty($hero_group['hero_background_image'])): ?>
<section 
  class="relative w-full h-[85vh] bg-cover bg-center rounded-xl p-8  my-8" 
  style="background-image: url('<?php echo !empty($hero_group['hero_background_image']) ? $hero_group['hero_background_image'] : ''; ?>');"
>
<div class="max-w-7xl mx-auto">
  
  <!-- Logo at the top -->
  

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
      
    </div>
  </div>
  </div>
</section>
<?php endif; ?>
