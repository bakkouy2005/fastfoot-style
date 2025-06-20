<?php
/**
 * Template Name: Product Page Template
 */

get_header();

while (have_posts()) :
    the_post();
?>

<div class="min-h-screen text-white">
    <div class="container mx-auto px-4 py-12">
        <!-- Dropdown Repeater -->
        <?php 
        if(have_rows('product_dropdowns')):
            while(have_rows('product_dropdowns')): the_row(); 
                $title = get_sub_field('dropdown_title');
                $content = get_sub_field('dropdown_content');
        ?>
                <div class="mb-4 dropdown-item">
                    <button type="button" class="w-full py-3 px-4 bg-[#1a1f1a] rounded-2xl text-left flex justify-between items-center hover:bg-[#2a2f2a] transition toggle-dropdown">
                        <span class="text-white font-medium"><?php echo esc_html($title); ?></span>
                        <svg class="w-4 h-4 transition-transform arrow-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="dropdown-content hidden mt-2 bg-[#374437] text-[#CFCFCF] text-sm p-4 rounded-xl">
                        <?php echo wpautop(wp_kses_post($content)); ?>
                    </div>
                </div>
        <?php 
            endwhile;
        endif; 
        ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Dropdown functionality
    const dropdownButtons = document.querySelectorAll('.dropdown-item button');
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function() {
            const content = this.nextElementSibling;
            content.classList.toggle('hidden');
            const svg = this.querySelector('svg');
            svg.style.transform = content.classList.contains('hidden') ? '' : 'rotate(180deg)';
        });
    });
});
</script>

<?php
endwhile;
get_footer();
?>