<?php
/* PlumTree functions and definitions */

/** Contents:
		- Additional image sizes.
		- Google Fonts for your site.
		- Handy Setup.
		- Enqueue scripts and styles.
		- Handy Init Sidebars.
		- Options Panel.
		- Adding features.
**/

/* Set up the content width value based on the theme's design */
if (!isset( $content_width )) $content_width = 1200;


/* Adding additional image sizes */
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'product-extra-gallery-thumb', 70, 70, true );
	add_image_size( 'pt-cat-thumb', 25, 25, true );
	add_image_size( 'pt-product-thumbs', 123, 123, true);
	add_image_size( 'pt-recent-posts-thumb', 263, 174, true);
	add_image_size( 'pt-sidebar-thumbs', 80, 80, true);
	add_image_size( 'pt-vendor-product-thumbs', 120, 120, true);
	add_image_size( 'pt-gallery-s', 265, 200, true);
	add_image_size( 'pt-gallery-m', 360, 240, true);
	add_image_size( 'pt-gallery-l', 555, 370, true);
}


/* Handy Setup. Set up theme defaults and registers support for various WordPress features. */
if ( ! function_exists( 'plumtree_setup' ) ) {
	function plumtree_setup() {

		// Translation availability
		load_theme_textdomain( 'handystore', get_template_directory() . '/languages' );

		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		add_theme_support( "title-tag" );

		// Custom Logo
		add_theme_support( 'custom-logo', array(
				'height' => 73,
				'width' => 225,
		) );

		// Enable support for Post Thumbnails.
		add_theme_support( 'post-thumbnails' );

		set_post_thumbnail_size( 1138, 450, true );

		// Nav menus.
		register_nav_menus( array(
			'header-top-nav'   => __( 'Top Menu', 'handystore' ),
			'primary-nav'      => __( 'Primary Menu (Under Logo)', 'handystore' ),
		) );

		// Switch default core markup for search form, comment form, and comments to output valid HTML5.
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array(
			'div', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
		) );

		// Enable woocommerce support
		add_theme_support( 'woocommerce' );

		// Enable layouts support
		$pt_layouts = array(
				array('value' => 'one-col', 'label' => esc_html__('1 Column (no sidebars)', 'handystore'), 'icon' => get_template_directory_uri().'/theme-options/images/one-col.png'),
				array('value' => 'two-col-left', 'label' => esc_html__('2 Columns, sidebar on left', 'handystore'), 'icon' => get_template_directory_uri().'/theme-options/images/two-col-left.png'),
				array('value' => 'two-col-right', 'label' => esc_html__('2 Columns, sidebar on right', 'handystore'), 'icon' => get_template_directory_uri().'/theme-options/images/two-col-right.png'),
		);
		add_theme_support( 'plumtree-layouts', apply_filters('pt_default_layouts', $pt_layouts) );

	}
}
add_action( 'after_setup_theme', 'plumtree_setup' );


/* Enqueue scripts and styles for the front end. */
function plumtree_scripts() {
	//---- CSS Styles
	wp_enqueue_style( 'pt-grid', get_template_directory_uri().'/css/grid.css' );
	wp_enqueue_style( 'pt-additional-styles', get_template_directory_uri().'/css/additional-styles.css' );
	wp_enqueue_style( 'pt-icons', get_template_directory_uri() . '/css/icon-font.css' );
	if ( class_exists('WC_Vendors') ) {
		wp_enqueue_style( 'pt-vendor-styles', get_template_directory_uri() . '/css/vendor-styles.css' );
	}
	wp_enqueue_style( 'pt-basic', get_stylesheet_uri() );

	//---- Font Awesome Icons
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );

	//---- JS libraries
	wp_enqueue_script( 'hoverIntent', array('jquery') );
	wp_enqueue_script( 'lazy-sizes', get_template_directory_uri() . '/js/lazysizes.js', array(), '1.5.0', false );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri() . '/js/owl.carousel.js', array('jquery'), '1.3.3', true );
	wp_enqueue_script( 'magnific-popup', get_template_directory_uri() . '/js/magnific-popup.js', array('jquery'), '1.1.0', true );
	wp_enqueue_script( 'pt-helper-js', get_template_directory_uri() . '/js/helper.js', array('jquery'), '1.0', true );
	if ( is_page_template( 'page-templates/gallery-page.php' ) || is_page_template( 'page-templates/portfolio-page.php' ) ) {
		wp_enqueue_script( 'pt-gallery-filters-js', get_template_directory_uri() . '/js/filterizr.js', array('jquery'), '1.2.3', true );
	}

	//---- Comments script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'plumtree_scripts' );


