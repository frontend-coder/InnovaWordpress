<?php
/**
 * innova functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package innova
 */

//require get_template_directory() . '/inc/carbon-fields/custom-fields/custom-fields.php';


use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
require_once __DIR__  . '/inc/carbon-fields/custom-fields/custom-fields.php';

}
add_action( 'carbon_fields_register_fields', 'crb_attach_post_meta' );
function crb_attach_post_meta() {
require_once __DIR__  . '/inc/carbon-fields/custom-fields/index-fields.php';
}


add_action( 'after_setup_theme', 'crb_load' );
function crb_load() {
//    require_once( ABSPATH . '/inc/carbon-fields/vendor/autoload.php' );
require_once __DIR__  . '/inc/carbon-fields/vendor/autoload.php';
    \Carbon_Fields\Carbon_Fields::boot();
}

add_action( 'carbon_fields_post_meta_container_saved', 'crb_after_save_event' );
function crb_after_save_event( $post_id ) {
    if ( get_post_type( $post_id ) !== 'crb_event' ) {
        return false;
    }
    $event_date = carbon_get_post_meta( $post_id, 'crb_event_date' );
    if ( $event_date ) {
        $timestamp = strtotime( $event_date );
        update_post_meta( $post_id, '_crb_event_timestamp', $timestamp );
    }
}

// carbon_fields_theme_options_container_saved








if ( ! function_exists( 'innova_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function innova_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on innova, use a find and replace
		 * to change 'innova' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'innova', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Глвное меню в шапке сайта', 'innova' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'innova_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'innova_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function innova_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'innova_content_width', 640 );
}
add_action( 'after_setup_theme', 'innova_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function innova_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'innova' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'innova' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'innova_widgets_init' );

/**
 * Enqueue scripts and styles.
 */


function innova_scripts() {
wp_enqueue_style( 'innova-style', get_stylesheet_uri() );
wp_enqueue_style( 'innova-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
wp_enqueue_style( 'innova-font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.css');
wp_enqueue_style( 'innova-ownerstyle', get_template_directory_uri() . '/assets/css/style.css');
wp_enqueue_style( 'innova-nivo-lightbox', get_template_directory_uri() . '/assets/css/nivo-lightbox/nivo-lightbox.css');
wp_enqueue_style( 'innova-nivo-lightbox-default', get_template_directory_uri() . '/assets/css/nivo-lightbox/default.css');
wp_enqueue_style( 'innova-OpenSanslight', 'https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' );
wp_enqueue_style( 'innova-OpenSans', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');


wp_deregister_script( 'jquery');
wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/jquery.1.11.1.js', array(),'',true);
wp_enqueue_script( 'jquery');


wp_enqueue_script( 'innova-bootstrapjs', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), '1.0', true );
wp_enqueue_script( 'innova-SmoothScrolljs', get_template_directory_uri() . '/assets/js/SmoothScroll.js', array('jquery'), '1.0', true );
wp_enqueue_script( 'innova-nivo-lightboxjs', get_template_directory_uri() . '/assets/js/nivo-lightbox.js', array('jquery'), '1.0', true );
wp_enqueue_script( 'innova-jqBootstrapValidationjs', get_template_directory_uri() . '/assets/js/jqBootstrapValidation.js', array('jquery'), '1.0', true );
wp_enqueue_script( 'innova-mainjs', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0', true );



	// wp_enqueue_script( 'innova-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	// if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	// 	wp_enqueue_script( 'comment-reply' );
	// }
}
add_action( 'wp_enqueue_scripts', 'innova_scripts' );

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
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
//require get_template_directory() . '/inc/post-type.php';














function custom_tinymce_settings($settings) {
if (!isset($settings['extended_valid_elements'])) {
 $settings['extended_valid_elements'] = '';
 } else {
 $settings['extended_valid_elements'] .= ',';
 }
if (!isset($settings['valid_children'])) {
 $settings['valid_children'] = '';
 } else {
 $settings['valid_children'] .= ',';
 }
$settings['extended_valid_elements'] .= "meta[*],span[*]";
 $settings['valid_children'] .= "+span[meta]";
return $settings;
 }
add_filter('tiny_mce_before_init', 'custom_tinymce_settings');




function innova_debug($data) {
	echo '<pre>' . print_r ($data, 1) . '</pre>';
}
