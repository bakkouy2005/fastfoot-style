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
    <div class="swiper league-slider relative max-w-7xl mx-auto px-8">
        <div class="swiper-wrapper py-4">
            <?php foreach ($logos as $logo): ?>
            <div class="swiper-slide flex items-center justify-center">
                <img 
                    src="<?php echo get_template_directory_uri(); ?>/assets/images/<?php echo $logo['src']; ?>" 
                    alt="<?php echo $logo['alt']; ?>" 
                    class="h-24 w-auto opacity-70 hover:opacity-100 transition-all duration-300 ease-in-out transform hover:scale-110"
                >
            </div>
            <?php endforeach; ?>
        </div>
        <!-- Navigation buttons -->
        <div class="swiper-button-next !text-white opacity-50 hover:opacity-100 transition-opacity"></div>
        <div class="swiper-button-prev !text-white opacity-50 hover:opacity-100 transition-opacity"></div>
    </div>
</div>

<style>
.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 24px !important;
}
.swiper-button-next {
    right: 0 !important;
}
.swiper-button-prev {
    left: 0 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.league-slider', {
        slidesPerView: 4,
        spaceBetween: 20,
        centeredSlides: false,
        loop: true,
        speed: 800,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        effect: 'slide',
        grabCursor: true,
        breakpoints: {
            320: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            640: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 20
            }
        }
    });
});
</script>