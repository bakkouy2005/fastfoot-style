<?php
get_header();

while (have_posts()) :
    the_post();
    global $product;
?>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Left Column - Product Images -->
        <div class="relative">
            <!-- Main Product Image -->
            <div class="bg-[#1a1f1a] p-4 rounded-xl mb-4">
                <?php
                $main_image_id = $product->get_image_id();
                $main_image = wp_get_attachment_image_src($main_image_id, 'full');
                ?>
                <img src="<?php echo esc_url($main_image[0]); ?>" 
                     alt="<?php echo esc_attr($product->get_name()); ?>"
                     class="w-full h-auto object-contain rounded-lg main-product-image">
            </div>

            <!-- Thumbnail Gallery -->
            <div class="grid grid-cols-3 gap-4 product-gallery">
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                array_unshift($attachment_ids, $main_image_id); // Add main image to gallery
                foreach ($attachment_ids as $attachment_id) {
                    $image_url = wp_get_attachment_image_src($attachment_id, 'thumbnail')[0];
                    $full_image_url = wp_get_attachment_image_src($attachment_id, 'full')[0];
                    ?>
                    <div class="bg-[#1a1f1a] p-2 rounded-xl cursor-pointer hover:opacity-75 transition-opacity gallery-thumbnail"
                         data-full-image="<?php echo esc_url($full_image_url); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" 
                             alt="Product thumbnail" 
                             class="w-full h-auto object-contain rounded-lg">
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <!-- Right Column - Product Info -->
        <div class="text-white">
            <h1 class="text-3xl font-bold mb-2"><?php echo esc_html($product->get_name()); ?></h1>
            
            <!-- Brand & Category Info -->
            <div class="mb-4">
                <p class="text-[#9EB89E]">
                    <?php
                    $categories = $product->get_categories();
                    echo wp_kses_post($categories);
                    ?>
                </p>
            </div>

            <!-- Price -->
            <div class="text-2xl font-bold mb-6">
                <?php echo $product->get_price_html(); ?>
            </div>

            <form class="cart" method="post" enctype="multipart/form-data">
                <!-- Size Selection -->
                <div class="mb-6">
                    <div class="grid grid-cols-6 gap-2">
                        <?php
                        $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                        foreach ($sizes as $size) {
                            ?>
                            <label class="relative">
                                <input type="radio" name="size" value="<?php echo esc_attr($size); ?>" class="absolute opacity-0" required>
                                <span class="block text-center py-2 px-3 bg-[#324132] rounded-lg cursor-pointer hover:bg-[#425142] transition-colors size-option">
                                    <?php echo esc_html($size); ?>
                                </span>
                            </label>
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <!-- Personalization -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold mb-3">Personalize</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm mb-1">Name</label>
                            <input type="text" name="custom_name" placeholder="Your Name" maxlength="20"
                                   class="w-full px-3 py-2 bg-[#324132] rounded-lg border border-[#425142] focus:outline-none focus:border-white">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Number</label>
                            <input type="number" name="custom_number" placeholder="0-99" min="0" max="99"
                                   class="w-full px-3 py-2 bg-[#324132] rounded-lg border border-[#425142] focus:outline-none focus:border-white">
                        </div>
                    </div>
                </div>

                <!-- Badge Options -->
                <div class="mb-6 badge-options">
                    <div class="flex gap-3">
                        <label class="flex items-center">
                            <input type="radio" name="badge" value="none" class="mr-2" checked>
                            <span>No badge</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="badge" value="league" class="mr-2">
                            <span>League badge</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="badge" value="ucl" class="mr-2">
                            <span>UCL badge</span>
                        </label>
                    </div>
                </div>

                <!-- Product Care -->
                <div class="mb-6 product-care">
                    <button type="button" class="w-full py-3 px-4 bg-[#324132] rounded-lg text-left flex justify-between items-center">
                        <span>Product Care</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div class="mt-2 p-4 bg-[#324132] rounded-lg hidden">
                        <ul class="list-disc list-inside space-y-2">
                            <li>Cool wash</li>
                            <li>Do not bleach</li>
                            <li>Do not tumble dry</li>
                            <li>Do not use fabric softener</li>
                            <li>Wash inside out</li>
                            <li>Use a cool iron</li>
                        </ul>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" 
                        class="w-full py-3 bg-[#12A212] hover:bg-[#0E800E] rounded-lg text-white font-semibold transition-colors">
                    Add to Cart
                </button>

                <?php do_action('woocommerce_after_add_to_cart_button'); ?>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Size selection
    const sizeInputs = document.querySelectorAll('input[name="size"]');
    sizeInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Remove active class from all
            sizeInputs.forEach(inp => {
                inp.nextElementSibling.classList.remove('bg-white', 'text-black');
            });
            // Add active class to selected
            if (this.checked) {
                this.nextElementSibling.classList.add('bg-white', 'text-black');
            }
        });
    });

    // Product care accordion
    const careButton = document.querySelector('.product-care button');
    const careContent = careButton.nextElementSibling;
    careButton.addEventListener('click', function() {
        careContent.classList.toggle('hidden');
        const svg = this.querySelector('svg');
        svg.style.transform = careContent.classList.contains('hidden') ? '' : 'rotate(180deg)';
    });

    // Gallery functionality
    const mainImage = document.querySelector('.main-product-image');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const fullImageUrl = this.dataset.fullImage;
            mainImage.src = fullImageUrl;
            
            // Add active state to clicked thumbnail
            thumbnails.forEach(thumb => thumb.classList.remove('ring-2', 'ring-[#12A212]'));
            this.classList.add('ring-2', 'ring-[#12A212]');
        });
    });

    // Set first thumbnail as active by default
    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('ring-2', 'ring-[#12A212]');
    }

    // Form validation
    const form = document.querySelector('form.cart');
    form.addEventListener('submit', function(e) {
        const selectedSize = document.querySelector('input[name="size"]:checked');
        if (!selectedSize) {
            e.preventDefault();
            alert('Please select a size');
        }
    });

    // Number input validation
    const numberInput = document.querySelector('input[name="custom_number"]');
    numberInput.addEventListener('input', function() {
        const value = parseInt(this.value);
        if (value < 0) this.value = 0;
        if (value > 99) this.value = 99;
    });
});
</script>

<?php
endwhile;
get_footer();
?> 