<?php
/**
 * Twenty Fifteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Twenty Fifteen 1.0
 */

if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Twenty Fifteen only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}
add_filter( 'ot_show_pages', '__return_false' );
add_filter( 'ot_theme_mode', '__return_true' );
include_once( 'option-tree/ot-loader.php' );
include_once( 'theme-options.php' );
include_once( 'templates/load.php' );
require get_template_directory() . '/dompdf/dompdf_config.inc.php';
require get_template_directory() . '/fpd/fpdf.php';
require get_template_directory() . '/inc/class.html2text.inc';

//remove_filter('the_content', 'wpautop');

if ( ! function_exists( 'twentyfifteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on twentyfifteen, use a find and replace
	 * to change 'twentyfifteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentyfifteen', get_template_directory() . '/languages' );

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
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 825, 510, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'twentyfifteen' ),
		'secondary'  => __( 'Secondary Menu', 'twentyfifteen' ),
		'social'  => __( 'Social Links Menu', 'twentyfifteen' ),

	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	/*
	 * Enable support for custom logo.
	 *
	 * @since Twenty Fifteen 1.5
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 248,
		'width'       => 248,
		'flex-height' => true,
	) );

	$color_scheme  = twentyfifteen_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'twentyfifteen_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', twentyfifteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentyfifteen_setup
add_action( 'after_setup_theme', 'twentyfifteen_setup' );

/**
 * Register widget area.
 *
 * @since Twenty Fifteen 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */

function twentyfifteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'twentyfifteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyfifteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentyfifteen_widgets_init' );

if ( ! function_exists( 'twentyfifteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Fifteen.
 *
 * @since Twenty Fifteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentyfifteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentyfifteen' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'twentyfifteen' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Fifteen 1.1
 */
function twentyfifteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentyfifteen_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Twenty Fifteen 1.0
 */
function twentyfifteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentyfifteen-fonts', twentyfifteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfifteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentyfifteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentyfifteen-style' ), '20141010' );
	wp_style_add_data( 'twentyfifteen-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'twentyfifteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfifteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'twentyfifteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'twentyfifteen-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'twentyfifteen' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'twentyfifteen' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Twenty Fifteen 1.0
 *
 * @see wp_add_inline_style()
 */



function twentyfifteen_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'twentyfifteen-style', $css );
}
add_action( 'wp_enqueue_scripts', 'twentyfifteen_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function twentyfifteen_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'twentyfifteen_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Twenty Fifteen 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */

function twentyfifteen_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'twentyfifteen_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Twenty Fifteen 1.0
 */
require get_template_directory() . '/inc/customizer.php';


function change_submenu_class($menu) {  
  $menu = preg_replace('/ class="sub-menu"/','/ class="dropdown-menu navmenu-nav" /',$menu);  
  return $menu;  
}  
add_filter('wp_nav_menu','change_submenu_class');


/*Remove empty paragraph tags from the_content*/
function removeEmptyParagraphs($content) {

    $pattern = "/<p[^>]*><\\/p[^>]*>/";   
    $content = preg_replace($pattern, '', $content);
    /*$content = str_replace("<p></p>","",$content);*/
    return $content;
}

add_filter('the_content', 'removeEmptyParagraphs');
//add_filter('the_content', 'removeEmptyParagraphs',99999);



function add_menu_parent_class( $items ) {
$parents = array();
foreach ( $items as $item ) {
    //Check if the item is a parent item
    if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
        $parents[] = $item->menu_item_parent;
    }   
}
	//echo '<pre>'; print_r($parents);  die();
foreach ( $items as $item ) {
    if ( in_array( $item->ID, $parents ) ) {
        //Add "menu-parent-item" class to parents
        $item->classes[] = 'dropdown';
	//echo '<pre>'; print_r($item);  die();
    }
}
return $items;
}
//add_menu_parent_class to menu
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' ); 


// Hide admin bar +++++++++++
add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}




//create custom post type for newsroom
function custom_news() {
	$labels = array(
			'name'               => __( 'News', ''),
			'singular_name'      => __( 'News', ''),
			'add_new'            => __( 'Add New', ''),
			'add_new_item'       => __( 'Add New News', '' ),
			'edit_item'          => __( 'Edit News', '' ),
			'new_item'           => __( 'New News', '' ),
			'all_items'          => __( 'All News', '' ),
			'view_item'          => __( 'View News', '' ),
			'search_items'       => __( 'Search News', '' ),
			'not_found'          => __( 'No Menu found', '' ),
			'not_found_in_trash' => __( 'No Menu found in the Trash', '' ),
			'parent_item_colon'  => '',
			'menu_name'          => 'News'
	);
	
	$args = array(
			'labels'        => $labels,
			'description'   => 'News section',
			'public'        => true,
			'menu_position' => 5,
			'hierarchical'  => false,
			'supports'      => array( 'title', 'editor', 'thumbnail','excerpt', 'tags', 'author' ),
			'has_archive'   => false,
			'taxonomies' => array('post_tag'),
			'show_tagcloud' => true,
	);
	register_post_type( 'news', $args );
}
add_action( 'init', 'custom_news' );

function news_taxnomies() {
		$labels = array(
			'name'              => __( 'Categories', ''),
					'singular_name'     => __( 'Category', ''),
					'search_items'      => __( 'Search Categories', '' ),
			'all_items'         => __( 'All Categories', '' ),
			'parent_item'       => __( 'Parent Category', '' ),
			'parent_item_colon' => __( 'Parent Category:', '' ),
			'edit_item'         => __( 'Edit Category', '' ),
			'update_item'       => __( 'Update Category', '' ),
			'add_new_item'      => __( 'Add New Category', '' ),
			'new_item_name'     => __( 'New Category', '' ),
			'menu_name'         => __( 'Categories', '' )
		);
		
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
		register_taxonomy( 'news_category', 'news', $args );
}
add_action( 'init', 'news_taxnomies', 0 );


//create custom post type for services
function custom_services() {
	$labels = array(
			'name'               => __( 'Services', ''),
			'singular_name'      => __( 'Service', ''),
			'add_new'            => __( 'Add Services', ''),
			'add_new_item'       => __( 'Add New Services', '' ),
			'edit_item'          => __( 'Edit Services', '' ),
			'new_item'           => __( 'New Services', '' ),
			'all_items'          => __( 'All Services', '' ),
			'view_item'          => __( 'View Services', '' ),
			'search_items'       => __( 'Search Services', '' ),
			'not_found'          => __( 'No Menu found', '' ),
			'not_found_in_trash' => __( 'No Menu found in the Trash', '' ),
			'parent_item_colon'  => '',
			'menu_name'          => 'Services'
	);
	
	$args = array(
			'labels'        => $labels,
			'description'   => 'Services section',
			'public'        => true,
			'menu_position' => 5,
			'hierarchical'  => false,
			'supports'      => array( 'title', 'editor', 'thumbnail','excerpt', 'tags', 'author' ),
			'has_archive'   => false,
			'taxonomies' => array('post_tag'),
			'show_tagcloud' => true,
	);
	register_post_type( 'services', $args );
}
add_action( 'init', 'custom_services' );

function services_taxnomies() {
		$labels = array(
			'name'              => __( 'Categories', ''),
					'singular_name'     => __( 'Category', ''),
					'search_items'      => __( 'Search Categories', '' ),
			'all_items'         => __( 'All Categories', '' ),
			'parent_item'       => __( 'Parent Category', '' ),
			'parent_item_colon' => __( 'Parent Category:', '' ),
			'edit_item'         => __( 'Edit Category', '' ),
			'update_item'       => __( 'Update Category', '' ),
			'add_new_item'      => __( 'Add New Category', '' ),
			'new_item_name'     => __( 'New Category', '' ),
			'menu_name'         => __( 'Categories', '' )
		);
		
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
		register_taxonomy( 'services_category', 'services', $args );
}
add_action( 'init', 'services_taxnomies', 0 );


