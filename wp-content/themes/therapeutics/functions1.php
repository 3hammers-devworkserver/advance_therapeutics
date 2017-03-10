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


function add_menus_meta_box(){

	add_meta_box( 'menus-options', 'Breadcrumb', 'menus_options', 'page', 'side', 'high' );
/*									'label'												*/
}
add_action( 'add_meta_boxes', 'add_menus_meta_box' );

function menus_options($menu)
{
		// $values = get_post_custom( $menu->ID );
?>
		<select name="meta-box-dropdown">
                <?php 
                    $option_values = array('Enable', 'Disable');

                    foreach($option_values as $key => $value) 
                    {
                        if($value == get_post_meta($menu->ID, "meta-box-dropdown", true))
                        {
                            ?>
                                <option selected><?php echo $value; ?></option>
                            <?php    
                        }
                        else
                        {
                            ?>
                                <option><?php echo $value; ?></option>
                            <?php
                        }
                    }
                ?>
            </select>

<?php
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
	<?php $services= get_posts(array(
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
	                            <p>
	                            	<?php echo $service->post_title; ?>
	                            </p>                                  
	                        </div>
	                    </div>
                	<?php endforeach; endif; ?>
	            </div>
	        </div>
	   	

<?php
}

function shortcode_newsroom(){
?>
		<section>
		    <div class="section-title">
		        <div class="container">
		            <div class="row">
		                <?php if(!empty(ot_get_option('text_second'))): echo ot_get_option('text_second');
		                else: ?>
		                    <div class="col-md-6">
		                        <h1>Recent From <br>Newsroom</h1>
		                    </div>
		                    <div class="col-md-6">
		                        <p>
		                           Experience the advantage of excellent service, solutions, partnership, integrity and innovation with leading multi-specialty health care company Advanced Therapeutics.
		                        </p>
		                    </div> 
		                <?php endif; ?>
		            </div>
		        </div>
		    </div>

	    		<div class="post-wrapper">
	                <div class="container">
	                    <div class="post-block">
	                        <?php $k = 1; ?>
	                        <?php $news= get_posts(array(
	                            'post_type' => 'news',
	                            'posts_per_page' => -1,
	                            'order' => 'ASC' ) ); ?>
	                            <?php if($news) :            
	                            foreach( $news as $key => $new ): 
	                            if ($k % 2 == 1): ?>
	                        <div class="row">
	                            <div class="col-md-5">
	                            <?php $news_image_url = wp_get_attachment_url( get_post_thumbnail_id( $new->ID )); ?>
	                            <!-- <a href= "<?php echo get_the_permalink($new->ID);?>" > -->
	                                <div class="post-image bg-image" style="background-image:
	                                url('<?php echo $news_image_url;?>');">                                    
	                                </div>
	                            </div>
	                            <div class="col-md-7">
	                                <div class="entry-content p20left">
	                                    <div class="post-meta">
	                                        <ul class="list-unstyled list-inline">
	                                            <li><i class="fa fa-user"></i><em>Posted by</em><a href="#">
	                                                <?php echo $new->post_author;?></a></li>
	                                            <li><i class="fa fa-tag"></i><a href="#">Social Studies</a></li>
	                                        </ul>
	                                    </div>
	                                    <div class="post-head">
	                                        <h1 class="post-title"><?php echo $new->post_title;?></h1>
	                                    </div>
	                                    <div class="post-content">
	                                        <p>
	                                            <?php echo $new->post_content;?>
	                                        </p>
	                                    </div>
	                                    <a href="<?php echo get_the_permalink($new->ID); ?>" class="">Read More</a>
	                                </div>
	                            </div>
	                        </div>                       
	                        
	                            <?php else: ?>
	                        <div class="row">                            
	                            <div class="col-md-7">
	                                <div class="entry-content p20right">
	                                    <div class="post-meta">
	                                        <ul class="list-unstyled list-inline">
	                                            <li><i class="fa fa-user"></i><em>Posted by</em><a href="#">
	                                                <?php echo $new->post_author;?></a></li>
	                                            <li><i class="fa fa-tag"></i><a href="#">Case Studies</a></li>
	                                        </ul>
	                                    </div>
	                                    <div class="post-head">
	                                        <h1 class="post-title"><?php echo $new->post_title;?></h1>
	                                    </div>
	                                    <div class="post-content">
	                                        <p>
	                                            <?php echo $new->post_content;?>
	                                        </p>
	                                    </div>
	                                    <a href="<?php echo get_the_permalink($new->ID); ?>" class="">Read More</a>
	                                </div>
	                            </div>
	                            <div class="col-md-5">
	                                <?php $news_image_url1 = wp_get_attachment_url(get_post_thumbnail_id( $new->ID));?>
	                                <div class="post-image bg-image" style="background-image:
	                                url('<?php echo $news_image_url1;?>');">
	                                </div>
	                            </div>
	                        </div>                    
	                        <?php  endif; $k++; endforeach; endif; ?>                  
	                    </div>
	                    
	                </div>
	            </div>
        </section>
	
<?php
}
add_shortcode('newsroom', 'shortcode_newsroom');


function show_breadcrumb() {
    global $post;
    
    //echo '<div >You are here: ';
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
           			echo $pieces[$i] ;
           		}
				$last_word = array_pop($pieces);
                echo '<span> &nbsp;'.$last_word.('</span></h2>');
                
            }
        }elseif(!is_single()){          
             	echo '<li class="active">';
                echo " $post->post_title".(' </li></ol> ');
           		echo '<h2 class="inner_page_title">';
           		$pieces = explode(' ', $post->post_title);
           		$count = count($pieces);
           		for( $i=0; $i < ( $count - 1 ); $i++){
           			echo $pieces[$i] ;
           		}
				$last_word = array_pop($pieces);
                echo '<span> &nbsp;'.$last_word.('</span></h2>');
            
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
    //echo '</div>';       
 }



