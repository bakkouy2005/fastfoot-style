<?php
/* Template Name: Cart Page */

defined('ABSPATH') || exit;

// Handle cart updates
if (isset($_POST['update_cart']) && isset($_POST['cart'])) {
    foreach ($_POST['cart'] as $cart_item_key => $values) {
        $quantity = wc_stock_amount($values['qty']);
        WC()->cart->set_quantity($cart_item_key, $quantity, true);

        // Update personalization data
        if (isset($values['personalization'])) {
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
    wc_add_notice(__('Cart updated.', 'woocommerce'));
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
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
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
        ?>

        <div class="bg-[#1a1f1a] rounded-xl p-6 space-y-4 shadow-lg">
            <div class="flex justify-between items-center gap-4">
                <div class="flex flex-col gap-1">
                    <div class="text-xl font-bold text-white"><?php echo $_product->get_name(); ?></div>
                    <div class="text-sm text-gray-400"><?php echo $_product->get_categories(); ?></div>
                    <div class="text-lg font-bold text-[#12A212]">
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
                           class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212]">
                </div>
                <div>
                    <label class="block text-xs text-[#9EB89E] uppercase mb-1">Number</label>
                    <input type="number" 
                           name="cart[<?php echo $cart_item_key; ?>][personalization][number]" 
                           value="<?php echo esc_attr($personalization['number']); ?>"
                           min="0" 
                           max="99"
                           class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212]">
                </div>
                <div>
                    <label class="block text-xs text-[#9EB89E] uppercase mb-1">Size</label>
                    <select name="cart[<?php echo $cart_item_key; ?>][personalization][size]"
                            class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212]">
                        <?php
                        $sizes = array('XS', 'S', 'M', 'L', 'XL', 'XXL');
                        foreach ($sizes as $size) {
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
                            class="w-full px-3 py-2 bg-[#293829] rounded-lg text-white text-sm border-none focus:outline-none focus:ring-1 focus:ring-[#12A212]">
                        <?php
                        $badges = array(
                            'No badge' => 'No badge',
                            'League badge' => 'League badge',
                            'UCL badge' => 'UCL badge'
                        );
                        foreach ($badges as $value => $label) {
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
                           class="w-12 h-8 bg-[#293829] rounded-lg text-center text-white border-none focus:outline-none focus:ring-1 focus:ring-[#12A212]" 
                           min="1" 
                           max="99">
                    <button type="button" 
                            class="w-8 h-8 flex items-center justify-center bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors quantity-increase" 
                            data-cart-key="<?php echo $cart_item_key; ?>">
                        <span class="text-lg">+</span>
                    </button>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-lg font-bold">
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
        <button type="submit" name="update_cart"
                class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
            Update latest changes
        </button>

        <div class="flex items-center gap-4">
            <div class="text-lg">
                Total: <span class="font-bold"><?php echo WC()->cart->get_cart_total(); ?></span>
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
    // Function to update cart quantity via AJAX
    function updateCartQuantity(cartKey, newQty) {
        const data = {
            action: 'update_cart_quantity',
            cart_item_key: cartKey,
            quantity: newQty,
            security: wc_cart_params.update_shipping_method_nonce
        };

        jQuery.ajax({
            type: 'POST',
            url: wc_cart_params.ajax_url,
            data: data,
            beforeSend: function() {
                jQuery('body').addClass('updating-cart');
            },
            success: function(response) {
                jQuery('body').removeClass('updating-cart');
                if (response && response.fragments) {
                    jQuery.each(response.fragments, function(key, value) {
                        jQuery(key).replaceWith(value);
                    });
                }
                // Update the hidden input with the new quantity
                const qtyInput = document.querySelector(`input[name="cart[${cartKey}][qty]"]`);
                if (qtyInput) {
                    qtyInput.value = newQty;
                }
                jQuery(document.body).trigger('updated_cart_totals');
            }
        });
    }

    // Handle quantity decrease
    document.querySelectorAll('.quantity-decrease').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.nextElementSibling;
            const currentValue = parseInt(input.value);
            const cartKey = this.dataset.cartKey;
            if (currentValue > 1) {
                const newQty = currentValue - 1;
                input.value = newQty;
                updateCartQuantity(cartKey, newQty);
            }
        });
    });

    // Handle quantity increase
    document.querySelectorAll('.quantity-increase').forEach(button => {
        button.addEventListener('click', function() {
            const input = this.previousElementSibling;
            const currentValue = parseInt(input.value);
            const cartKey = this.dataset.cartKey;
            if (currentValue < 99) {
                const newQty = currentValue + 1;
                input.value = newQty;
                updateCartQuantity(cartKey, newQty);
            }
        });
    });

    // Handle direct input changes
    document.querySelectorAll('input[name^="cart"][name$="[qty]"]').forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (value < 1) value = 1;
            if (value > 99) value = 99;
            this.value = value;
            
            const cartKey = this.name.match(/cart\[(.*?)\]/)[1];
            updateCartQuantity(cartKey, value);
        });
    });

    // Handle form submission
    const form = document.querySelector('.woocommerce-cart-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Remove updating-cart class if it was left there
            jQuery('body').removeClass('updating-cart');
        });
    }
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