//create custom post type for formulations
function formulations() {
	$labels = array(
			'name'               => __( 'Formulations', ''),
			'singular_name'      => __( 'Formulation', ''),
			'add_new'            => __( 'Add Formulations', ''),
			'add_new_item'       => __( 'Add New Formulations', '' ),
			'edit_item'          => __( 'Edit Formulations', '' ),
			'new_item'           => __( 'New Formulations', '' ),
			'all_items'          => __( 'All Formulations', '' ),
			'view_item'          => __( 'View Formulations', '' ),
			'search_items'       => __( 'Search Formulations', '' ),
			'not_found'          => __( 'No Menu found', '' ),
			'not_found_in_trash' => __( 'No Menu found in the Trash', '' ),
			'parent_item_colon'  => '',
			'menu_name'          => 'Formulations'
	);
	
	$args = array(
			'labels'        => $labels,
			'description'   => 'Formulations section',
			'public'        => true,
			'menu_position' => 5,
			'hierarchical'  => false,
			'supports'      => array( 'title', 'editor', 'thumbnail','excerpt', 'tags', 'author' ),
			'has_archive'   => false,
			'taxonomies' => array('post_tag'),
			'show_tagcloud' => true,
	);
	register_post_type( 'formulations', $args );
}
add_action( 'init', 'formulations' );

function formulation_taxnomies() {
		$labels = array(
			'name'              => __( 'Categories', ''),
					'singular_name'     => __( 'Category', ''),
					'search_items'      => __( 'Search Categories', '' ),
			'all_items'         => __( 'All Categories', '' ),
			'parent_item'       => __( 'Parent Category', '' ),
			'parent_item_colon' => __( 'Parent Category:', '' ),
			'edit_item'         => __( 'Edit Category', '' ),
			'update_item'       => __( 'Update Category', '' ),
			'add_new_item'      => __( 'Add New Category', '' ),
			'new_item_name'     => __( 'New Category', '' ),
			'menu_name'         => __( 'Categories', '' )
		);
		
		$args = array(
			'labels' => $labels,
			'hierarchical' => true,
		);
		register_taxonomy( 'formulation_category', 'formulations', $args );
}
add_action( 'init', 'formulation_taxnomies', 0 );


// function to add attachment on custom post type 
function attachments( $attachments )
{
  $fields         = array(
   array(
      'name'      => 'title',                         // unique field name
      'type'      => 'text',                          // registered field type
      'label'     => __( 'Title', 'attachments' ),    // label to display
      'default'   => 'title',                         // default value upon selection
    ),
    array(
      'name'      => 'caption',                       // unique field name
      'type'      => 'textarea',                      // registered field type
      'label'     => __( 'Caption', 'attachments' ),  // label to display
      'default'   => 'caption',                       // default value upon selection
    ),
    // array(
    //   'name'      => 'link',                         // unique field name
    //   'type'      => 'text',                          // registered field type
    //   'label'     => __( 'Link', 'attachments' ),    // label to display
    //   'default'   => 'link',                         // default value upon selection
    // ),
  );

   $args = array(

    // title of the meta box (string)
    'label'         => 'Attachments',

    // all post types to utilize (string|array)
    'post_type'     => array( 'page', 'services' ),

    // meta box position (string) (normal, side or advanced)
    'position'      => 'normal',

    // meta box priority (string) (high, default, low, core)
    'priority'      => 'high',

    // allowed file type(s) (array) (image|video|text|audio|application)
    'filetype'      => null,  // no filetype limit

    // include a note within the meta box (string)
    'note'          => 'Attach files here!',

    // by default new Attachments will be appended to the list
    // but you can have then prepend if you set this to false
    'append'        => true,

    // text for 'Attach' button in meta box (string)
    'button_text'   => __( 'Attach Files', 'attachments' ),

    // text for modal 'Attach' button (string)
    'modal_text'    => __( 'Attach', 'attachments' ),

    // which tab should be the default in the modal (string) (browse|upload)
    'router'        => 'browse',

    // whether Attachments should set 'Uploaded to' (if not already set)
    'post_parent'   => false,

    // fields array
    'fields'        => $fields,

  );

  $attachments->register( 'attachments', $args ); // unique instance name
}

add_action( 'attachments_register', 'attachments' );


add_shortcode('services', 'shortcode_services'); 

function shortcode_services(){
?>
	<?php 
 ob_start();
	$services= get_posts(array(
            'post_type'=> 'services',
            'posts_per_page' => -1,
            'order'=> 'ASC') ); ?>

 	
 			<div class="row">
                <div class="col-md-12 text-center">
                    <h2 class="inner_page_title">compounded <span>medications</span></h2>
                     <p>
                       Our current offerings are more of pharmacy services and Consultation Services
                     </p>
                </div>
            </div>
            <div class="white-box-wrap">
	            <div class="row">
					<?php if($services):
                    foreach( $services as $key => $service ): ?>
						<div class="col-md-2">
	                        <div class="block-item">
	                        	<div class="text-center fontawsom-icons"><?php echo the_field('font_awesome', $service->ID); ?></div>
	                            <p>
	                            	<?php echo $service->post_title; ?>
	                            </p>                                  
	                        </div>
	                    </div>
                	<?php endforeach; endif; ?>
	            </div>
	        </div>
	   	

<?php
 $content = ob_get_contents();
 ob_end_clean();
 return $content; 
}

function shortcode_newsroom(){
?>
		<section class="inner-wrapper">
			<div class="inner-content">
	    		  <div class="news-list-page">
	<div class="container">
	                        <?php $news= get_posts(array(
	                            'post_type' => 'news',
	                            'posts_per_page' => -1,
	                            'order' => 'ASC' ) ); ?>
	                            <?php if($news) :            
	                            foreach( $news as $key => $new ): ?>
	                            
	                        
	                        <div class="news-list">
	                        	<header class="post-entry-header clearfix">
					<div class="row">
						<div class="col-md-8 col-sm-8">
							<div class="share">
								<div class="post-meta">
                                        <ul class="list-unstyled list-inline">
                                        <li class="dropdown">
								          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-share-alt"></i>
										Share</a>
								          <ul class="dropdown-menu">
								            	<li>
                                                 <a id="backforunical19" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($new->ID);?>&title=<?php echo $new->post_title;?>" onclick="javascript:void window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo get_the_permalink($new->ID); ?>&title=<?php echo $new->post_title;?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -0px -120px ">
								            		<i class="fa fa-facebook"></i>facebook</a></li>
												<li>
													<a id="backforunical19" href="https://twitter.com/share?status=<?php echo get_the_permalink($new->ID); ?>&amp;text=<?php echo $new->post_title; ?>" onclick="javascript:void window.open('https://twitter.com/share?status=<?php echo get_the_permalink($new->ID); ?>&amp;text=<?php echo $new->post_title; ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -20px -80px "><i class="fa fa-twitter"></i>twitter</a></li>
											<li><a id="backforunical19" href="https://www.linkedin.com/shareArticle?title=<?php echo $new->post_title; ?>&amp;mini=true&amp;url=<?php echo get_the_permalink($new->ID); ?>" onclick="javascript:void window.open('https://www.linkedin.com/shareArticle?title=<?php echo $new->post_title; ?>&amp;mini=true&amp;url=<?php echo get_the_permalink($new->ID); ?>','1410949501326','width=700,height=500,toolbar=0,menubar=0,location=0,status=1,scrollbars=1,resizable=1,left=0,top=0');return false;" style="background-position: -80px -80px "><i class="fa fa-linkedin"></i>linkedin</a></li>
								          </ul>
								        </li>
                                            <li><i class="fa fa-user"></i><em>Posted by</em><span>
                                                <?php the_author();?></span></li>
                                                <?php $cats = get_the_terms( $new->ID, 'news_category' );  ?>
                                            <li><i class="fa fa-tag"></i>
												
                                            	<a href="<?php echo site_url().'/list-by-cat?cat='.$cats[0]->slug; ?>"><?php echo $cats[0]->name; ?></a></li>
                                        </ul>
                                    </div>
                            </div>
						</div>
						<div class="col-md-4 col-sm-4">
							<span class="view-post">
								<a href="<?php echo get_the_permalink( $new->ID ); ?>">
									View post
									<i class="fa fa-long-arrow-right"></i>
								</a>
							</span>
							
						</div>
					</div>
				</header>
	                        		
								<div class="row">
									<div class="col-md-4 col-sm-4">
										<h1>
											<a href="<?php echo get_the_permalink($new->ID); ?>" class=""><?php echo wp_trim_words( $new->post_title, '7', '...' );?></a>
										</h1>
										<span><?php echo $date = get_the_date( 'F j, Y', $new->ID ); ?></span>
									</div>
									<div class="col-md-8 col-sm-8">
										<?php $news_image_url = wp_get_attachment_url( get_post_thumbnail_id( $new->ID )); ?>
										<div class="list-content">
										<p>
											<?php echo wp_trim_words( $new->post_content, '100', '...' );?>
										</p>
										<div class="post-image bg-image" style="background-image:
		                                url('<?php echo $news_image_url;?>');">                                    
		                                </div>
		                            	</div>
									</div>
									
								</div>
										
							</div>                 
	                        <?php  endforeach; endif; ?>                  
	        <?php if( count( $news ) > 2 ) : ?>    
			<p class="text-center"><a href="javascript:;" class="loadmorebtn btn btn-primary">load more</a></p>
		<?php endif; ?>
	</div>
</div>
</div>
        </section>
	
<?php
}
add_shortcode('newsroom', 'shortcode_newsroom');


