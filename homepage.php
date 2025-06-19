<?php
/* Template Name: Homepages */
get_header();
?>

<div class="">
    <div class="container mx-auto ">
    <?php get_template_part('template-parts/hero-conf', null, ['hero_index' => 1]); ?>
    <?php get_template_part('template-parts/product-listing', null, [
  'term' => 'New collection',
  'title' => 'New collection',
  'limit' => 3
]); ?>
    <?php get_template_part('template-parts/hero-conf', null, ['hero_index' => 2]); ?>
    <?php get_template_part('template-parts/hero-conf', null, ['hero_index' => 3]); ?>

    </div>
</div>

<?php
get_footer();
?>