<?php
/* Template Name: Cart Page */

defined('ABSPATH') || exit;

get_header();
?>

<div class="min-h-screen bg-[#212821] text-white py-12">
    <div class="container mx-auto px-4">
        <?php do_action('woocommerce_before_cart'); ?>

        <h1 class="text-3xl font-bold mb-8">Your Cart</h1>

        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

    <div class="space-y-6">
        <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
            $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

            if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
                $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                $thumbnail = $_product->get_image('woocommerce_thumbnail', ['class' => 'object-cover w-full h-full']);
        ?>

        <div class="bg-[#1a1f1a] rounded-xl p-6 space-y-4 shadow-lg">
            <div class="flex justify-between items-center gap-4">
                <div class="flex flex-col gap-1">
                    <div class="text-sm text-gray-400">Quantity: <?php echo $cart_item['quantity']; ?></div>
                    <div class="text-xl font-bold text-white"><?php echo $_product->get_name(); ?></div>
                    <div class="text-sm text-gray-400"><?php echo $_product->get_categories(); ?></div>
                </div>

                <div class="w-28 h-28 rounded-xl overflow-hidden border-2 border-[#2e382e]">
                    <?php echo $thumbnail; ?>
                </div>
            </div>

            <?php if (!empty($cart_item['personalization'])): ?>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                    <div>
                        <span class="text-xs text-[#9EB89E] uppercase">Name</span>
                        <p class="text-sm text-white"><?php echo esc_html($cart_item['personalization']['name'] ?? ''); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-[#9EB89E] uppercase">Number</span>
                        <p class="text-sm text-white"><?php echo esc_html($cart_item['personalization']['number'] ?? ''); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-[#9EB89E] uppercase">Size</span>
                        <p class="text-sm text-white"><?php echo esc_html($cart_item['personalization']['size'] ?? ''); ?></p>
                    </div>
                    <div>
                        <span class="text-xs text-[#9EB89E] uppercase">Badge</span>
                        <p class="text-sm text-white"><?php echo esc_html($cart_item['personalization']['badge'] ?? ''); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mt-4">
                <button type="button" class="text-sm text-[#9EB89E] hover:text-white font-semibold" onclick="window.location.href='<?php echo $product_permalink; ?>'">EDIT</button>

                <a href="<?php echo esc_url(wc_get_cart_remove_url($cart_item_key)); ?>" class="text-sm text-[#9EB89E] hover:text-white font-semibold">REMOVE</a>
            </div>
        </div>

        <?php endif; endforeach; ?>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8">
        <button type="submit" name="update_cart"
                class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
            Update latest changes
        </button>

        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"
           class="px-6 py-2 bg-[#12A212] rounded-lg text-white hover:bg-[#0E800E] transition-colors">
            Proceed to Checkout
        </a>
    </div>

    <?php do_action('woocommerce_cart_contents'); ?>
    <?php do_action('woocommerce_cart_actions'); ?>
    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
</form>

<!-- Payment Methods -->
<div class="mt-10">
    <h3 class="text-white text-lg font-semibold mb-4">Choose your payment method</h3>
    <div class="grid grid-cols-3 sm:grid-cols-5 gap-2">
        <button class="px-4 py-2 bg-[#293829] rounded-lg text-sm font-medium hover:bg-[#324132]">Paypal</button>
        <button class="px-4 py-2 bg-[#12A212] rounded-lg text-sm font-medium hover:bg-[#0E800E]">iDeal</button>
        <button class="px-4 py-2 bg-[#293829] rounded-lg text-sm font-medium hover:bg-[#324132]">Giro Pay</button>
        <button class="px-4 py-2 bg-[#293829] rounded-lg text-sm font-medium hover:bg-[#324132]">Mastercard</button>
        <button class="px-4 py-2 bg-[#293829] rounded-lg text-sm font-medium hover:bg-[#324132]">Visa Card</button>
    </div>
</div>

<?php do_action('woocommerce_after_cart'); ?>
    </div>
</div>

<?php get_footer(); ?>