function show_breadcrumb() {
    global $post;
    
    echo '<ol class="breadcrumb">';
    if (!is_home()) {
        
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        _e('Home','adv_therapeutics');
        //echo 'Home';
        echo '</a></li>';
        //echo '<h2 class="inner_page_title">';
        //echo "'.$title.'".('</h2>');
        
         if ( get_post_type() && is_single()) { 
             
            if($post->post_type == 'news'){
                echo '<li><a href="'.site_url("news").'">';
                _e('News','adv_therapeutics');
                echo '</a></li>';
                
            }elseif($post->post_type == 'services'){
                echo '<li>';
                _e('Services','adv_therapeutics');
                echo '</li>';
            
            }else{
                echo '<li><a href="'.site_url("$post->post_type").'">';
                echo " $post->post_type".(' </a></li></ol> ');
                echo '<h2 class="inner_page_title">';
                echo "$post->post_type".('</h2>');
            }
            if (is_single()) {
                echo '<li class="active">';
                the_title();
                echo '</li></ol>';
                echo '<h2 class="inner_page_title">';
                $pieces = explode(' ', $post->post_title);
           		$count = count($pieces);
           		for( $i=0; $i < ( $count - 1 ); $i++){
           			echo $pieces[$i] . ' ' ;
           		}
				$last_word = array_pop($pieces);
                echo '<span>'.$last_word.('</span></h2>');
                
            }
        }elseif(!is_single()){          
             	echo '<li class="active">';
                echo " $post->post_title".(' </li></ol> ');
           		echo '<h2 class="inner_page_title">';
           		$pieces = explode(' ', $post->post_title);
           		$count = count($pieces);
           		for( $i=0; $i < ( $count - 1 ); $i++){
           			echo $pieces[$i]. ' ';
           		}
				$last_word = array_pop($pieces);
                echo '<span>'.$last_word.('</span>');
                if(!empty($_GET['cat'])):
                	echo ' : ' . $_GET["cat"];
                endif;
                echo '</h2>';
            
        }
         elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li class="current"><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li></ol>';
                }
                echo $output;
                echo "'.$title.'";
                echo '<h2 class="inner_page_title">';
                echo "'.$title.'".('</h2>');
            } else {
                echo the_title();
                echo '<h2 class="inner_page_title">';
                the_title();
                echo '</h2>';
            }
        }
    }
    elseif( is_home()){
        
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
       _e('Home','adv_therapeutics');
        echo '</a></li>';
       
          
        }
    
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>";   _e('Archive for','adv_therapeutics'); the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>";   _e('Archive for','adv_therapeutics'); the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>";   _e('Archive for','adv_therapeutics'); the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>";   _e('Author Archive','adv_therapeutics'); echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo"<li>";    _e('Blog Archives','adv_therapeutics'); echo'</li>';}
    elseif (is_search()) {echo"<li>";   _e('Search Results','adv_therapeutics'); echo'</li>';}
    echo '</ol>';
 }



// ++++++++ registration new physician +++++++

add_action("wp_ajax_register", "pippin_add_new_member");
add_action("wp_ajax_nopriv_register", "pippin_add_new_member");

function pippin_add_new_member(){
	parse_str($_POST['data'], $data);
	ob_start();

if (isset( $data["pp_email"] ) && wp_verify_nonce($data['pippin_register_nonce'], 'pippin-register-nonce')) {
				$user_title= $data["pp_title"];
				$user_speciality= $data["pp_speciality"];
				$user_firstname= $data["pp_firstname"];
				$user_lastname= $data["pp_lastname"];
				$user_dob_year= $data["dyear"];
				$user_dob_month= $data["dmonth"];
				$user_dob_day= $data["dday"];
				$user_gender= $data["optionsRadios"];
				$user_email= $data["pp_email"];
				$user_number= $data["pp_phoneno"];
				$user_name= $data["pp_username"];
				$user_pass= $data["pp_password"];
				$user_address= $data["pp_address"];
				$user_city= $data["pp_city"];
				$user_state= $data["pp_state"];
				$user_zipcode= $data["pp_zipcode"];
				$user_lic= $data["pp_lic"];
				$user_dea= $data["pp_dea"];
				$user_npi= $data["pp_npi"];

				if ( username_exists( $user_name ) ){
								
				echo 'exist_username';
				}
				else if(!is_email($user_email)) 
				{
					echo 'invalid';
				}
				else if($user_pass == '') {
				
				echo 'empty';
				}
			
				else if(email_exists($user_email)) {
			
				echo 'exist';
				} else {
				global $wpdb;
                $new_user_id = wp_insert_user(array(
				'user_login'=> $user_name,
				'user_pass' => $user_pass,
				'user_email'=> $user_email,
				'first_name'=> $user_firstname,
				'last_name'=>  $user_lastname,
				'user_registered'=> date('Y-m-d H:i:s'),
				'role'=> 'physician'
				)
				);

				if($new_user_id) {	
						$wpdb->query($wpdb->prepare( "UPDATE wp_users SET user_activation_key = '1', 
						 user_status = '1' where ID = $new_user_id"));
						if(!empty($_FILES["file"]["name"]) && count($_FILES["file"]["name"]) > 0 ){
						$sourcePath = $_FILES['file']['tmp_name'];
				     	$upload_dir = wp_upload_dir();
				    	$attachs = move_uploaded_file($sourcePath, WP_CONTENT_DIR ."/uploads/".$_FILES["file"]["name"]);
				      	add_user_meta( $new_user_id, 'ppicture', $_FILES["file"]["name"] ); 
				    	}
				    	add_user_meta( $new_user_id, 'title', $user_title ); 
				    	add_user_meta( $new_user_id, 'speciality', $user_speciality ); 
				    	add_user_meta( $new_user_id, 'dateyear', $user_dob_year); 
				    	add_user_meta( $new_user_id, 'datemonth', $user_dob_month ); 
				    	add_user_meta( $new_user_id, 'dateday', $user_dob_day ); 
				    	add_user_meta( $new_user_id, 'gender', $user_gender ); 
				    	add_user_meta( $new_user_id, 'contact', $user_number ); 
				    	add_user_meta( $new_user_id, 'address', $user_address ); 
				    	add_user_meta( $new_user_id, 'city', $user_city ); 
				    	add_user_meta( $new_user_id, 'state', $user_state ); 
				    	add_user_meta( $new_user_id, 'zipcode', $user_zipcode ); 
				    	add_user_meta( $new_user_id, 'lic', $user_lic ); 
				    	add_user_meta( $new_user_id, 'dea', $user_dea ); 
				    	add_user_meta( $new_user_id, 'npi', $user_npi ); 
				    	add_user_meta( $new_user_id, 'upassword', $user_pass ); 
				    	add_user_meta( $new_user_id, 'user_status', '1' ); 
 				wp_new_user_notification($new_user_id);

				$email_subject = "User Registered";

add_filter( 'wp_mail_content_type', 'set_html_content_type' );

$message = '<html lang="en" style="background:#fbfbfb;">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px; border-bottom:1px dashed #500847; margin:0;">
                        <a href="'.site_url().'" style="display:block;">
                            <img class="w320" width="200" height="100" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:14px; padding:10px 20px 0; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">Welcome to Advance Therapeutics. To log in when visiting our site go to login page, and then enter your email and password.</p>
                    </td>
                </tr>
                <tr class="highlight" style="padding:0; margin:0;">
                    <td style="font-size:14px; padding:10px 20px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <p style="color: #52595f; padding:0; margin:0">
                        To login you must verify your email address.Click link below to verify your email.
                        </p>
                    </td>
                </tr>
                  <tr class="highlight" style="padding:0; margin:0;">
                    <td style="font-size:14px; padding:10px 20px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <p style="color: #52595f; padding:0; margin:0">
                        <a href="'.site_url().'/verifyemail?id='.$new_user_id.'">Verify Email</a>
                        </p>
                    </td>
                </tr>
                   
                    <tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:14px;line-height:normal; 
                            margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">Thank You,</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_address_detail").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_helpline").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_detail").'">'.ot_get_option("pp_email_detail").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_hours_operation").'</p>
                        </td>
                    </tr>
            </table>
        </center>
    </div>
</body>
</html>';

$adminmessage = '<html lang="en" style="background:#fbfbfb;">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px; border-bottom:1px dashed #500847; margin:0;">
                        <a href="'.site_url().'" style="display:block;">
                            <img class="w320" width="200" height="100" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
                
                <tr class="highlight" style="padding:0; margin:0;">
                    <td style="font-size:14px; padding:10px 20px; margin:0; font-family:Arial;" class="w320 mobile-spacing">
                        <p style="color: #52595f; padding:0; margin:0">New user registration on your site Advance Therapeutics:</p>
                    </td>
                </tr>

				<tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Title :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">'.$user_title.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>

                   <tr>
                    <td style="padding:0 20px; margin:0; font-size:14px; font-family:Arial; ">
                        <table style="padding:5px 20px; margin:0; background:#fafafa; width:100%;">
                         <tr>
                          <td style="width:30%; text-align: left;">
                           <b style="margin:0 20px 0 0; padding:0;">Speciality:</b>
                          </td>
                          <td align="left" style="text-align: left; width: 80%;">'.$user_speciality.'
                          </td>
                         </tr>
                        </table>
                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0; font-size:14px; font-family:Arial; ">
                        <table style="padding:5px 20px; margin:0; background:#fafafa; width:100%;">
                         <tr>
                          <td style="width:30%; text-align: left;">
                           <b style="margin:0 20px 0 0; padding:0;">First name :</b>
                          </td>
                          <td align="left" style="text-align: left; width: 80%;">'.$user_firstname.'
                          </td>
                         </tr>
                        </table>
                       
                    </td>
                </tr>                
                
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Last Name :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_lastname.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">DOB :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_dob_year.', '.$user_dob_month.' '.$user_dob_day.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Gender :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_gender.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Email :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_email.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact:</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_number.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Username :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_name.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Address :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_address.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">City :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_city.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">State :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_state.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Zip/Postal Code :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_zipcode.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">LIC :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_lic.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">DEA :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_dea.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">NPI :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_npi.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>

					<tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:14px;line-height:normal; 
                            margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">Thank You,</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_address_detail").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_helpline").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_detail").'">'.ot_get_option("pp_email_detail").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_hours_operation").'</p>
                        </td>
                    </tr>

            </table>
        </center>
    </div>
</body>
</html>';


$admin_email = get_option( 'admin_email' );
$headers = 'From: Advance Therapeutics <info@advancetherapeutics.com>' . "\r\n";
//$attachments = array(WP_CONTENT_DIR ."/uploads/".$_FILES["file"]["name"]);
    if( wp_mail( $user_email, 'User Verification', $message, $headers )){
        if(wp_mail( $admin_email, $email_subject, $adminmessage, $headers )){
        	echo 'true';
        }
    }else{
		echo 'false';
    }
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
				
		}
	  }
	}
				$content = ob_get_contents();
				ob_get_clean();
				echo $content;
				exit;
}