// ++++++++ registration add new physician +++++++

add_action("wp_ajax_register", "pippin_add_new_member");
add_action("wp_ajax_nopriv_register", "pippin_add_new_member");

function pippin_add_new_member(){
	parse_str($_POST['data'], $data);
	ob_start();

if (isset( $data["pp_email"] ) && wp_verify_nonce($data['pippin_register_nonce'], 'pippin-register-nonce')) {
				//$redirecturl= $data["pippin_redirect_url"];
				$user_title= $data["pp_title"];
				$user_speciality= $data["pp_speciality"];
				$user_firstname= $data["pp_firstname"];
				$user_lastname= $data["pp_lastname"];
				$user_dob= $data["pp_dob"];
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
				//$pass_confirm = $data["pippin_user_pass_confirm"];

			
				if ( username_exists( $user_name ) ){
				//invalid email
				//$response['success'] = 'invalid';							
				echo 'exist_username';
				//pippin_errors()->add('email_invalid', __('Invalid email'));
				}
				else if(!is_email($user_email)) 
				{
					echo 'invalid';
				}
				else if($user_pass == '') {
				// passwords do not match
				//$response['success'] = 'empty';
				echo 'empty';
				//pippin_errors()->add('password_empty', __('Please enter a password'));
				}
				//else if($user_pass != $pass_confirm) {
				// passwords do not match
				//echo 'match';
				//pippin_errors()->add('password_mismatch', __('Passwords do not match'));
				//}
				else if(email_exists($user_email)) {
				//Email address already registered
				//$response['success'] = 'exist';
				echo 'exist';
				//pippin_errors()->add('email_used', __('Email already registered'));
				} else {
					//echo '<pre>11'; die();
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
						$wpdb->query($wpdb->prepare( "UPDATE wp_users SET user_activation_key = '0' where ID = $new_user_id"));
						$sourcePath = $_FILES['file']['tmp_name'];
						//echo $_FILES["file"]; die();
				     	$upload_dir = wp_upload_dir();
				    	$attachs = move_uploaded_file($sourcePath, WP_CONTENT_DIR ."/uploads/".$_FILES["file"]["name"]);
				    	add_user_meta( $new_user_id, 'title', $user_title ); 
				    	add_user_meta( $new_user_id, 'speciality', $user_speciality ); 
				      	add_user_meta( $new_user_id, 'ppicture', $_FILES["file"]["name"] ); 
				    	add_user_meta( $new_user_id, 'dateofbirth', $user_dob ); 
				    	add_user_meta( $new_user_id, 'gender', $user_gender ); 
				    	add_user_meta( $new_user_id, 'contact', $user_number ); 
				    	add_user_meta( $new_user_id, 'address', $user_address ); 
				    	add_user_meta( $new_user_id, 'city', $user_city ); 
				    	add_user_meta( $new_user_id, 'state', $user_state ); 
				    	add_user_meta( $new_user_id, 'zipcode', $user_zipcode ); 
				    	add_user_meta( $new_user_id, 'lic', $user_lic ); 
				    	add_user_meta( $new_user_id, 'dea', $user_dea ); 
				    	add_user_meta( $new_user_id, 'npi', $user_npi ); 



 				wp_new_user_notification($new_user_id);

				// die('here');
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Full Name :</b></td>
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
                           <b style="margin:0 20px 0 0; padding:0;">Username :</b>
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
                           <b style="margin:0 20px 0 0; padding:0;">Email Address :</b>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
                      <td align="left" style="width: 80%; text-align: left;">   '.$user_dob.'
                      </td>
                     </tr>
                    </table>                       
                    </td>
                </tr>
                <tr>
                    <td style="padding:0 20px; margin:0;font-size:14px; font-family:Arial;">
                    <table style="padding:5px 20px; margin:0; background:#fafafa; width: 100%;">
                     <tr>
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
                      <td align="left" style="width:30%;"><b style="margin:0 20px 0 0; padding:0;">Contact No :</b></td>
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
$attachments = array(WP_CONTENT_DIR ."/uploads/".$_FILES["file"]["name"]);
    wp_mail( $user_email, 'User Verification', $message, $headers );
    wp_mail( $admin_email, $email_subject, $adminmessage, $headers, $attachments );
    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
				
				echo 'true';
				}
				else
				{
				//$response['success'] = 'false';
				echo 'false';
				}
				 
				}

				}
				$content = ob_get_contents();
				ob_get_clean();
				// echo json_encode($response);
				echo $content;
				exit;
				}


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
					$user = get_user_by('username', $data['pp_user_login']);
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
				// else if($user->user_activation_key == 0 && 'role' == 'subscriber') {
				// 		$response['success'] = 'notverified';
				// }
				else{
				 
				wp_setcookie($data['pp_user_login'], $data['pp_user_pass'], true);
				wp_set_auth_cookie( $user->ID);
				wp_set_current_user($user->ID, $data['pp_user_login']);
				do_action('wp_login', $data['pp_user_login']);
				 
				$response['data.url'] = $data["pippin_redirect_url"];
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
		//echo '<pre>'; print_r($data);	die();
		ob_start();
			
		$patient_firstname = $data["pippin_first_name"]; 
		$patient_middlename = $data["pippin_middle_name"]; 
		$patient_lastname = $data["pippin_last_name"]; 
		$patient_number = $data["pippin_number"]; 
		$patient_email = $data["pippin_email"]; 
		$insurance_carrier = $data["insurance_carrier"]; 
		$pain_duration = $data["pain_duration"]; 
		$pain_location = $data["pain_location"]; 
		$pain_begin = implode(',', $data['checkBox']);
		$pain_description = implode(',', $data['Checkbox']);
		$options_radio = $data['optionsRadios'];
		$pain_affect = implode(',', $data['CheckBox']);


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
                            Your queries have been successfully registered. </p>
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
                            New queries have been registered to your site. To respond go to the admin panel.</p>
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
	            	'user_login' => $patient_email,
					'user_email' => $patient_email,
					'first_name' => $patient_firstname,
					'last_name' =>  $patient_lastname,
					'user_registered' => date('Y-m-d H:i:s'),
					'role' => 'patient'
					)
					);

				if($new_patient_id) {							
				    	add_user_meta( $new_patient_id, 'patient_middlename', $patient_middlename ); 
				    	add_user_meta( $new_patient_id, 'patient_number', $patient_number ); 
				    	add_user_meta( $new_patient_id, 'insurance_carrier', $insurance_carrier ); 
				    	add_user_meta( $new_patient_id, 'pain_duration', $pain_duration ); 
				    	add_user_meta( $new_patient_id, 'pain_location', $pain_location ); 
				    	add_user_meta( $new_patient_id, 'pain_begin', $pain_begin ); 
				    	add_user_meta( $new_patient_id, 'pain_description1', $pain_description ); 
				    	add_user_meta( $new_patient_id, 'pain_description2', $options_radio ); 
				    	add_user_meta( $new_patient_id, 'pain_affect', $pain_affect ); 
				    }

				echo "true";                


				$content = ob_get_contents();
				ob_get_clean();
				echo $content;
				exit;
}


