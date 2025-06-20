<?php
/**
 * Cart Page Template
 */

defined('ABSPATH') || exit;

get_header();
?>

<div class="min-h-screen bg-[#212821] text-white py-12">
    <div class="container mx-auto px-4">
        <?php do_action('woocommerce_before_cart'); ?>

        <h1 class="text-3xl font-bold mb-8">Your Cart</h1>

        <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
            <?php do_action('woocommerce_before_cart_table'); ?>

            <div class="space-y-8">
                <?php
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        ?>
                        <div class="cart-item">
                            <!-- Quantity and Product Info -->
                            <div class="mb-4">
                                <div class="text-sm text-gray-400">Quantity: <?php echo $cart_item['quantity']; ?></div>
                                <div class="text-xl font-bold"><?php echo $_product->get_name(); ?></div>
                                <div class="text-sm text-gray-400"><?php echo $_product->get_categories(); ?></div>
                            </div>

                            <!-- Personalization Details -->
                            <?php if (!empty($cart_item['custom_name']) || !empty($cart_item['custom_number']) || !empty($cart_item['size']) || !empty($cart_item['badge'])) : ?>
                                <div class="bg-[#1a1f1a] rounded-lg p-4 mb-4">
                                    <div class="text-sm font-medium mb-2">Personalize</div>
                                    <div class="grid grid-cols-2 gap-4">
                                        <?php if (!empty($cart_item['custom_name'])) : ?>
                                            <div class="bg-[#293829] rounded-lg px-3 py-2">
                                                <span class="text-[#9EB89E]">Name</span>
                                                <div><?php echo esc_html($cart_item['custom_name']); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($cart_item['custom_number'])) : ?>
                                            <div class="bg-[#293829] rounded-lg px-3 py-2">
                                                <span class="text-[#9EB89E]">Number</span>
                                                <div># <?php echo esc_html($cart_item['custom_number']); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($cart_item['size'])) : ?>
                                            <div class="bg-[#293829] rounded-lg px-3 py-2">
                                                <span class="text-[#9EB89E]">Size</span>
                                                <div><?php echo esc_html($cart_item['size']); ?></div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!empty($cart_item['badge'])) : ?>
                                            <div class="bg-[#293829] rounded-lg px-3 py-2">
                                                <span class="text-[#9EB89E]">Badge</span>
                                                <div><?php echo esc_html($cart_item['badge']); ?></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Product Image and Total -->
                            <div class="flex justify-between items-start">
                                <div class="bg-[#1a1f1a] rounded-xl p-2 w-24 h-24">
                                    <?php
                                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                                    echo $thumbnail;
                                    ?>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-400">Total</div>
                                    <div class="text-xl font-bold">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key);
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit/Remove Buttons -->
                            <div class="flex justify-between mt-4">
                                <button type="button" class="text-sm text-[#9EB89E] hover:text-white transition-colors"
                                        onclick="window.location.href='<?php echo $product_permalink; ?>'">
                                    EDIT
                                </button>
                                <?php
                                echo apply_filters('woocommerce_cart_item_remove_link',
                                    sprintf(
                                        '<a href="%s" class="text-sm text-[#9EB89E] hover:text-white transition-colors" aria-label="%s">REMOVE</a>',
                                        esc_url(wc_get_cart_remove_url($cart_item_key)),
                                        esc_html__('Remove this item', 'woocommerce')
                                    ),
                                    $cart_item_key
                                );
                                ?>
                            </div>
                        </div>
                        <hr class="border-[#425142] my-6">
                        <?php
                    }
                }
                ?>
            </div>

            <?php do_action('woocommerce_cart_contents'); ?>

            <!-- Payment Methods -->
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Payment Methods</h3>
                <div class="flex gap-2">
                    <button type="button" class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
                        PayPal
                    </button>
                    <button type="button" class="px-4 py-2 bg-[#12A212] rounded-lg text-white hover:bg-[#0E800E] transition-colors">
                        iDeal
                    </button>
                    <button type="button" class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
                        Giro Pay
                    </button>
                    <button type="button" class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
                        Mastercard
                    </button>
                    <button type="button" class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors">
                        Visa Card
                    </button>
                </div>
            </div>

            <!-- Cart Actions -->
            <div class="flex justify-between items-center mt-8">
                <button type="submit" class="px-4 py-2 bg-[#293829] rounded-lg text-white hover:bg-[#324132] transition-colors" 
                        name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>">
                    Update latest changes
                </button>

                <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" 
                   class="px-6 py-2 bg-[#12A212] rounded-lg text-white hover:bg-[#0E800E] transition-colors">
                    Proceed to Checkout
                </a>
            </div>

            <?php do_action('woocommerce_after_cart_contents'); ?>
            <?php do_action('woocommerce_after_cart_table'); ?>
        </form>

        <?php do_action('woocommerce_after_cart'); ?>
    </div>
</div>

<?php get_footer(); ?>
