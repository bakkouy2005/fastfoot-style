<?php
/**
 * Template Name: Product Page Template
 */

get_header();

// Add personalization data to cart
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    if (isset($_POST['size'])) {
        $cart_item_data['personalization']['size'] = sanitize_text_field($_POST['size']);
    }
    if (isset($_POST['custom_name'])) {
        $cart_item_data['personalization']['name'] = sanitize_text_field($_POST['custom_name']);
    }
    if (isset($_POST['custom_number'])) {
        $cart_item_data['personalization']['number'] = sanitize_text_field($_POST['custom_number']);
    }
    if (isset($_POST['badge'])) {
        $cart_item_data['personalization']['badge'] = sanitize_text_field($_POST['badge']);
    }
    
    return $cart_item_data;
}, 10, 2);

// Ensure unique cart item when personalization is different
add_filter('woocommerce_add_cart_item_data', function($cart_item_data, $product_id) {
    $unique_key = md5(serialize($cart_item_data['personalization'] ?? []));
    $cart_item_data['unique_key'] = $unique_key;
    return $cart_item_data;
}, 11, 2);

while (have_posts()) :
    the_post();
    global $product;
?>

<div class=" min-h-screen text-white">
    <!-- Notification container -->
    <div id="notification" class="fixed top-4 right-4 z-50 transform translate-x-full transition-transform duration-300 bg-[#12A212] text-white px-6 py-4 rounded-lg shadow-lg">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <span>Product succesvol toegevoegd aan winkelwagen!</span>
        </div>
    </div>
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            <!-- Left Column - Product Images -->
            <div class="relative">
                <!-- Main Image -->
                <div class="bg-[#1a1f1a] p-4 rounded-2xl mb-4">
                    <?php
                    $main_image_id = $product->get_image_id();
                    $main_image = wp_get_attachment_image_src($main_image_id, 'full');
                    ?>
                    <img src="<?php echo esc_url($main_image[0]); ?>" 
                         alt="<?php echo esc_attr($product->get_name()); ?>"
                         class="w-full h-auto object-contain rounded-xl main-product-image">
                </div>

                <!-- Thumbnails -->
                <div class="grid grid-cols-4 gap-4 product-gallery">
                    <?php
                    $attachment_ids = $product->get_gallery_image_ids();
                    array_unshift($attachment_ids, $main_image_id);
                    foreach ($attachment_ids as $attachment_id) {
                        $image_url = wp_get_attachment_image_src($attachment_id, 'thumbnail')[0];
                        $full_image_url = wp_get_attachment_image_src($attachment_id, 'full')[0];
                        ?>
                        <div class="bg-[#1a1f1a] p-1 rounded-xl cursor-pointer hover:opacity-75 transition-opacity gallery-thumbnail"
                             data-full-image="<?php echo esc_url($full_image_url); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" 
                                 alt="Product thumbnail" 
                                 class="w-full aspect-square object-cover rounded-lg">
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <!-- Right Column - Info -->
            <div>
                <!-- Title -->
                <h1 class="text-4xl font-bold mb-3"><?php echo esc_html($product->get_name()); ?></h1>

                <!-- Category / Brand -->
                <p class="text-sm text-[#9EB89E] uppercase tracking-wide mb-4">
                    <?php echo wp_kses_post($product->get_categories()); ?>
                </p>

                <!-- Add to cart form -->
                <form class="cart" method="post" enctype="multipart/form-data">
                    <!-- Price and Add to Cart -->
                    <div class="flex items-center justify-between mb-8">
                        <div class="text-2xl font-bold">
                            <?php echo $product->get_price_html(); ?>
                        </div>
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" 
                                class="px-6 py-2 bg-[#12A212] hover:bg-[#0E800E] rounded-lg text-white font-medium transition">
                            Add to Cart
                        </button>
                    </div>

                    <!-- Size -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Select size</h3>
                        <div class="flex flex-wrap gap-3">
                            <?php
                            $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
                            foreach ($sizes as $size) {
                            ?>
                            <label class="relative">
                                <input type="radio" 
                                       name="personalization[size]" 
                                       value="<?php echo esc_attr($size); ?>" 
                                       class="sr-only peer" 
                                       required>
                                <div class="w-12 h-12 bg-[#293829] text-white rounded-[8px] flex items-center justify-center font-medium text-[16px] leading-[24px] peer-checked:border-[2px] peer-checked:border-[#12A212] transition-all cursor-pointer hover:border-white">
                                    <?php echo esc_html($size); ?>
                                </div>
                            </label>
                            <?php } ?>
                        </div>
                    </div>

                    <!-- Personalize -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4">Personalize</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm mb-1">Name</label>
                                <input type="text" 
                                       name="personalization[name]" 
                                       placeholder="Your Name" 
                                       maxlength="20"
                                       class="w-full px-3 py-2 bg-[#1a1f1a] border border-[#425142] rounded-lg focus:outline-none focus:border-white">
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Number</label>
                                <input type="number" 
                                       name="personalization[number]" 
                                       placeholder="0-99" 
                                       min="0" 
                                       max="99"
                                       class="w-full px-3 py-2 bg-[#1a1f1a] border border-[#425142] rounded-lg focus:outline-none focus:border-white">
                            </div>
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-4 text-white">Select badge</h3>
                        <div class="flex flex-wrap gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" 
                                       name="personalization[badge]" 
                                       value="No badge" 
                                       class="sr-only peer" 
                                       required>
                                <div class="px-4 h-[44px] flex items-center justify-center bg-[#293829] text-white text-[14px] leading-[21px] font-medium border border-[#3D543D] rounded-[12px] peer-checked:border-white peer-checked:bg-[#3D543D] transition-all">
                                    No badge
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" 
                                       name="personalization[badge]" 
                                       value="League badge" 
                                       class="sr-only peer" 
                                       required>
                                <div class="px-4 h-[44px] flex items-center justify-center bg-[#293829] text-white text-[14px] leading-[21px] font-medium border border-[#3D543D] rounded-[12px] peer-checked:border-white peer-checked:bg-[#3D543D] transition-all">
                                    League badge
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" 
                                       name="personalization[badge]" 
                                       value="UCL badge" 
                                       class="sr-only peer" 
                                       required>
                                <div class="px-4 h-[44px] flex items-center justify-center bg-[#293829] text-white text-[14px] leading-[21px] font-medium border border-[#3D543D] rounded-[12px] peer-checked:border-white peer-checked:bg-[#3D543D] transition-all">
                                    UCL badge
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Product care accordion -->
                    <div class="mb-8 product-care">
                        <button type="button" class="w-full py-3 px-4 bg-[#1a1f1a] rounded-2xl text-left flex justify-between items-center hover:bg-[#2a2f2a] transition">
                            <span>Product Care</span>
                            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="mt-3 p-4 bg-[#1a1f1a] rounded-xl hidden text-sm text-[#CFCFCF]">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Cool wash</li>
                                <li>Do not bleach</li>
                                <li>Do not tumble dry</li>
                                <li>Do not use fabric softener</li>
                                <li>Wash inside out</li>
                                <li>Use a cool iron</li>
                            </ul>
                        </div>
                    </div>

                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show notification function
    function showNotification() {
        const notification = document.getElementById('notification');
        notification.style.transform = 'translateX(0)';
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
        }, 3000);
    }

    // Active style for sizes
    const sizeInputs = document.querySelectorAll('input[name="personalization[size]"]');
    sizeInputs.forEach(input => {
        input.addEventListener('change', function() {
            sizeInputs.forEach(inp => inp.nextElementSibling.classList.remove('bg-white', 'text-black', 'border-white'));
            if (this.checked) {
                this.nextElementSibling.classList.add('bg-white', 'text-black', 'border-white');
            }
        });
    });

    // Active style for badges
    const badgeInputs = document.querySelectorAll('input[name="personalization[badge]"]');
    badgeInputs.forEach(input => {
        input.addEventListener('change', function() {
            badgeInputs.forEach(inp => inp.nextElementSibling.classList.remove('border-white', 'bg-[#3D543D]'));
            if (this.checked) {
                this.nextElementSibling.classList.add('border-white', 'bg-[#3D543D]');
            }
        });
    });

    // Gallery
    const mainImage = document.querySelector('.main-product-image');
    const thumbnails = document.querySelectorAll('.gallery-thumbnail');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            const fullImageUrl = this.dataset.fullImage;
            mainImage.src = fullImageUrl;
            thumbnails.forEach(thumb => thumb.classList.remove('ring-2', 'ring-[#12A212]'));
            this.classList.add('ring-2', 'ring-[#12A212]');
        });
    });

    if (thumbnails.length > 0) {
        thumbnails[0].classList.add('ring-2', 'ring-[#12A212]');
    }

    // Product care accordion (only initialize if it exists)
    const careButton = document.querySelector('.product-care button');
    const careContent = careButton?.nextElementSibling;
    
    if (careButton && careContent) {
        careButton.addEventListener('click', function() {
            careContent.classList.toggle('hidden');
            const svg = this.querySelector('svg');
            svg.style.transform = careContent.classList.contains('hidden') ? '' : 'rotate(180deg)';
        });
    }

    // Form submission
    const form = document.querySelector('form.cart');
    form.addEventListener('submit', function(e) {
        if (!document.querySelector('input[name="personalization[size]"]]:checked')) {
            e.preventDefault();
            alert('Please select a size');
            return;
        }
        if (!document.querySelector('input[name="personalization[badge]"]]:checked')) {
            e.preventDefault();
            alert('Please select a badge option');
            return;
        }
        
        // If all required fields are selected, show notification after a small delay
        setTimeout(showNotification, 500);
    });

    // Number input validation
    const numberInput = document.querySelector('input[name="personalization[number]"]');
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