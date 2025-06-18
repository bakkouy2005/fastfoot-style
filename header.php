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

<header class="glass-effect fixed top-0 left-0 right-0 z-50 shadow-lg">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <!-- Logo -->
        <div class="flex items-center">
            <a href="<?php echo home_url(); ?>" class="text-white text-2xl font-bold">
                <?php bloginfo('name'); ?>
            </a>
        </div>

        <!-- Navigation -->
        <nav>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary-menu',
                'container' => false,
                'menu_class' => 'flex space-x-6',
                'add_li_class' => 'text-white'
            ));
            ?>
        </nav>
    </div>
</header>
