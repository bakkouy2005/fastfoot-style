<?php
/**
 * Template Name: Cart Page
 */

get_header();
?>

<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold mb-8 text-white">Shopping Cart</h1>

    <?php if (WC()->cart->is_empty()) : ?>
        <div class="bg-[#324132] rounded-[12px] p-8 text-center">
            <p class="text-white text-xl mb-6">Your cart is currently empty.</p>
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" 
               class="inline-flex items-center justify-center px-8 py-3 text-base bg-white rounded-[12px] text-[#324132] font-medium hover:bg-[#9EB89E] hover:text-white transition-colors">
                Return to Shop
            </a>
        </div>
    <?php else : ?>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-[#324132] rounded-[12px] p-6">
                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : 
                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0) :
                    ?>
                        <div class="flex items-center gap-6 py-6 border-b border-[#9EB89E] last:border-0">
                            <div class="w-24 h-24 bg-[url('/wp-content/themes/fastfoot-style/assets/images/mesh-pattern.png')] bg-cover rounded-[12px] overflow-hidden">
                                <?php echo $_product->get_image('thumbnail', ['class' => 'w-full h-full object-contain']); ?>
                            </div>
                            <div class="flex-grow">
                                <h3 class="text-xl font-bold text-white"><?php echo $_product->get_name(); ?></h3>
                                <p class="text-[#9EB89E] mt-2">
                                    Price: <?php echo WC()->cart->get_product_price($_product); ?>
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center bg-[#1a231a] rounded-[12px] p-2">
                                    <button class="px-3 py-1 text-white hover:text-[#9EB89E] quantity-button" 
                                            data-action="decrease" 
                                            data-key="<?php echo $cart_item_key; ?>">-</button>
                                    <input type="number" 
                                           value="<?php echo $cart_item['quantity']; ?>" 
                                           class="w-12 text-center bg-transparent text-white" 
                                           data-key="<?php echo $cart_item_key; ?>"
                                           min="0">
                                    <button class="px-3 py-1 text-white hover:text-[#9EB89E] quantity-button" 
                                            data-action="increase" 
                                            data-key="<?php echo $cart_item_key; ?>">+</button>
                                </div>
                                <button class="text-[#9EB89E] hover:text-white transition-colors remove-item" 
                                        data-key="<?php echo $cart_item_key; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="lg:col-span-1">
                <div class="bg-[#324132] rounded-[12px] p-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Cart Summary</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between text-[#9EB89E]">
                            <span>Subtotal</span>
                            <span><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                        </div>
                        <?php if (WC()->cart->get_cart_shipping_total()) : ?>
                        <div class="flex justify-between text-[#9EB89E]">
                            <span>Shipping</span>
                            <span><?php echo WC()->cart->get_cart_shipping_total(); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="flex justify-between text-white font-bold text-xl pt-4 border-t border-[#9EB89E]">
                            <span>Total</span>
                            <span><?php echo WC()->cart->get_cart_total(); ?></span>
                        </div>
                    </div>
                    <div class="mt-8">
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" 
                           class="block w-full text-center px-8 py-3 text-base bg-white rounded-[12px] text-[#324132] font-medium hover:bg-[#9EB89E] hover:text-white transition-colors">
                            Proceed to Checkout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
jQuery(document).ready(function($) {
    // Update quantity
    $('.quantity-button').on('click', function(e) {
        e.preventDefault();
        const input = $(this).siblings('input');
        const currentVal = parseInt(input.val());
        const action = $(this).data('action');
        
        if (action === 'increase') {
            input.val(currentVal + 1).trigger('change');
        } else if (action === 'decrease' && currentVal > 1) {
            input.val(currentVal - 1).trigger('change');
        }
    });

    // Handle quantity change
    $('input[type="number"]').on('change', function() {
        const key = $(this).data('key');
        const qty = $(this).val();

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'update_cart_item',
                cart_item_key: key,
                quantity: qty
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });

    // Remove item
    $('.remove-item').on('click', function(e) {
        e.preventDefault();
        const key = $(this).data('key');

        $.ajax({
            type: 'POST',
            url: wc_add_to_cart_params.ajax_url,
            data: {
                action: 'remove_cart_item',
                cart_item_key: key
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
});
</script>

<?php
get_footer();
?>