add_action("wp_ajax_passwordreset", "passwordreset");
add_action("wp_ajax_nopriv_passwordreset", "passwordreset");

            function passwordreset(){
              $email = $_POST['email'];
              //echo '<pre>'; print_r($email); die();	
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

// function register_custom_menu_page() {
//     add_menu_page('patient queries', 'Patient queries', 'add_users', 'custompage', '_custom_menu_page', null); 
// }
// add_action('admin_menu', 'register_custom_menu_page');

// function _custom_menu_page(){

// 	global $wpdb;
// 

 //<!-- <div class="">
// 	<table class='' border='1' font-family='arial' width: '600' >
// 		<thead>
// 			<tr>
// 				<th class="">S.N.</th>
// 				<th class="">First Name</th>
// 				<th class="">Middle Name</th>
// 				<th class="">Last Name</th>
// 				<th class="">Phone Number</th>
// 				<th class="">Email Address</th>
// 				<th class="">Insurance Carrier</th>
// 				<th class="">How long have you had pain?</th>
// 				<th class="">Where is your pain located?</th>
// 				<th class="">Which of the following best describes how the pain begin</th>
// 				<th class="">How do you best describe your pain?</th>
// 				<th class="">How do you best describe your pain? </th>
// 				<th class="">Which affect your pain?</th>
// 			</tr>
// 		</thead>
// 		<tbody> -->

		  
// 		</tbody>
// 	</table>
// </div>
// <?php  
// }


add_shortcode('loggedin','loggedin_page');

function loggedin_page() {
?>
	<?php if( is_user_logged_in() ) : ?>
	<div class="navbar navbar-default navbar-fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo site_url();?>">
            	<img src="<?php echo get_template_directory_uri();?>/assets/images/logo.png" alt="Advance Therapeutics"></a>
			<div class="auth">
              <div class="auth-img">
                <i class="fa fa-user-o"></i>
              </div>
              <ul class="list-unstyled">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    	<?php $current_user = wp_get_current_user(); ?>
                    	<?php $title = get_user_meta( $current_user->ID, 'title', false ); ?>
                    	<?php echo $title[0]; ?> 
						<?php echo $current_user->user_firstname." ".$current_user->user_lastname; ?>
                    	<i class="fa fa-angle-down"></i></a>
                    <ul class="dropdown-menu navmenu-nav">
                        <li><a href="profile.html"><i class="fa fa-cog"></i>Manage Account</a></li>
                        <li><a href="#"><i class="fa fa-sign-out"></i>log out</a></li>
                      
                    </ul>
                </li>
              </ul>
              
            </div>
            <button type="button" class="navbar-toggle" data-toggle="offcanvas" data-recalc="false" data-target=".navmenu" data-canvas=".canvas">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            </div>
    </div>
      

 	<section class="light-gray step-wrapper">
      <div class="step1 text-center">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <h2 class="inner_page_title">
              	Welcome 
              	<?php echo $title[0]; ?> 
              	<?php echo $current_user->user_firstname." ".$current_user->user_lastname; ?>,
              	<span>what would you like to do today? </span></h2>

              <div class="step1-btn-group">
                <a href="<?php echo site_url('/formulations/');?>" class="btn btn-primary">write new rx</a>
                <a href="#" class="btn btn-primary">refill previous rx</a>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section> 

 <?php  endif; ?>
 <?php 
 }

function set_html_content_type(){
				return 'text/html';
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
	$name = $wpdb->esc_like(stripslashes($_POST['name'])); //escape for use in LIKE statement

	$sql = "select * 
		from $wpdb->users 
		where user_login = %s 
		and user_status = '2'";

	$sql = $wpdb->prepare($sql, $name);
	
	$results = $wpdb->get_row($sql);

	//copy the business titles to a simple array
	
    $info['user_email'] = $results->user_email;
    $info['firstname'] = get_user_meta($results->ID,'first_name',true);
    $info['middlename'] = get_user_meta($results->ID,'middle_name',true);
    $info['lastname'] = get_user_meta($results->ID,'last_name',true);
    $info['phone'] = get_user_meta($results->ID,'contact',true);
	
		
	echo json_encode($info); //encode into JSON format and output

	die(); //stop "0" from being output
}

add_action('wp_ajax_nopriv_formprocess', 'form_process');
add_action('wp_ajax_formprocess', 'form_process');

function form_process(){
		parse_str($_POST['data'], $data);
		
		ob_start(); 
		require_once(ABSPATH . "wp-admin" . '/includes/file.php');
		if(!empty($_FILES["file"]["name"])){
		    $file = $_FILES["file"]["name"];
		    $sourcePath = $_FILES['file']['tmp_name'];
		    $upload_dir = wp_upload_dir();
			move_uploaded_file($sourcePath, WP_CONTENT_DIR ."/uploads/".$file);
			$attachments =  WP_CONTENT_DIR ."/uploads/".$file ;
			}
			
			  $html = '
<div class="pdf-wrapper">
<div class="wrap">
<div class="left">
<h2>Advance Therapeutics</h2>
<p>'.ucfirst( $data["formulationsection"] ).'</p>
</div>
</div>
<h5>New Patient Information</h5>
<table  border="0" cellspacing="0" >
<tr>
<td>
<table border="0" cellspacing="0" >
<tbody>
<tr>
<td>Refill : '.$data["optionsRadios"].'</td>
</tr>
<tr>
<td>Username : '.$data["username"].'</td>
</tr>
<tr>
<td>First Name : '.$data["firstname"].'</td>
</tr>
<tr>
<td>Last name : '.$data["lastname"].'</td>
</tr>
<tr>
<td>Email Address : '.$data["email"].'</td>
</tr>
<tr>
<td>DOB : '.$data["dob"].'</td>
</tr>
<tr>
<td>Phone : '.$data["phone"].'</td>
</tr>
</tbody>
</table>
</td>
</tr>
</table>   	
</div> 
   ';
$h2t =& new html2text($html);
   // fpdf object
$pdf = new FPDF();
// generate a simple PDF (for more info, see http://fpdf.org/en/tutorial/)
$pdf->AddPage();
$pdf->SetFont("Arial","",14);
$pdf->MultiCell(400,5, $h2t->get_text(),0,'L');
// email stuff (change data below)
$to = "lakshya@3hammers.com"; 
$from = $data["email"]; 
$subject = "Patient Information"; 
$message = "<p>Please see the attachment.</p>";
// a random hash will be necessary to send mixed content
$separator = md5(time());
// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;
// attachment name
$filename = "appoinment.pdf";
// encode data (puts attachment in proper format)
$pdfdoc = $pdf->Output("", "S");
$attachment = chunk_split(base64_encode($pdfdoc));

// main header (multipart mandatory)
$headers  = "From: ".$from.$eol;
$headers .= "MIME-Version: 1.0".$eol; 
$headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\""; 
$body = "--".$separator.$eol;
$body .= "Content-Transfer-Encoding: 7bit".$eol;
$body .= "This is a MIME encoded message.".$eol.$eol;
// message
$body .= "--".$separator.$eol;
$body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
$body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
$body .= $message.$eol.$eol;
// attachment
$body .= "--".$separator.$eol;
$body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
$body .= "Content-Transfer-Encoding: base64".$eol;
$body .= "Content-Disposition: attachment".$eol.$eol;
$body .= $attachment.$eol.$eol;
$body .= "--".$separator."--";

// send message
if(mail($to, $subject, $body, $headers)){
	echo 'sucess';
}else{
	echo 'fail';
}
	$content = ob_get_contents();
				ob_get_clean();
				echo $content;
				exit;
				    
	}












