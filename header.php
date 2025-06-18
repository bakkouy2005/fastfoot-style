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
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bg-[#181d18] shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.svg" alt="FastFoot Style" class="h-8">
            <span class="text-white text-xl font-bold ml-2">Fast Foot Style</span>
        </a>
        
        <!-- Main Navigation -->
        <nav class="hidden md:flex space-x-8">
            <a href="#" class="text-white hover:text-gray-300">Men</a>
            <a href="#" class="text-white hover:text-gray-300">Women</a>
            <a href="#" class="text-white hover:text-gray-300">Kids</a>
            <a href="#" class="text-white hover:text-gray-300">Sale</a>
            <a href="#" class="text-white hover:text-gray-300">Contact</a>
            <div class="flex items-center space-x-6">
            <button class="text-white hover:text-gray-300">
                <i class="fas fa-search text-xl"></i>
            </button>
            <button class="text-white hover:text-gray-300">
                <i class="fas fa-user text-xl"></i>
            </button>
            <button class="text-white hover:text-gray-300">
                <i class="fas fa-shopping-bag text-xl"></i>
            </button>
        </div>
        </nav>

        <!-- Icons -->
        

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-white">
            <i class="fas fa-bars text-xl"></i>
        </button>
    </div>
</header>