//++++++++ Edit Profile ++++++++++++++
add_action("wp_ajax_edit_profile", "edit_profile");
add_action("wp_ajax_nopriv_edit_profile", "edit_profile");


function edit_profile(){
	parse_str($_POST['data'], $data);
	ob_start();
	if (isset( $data["pp_email"] ) && wp_verify_nonce($data['pippin_register_nonce'], 'pippin-register-nonce')) {
				$userid= $data["userid"];
				$user_title= $data["pp_title"];
				$user_speciality= $data["pp_speciality"];
				$user_firstname= $data["pp_firstname"];
				$user_lastname= $data["pp_lastname"];
				$user_dob_year= $data["dyear"];
				$user_dob_month= $data["dmonth"];
				$user_dob_day= $data["dday"];
				$user_gender= $data["optionsRadios"];
				$user_email= $data["pp_email"];
				$user_number= $data["pp_phoneno"];
				$user_name= $data["pp_username"];
				$user_address= $data["pp_address"];
				$user_city= $data["pp_city"];
				$user_state= $data["pp_state"];
				$user_zipcode= $data["pp_zipcode"];
				$user_lic= $data["pp_lic"];
				$user_dea= $data["pp_dea"];
				$user_npi= $data["pp_npi"];
				if(!is_email($user_email)) 
				{
					echo 'invalid';
				}  else {
				
					global $wpdb;
					//$filename = get_user_meta($userid,'ppicture',true);
		              $userid = wp_update_user(array(
				               	'ID' => $userid,
								//'user_login'=> $user_name,
								'user_email'=> $user_email,
								'first_name'=> $user_firstname,
								'last_name'=>  $user_lastname,
								'user_registered'=> date('Y-m-d H:i:s'),
								'role'=> 'physician'
							)
						);

               			if(!empty($_FILES["file"]["name"]) && count($_FILES["file"]["name"]) > 0 ){
						$sourcePath = $_FILES['file']['tmp_name'];
				     	$upload_dir = wp_upload_dir();
				    	$attachs = move_uploaded_file($sourcePath, WP_CONTENT_DIR ."/uploads/".$_FILES["file"]["name"]);
				      	update_user_meta( $userid, 'ppicture', $_FILES["file"]["name"] ); 
				    	}
				    	// else{
				     //  	update_user_meta( $userid, 'ppicture', $filename ); 
				    	// }
				    	update_user_meta( $userid, 'title', $user_title ); 
				    	update_user_meta( $userid, 'speciality', $user_speciality ); 
				    	update_user_meta( $userid, 'dateyear', $user_dob_year ); 
				    	update_user_meta( $userid, 'datemonth', $user_dob_month ); 
				    	update_user_meta( $userid, 'dateday', $user_dob_day ); 
				    	update_user_meta( $userid, 'gender', $user_gender ); 
				    	update_user_meta( $userid, 'contact', $user_number ); 
				    	update_user_meta( $userid, 'address', $user_address ); 
				    	update_user_meta( $userid, 'city', $user_city ); 
				    	update_user_meta( $userid, 'state', $user_state ); 
				    	update_user_meta( $userid, 'zipcode', $user_zipcode ); 
				    	update_user_meta( $userid, 'lic', $user_lic ); 
				    	update_user_meta( $userid, 'dea', $user_dea ); 
				    	update_user_meta( $userid, 'npi', $user_npi ); 
		 				//wp_new_user_notification($new_user_id);

		 				if( is_wp_error( $userid ) ) {
		 					echo 'false';
		 				} else {
		 					echo 'success';
		 				}

			}
		}
		$content = ob_get_contents();
				ob_get_clean();
				echo $content;
				exit;
}

//++++++++++REFILL PROCESS FORM +++++++++++++++
// add_action("wp_ajax_refillrx_form", "refillrx_form");
// add_action("wp_ajax_nopriv_refillrx_form", "refillrx_form");


// function refillrx_form(){

// 	$id = $_POST['reid'];
// 	global $wpdb; 

// 	$sql = "Select * from wp_rxrefill where id = $id ";

// }
// +++++++++++ END ++++++++++++++++
//++++++++ LOG IN FUNCTION +++++++++++

add_action("wp_ajax_login", "pippin_login_member");
add_action("wp_ajax_nopriv_login", "pippin_login_member");

