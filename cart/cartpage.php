<?php
/* Template Name: Cart Page */

defined('ABSPATH') || exit;

// Handle cart updates
if (isset($_POST['update_cart']) && isset($_POST['cart'])) {
    foreach ($_POST['cart'] as $cart_item_key => $values) {
        $cart_item = WC()->cart->get_cart_item($cart_item_key);
        $product_id = $cart_item['product_id'];
        
        // Get available options for this product
        $available_sizes = get_post_meta($product_id, '_available_sizes', true);
        $available_badges = get_post_meta($product_id, '_available_badges', true);
        
        if (empty($available_sizes)) {
            $available_sizes = array('XS', 'S', 'M', 'L', 'XL', 'XXL');
        }
        if (empty($available_badges)) {
            $available_badges = array('no_badge', 'league_badge', 'ucl_badge');
        }
        
        // Validate size and badge
        if (isset($values['personalization'])) {
            $size = $values['personalization']['size'];
            $badge = $values['personalization']['badge'];
            
            // Check if selected size is still available
            if (!in_array($size, $available_sizes)) {
                wc_add_notice(sprintf(
                    __('Size "%s" is no longer available for product "%s". Please select a different size.', 'woocommerce'),
                    $size,
                    get_the_title($product_id)
                ), 'error');
                continue;
            }
            
            // Check if selected badge is still available
            $badge_key = strtolower(str_replace(' ', '_', $badge));
            if ($badge !== 'No badge' && !in_array($badge_key, $available_badges)) {
                wc_add_notice(sprintf(
                    __('Badge "%s" is no longer available for product "%s". Please select a different badge.', 'woocommerce'),
                    $badge,
                    get_the_title($product_id)
                ), 'error');
                continue;
            }
            
            // Update cart item if validations pass
            $quantity = wc_stock_amount($values['qty']);
            WC()->cart->set_quantity($cart_item_key, $quantity, true);

            $cart_item = WC()->cart->get_cart_item($cart_item_key);
            if ($cart_item) {
                $personalization = array(
                    'name' => sanitize_text_field($values['personalization']['name']),
                    'number' => sanitize_text_field($values['personalization']['number']),
                    'size' => sanitize_text_field($values['personalization']['size']),
                    'badge' => sanitize_text_field($values['personalization']['badge'])
                );
                WC()->cart->cart_contents[$cart_item_key]['personalization'] = $personalization;
            }
        }
    }
    
    WC()->cart->calculate_totals();
    if (!wc_notice_count('error')) {
        wc_add_notice(__('Cart updated.', 'woocommerce'));
    }
}

get_header();
?>