/* Handy Init Sidebars */
if (!function_exists('plumtree_widgets_init')){
	function plumtree_widgets_init() {
		// Default Sidebars
		register_sidebar( array(
			'name' => __( 'Blog Sidebar', 'handystore' ),
			'id' => 'sidebar-blog',
			'description' => __( 'Appears on single blog posts and on Blog Page', 'handystore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title" itemprop="name">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Header Top Panel Sidebar', 'handystore' ),
			'id' => 'top-sidebar',
			'description' => __( 'Located at the top of site', 'handystore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s right-aligned">',
			'after_widget' => '</div>',
			'before_title' => '<!--',
			'after_title' => '-->',
		) );
		register_sidebar( array(
			'name' => __( 'Header (Logo group) sidebar', 'handystore' ),
			'id' => 'hgroup-sidebar',
			'description' => __( 'Located to the right from header', 'handystore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '',
			'after_title' => '',
		) );
		register_sidebar( array(
			'name' => __( 'Front Page Sidebar', 'handystore' ),
			'id' => 'sidebar-front',
			'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'handystore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title itemprop="name">',
			'after_title' => '</h3>',
		) );
		register_sidebar( array(
			'name' => __( 'Pages Sidebar', 'handystore' ),
			'id' => 'sidebar-pages',
			'description' => __( 'Appears on Pages', 'handystore' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget-title itemprop="name">',
			'after_title' => '</h3>',
		) );
		if ( class_exists('Woocommerce') ) {
			register_sidebar( array(
				'name' => __( 'Shop Page Sidebar', 'handystore' ),
				'id' => 'sidebar-shop',
				'description' => __( 'Appears on Products page', 'handystore' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title itemprop="name">',
				'after_title' => '</h3>',
			) );
			register_sidebar( array(
				'name' => __( 'Single Product Page Sidebar', 'handystore' ),
				'id' => 'sidebar-product',
				'description' => __( 'Appears on Single Products page', 'handystore' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title itemprop="name">',
				'after_title' => '</h3>',
			) );
			if ( class_exists('WCV_Vendors') ) {
				register_sidebar( array(
					'name' => __( 'Vendor Shop Page Sidebar', 'handystore' ),
					'id' => 'sidebar-vendor',
					'description' => __( 'Appears on Vendors Shop Page', 'handystore' ),
					'before_widget' => '<div id="%1$s" class="widget %2$s">',
					'after_widget' => '</div>',
					'before_title' => '<h3 class="widget-title itemprop="name">',
					'after_title' => '</h3>',
				) );
			}
		}
	  // Footer Sidebars
	  register_sidebar( array(
	    'name' => __( 'Footer Sidebar Col#1', 'handystore' ),
	    'id' => 'footer-sidebar-1',
	    'description' => __( 'Located in the footer of the site', 'handystore' ),
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h3 class="widget-title itemprop="name">',
	    'after_title' => '</h3>',
		) );
	  register_sidebar( array(
	    'name' => __( 'Footer Sidebar Col#2', 'handystore' ),
	    'id' => 'footer-sidebar-2',
	    'description' => __( 'Located in the footer of the site', 'handystore' ),
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h3 class="widget-title itemprop="name">',
	    'after_title' => '</h3>',
	  ) );
	  register_sidebar( array(
	    'name' => __( 'Footer Sidebar Col#3', 'handystore' ),
	    'id' => 'footer-sidebar-3',
	    'description' => __( 'Located in the footer of the site', 'handystore' ),
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h3 class="widget-title itemprop="name">',
	    'after_title' => '</h3>',
	  ) );
	  register_sidebar( array(
	    'name' => __( 'Footer Sidebar Col#4', 'handystore' ),
	    'id' => 'footer-sidebar-4',
	    'description' => __( 'Located in the footer of the site', 'handystore' ),
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h3 class="widget-title itemprop="name">',
	    'after_title' => '</h3>',
	  ) );
	  // Custom Sidebars
	  register_sidebar( array(
	    'name' => __( 'Top Footer Sidebar', 'handystore' ),
	    'id' => 'top-footer-sidebar',
	    'description' => __( 'Located in the footer of the site', 'handystore' ),
	    'before_widget' => '<div id="%1$s" class="widget %2$s">',
	    'after_widget' => '</div>',
	    'before_title' => '<h3 class="widget-title itemprop="name">',
	    'after_title' => '</h3>',
	  ) );
		register_sidebar( array(
			 'name' => __( 'Special Filters Sidebar', 'handystore' ),
		   'id' => 'filters-sidebar',
		   'description' => __( 'Located at the top of the products page', 'handystore' ),
		    'before_widget' => '<div id="%1$s" class="widget %2$s">',
		    'after_widget' => '</div>',
		    'before_title' => '<h3 class="dropdown-filters-title">',
		    'after_title' => '</h3>',
		  ) );
			register_sidebar( array(
			   'name' => __( 'Special Front Page Sidebar', 'handystore' ),
		     'id' => 'front-special-sidebar',
		     'description' => __( 'Located at the bottom of the page (appears only when using Front Page Template)', 'handystore' ),
		     'before_widget' => '<div id="%1$s" class="widget %2$s col-xs-12 col-sm-6 col-md-3">',
		     'after_widget' => '</div>',
		     'before_title' => '<h3 class="widget-title" itemprop="name">',
		     'after_title' => '</h3>',
		  ) );
	}
	add_action( 'widgets_init', 'plumtree_widgets_init' );
}

/* Options Panel */
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/theme-options/' );
require_once ( get_template_directory() . '/theme-options/options-framework.php' );

/* Loads options.php from child or parent theme */
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );

function handy_prefix_options_menu_filter( $menu ) {
 	$menu['mode'] = 'menu';
 	$menu['page_title'] = esc_html__( 'Handy Theme Options', 'handystore');
 	$menu['menu_title'] = esc_html__( 'Handy Theme Options', 'handystore');
 	$menu['menu_slug'] = 'handy-theme-options';
 	return $menu;
}
add_filter( 'optionsframework_menu', 'handy_prefix_options_menu_filter' );

/* Required functions */
require_once( get_template_directory() . '/inc/pt-google-fonts.php' );
require_once( get_template_directory() . '/inc/pt-theme-layouts.php' );
require_once( get_template_directory() . '/inc/pt-functions.php' );
require_once( get_template_directory() . '/inc/pt-tgm-plugin-activation.php' );
require_once( get_template_directory() . '/inc/pt-self-install.php' );
require_once( get_template_directory() . '/inc/pt-kirki.php');
require_once( get_template_directory() . '/inc/pt-customizer-options.php');
if ( class_exists('Woocommerce') ) {
	require_once( get_template_directory() . '/inc/pt-woo-modification.php' );
	if ( class_exists('WC_Vendors') ) {
		require_once( get_template_directory() . '/inc/pt-vendors-modification.php' );
		if ( ('on' == handy_get_option('show_wcv_favourite_vendors')) && class_exists('WCVendors_Pro') ) {
			require_once( get_template_directory() . '/inc/pt-favourite-vendors.php' );
		}
	}
}
if ( true == handy_get_option('site_post_shares') ) {
	require_once( get_template_directory() . '/inc/pt-share-buttons.php' );
}
if ( 'on' == handy_get_option('site_post_likes') ) {
	require_once( get_template_directory() . '/inc/pt-post-like.php' );
}

/* Registers an editor stylesheet for the theme */
function handy_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'admin_init', 'handy_theme_add_editor_styles' );