function pippin_login_member() {
				parse_str($_POST['data'], $data);
				//$email = $data['pippin_user_email'];
				//$response = array();
				ob_start();
				 
				if(isset($data['pp_user_login']) && wp_verify_nonce($data['pippin_login_nonce'], 'pippin-login-nonce')) {
				 //$redirecturl = $data["pippin_redirect_url"];
				// this returns the user ID and other info from the user name
				 if ( is_email( $data['pp_user_login'] ) ) {
      				$user = get_user_by( 'email', $data['pp_user_login'] );
				 }else{
					$user = get_user_by('login', $data['pp_user_login']);
				 }
				
				if(!$user) {
				// if the user name doesn't exist
				$response['success'] = 'invalid';
				//pippin_errors()->add('empty_username', __('Invalid username'));
				}else if(!isset($data['pp_user_pass']) || $data['pp_user_pass'] == '') {
				// if no password was entered
				$response['success'] = 'empty';
				//pippin_errors()->add('empty_password', __('Please enter a password'));
				}else if(!wp_check_password($data['pp_user_pass'], $user->user_pass, $user->ID)) {
				// if the password is incorrect for the specified user
				$response['success'] = 'incorrect';
				//pippin_errors()->add('empty_password', __('Incorrect password'));
				}
				else if( $user->user_activation_key == 1 && $user->roles[0] == 'physician') {
				 		$response['success'] = 'notverified';
				}else if( $user->roles[0] == 'patient') {

				 		$response['success'] = 'patient';
				}
				else {
				
				wp_setcookie($data['pp_user_login'], $data['pp_user_pass'], true);
				wp_set_auth_cookie( $user->ID);
				wp_set_current_user($user->ID, $data['pp_user_login']);
				do_action('wp_login', $data['pp_user_login']);
				 
				$response['url'] = $data["pippin_redirect_url"];
				$response['success'] = 'true';
				}
			}
				ob_get_clean();
				echo json_encode($response);
				exit;
		}


add_action("wp_ajax_patient","pippin_patient_form");
add_action("wp_ajax_nopriv_patient","pippin_patient_form");

function pippin_patient_form(){
		parse_str($_POST['data'], $data);
		ob_start();
			
		$patient_username = $data["pippin_user_name"]; 
		$patient_firstname = $data["pippin_first_name"]; 
		$patient_lastname = $data["pippin_last_name"]; 
		$patient_number = $data["pippin_number"]; 
		$patient_email = $data["pippin_email"]; 
		$patient_year = $data["dyear"]; 
		$patient_month = $data["dmonth"]; 
		$patient_day = $data["dday"]; 
		$insurance_carrier = $data["insurance_carrier"]; 
		$pain_duration = $data["pain_duration"]; 
		$pain_location = $data["pain_location"]; 
		$pain_begin = implode(',', $data['checkBox']);
		$pain_description = implode(',', $data['Checkbox']);
		$options_radio = $data['optionsRadios'];
		$pain_affect = implode(',', $data['CheckBox']);
$response = array();
if( username_exists( $patient_username ) ){
	$response['success'] = 'user_exist';
}elseif( email_exists( $patient_email ) ){
	$response['success'] = 'email_exist';
  //echo 'email_exists';
}else{
  add_filter( 'wp_mail_content_type', 'set_html_content_type' );

$message = '<html lang="en" style="background:#fbfbfb;">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px; border-bottom:1px dashed #500847; margin:0;">
                        <a href="'.site_url().'" style="display:block;">
                            <img class="w320" width="120" height="90" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
                

                	<tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:20px;line-height:normal; 
                            margin:0; text-align:center; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">
                            Thank you, <br/>
                            You have been successfully registered. </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_address_detail").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_helpline").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_detail").'">'.ot_get_option("pp_email_detail").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_hours_operation").'</p>
                        </td>
                    </tr>               
            </table>
        </center>
    </div>
</body>
</html>';

$adminmessage = '<html lang="en" style="background:#fbfbfb;">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px; align:center; border-bottom:1px dashed #500847; margin:0;">
                        <a href="'.site_url().'" style="display:block;">
                            <img class="w320" width="120" height="90" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
                

                	<tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:20px;line-height:normal; 
                            margin:0; text-align:center; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">
                            Admin, <br/>
                            New patient have been registered to your site. To respond go to the admin panel.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_address_detail").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_helpline").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_detail").'">'.ot_get_option("pp_email_detail").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_hours_operation").'</p>
                        </td>
                    </tr>               
            </table>
        </center>
    </div>
</body>
</html>';

//echo $message;
//echo $adminmessage;

$admin_email = get_option( 'admin_email' );
$headers = 'From: Advanced Therapeutics <example@advancedtherapeutics.com>' . "\r\n";
$email_subject = "Patient queries";
	wp_mail( $patient_email, $email_subject, $message, $headers );
	wp_mail( $admin_email, $email_subject, $adminmessage, $headers );
	remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

				global $wpdb;
	            $new_patient_id = wp_insert_user(array(
	            	'user_login' => $patient_username,
					'user_email' => $patient_email,
					'first_name' => $patient_firstname,
					'last_name' =>  $patient_lastname,
					'user_registered' => date('Y-m-d H:i:s'),
					'role' => 'patient'
					)
					);

				if($new_patient_id) {
						$wpdb->query($wpdb->prepare( "UPDATE wp_users SET user_status = '2' where ID = $new_patient_id"));							
				    	//add_user_meta( $new_patient_id, 'patient_middlename', $patient_middlename ); 
				    	add_user_meta( $new_patient_id, 'contact', $patient_number ); 
				    	add_user_meta( $new_patient_id, 'insurance_carrier', $insurance_carrier ); 
				    	add_user_meta( $new_patient_id, 'pain_duration', $pain_duration ); 
				    	add_user_meta( $new_patient_id, 'pain_location', $pain_location ); 
				    	add_user_meta( $new_patient_id, 'pain_begin', $pain_begin ); 
				    	add_user_meta( $new_patient_id, 'pain_description1', $pain_description ); 
				    	add_user_meta( $new_patient_id, 'pain_description2', $options_radio ); 
				    	add_user_meta( $new_patient_id, 'pain_affect', $pain_affect ); 
				    	add_user_meta( $new_patient_id, 'dateyear', $patient_year ); 
				    	add_user_meta( $new_patient_id, 'datemonth', $patient_month ); 
				    	add_user_meta( $new_patient_id, 'dateday', $patient_day ); 
				    	add_user_meta( $new_patient_id, 'user_status', '2' ); 
				    }
$response['success'] = 'success';
				//echo "true"; 
}
				$content = ob_get_contents();
				ob_get_clean();
				echo json_encode($response);
				exit;
}


add_action("wp_ajax_passwordreset", "passwordreset");
add_action("wp_ajax_nopriv_passwordreset", "passwordreset");

            function passwordreset(){
              $email = $_POST['email'];
              ob_start();
              add_filter( 'wp_mail_content_type', 'set_html_content_type' );

              $response = array();
              if(email_exists($email)){
              $username = get_user_by( 'email' , $email );

$message = '<!DOCTYPE html>
<html lang="en" style="background:#fbfbfb;">

<head>
    <meta charset="UTF-8">
</head>

<body>
    <div style="margin:0 auto; padding:50px 0; width: 100%;">
        <center>
            <table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
                <tr class="logo">
                    <td style="padding:0 20px; align:center; border-bottom:1px dashed #500847; margin:0;">
                        <a href="'.site_url().'" style="display:block;">
                            <img class="w320" width="120" height="90" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
                        </a>
                    </td>
                </tr>
                <tr class="main-content" style="padding:0; margin:0;">
                    <td style="font-size:14px;padding:20px 20px 0;font-weight:600;font-family:Arial; margin:0px;">
                        <p style="padding:0 0 5px 0; margin: 0;">Hello User,</p>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">
                        To reset your password, visit the following address: </p>
                    </td>
                </tr>
                
               <tr>
                    <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
                        <p style="padding:0 0 5px 0; margin:0; color: #52595f;">
                        <a href="'.site_url().'/password-reset?id='.$username->data->ID.'">Password Reset Link</a></p>
                    </td>
                </tr>
                    <tr class="footer" style="padding:0; margin:0;">
                        <td style="padding:0 20px 10px;font-family:Arial;">
                            <p style="font-size:14px;line-height:normal; 
                            margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">Thank You,</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_address_detail").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_helpline").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_detail").'">'.ot_get_option("pp_email_detail").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_hours_operation").'</p>
                        </td>
                    </tr>
            </table>
        </center>
    </div>
</body>

</html>';

		$headers = 'From: Advanced Therapeutics <more@advthx.com>' . "\r\n";

        if(wp_mail($email,'Password Reset',$message,$headers)){

        	$response['message'] = 'success';
        	}
        remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
        }else {
            $response['message'] = 'error';
        }
        ob_get_clean();
        echo json_encode($response);
        exit();
    }



