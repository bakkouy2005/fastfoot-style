<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>




</head>
<body>
    <header class="bg-gradient-to-r from-black via-black to-transparent bg-opacity-90 shadow-md ">
        <div class="container mx-auto flex justify-between items-center py-4 px-6">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-2xl font-bold text-orange-600">
                Wheely Good cars!
            </a>
            
            <nav class="hidden md:flex space-x-6 text-white">
                <a href="#" class="text-white hover:text-blue-600">alle autos</a>
                <a href="#" class="text-white hover:text-blue-600">Verkopen</a>
                <a href="#" class="text-white hover:text-blue-600">Financiering</a>
                <?php if (!is_user_logged_in()) : ?>
                    <a href="http://localhost/wordpress/login" class="text-white hover:text-blue-600">Inloggen</a>
                <?php endif; ?>
            </nav>
            <div class="hidden md:flex space-x-4 items-center">
                <?php if (!is_user_logged_in()) : ?>
                    <a href="<?php echo esc_url(home_url('/register-pagina')); ?>" class="border border-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-600 hover:text-white">
                        Registreren
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url(home_url('/verkopen')); ?>" class="bg-orange-600 text-white px-4 py-2 rounded-md hover:bg-orange-700">
                    Advertentie plaatsen
                </a>
                <?php if (is_user_logged_in()) : ?>
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center space-x-2 text-white focus:outline-none">
                            <i class="fas fa-user"></i>
                            <span class="mx-auto"><?php echo wp_get_current_user()->display_name; ?></span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div id="user-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20 hidden">
                            <a href="<?php echo esc_url(home_url('/mijn-aanbod')); ?>" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Mijn Aanbod</a>
                            <a href="<?php echo esc_url(home_url('/mijn-account-2')); ?>" class="block px-4 py-2 text-blue-800 hover:bg-gray-200">Mijn Account</a>
                            <a href="<?php echo wp_logout_url(home_url()); ?>" class="block px-4 py-2 text-red-600 hover:bg-gray-200">Afmelden</a>
                        </div>
                    </div>
                    <script>
                        document.getElementById('user-menu-button').addEventListener('click', function() {
                            var menu = document.getElementById('user-menu');
                            menu.classList.toggle('hidden');
                        });
                    </script>
                <?php endif; ?>
            </div>
            <button class="md:hidden text-orange-600">
                ☰
            </button>
        </div>
    </header>
</body>
</html>