<div class="min-h-screen bg-[#212821] text-white py-12">
    <div class="container mx-auto px-4">
        <?php do_action('woocommerce_before_cart'); ?>

        <h1 class="text-3xl font-bold mb-8">Your Cart</h1>

        <form class="woocommerce-cart-form" action="<?php echo esc_url(get_permalink()); ?>" method="post">
            <div class="space-y-6">
                <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        $thumbnail = $_product->get_image('woocommerce_thumbnail', ['class' => 'object-cover w-full h-full']);
                        
                        // Get personalization data
                        $personalization = isset($cart_item['personalization']) ? $cart_item['personalization'] : array(
                            'name' => '',
                            'number' => '',
                            'size' => '',
                            'badge' => ''
                        );

                        // Get available options and prices for this product
                        $available_sizes = get_post_meta($product_id, '_available_sizes', true);
                        $available_badges = get_post_meta($product_id, '_available_badges', true);
                        $name_number_price = get_post_meta($product_id, '_name_number_price', true);
                        $league_badge_price = get_post_meta($product_id, '_league_badge_price', true);
                        $ucl_badge_price = get_post_meta($product_id, '_ucl_badge_price', true);
                        
                        if (empty($available_sizes)) {
                            $available_sizes = array('XS', 'S', 'M', 'L', 'XL', 'XXL');
                        }
                        if (empty($available_badges)) {
                            $available_badges = array('no_badge', 'league_badge', 'ucl_badge');
                        }

                        // Check if current selections are still available
                        $size_available = in_array($personalization['size'], $available_sizes);
                        $badge_key = strtolower(str_replace(' ', '_', $personalization['badge']));
                        $badge_available = $personalization['badge'] === 'No badge' || in_array($badge_key, $available_badges);
                ?>

                <div class="bg-[#1a1f1a] rounded-xl p-6 space-y-4 shadow-lg <?php echo (!$size_available || !$badge_available) ? 'border-2 border-red-500' : ''; ?>"
                     data-product-id="<?php echo esc_attr($product_id); ?>"
                     data-name-number-price="<?php echo esc_attr($name_number_price); ?>"
                     data-league-badge-price="<?php echo esc_attr($league_badge_price); ?>"
                     data-ucl-badge-price="<?php echo esc_attr($ucl_badge_price); ?>"
                     data-base-price="<?php echo esc_attr($_product->get_price()); ?>">
                    <?php if (!$size_available || !$badge_available): ?>
                        <div class="bg-red-500/10 text-red-500 p-4 rounded-lg mb-4">
                            <?php if (!$size_available): ?>
                                <p>Size "<?php echo esc_html($personalization['size']); ?>" is no longer available. Please select a different size.</p>
                            <?php endif; ?>
                            <?php if (!$badge_available): ?>
                                <p>Badge "<?php echo esc_html($personalization['badge']); ?>" is no longer available. Please select a different badge.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <div class="flex justify-between items-center gap-4">
                        <div class="flex flex-col gap-1">
                            <div class="text-xl font-bold text-white"><?php echo $_product->get_name(); ?></div>
                            <div class="text-sm text-gray-400"><?php echo $_product->get_categories(); ?></div>
                            <div class="text-lg font-bold text-[#12A212] product-price">
                                <?php
                                    echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                                ?>
                            </div>
                        </div>

                        <div class="w-28 h-28 rounded-xl overflow-hidden border-2 border-[#2e382e]">
                            <?php echo $thumbnail; ?>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                        <div>
                            <label class="block text-xs text-[#9EB89E] uppercase mb-1">Name</label>
                            <input type="text" 
                                   name="cart[<?php echo $cart_item_key; ?>][personalization][name]" 
                                   value="<?php echo esc_attr($personalization['name']); ?>"
                                   class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212] personalization-input"
                                   data-type="name">
                        </div>
                        <div>
                            <label class="block text-xs text-[#9EB89E] uppercase mb-1">Number</label>
                            <input type="number" 
                                   name="cart[<?php echo $cart_item_key; ?>][personalization][number]" 
                                   value="<?php echo esc_attr($personalization['number']); ?>"
                                   min="0" 
                                   max="99"
                                   class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212] personalization-input"
                                   data-type="number">
                        </div>
                        <div>
                            <label class="block text-xs text-[#9EB89E] uppercase mb-1">Size</label>
                            <select name="cart[<?php echo $cart_item_key; ?>][personalization][size]"
                                    class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212] <?php echo !$size_available ? 'border-2 border-red-500' : ''; ?> personalization-input"
                                    data-type="size">
                                <?php
                                foreach ($available_sizes as $size) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        esc_attr($size),
                                        selected($personalization['size'], $size, false),
                                        esc_html($size)
                                    );
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs text-[#9EB89E] uppercase mb-1">Badge</label>
                            <select name="cart[<?php echo $cart_item_key; ?>][personalization][badge]"
                                    class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212] <?php echo !$badge_available ? 'border-2 border-red-500' : ''; ?> personalization-input"
                                    data-type="badge">
                                <?php
                                $badge_options = array(
                                    'No badge' => 'No badge'
                                );
                                
                                if (in_array('league_badge', $available_badges)) {
                                    $badge_options['League badge'] = 'League badge';
                                }
                                if (in_array('ucl_badge', $available_badges)) {
                                    $badge_options['UCL badge'] = 'UCL badge';
                                }
                                
                                foreach ($badge_options as $value => $label) {
                                    printf(
                                        '<option value="%s" %s>%s</option>',
                                        esc_attr($value),
                                        selected($personalization['badge'], $value, false),
                                        esc_html($label)
                                    );
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mt-4">
                        <div class="flex items-center gap-2">
                            <button type="button" 
                                    class="w-8 h-8 flex items-center justify-center bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors quantity-decrease" 
                                    data-cart-key="<?php echo $cart_item_key; ?>">
                                <span class="text-lg">-</span>
                            </button>
                            <input type="number" 
                                   name="cart[<?php echo $cart_item_key; ?>][qty]" 
                                   value="<?php echo $cart_item['quantity']; ?>" 
                                   class="w-12 h-8 bg-[#293829] rounded-lg text-center text-white border-none focus:outline-none focus:ring-1 focus:ring-[#12A212] quantity-input" 
                                   min="1" 
                                   max="99">
                            <button type="button" 
                                    class="w-8 h-8 flex items-center justify-center bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors quantity-increase" 
                                    data-cart-key="<?php echo $cart_item_key; ?>">
                                <span class="text-lg">+</span>
                            </button>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-lg font-bold product-subtotal">
                                <?php
                                    echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                ?>
                            </div>
                            <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" 
                               class="text-sm text-[#9EB89E] hover:text-white font-semibold">
                                REMOVE
                            </a>
                        </div>
                    </div>
                </div>

                <?php endif; endforeach; ?>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
                <button type="submit" 
                        name="update_cart"
                        class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
                    Update latest changes
                </button>

                <div class="flex items-center gap-4">
                    <div class="text-lg">
                        Total: <span class="font-bold cart-total"><?php echo WC()->cart->get_cart_total(); ?></span>
                    </div>
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
                       class="px-6 py-2 bg-[#12A212] rounded-lg text-white hover:bg-[#0E800E] transition-colors">
                        Proceed to Checkout
                    </a>
                </div>
            </div>

            <?php do_action('woocommerce_cart_contents'); ?>
            <?php do_action('woocommerce_cart_actions'); ?>
            <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
        </form>

        <?php do_action('woocommerce_after_cart'); ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to calculate personalization costs
    function calculatePersonalizationCosts(container) {
        const basePrice = parseFloat(container.dataset.basePrice) || 0;
        const nameNumberPrice = parseFloat(container.dataset.nameNumberPrice) || 0;
        const leagueBadgePrice = parseFloat(container.dataset.leagueBadgePrice) || 0;
        const uclBadgePrice = parseFloat(container.dataset.uclBadgePrice) || 0;
        
        let extraCost = 0;
        
        // Get personalization inputs
        const nameInput = container.querySelector('input[data-type="name"]');
        const numberInput = container.querySelector('input[data-type="number"]');
        const badgeSelect = container.querySelector('select[data-type="badge"]');
        const quantityInput = container.querySelector('.quantity-input');
        
        // Add name/number cost if either is filled
        if ((nameInput.value && nameInput.value.trim() !== '') || 
            (numberInput.value && numberInput.value.trim() !== '')) {
            extraCost += nameNumberPrice;
        }
        
        // Add badge cost based on selection
        if (badgeSelect.value === 'League badge') {
            extraCost += leagueBadgePrice;
        } else if (badgeSelect.value === 'UCL badge') {
            extraCost += uclBadgePrice;
        }
        
        const quantity = parseInt(quantityInput.value) || 1;
        const totalPrice = (basePrice + extraCost) * quantity;
        
        // Update price display
        const priceDisplay = container.querySelector('.product-price');
        const subtotalDisplay = container.querySelector('.product-subtotal');
        if (priceDisplay) {
            priceDisplay.textContent = formatPrice(basePrice + extraCost);
        }
        if (subtotalDisplay) {
            subtotalDisplay.textContent = formatPrice(totalPrice);
        }
        
        // Update cart total
        updateCartTotal();
    }
    
    // Function to format price
    function formatPrice(price) {
        return '€' + price.toFixed(2);
    }
    
    // Function to update cart total
    function updateCartTotal() {
        let total = 0;
        document.querySelectorAll('.product-subtotal').forEach(subtotal => {
            const price = parseFloat(subtotal.textContent.replace('€', '')) || 0;
            total += price;
        });
        document.querySelector('.cart-total').textContent = formatPrice(total);
    }
    
    // Add event listeners to all personalization inputs
    document.querySelectorAll('.personalization-input').forEach(input => {
        input.addEventListener('change', function() {
            const container = this.closest('[data-product-id]');
            calculatePersonalizationCosts(container);
        });
        
        if (input.type === 'text' || input.type === 'number') {
            input.addEventListener('input', function() {
                const container = this.closest('[data-product-id]');
                calculatePersonalizationCosts(container);
            });
        }
    });
    
    // Add event listeners to quantity buttons
    document.querySelectorAll('.quantity-decrease, .quantity-increase').forEach(button => {
        button.addEventListener('click', function() {
            const container = this.closest('[data-product-id]');
            const input = container.querySelector('.quantity-input');
            let value = parseInt(input.value);
            
            if (this.classList.contains('quantity-decrease') && value > 1) {
                input.value = value - 1;
            } else if (this.classList.contains('quantity-increase') && value < 99) {
                input.value = value + 1;
            }
            
            calculatePersonalizationCosts(container);
        });
    });
    
    // Add event listener to quantity input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const container = this.closest('[data-product-id]');
            let value = parseInt(this.value);
            if (value < 1) value = 1;
            if (value > 99) value = 99;
            this.value = value;
            
            calculatePersonalizationCosts(container);
        });
    });
    
    // Initial calculation for all items
    document.querySelectorAll('[data-product-id]').forEach(container => {
        calculatePersonalizationCosts(container);
    });
});
</script>

<?php
// Add the AJAX handler for cart quantity updates
add_action('wp_ajax_update_cart_quantity', 'handle_update_cart_quantity');
add_action('wp_ajax_nopriv_update_cart_quantity', 'handle_update_cart_quantity');

function handle_update_cart_quantity() {
    check_ajax_referer('update-shipping-method', 'security');

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);

    WC()->cart->set_quantity($cart_item_key, $quantity);

    WC_AJAX::get_refreshed_fragments();
}

// Ensure WooCommerce cart scripts are loaded
add_action('wp_enqueue_scripts', function() {
    if (is_cart()) {
        wp_enqueue_script('wc-cart');
    }
});
?>

<?php get_footer(); ?>