add_action("wp_ajax_newpasswordset", "newpasswordset");
add_action("wp_ajax_nopriv_newpasswordset", "newpasswordset");

	function newpasswordset()
	{
		global $wpdb;
		if( $_POST['password'] != $_POST['cpassword'] ) {
				// if the password is incorrect for the specified user
			$response['message'] = 'incorrect';
				//pippin_errors()->add('empty_password', __('Incorrect password'));
			} 
			else {
					$password = wp_hash_password($_POST['password']);
					$id = $_POST['id'];

					ob_start();
					add_filter( 'wp_mail_content_type', 'set_html_content_type' );
					$response = array();
					$rows_affected = $wpdb->query(
					$wpdb->prepare( "UPDATE wp_users SET user_pass = %s where ID= %d",
					$password, $id
					) // $wpdb->prepare
					); // $wpdb->query
					if($rows_affected > 0) {
					$username = get_user_by('id',$id);

$message = '<!DOCTYPE html>
	<html lang="en" style="background:#fbfbfb;">
		<head>
			<meta charset="UTF-8">
		</head>
	<body>
	<div style="margin:0 auto; padding:50px 0; width: 100%;">			
		<center>			
			<table style="width:600px; margin:0px auto; background:#fff; padding:0px; border:1px solid #ececec" cellpadding="0" cellspacing="0" border="0">
						<tr class="logo">
				            <td style="padding:0 20px; align:center; border-bottom:1px dashed #500847; margin:0;">
				                <a href="'.site_url().'" style="display:block;">
				                    <img class="w320" width="120" height="90" src="'.get_template_directory_uri().'/assets/images/logo.png" alt="company logo">
				                </a>
				            </td>
				        </tr>
				        <tr class="main-content" style="padding:0; margin:0;">
				            <td style="font-size:14px;padding:20px 20px 0;font-weight:600;font-family:Arial; margin:0px;">
				                <p style="padding:0 0 5px 0; margin: 0;">Hello User,</p>
				            </td>
				        </tr>
				        <tr>
				            <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
				                <p style="padding:0 0 5px 0; margin:0; color: #52595f;">
				                Your password has been reset. Please login with this credential.
				                </p>
				            </td>
				        </tr>				                
				        <tr>
				            <td style="font-size:14px; padding:10px 20px ; margin:0; font-family:Arial;" class="mobile-spacing">
				                <p style="padding:0 0 5px 0; margin:0; color: #52595f;">New Password: '.$_POST['password'].'
				                </p>
				            </td>
				        </tr>         
				               
				        <tr class="footer" style="padding:0; margin:0;">
				            <td style="padding:0 20px 10px;font-family:Arial;">
				                <p style="font-size:14px;line-height:normal;
				                margin:0; padding:20px 0 0 0; color:#52595f; border-top:1px dashed #ccc;">Thank You,</p>
				            </td>
				        </tr>
				    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0;">'.ot_get_option("pp_address_detail").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_helpline").'</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial; padding:0 20px 0">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;"><a href="mailto:'.ot_get_option("pp_email_detail").'">'.ot_get_option("pp_email_detail").'</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td style=" font-family:Arial; padding:0 20px 20px">
                            <p style="font-size:14px;line-height:normal; margin:0; padding:0; color:#52595f;">'.ot_get_option("pp_hours_operation").'</p>
                        </td>
                    </tr>
				</table>
			</center>
		</div>
	</body>
</html>';
				    
		$headers = 'From: Advanced Therapeutics <more@advthx.com>' . "\r\n";

			if(wp_mail($username->user_email,'Password Reset Success',$message,$headers)) {
				$response['message'] = 'success';
			}
				remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
		} 
			else {
				$response['message'] = 'error';
				}
					    
    		}
    ob_get_clean();
    echo json_encode($response);
    exit();
}

function load_custom_wp_admin_style() {
				       
				        wp_register_style( 'custom_wp_css', get_template_directory_uri() . '/assets/css/style-admin.css', false, '1.0.0' );
        				wp_enqueue_style( 'custom_wp_css' );
}
add_action( 'admin_enqueue_scripts', 'load_custom_wp_admin_style' );

add_shortcode('loggedin','loggedin_page');

function loggedin_page() {
?>
	<?php if( is_user_logged_in() ) : ?>     

 	<section class="light-gray step-wrapper">
      <div class="step1 text-center">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
            	<h2 class="inner_page_title">
              	<?php $current_user = wp_get_current_user(); ?>
                <?php $title = get_user_meta( $current_user->ID, 'title', false ); ?>
              	Welcome 
              	<?php echo $title[0]; ?> 
              	<?php echo $current_user->user_firstname." ".$current_user->user_lastname; ?>,
              	<span>what would you like to do today? </span>
              </h2>
              <?php if($_GET['val'] == 'success'):?>
              		<?php $style = 'display:block'; ?>
              <?php else: ?>
              	<?php $style="display:none;"; ?>
              <?php endif; ?>
              <?php if($_GET['redirect'] == 'success'):?>
              		<?php $style1 = 'display:block'; ?>
              <?php else: ?>
              	<?php $style1="display:none;"; ?>
              <?php endif; ?>
              <div class="info-rxnew alert alert-success" style="<?php echo $style1; ?>">A new RX has been written successfully and data has been sent in pdf format to patient email.</div>
              <div class="info-rxrefill alert alert-success" style="<?php echo $style; ?>">The RX has been refilled and data has been sent in pdf format to patient email.</div>
            	<div class="vertical-tab">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" id="myTab">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#refillrx" aria-controls="profile" role="tab" data-toggle="tab">Refill RX</a></li>
      </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

              <div class="step1-btn-group">
                <a href="<?php echo site_url('/formulations/');?>" class="btn btn-primary">write new rx</a>
              </div>
    </div>
    <div role="tabpanel" class="tab-pane" id="refillrx">
    	<?php
    	global $wpdb; 
    	$sql = "Select * from wp_rxrefill where currentuser = '".$current_user->ID."'";
    	$results = $wpdb->get_results($sql);
    	?>
    	<table class="table" id="example">
    		<thead>
    			<th>S.N.</th>
    			<th>Refill Value </th>
    			<th>Patient Name</th>
    			<th>Formulation</th>
    			<th>DOB</th>
    			<th>Phone</th>
    			<th>Prescribed At</th>
    			<th>Action</th>
    		</thead>
			<tbody>
				<?php if( !empty( $results ) ):
				$k = 1; 
				 foreach( $results  as $key => $r ):
				 $title = get_the_title( $r->formulation_id );
				 $users = get_user_by( 'ID', $r->user_id );
				 $year = get_user_meta( $r->user_id, 'dateyear', true );
				 $month = get_user_meta( $r->user_id, 'datemonth', true );
				 $day = get_user_meta( $r->user_id, 'dateday', true );
				 $phone = get_user_meta( $r->user_id, 'contact', true );
				 if( $r->refill == 0 ){
				  $rx = $r->last_option;
				 }else{
				 $rx = $r->refill;
				 }
				 	?>
				<tr>
					<td><?php echo $k; ?></td>
					<td><?php echo $rx; ?></td>
					<td><?php echo $users->user_nicename; ?></td>
					<td><?php echo wp_trim_words( ucfirst( $title ), 2, '...' ); ?></td>
					<td><?php if( !empty( $year ) && !empty( $month ) && !empty( $day ) ) { echo $year. ', '. $month . ' '. $day ; }?></td>
					<td><?php echo $phone?></td>
					<td><?php echo $r->created_at; ?></td>
					<td><a href="<?php echo site_url() . '/refill-rx?id='.$r->id ;?>" id="refillrx" class="btn btn-primary" data-id="<?php echo $r->id; ?>"><i class="fa fa-refresh"></i></a></td>
				</tr>
				<?php $k++; endforeach; 
					 
				endif; ?>
			</tbody>
    	</table>
    </div>
  </div>

</div>
              
            </div>
            
          </div>
        </div>
      </div>
    </section> 

 <?php  endif; ?>
 <?php 
 }


 function the_slug($echo=true){
  $slug = basename(get_permalink());
  do_action('before_slug', $slug);
  $slug = apply_filters('slug_filter', $slug);
  if( $echo ) echo $slug;
  do_action('after_slug', $slug);
  return $slug;
}

