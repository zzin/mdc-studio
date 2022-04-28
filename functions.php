<?php

/**
 * zeein functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package zeein
 */

if (!defined('_S_VERSION')) {
	// Replace the version number of the theme on each release.
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('zeein_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function zeein_setup()
	{
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on zeein, use a find and replace
         * to change 'zeein' to the name of your theme in all the template files.
         */
		load_theme_textdomain('zeein', get_template_directory() . '/languages');

		add_theme_support('editor-styles');
		add_theme_support('wp-block-styles');
		add_theme_support('align-wide');
		add_theme_support('revisions');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
		add_theme_support('title-tag');

		/*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__('Primary', 'zeein'),
				'menu-2' => esc_html__('Secondary', 'zeein'),
			)
		);

		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'zeein_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height' => 250,
				'width' => 250,
				'flex-width' => true,
				'flex-height' => true,
			)
		);

		add_post_type_support('portfolio', 'excerpt');
	}
endif;
add_action('after_setup_theme', 'zeein_setup');
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function zeein_content_width()
{
	$GLOBALS['content_width'] = apply_filters('zeein_content_width', 640);
}
add_action('after_setup_theme', 'zeein_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function zeein_widgets_init()
{
	register_sidebar(
		array(
			'name' => esc_html__('Sidebar', 'zeein'),
			'id' => 'sidebar-1',
			'description' => esc_html__('Add widgets here.', 'zeein'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget' => '</section>',
			'before_title' => '<h2 class="widget-title">',
			'after_title' => '</h2>',
		)
	);
}
add_action('widgets_init', 'zeein_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function zeein_scripts()
{
	wp_enqueue_style('zeein-style', get_stylesheet_uri(), array(), _S_VERSION);
	wp_style_add_data('zeein-style', 'rtl', 'replace');

	// Loads bundled frontend CSS.
	wp_enqueue_style('_zeein-frontend', get_stylesheet_directory_uri() . '/assets/public/css/frontend.css');

	wp_enqueue_script('_zeein-frontend-scripts', get_template_directory_uri() . '/assets/public/js/frontend.js', array(), 'v1.0', true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'zeein_scripts', 1000);

function zeein_scripts_admin()
{
	wp_enqueue_style('_zeein-backend', get_stylesheet_directory_uri() . '/assets/public/css/backend.css');
	wp_enqueue_script('_zeein-backend-scripts', get_template_directory_uri() . '/assets/public/js/backend.js', array(), 'v1.0', true);
}
add_action('admin_enqueue_scripts', 'zeein_scripts_admin');

// footer query init
function footer_somethings()
{
	global $portfolioQuery;
	wp_localize_script(
		'_zeein-frontend-scripts',
		'frontendAjaxObject',
		array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
			'posts' => ($portfolioQuery) ? json_encode($portfolioQuery->query_vars) : null,
			'currentPage' => 1,
			'totalPortfolio' => ($portfolioQuery) ? $portfolioQuery->found_posts : null,
			'maxPage' => ($portfolioQuery) ? $portfolioQuery->max_num_pages : null,
		)
	);
}
add_action('wp_footer', 'footer_somethings');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
	require get_template_directory() . '/inc/jetpack.php';
}

/*************************************************************************/
/**
 * Author : zeein81@gmail.com
 */

function cptui_register_my_cpts_portfolio()
{

	/**
	 * Post Type: 포트폴리오.
	 */

	$labels = [
		"name" => __("포트폴리오", "zeein"),
		"singular_name" => __("포트폴리오", "zeein"),
	];

	$args = [
		"label" => __("포트폴리오", "zeein"),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => ["slug" => "portfolio", "with_front" => true],
		"query_var" => true,
		"menu_icon" => "dashicons-archive",
		"supports" => ["title", "editor", "thumbnail", "page-attributes"],
		"show_in_graphql" => false,
	];

	register_post_type("portfolio", $args);
}

add_action('init', 'cptui_register_my_cpts_portfolio');

function cptui_register_my_taxes_portfoliotax()
{

	/**
	 * Taxonomy: 포트폴리오 카테고리.
	 */

	$labels = [
		"name" => __("포트폴리오 카테고리", "zeein"),
		"singular_name" => __("포트폴리오 카테고리", "zeein"),
	];


	$args = [
		"label" => __("포트폴리오 카테고리", "zeein"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => ['slug' => 'portfoliotax', 'with_front' => true,],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "portfoliotax",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy("portfoliotax", ["portfolio"], $args);
}
add_action('init', 'cptui_register_my_taxes_portfoliotax');

function cptui_register_my_taxes_portfoliotag()
{

	/**
	 * Taxonomy: 포트폴리오 태그.
	 */

	$labels = [
		"name" => __("포트폴리오 태그", "zeein"),
		"singular_name" => __("포트폴리오 태그", "zeein"),
	];


	$args = [
		"label" => __("포트폴리오 태그", "zeein"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => ['slug' => 'portfoliotag', 'with_front' => true,],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "portfoliotag",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy("portfoliotag", ["portfolio"], $args);
}
add_action('init', 'cptui_register_my_taxes_portfoliotag');



/**
 * Custom nav walker
 */
require get_template_directory() . '/inc/cssmenu-navwalker.php';
require get_template_directory() . '/inc/template-func.php';
// require get_template_directory() . '/inc/template-admin.php';
// require get_template_directory() . '/inc/template-api.php';
// require get_template_directory() . '/inc/template-ajax.php';
// require get_template_directory() . '/inc/template-save.php';

// require get_template_directory() . '/inc/template-kboard.php';
// require get_template_directory() . '/inc/template-print.php';
// require get_template_directory() . '/inc/template-calendar.php';
