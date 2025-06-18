<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/src/style.css">

</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container mx-auto flex justify-between items-center py-4 px-0">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
            <img src="<?php echo get_template_directory_uri(); ?>/images/image copy 2.png" alt="Fast Foot Style" class="h-22 md:h-20 w-auto ">
        </a>
        
        <!-- Main Navigation -->
        <nav class="hidden md:flex space-x-8">
        <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'menu_class' => 'flex items-center space-x-6',
                'add_li_class' => 'text-white'
            ));
            ?>
            <div class="flex items-center space-x-6">
                <button class="text-white bg-[#333d33] hover:text-gray-300 rounded-xl p-2 px-3">
                    <i class="fas fa-search text-xl"></i>
                </button>
                <button class="text-white bg-[#333d33] hover:text-gray-300 rounded-xl p-2 px-3">
                    <i class="fas fa-user text-xl"></i>
                </button>
                <button class="text-white bg-[#333d33] hover:text-gray-300 rounded-xl p-2 px-3">
                    <i class="fas fa-shopping-bag text-xl"></i>
                </button>
            </div>
        </nav>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-white">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</header>