//get listings for 'works at' on submit listing page
add_action('wp_ajax_nopriv_get_listing_names', 'ajax_listings');
add_action('wp_ajax_get_listing_names', 'ajax_listings');

function ajax_listings() {
	global $wpdb; //get access to the WordPress database object variable

	//get names of all businesses
	$name = $wpdb->esc_like(stripslashes($_POST['name'])).'%'; //escape for use in LIKE statement
	$sql = "select user_login 
		from $wpdb->users 
		where user_nicename like %s 
		and user_status='2'";

	$sql = $wpdb->prepare($sql, $name);
	
	$results = $wpdb->get_results($sql);

	//copy the business titles to a simple array
	$titles = array();
	foreach( $results as $r )
		$titles[] = addslashes($r->user_login);
		
	echo json_encode($titles); //encode into JSON format and output

	die(); //stop "0" from being output
}
//get listings for 'works at' on submit listing page
add_action('wp_ajax_nopriv_get_names_information', 'ajax_information');
add_action('wp_ajax_get_names_information', 'ajax_information');

function ajax_information() {
	global $wpdb; //get access to the WordPress database object variable

	//get names of all businesses
	$name = $_POST['name']; //escape for use in LIKE statement
    $users = get_user_by('login', $name);
    $status = get_user_meta( $users->ID, 'user_status', true);

	$sql = "select * 
		from $wpdb->users 
		where user_login = %s 
		and user_status = %d ";

	$sql = $wpdb->prepare($sql, $name, $status);
	
	$results = $wpdb->get_row($sql);

	//copy the business titles to a simple array
	$info['user_email'] = $results->user_email;
    $info['firstname'] = get_user_meta($results->ID,'first_name',true);
    $info['middlename'] = get_user_meta($results->ID,'middle_name',true);
    $info['lastname'] = get_user_meta($results->ID,'last_name',true);
    $info['phone'] = get_user_meta($results->ID,'contact',true);
    $info['dyear'] = get_user_meta($results->ID,'dateyear',true);
    $info['dmonth'] = get_user_meta($results->ID,'datemonth',true);
    $info['dday'] = get_user_meta($results->ID,'dateday',true);
	
		
	echo json_encode($info); //encode into JSON format and output

	die(); //stop "0" from being output
}

add_action('wp_ajax_nopriv_formprocess', 'form_process');
add_action('wp_ajax_formprocess', 'form_process');

