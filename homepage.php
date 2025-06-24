<?php
/* Template Name: Homepages */
get_header();
?>

<div class="">
    <div class="container mx-auto ">
    <?php get_template_part('template-parts/hero-conf', null, ['hero_index' => 1]); ?>
    <?php get_template_part('template-parts/product', null, [
  'term' => 'new-collection', // <-- dit is de slug van de categorie
  'taxonomy' => 'product_cat',
  'title' => 'Nieuwste Collectie',
  'limit' => -1
]); ?>
    <?php get_template_part('template-parts/hero-conf', null, ['hero_index' => 2]); ?>
    <?php get_template_part('template-parts/product', null, [
  'term' => 'Retro', // <-- dit is de slug van de categorie
  'taxonomy' => 'product_cat',
  'title' => 'Retro',
  'limit' => 3
]); ?>

    <?php get_template_part('template-parts/hero-conf', null, ['hero_index' => 3]); ?>

    </div>
</div>

<?php
get_footer();
?>