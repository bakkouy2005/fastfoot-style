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
                <a href="<?php echo site_url('cart'); ?>" class="text-white bg-[#333d33]/80 hover:bg-[#333d33] rounded-xl p-2 px-3 transition-all duration-300 inline-block">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </a>
            </div>
        </nav>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-white relative z-10">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</header>

<!-- Spacer to prevent content from going under fixed header -->
<div class="h-32"></div>