function form_process(){
		parse_str($_POST['data'], $data);
		
		ob_start(); 
		$current_user = wp_get_current_user();
		$siteurl = site_url();
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		if(!empty($_FILES["file"]["name"])){
				
		    $file = str_replace(' ', '', $_FILES["file"]["name"]);
		    $sourcePath = $_FILES['file']['tmp_name'];
		    $upload_dir = wp_upload_dir();
			move_uploaded_file($sourcePath, WP_CONTENT_DIR ."/uploads/".$file);
			$attachments =  WP_CONTENT_DIR ."/uploads/".$file ;
			}
			
		 
			if( !empty( $data['pdfname'] ) ){
			$pdfname = $data['pdfname'];
			}else{
				$pdfname = 'formulation';
			}
			
			if($data['optionsRadios'] == 0){
				$refillval = $data['lastoption'];
				$refill = $data['optionsRadios'];
				}else{
				$refill = $data['optionsRadios'];
				$refillval = $data['optionsRadios'];
				}
			   $html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email templates</title>

    <style>
		.container{
			width: 560px;
			margin: 0 auto;
		}
    </style>
</head>

<body style="">
    <div class="container">
        
            <div style="text-align:center;">
                
                    <img src="'.get_template_directory_uri().'/assets/images/logo.png" />
            </div>
            <div style="text-align:center;text-decoration:underline;">
                <h3>'.ucfirst( $data["formulationsection"] ).'</h3>
            </div>
      
        <table width="100%" style="margin:0 auto;background-color:#fafafa;padding:15px;" cellpadding="0" cellspacing="0" border="0" align="center">
            <tbody>
                <tr>
                    <td>
                        <h3 style="margin:0;border-bottom:1px solid #e1e1e1; padding-bottom:10px;">Patient '.$data["username"].'`s New RX-Fill Information</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%;" cellpadding="0" cellspacing="0" border="0">
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Refill</td>
                                <td width="50%">: '.$refillval.'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Username</td>
                                <td width="50%">: '.$data["username"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">First Name</td>
                                <td width="50%">: '.$data["firstname"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Last Name</td>
                                <td width="50%">: '.$data["lastname"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Email Address</td>
                                <td width="50%">: '.$data["email"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">DOB</td>
                                <td width="50%">: '.$data["dyear"].','.$data["dmonth"].' '.$data["dday"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Phone No.</td>
                                <td width="50%">: '.$data["phone"].'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 10px 10px 0;">
                        <h4 style="margin:0">Allergies</h4>
                        <p style="margin:0;">'.$data["allergies"].'</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

   ';

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$output = $dompdf->output();
file_put_contents(WP_CONTENT_DIR ."/uploads/". $pdfname . ".pdf", $output);
// email stuff (change data below)
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
$email = $data["email"];
$to = $email .', lakshya.punkrock@gmail.com'; 
$from = $data["email"]; 
$subject = "Patient Information"; 
if(!empty($file)){
$body= "<p>Please see the attachment. <a href=".$siteurl."/wp-content/uploads/".$file.">Click here</a> to see the attachemnt for Patient Demographics Sheet. </p>";// a random hash will be 
}else{
$body= "<p>Please see the attachment.</p>" ; 
}
//necessary to send mixed content
//$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
//$eol = PHP_EOL;
// attachment name
$filename = $pdfname . ".pdf";
// encode data (puts attachment in proper format)
$attachment = WP_CONTENT_DIR ."/uploads/".$filename ;

// main header (multipart mandatory)
$headers  = "From: ".$from;

// send message

if(wp_mail($to, $subject, $body, $headers,$attachment)){
	    global $wpdb;
		$users = get_user_by('login', $data['username']);
		$table_name = $wpdb->prefix.'rxrefill';
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
		     //table not in database. Create new table
		     $charset_collate = $wpdb->get_charset_collate();
		 
		     $sql = "CREATE TABLE $table_name (
		          id mediumint(9) NOT NULL AUTO_INCREMENT,
		          currentuser integer NOT NULL,
		          user_id integer NOT NULL,
		          refill integer NOT NULL,
		          formulation_id integer NOT NULL,
		          filename text NOT NULL,
		          allergies text NOT NULL,
		          option1 integer NOT NULL,
		          last_option integer NOT NULL,
		          pdfname text NOT NULL,
		          created_at timestamp NOT NULL,
		          UNIQUE KEY id (id)
		     ) $charset_collate;";
		     require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		     dbDelta( $sql );
	}
	
		

	$fid = $data['formulationid'];
	$allergies = $data['allergies'];
	if(!empty($data['optionsRadios1'])){
	$options = $data['optionsRadios1'];
	} else {
	$options = 0;	
	}

	$date = date('Y/m/d H:i:s');
	if($users){
	$sql = "INSERT INTO $table_name (currentuser, user_id, refill, formulation_id, filename, allergies, option1, created_at,last_option, pdfname)
	     VALUES ('$current_user->ID','$users->ID', '$refill', '$fid', '$file', '$allergies','$options', '$date', '$refillval', '$pdfname')";
	$wpdb->query($sql);
	 }else{

	 	 $new_patient_id = wp_insert_user(array(
	            	'user_login' => $data['username'],
					'user_email' => $data['email'],
					'first_name' => $data['firstname'],
					'last_name' =>  $data['lastname'],
					'user_registered' => date('Y-m-d H:i:s'),
					'role' => 'patient'
					)
					);
				if($new_patient_id) {
					$wpdb->query($wpdb->prepare( "UPDATE wp_users SET user_status = '2' where ID = $new_patient_id"));							
				    	add_user_meta( $new_patient_id, 'contact', $data['phone'] ); 
				    	add_user_meta( $new_patient_id, 'dateyear', $data['dyear'] ); 
				    	add_user_meta( $new_patient_id, 'datemonth', $data['dmonth'] ); 
				    	add_user_meta( $new_patient_id, 'dateday', $data['dday'] ); 
				    	add_user_meta( $new_patient_id, 'user_status', '2' );
				    	$sql = "INSERT INTO $table_name (currentuser,user_id, refill, formulation_id, filename, allergies, option1, created_at, pdfname)
						     VALUES ('$current_user->ID','$new_patient_id', '$refill', '$fid', '$file', '$allergies','$options', '$date','$pdfname' )";
						$wpdb->query($sql);
				    }
	 }


		echo 'sucess';
	 }else{
	 	echo 'fail';
	 }
	$content = ob_get_contents();
				ob_get_clean();
				echo $content;
				exit;
				    
	}


	//------------------edit rx fill ------------------//

	add_action('wp_ajax_nopriv_updateformprocess', 'update_form_process');
add_action('wp_ajax_updateformprocess', 'update_form_process');

function update_form_process(){
		parse_str($_POST['data'], $data);
		
		ob_start(); 
		global $wpdb;
		$current_user = wp_get_current_user();
		$siteurl = site_url();
		$users = get_user_by('login', $data['username']);
		$table_name = $wpdb->prefix.'rxrefill';
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		if(!empty($_FILES["file"]["name"]) && count($_FILES["file"]["name"]) > 0 ){
			
		    $file = $_FILES["file"]["name"];
		    $sourcePath = $_FILES['file']['tmp_name'];
		    $upload_dir = wp_upload_dir();
			move_uploaded_file($sourcePath, WP_CONTENT_DIR ."/uploads/".$file);
			$attachments =  WP_CONTENT_DIR ."/uploads/".$file ;
			}else{
				
				$rid = $data['id']; 

				$sqls = "select filename 
					from $table_name 
					where id = %d ";

				$sqls = $wpdb->prepare($sqls, $rid);
				
				$results = $wpdb->get_row($sqls);
				$file = $results->filename; 
			}
			if( !empty( $data['pdfname'] ) ){
			$pdfname = $data['pdfname'];
			}else{
				$pdfname = 'formulation';
			}
			if($data['optionsRadios'] == 0){
				$refill = $data['optionsRadios'];
				$refillval = $data['lastoption'];
				}else{
				$refill = $data['optionsRadios'];
				$refillval = $data['optionsRadios'];
				}
			

			  $html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Email templates</title>

    <style>
		.container{
			width: 560px;
			margin: 0 auto;
		}
    </style>
</head>

<body style="">
    <div class="container">
        
            <div style="text-align:center;">
                
                    <img src="'.get_template_directory_uri().'/assets/images/logo.png" />
            </div>
            <div style="text-align:center;text-decoration:underline;">
                <h3>'.ucfirst( $data["formulationsection"] ).'</h3>
            </div>
      
        <table width="100%" style="margin:0 auto;background-color:#fafafa;padding:15px;" cellpadding="0" cellspacing="0" border="0" align="center">
            <tbody>
                <tr>
                    <td>
                        <h3 style="margin:0;border-bottom:1px solid #e1e1e1; padding-bottom:10px;">Patient '.$data["username"].'`s Refill RX Information</h3>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%;" cellpadding="0" cellspacing="0" border="0">
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Refill</td>
                                <td width="50%">: '.$refillval.'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Username</td>
                                <td width="50%">: '.$data["username"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">First Name</td>
                                <td width="50%">: '.$data["firstname"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Last Name</td>
                                <td width="50%">: '.$data["lastname"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Email Address</td>
                                <td width="50%">: '.$data["email"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">DOB</td>
                                <td width="50%">: '.$data["dyear"].','.$data["dmonth"].' '.$data["dday"].'</td>
                            </tr>
                            <tr style="border-bottom:1px solid #ccc;">
                                <td width="50%" style="padding:10px 10px 10px 0;">Phone No.</td>
                                <td width="50%">: '.$data["phone"].'</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding:10px 10px 10px 0;">
                        <h4 style="margin:0">Allergies</h4>
                        <p style="margin:0;">'.$data["allergies"].'</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>

   ';
   
   

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$output = $dompdf->output();
file_put_contents(WP_CONTENT_DIR ."/uploads/". $pdfname . ".pdf", $output);
// email stuff (change data below)
add_filter( 'wp_mail_content_type', 'set_html_content_type' );
$email = $data["email"];
$to = $email .', lakshya.punkrock@gmail.com'; 
$from = $data["email"]; 
$subject = "Patient Information"; 
if(!empty($file)){
$body= "<p>Please see the attachment. <a href=".$siteurl."/wp-content/uploads/".$file.">Click here</a> to see the attachemnt send for Patient Demographics Sheet. </p>";
}else{
$body= "<p>Please see the attachment.</p>" ; 
}
//necessary to send mixed content
//$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
//$eol = PHP_EOL;
// attachment name
$filename = $pdfname . ".pdf";
// encode data (puts attachment in proper format)
$attachment = WP_CONTENT_DIR ."/uploads/".$filename ;

// main header (multipart mandatory)
$headers  = "From: ".$from;

// send message

if(wp_mail($to, $subject, $body, $headers, $attachment)){
	    
		$fid = $data['formulationid'];
		$allergies = $data['allergies'];
		if(!empty($data['optionsRadios1'])){
		$options = $data['optionsRadios1'];
		} else {
		$options = 0;	
		}
	    $rxid = $data['refillid'];
		$date = date('Y/m/d H:i:s');
		if($users){
			$wpdb->update($table_name,
				array(
					'currentuser' => $current_user->ID,
					'user_id' => $users->ID,
					'refill' => $refill,
					'formulation_id' => $fid,
					'filename' =>$file,
					'allergies' =>$allergies,
					'option1' =>$options,
					'created_at' =>$date,
					'last_option' =>$refillval,
					'pdfname' =>$pdfname

					),
				array( 'id' => $rxid )
				
			);
						update_user_meta( $users->ID, 'first_name', $data['firstname'] ); 
						update_user_meta( $users->ID, 'last_name', $data['lastname'] ); 
						update_user_meta( $users->ID, 'contact', $data['phone'] ); 
				    	update_user_meta( $users->ID, 'dateyear', $data['dyear'] ); 
				    	update_user_meta( $users->ID, 'datemonth', $data['dmonth'] ); 
				    	update_user_meta( $users->ID, 'dateday', $data['dday'] );
		 }else{

	 	 $new_patient_id = wp_insert_user(array(
	            	'user_login' => $data['username'],
					'user_email' => $data['email'],
					'first_name' => $data['firstname'],
					'last_name' =>  $data['lastname'],
					'user_registered' => date('Y-m-d H:i:s'),
					'role' => 'patient'
					)
					);
				if($new_patient_id) {
						$wpdb->query($wpdb->prepare( "UPDATE wp_users SET user_status = '2' where ID = $new_patient_id"));							
				    	add_user_meta( $new_patient_id, 'contact', $data['phone'] ); 
				    	add_user_meta( $new_patient_id, 'dateyear', $data['dyear'] ); 
				    	add_user_meta( $new_patient_id, 'datemonth', $data['dmonth'] ); 
				    	add_user_meta( $new_patient_id, 'dateday', $data['dday'] ); 
				    	$sql = "INSERT INTO $table_name (currentuser, user_id, refill, formulation_id, filename, allergies, option1, created_at, pdfname)
						     VALUES ('$current_user->ID', '$new_patient_id', '$refill', '$fid', '$file', '$allergies','$options', '$date','$pdfname' )";
						$wpdb->query($sql);
				    }
	 }

	 	echo $data['siteurl'];
		echo 'sucess';
	 }else{
	 	echo 'fail';
	 }
	 remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
	$content = ob_get_contents();
				ob_get_clean();
				echo $content;
				exit;
				    
	}

	

function set_html_content_type(){
				return 'text/html';
				}


add_filter('the_content', 'remove_empty_tags_p', 20, 1);
function remove_empty_tags_p ($str, $repto = NULL) {
$str = force_balance_tags($str);
//** Return if string not given or empty.
if (!is_string ($str)
|| trim ($str) == "")
return $str;
//** Recursive empty HTML tags.
return preg_replace (
'~\s?<p>(\s|&nbsp;)+</p>\s?~',
//** Replace with nothing if string empty.
!is_string ($repto) ? "" : $repto,
//** Source string
$str
);}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
	return 'Advance Therapeutics';
}

// Hooking up our functions to WordPress filters 
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );








