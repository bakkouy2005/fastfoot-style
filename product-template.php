<?php
/**
 * Template Name: Product Page Template
 */

get_header();

while (have_posts()) :
    the_post();
    global $product;
?>

<div class=" min-h-screen text-white">
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
                <p class="text-sm text-[#9EB89E] uppercase tracking-wide mb-6">
                    <?php echo wp_kses_post($product->get_categories()); ?>
                </p>

                <!-- Price -->
                <div class="text-2xl font-bold mb-8">
                    <?php echo $product->get_price_html(); ?>
                </div>

                <!-- Add to cart form -->
                <form class="cart" method="post" enctype="multipart/form-data">
                    <!-- Size -->
                    <div class="mb-8">
  <h3 class="text-lg font-semibold mb-4">Select size</h3>
  <div class="flex flex-wrap gap-3">
    <?php
    $sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];
    foreach ($sizes as $size) {
    ?>
      <label class="relative">
        <input type="radio" name="size" value="<?php echo esc_attr($size); ?>" class="sr-only peer" required>
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
                                <input type="text" name="custom_name" placeholder="Your Name" maxlength="20"
                                       class="w-full px-3 py-2 bg-[#1a1f1a] border border-[#425142] rounded-lg focus:outline-none focus:border-white">
                            </div>
                            <div>
                                <label class="block text-sm mb-1">Number</label>
                                <input type="number" name="custom_number" placeholder="0-99" min="0" max="99"
                                       class="w-full px-3 py-2 bg-[#1a1f1a] border border-[#425142] rounded-lg focus:outline-none focus:border-white">
                            </div>
                        </div>
                    </div>

                    <!-- Badge -->
                    <div class="mb-8">
  <h3 class="text-lg font-semibold mb-4 text-white">Select badge</h3>
  <div class="flex flex-wrap gap-3">
    <label class="cursor-pointer">
      <input type="radio" name="badge" value="No badge" class="sr-only peer">
      <div class="px-4 h-[44px] flex items-center justify-center text-white text-[14px] leading-[21px] font-medium border border-[#3D543D] rounded-[12px] peer-checked:border-[#12A212] peer-checked:bg-[#1f2b1f] transition-all">
        No badge
      </div>
    </label>

    <label class="cursor-pointer">
      <input type="radio" name="badge" value="League badge" class="sr-only peer">
      <div class="px-4 h-[44px] flex items-center justify-center text-white text-[14px] leading-[21px] font-medium border border-[#3D543D] rounded-[12px] peer-checked:border-[#12A212] peer-checked:bg-[#1f2b1f] transition-all">
        League badge
      </div>
    </label>

    <label class="cursor-pointer">
      <input type="radio" name="badge" value="UCL badge" class="sr-only peer">
      <div class="px-4 h-[44px] flex items-center justify-center text-white text-[14px] leading-[21px] font-medium border border-[#3D543D] rounded-[12px] peer-checked:border-[#12A212] peer-checked:bg-[#1f2b1f] transition-all">
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

                    <!-- Add to cart -->
                    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" 
                            class="w-full py-3 bg-[#12A212] hover:bg-[#0E800E] rounded-2xl text-white font-bold text-lg transition">
                        Add to Cart
                    </button>

                    <?php do_action('woocommerce_after_add_to_cart_button'); ?>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Active style for sizes
    const sizeInputs = document.querySelectorAll('input[name="size"]');
    sizeInputs.forEach(input => {
        input.addEventListener('change', function() {
            sizeInputs.forEach(inp => inp.nextElementSibling.classList.remove('bg-white', 'text-black', 'border-white'));
            if (this.checked) {
                this.nextElementSibling.classList.add('bg-white', 'text-black', 'border-white');
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

    // Validation
    const form = document.querySelector('form.cart');
    form.addEventListener('submit', function(e) {
        if (!document.querySelector('input[name="size"]:checked')) {
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