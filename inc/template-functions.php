<?php

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package zeein
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function zeein_body_classes($classes)
{
	// Adds a class of hfeed to non-singular pages.
	if (!is_singular()) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if (!is_active_sidebar('sidebar-1')) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter('body_class', 'zeein_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function zeein_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'zeein_pingback_header');

/**
 * Add footer menu > home
 */

function zeein_wp_nav_menu_items($items, $args)
{
	if ($args->menu_id === 'primary-menu-footer') {
		$items = '<li id="nav-menu-item-home" class="main-menu-item  menu-item-even menu-item-depth-0 menu-item menu-item-type-post_type menu-item-object-page"><a href="/" class="menu-link main-menu-link"><span class="span">home</span></a></li>' . $items;
	}
	return $items;
}
// add_filter('wp_nav_menu_items','zeein_wp_nav_menu_items', 10, 2);