<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header fixed w-full top-0 z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-4">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center relative z-10">
            <img src="<?php echo get_template_directory_uri(); ?>/images/image copy 2.png" alt="Fast Foot Style" class="h-22 md:h-20 w-auto">
        </a>
        
        <!-- Main Navigation -->
        <nav class="hidden md:flex space-x-8 relative z-10">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'menu_class' => 'flex items-center space-x-6',
                'add_li_class' => 'text-white'
            ));
            ?>
            <div class="flex items-center space-x-6">
                <button class="text-white bg-[#333d33]/80 hover:bg-[#333d33] rounded-xl p-2 px-3 transition-all duration-300">
                    <i class="fas fa-search text-xl"></i>
                </button>
                <button class="text-white bg-[#333d33]/80 hover:bg-[#333d33] rounded-xl p-2 px-3 transition-all duration-300">
                    <i class="fas fa-user text-xl"></i>
                </button>
                <div class="relative group">
                    <a href="<?php echo site_url('cart'); ?>" class="text-white bg-[#333d33]/80 hover:bg-[#333d33] rounded-xl p-2 px-3 transition-all duration-300 inline-block">
                        <i class="fas fa-shopping-bag text-xl"></i>
                    </a>
                    <!-- Cart Dropdown -->
                    <div class="absolute right-0 top-full mt-2 w-80 bg-[#333d33]/80 backdrop-blur-md rounded-xl shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                        <div class="p-4">
                            <?php if (WC()->cart->is_empty()): ?>
                                <p class="text-white/80 text-center py-4">Je winkelwagen is leeg</p>
                            <?php else: ?>
                                <div class="max-h-96 overflow-y-auto">
                                    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): 
                                        $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                        if ($_product && $_product->exists() && $cart_item['quantity'] > 0): ?>
                                            <div class="flex items-center gap-3 pb-4 mb-4 border-b border-white/10">
                                                <div class="w-16 h-16 bg-[#333d33] rounded-lg overflow-hidden">
                                                    <?php echo $_product->get_image('thumbnail'); ?>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="text-sm font-medium text-white"><?php echo $_product->get_name(); ?></h4>
                                                    <p class="text-sm text-white/70">
                                                        <?php echo $cart_item['quantity']; ?> × <?php echo WC()->cart->get_product_price($_product); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        <?php endif;
                                    endforeach; ?>
                                </div>
                                <div class="border-t border-white/10 pt-4 mt-4">
                                    <div class="flex justify-between mb-4">
                                        <span class="text-white/80">Subtotaal:</span>
                                        <span class="font-medium text-white"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
                                    </div>
                                    <a href="<?php echo site_url('cart'); ?>" class="block w-full bg-white/10 text-white text-center py-2 rounded-lg hover:bg-white/20 transition-colors">
                                        Bekijk winkelwagen
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-white relative z-10">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</header>

<!-- Spacer to prevent content from going under fixed header -->
<div class="h-20"></div>
