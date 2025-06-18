<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <header id="masthead" class="site-header">
        <div class="container">
            <div class="site-branding">
                <?php
                if (is_front_page() && is_home()) :
                    ?>
                    <h1 class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </h1>
                    <?php
                else :
                    ?>
                    <p class="site-title">
                        <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                            <?php bloginfo('name'); ?>
                        </a>
                    </p>
                    <?php
                endif;
                ?>
            </div>

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'menu-1',
                        'menu_id'        => 'primary-menu',
                    )
                );
                ?>
            </nav>
        </div>
    </header>

    <div class="depth-frame">
      <div class="group">
        <div class="overlap-group">
          <img class="vector" src="img/image.svg" />
          <img class="img" src="img/vector.svg" />
          <img class="bildschirmfoto" src="img/bildschirmfoto-2025-06-17-um-23-10-42-removebg-preview-1.png" />
        </div>
      </div>
      <div class="div">
        <div class="div-2">
          <div class="div-wrapper"><div class="text-wrapper">Men</div></div>
          <div class="div-wrapper"><div class="text-wrapper">Women</div></div>
          <div class="div-wrapper"><div class="text-wrapper">Kids</div></div>
          <div class="div-wrapper"><div class="text-wrapper">Sale</div></div>
          <div class="div-wrapper"><div class="text-wrapper">Contact</div></div>
        </div>
        <div class="div-3">
          <div class="depth-frame-wrapper">
            <div class="depth-frame-wrapper-2">
              <div class="vector-wrapper"><img class="vector-2" src="img/vector-0.svg" /></div>
            </div>
          </div>
          <div class="depth-frame-wrapper">
            <div class="depth-frame-wrapper-2">
              <div class="vector-wrapper"><img class="vector-2" src="img/vector-0-3.svg" /></div>
            </div>
          </div>
          <div class="depth-frame-wrapper">
            <div class="depth-frame-wrapper-2">
              <div class="vector-wrapper"><img class="vector-3" src="img/vector-0-2.svg" /></div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
