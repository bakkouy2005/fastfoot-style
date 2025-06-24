<?php
$logos = [
    ['src' => 'premier-league.svg', 'alt' => 'Premier League'],
    ['src' => 'bundesliga.svg', 'alt' => 'Bundesliga'],
    ['src' => 'laliga.svg', 'alt' => 'La Liga'],
    ['src' => 'serie-a.svg', 'alt' => 'Serie A'],
    ['src' => 'ligue-1.svg', 'alt' => 'Ligue 1']
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
                    class="h-12 w-auto opacity-70 hover:opacity-100 transition-opacity"
                >
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.league-slider', {
        slidesPerView: 'auto',
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
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