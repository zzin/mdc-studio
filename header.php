<?php

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package zeein
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
  <link rel="profile" href="https://gmpg.org/xfn/11">
  <?php
  wp_head();
  global $slug, $portfolioQuery;
  $slug = get_post_field('post_name', get_post());

  $addClass = 'bg-white mb-0';
  if (is_page()) {
    $addClass .= ' page-slug-' . $slug;
  }

  $bgLoading = '#000000';
  if (is_single()) {
    if (get_field('colorLoading')) $bgLoading = get_field('colorLoading');
  }

  $getTheTitle = (get_the_title()) ? get_the_title() : 'loading';
  ?>
</head>

<body <?php body_class($addClass); ?> data-barba="wrapper" data-bg="<?= $bgLoading ?>" data-title="<?= $getTheTitle ?>">
  <?php wp_body_open(); ?>
  <div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'zeein'); ?></a>
    <header id="masthead" class="site-header fixed top-0 w-full z-50">
      <div class="container-full relative h-[60px] lg:h-24">
        <div class="site-branding absolute top-1/2 -translate-y-1/2 leading-none">
          <h1 class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo block" rel="home">
              <svg width="100%" height="100%" class="w-auto h-8" viewBox="0 0 30 30" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" xmlns:serif="http://www.serif.com/" style="fill-rule:evenodd;clip-rule:evenodd;stroke-linejoin:round;stroke-miterlimit:2;">
                <g>
                  <path d="M30,18l-6,0l0,3.2l-5.2,-6.2l5.2,-6.2l0,3.2l6,0l0,-12l-6,0l-9,10.6l-9,-10.6l-6,0l0,30l6,0l9,-10.6l9,10.6l6,0l0,-12Zm-24,3.2l0,-12.4l5.3,6.2l-5.3,6.2Z" style="fill:#1d1d1b;fill-rule:nonzero;" />
                </g>
              </svg>
            </a>
          </h1>
        </div><!-- .site-branding -->
        <nav id="site-navigation" class="main-navigation
						inline-block absolute right-8 top-1/2 -translate-y-1/2
						">
          <button id="menu-toggle" class="menu-toggle h-8 w-8 appearance-none border-0 block absolute right-6 top-[14px] z-0" aria-controls="primary-menu" aria-expanded="false">
            <span class="bg-gray-900"></span>
            <span class="bg-transparent"></span>
            <span class="bg-gray-900"></span>
          </button>
          <div class="menu-wrap">
            <?php
            wp_nav_menu(
              array(
                'theme_location' => 'menu-1',
                'menu_id' => 'primary-menu',
                'walker' => new cssmenu_walker_nav_menu(),
              )
            );
            ?>
          </div>
        </nav><!-- #site-navigation -->
      </div>
    </header><!-- #masthead -->

    <div class="loading">
      <div class="loading--wrap">
        <strong class="loading--title"></strong>
      </div>
    </div>