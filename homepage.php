<?php
/* Template Name: Homepages */
get_header();


?>

<section class="hero" style="background-image: url('<?php the_field('hero_background_image'); ?>')">
  <div class="overlay">
    <div class="hero-content">
      <h1><?php the_field('hero_heading'); ?></h1>
      <p><?php the_field('hero_subtext'); ?></p>

      <form class="hero-search-form" action="/search" method="get">
        <input 
          type="text" 
          name="s" 
          placeholder="<?php the_field('hero_search_placeholder'); ?>">
        <button type="submit"><?php the_field('hero_search_button_text'); ?></button>
      </form>
    </div>
  </div>
</section>


<?php


get_footer();

?>