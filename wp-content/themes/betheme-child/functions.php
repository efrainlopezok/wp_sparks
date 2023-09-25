<?php
/**
 * Betheme Child Theme
 *
 * @package Betheme Child Theme
 * @author Muffin group
 * @link https://muffingroup.com
 */

/**
 * Child Theme constants
 * You can change below constants
 */

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/shortcode.php' );

// white label

define('WHITE_LABEL', false);

/**
 * Enqueue Styles
 */

function mfnch_enqueue_styles()
{
	// enqueue the parent stylesheet
	// however we do not need this if it is empty
	// wp_enqueue_style('parent-style', get_template_directory_uri() .'/style.css');

	// enqueue the parent RTL stylesheet

	if (is_rtl()) {
		wp_enqueue_style('mfn-rtl', get_template_directory_uri() . '/rtl.css');
	}

	// enqueue the child stylesheet
	wp_enqueue_style( 'fontawesome', 'https://use.fontawesome.com/releases/v5.0.7/css/all.css' );

	wp_enqueue_style( 'slick', get_stylesheet_directory_uri() . '/css/slick.css' );

	wp_enqueue_style( 'aos-css', get_stylesheet_directory_uri() . '/css/aos.css' );
	wp_enqueue_style( 'animation-css', get_stylesheet_directory_uri() . '/css/animations.css' );
	wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri() . '/css/slick-theme.css' );

	wp_enqueue_script( 'slick', get_stylesheet_directory_uri() . '/js/slick.min.js' );

	wp_enqueue_script( 'custom', get_stylesheet_directory_uri() . '/js/custom.js' );
	wp_enqueue_script( 'aos-js', get_stylesheet_directory_uri() . '/js/aos.js' );
	wp_enqueue_script( 'animation-js', get_stylesheet_directory_uri() . '/js/css3-animate-it.js', array('jquery'),'1.1', true);
	wp_dequeue_style('style');
	wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');
	wp_enqueue_style('custom-load', get_stylesheet_directory_uri() .'/css/custom.css');
}
add_action('wp_enqueue_scripts', 'mfnch_enqueue_styles', 101);

/* Sparks Widgets */
require get_stylesheet_directory() . '/inc/widgets/init.php';

/* Muffin Builder functions */
require get_stylesheet_directory() . '/functions/builder/class-mfn-builder.php';
/**
 * Load Textdomain
 */

function mfnch_textdomain()
{
	load_child_theme_textdomain('betheme', get_stylesheet_directory() . '/languages');
	load_child_theme_textdomain('mfn-opts', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'mfnch_textdomain');

/* svg
---------------------------------------------------------------- */
add_filter('upload_mimes', 'my_upload_mimes');
function my_upload_mimes($mimes = array()) {
   $mimes['svg'] = 'image/svg+xml';
   return $mimes;
}
define('ALLOW_UNFILTERED_UPLOADS', true);


function wpb_widgets_init() {
 
    register_sidebar( array(
        'name'          => 'Custom Header Widget Area',
        'id'            => 'custom-header-widget',
        'before_widget' => '<div class="contentbox-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="chw-title">',
        'after_title'   => '</h2>',
    ) );
 
}
add_action( 'widgets_init', 'wpb_widgets_init' );

// class Mfn_Builder_Fields {
// 	public function __construct() {

// 		$this->sliders = array(
// 		  'layer' => Mfn_Builder_Helper::get_sliders('layer'),
// 		  'rev' => Mfn_Builder_Helper::get_sliders('rev'),
// 		);
  
  
// 		$this->set_custom_items();
  
// 	  }
// }
// function set_custom_items(){
// 	$this->items = array(
// 		// Placeholder ----------------------------------------------------

// 		'placeholder' => array(
// 			'type' 		=> 'placeholder',
// 			'title' 	=> __('Custom Item', 'mfn-opts'),
// 			'size' 		=> '1/4',
// 			'cat' 		=> 'other',
// 			'fields'	=> array(

// 				array(
// 					'id' 		=> 'info',
// 					'type' 		=> 'info',
// 					'title' 	=> '',
// 					'desc' 		=> __('This is Muffin Builder Placeholder.', 'mfn-opts'),
// 					'class' 	=> 'mfn-info info',
// 				),

// 			),
// 		),
// 	);
// }

function excerpt($num) {
	$limit = $num+1;
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	array_pop($excerpt);
	$excerpt = implode(" ",$excerpt).".";
	return $excerpt;
}