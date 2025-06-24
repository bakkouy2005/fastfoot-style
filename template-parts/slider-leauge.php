<?php
$logos = [
    ['src' => '1.svg', 'alt' => 'League 1'],
    ['src' => '2.svg', 'alt' => 'League 2'],
    ['src' => '3.svg', 'alt' => 'League 3'],
    ['src' => '4.svg', 'alt' => 'League 4'],
    ['src' => '5.svg', 'alt' => 'League 5']
];
?>

<div class="bg-black">
    <div class="swiper league-slider">
        <div class="swiper-wrapper py-4">
            <?php foreach ($logos as $logo): ?>
            <div class="swiper-slide flex items-center justify-center">
                <img 
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $logo['src']; ?>" 
                    alt="<?php echo $logo['alt']; ?>" 
                    class="h-24 w-auto opacity-70 hover:opacity-100 transition-opacity"
                >
            </div>
            <?php endforeach; ?>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.league-slider', {
        slidesPerView: 'auto',
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            1024: {
                slidesPerView: 5,
                spaceBetween: 40
            }
        }
    });
});
</script>