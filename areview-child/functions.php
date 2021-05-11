<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );

if ( !function_exists( 'chld_thm_cfg_parent_css' ) ):
    function chld_thm_cfg_parent_css() {
        wp_enqueue_style( 'chld_thm_cfg_parent', trailingslashit( get_template_directory_uri() ) . 'style.css', array( 'areview-bootstrap' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'chld_thm_cfg_parent_css', 10 );

// END ENQUEUE PARENT ACTION

// Redirect to Url
function redirect_function( $atts, $content = null ) {

	$default_atts = array(
		"url" => ''
	);
	
	$params = shortcode_atts( $default_atts, $atts );
	
	return '<a href="' . $params['url'] . '" target="_blank" id="a_link">' . $content . '</a>';
}
add_shortcode('redirect', 'redirect_function');

// Show current Date
function currentDate_function($atts){
	return '<p class="p_date">The current date is ' . date('d-m-Y') . '.</p>';
}

add_shortcode('date-today', 'currentDate_function');

// Adding a colored text shortcode
function custom_colored_text( $atts ) {
	$default_atts = array(
		"title" => '',
		"title_color" => ''
	);
	$params = shortcode_atts( $default_atts, $atts );
	$title_styles = "";
	// generate color style
	if( ! empty( $params['title_color'] ) ) {
		$title_styles .= "color: " . $params['title_color'] . ";";
	}
	return '<div class="text-holder"><span class="text-title" style="' . $title_styles . '">' . esc_html( $params['title'] ) . '</span></div>';
}

add_shortcode('colored_text', 'custom_colored_text');

// Embed Video
function video_embed_shortcode( $atts ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'src' => '',
			'width' => '',
			'height' => '',
		),
		$atts,
		'video_embed'
	);

	// Return custom embed code
	return '<embed 
	         src="' . $atts['src'] . '"
	         width="' . $atts['width'] . '"
	         height="' . $atts['height'] . '"
	         allowscriptaccess="always"
	         allowfullscreen="true">';
}

add_shortcode('video_embed', 'video_embed_shortcode');

// Display User Name Message
function greet_user_shortcode( $atts ) {
	$current_user = '';
	
	if (is_user_logged_in()) {    
		$user = wp_get_current_user();
		$current_user = $user->display_name;
	} else {
		$current_user = 'Guest';
	}
   return 'Hello ' . $current_user . '!';
}

add_shortcode('hello', 'greet_user_shortcode');

// Follow Us Page
function follow_function($atts, $content = null) {
    return '<a href="https://twitter.com/WordPress" target="blank" class="doti-follow">' . $content . '</a>';
}

add_shortcode('follow', 'follow_function');

// Show Latest Posts
function recent_posts_shortcode( $atts , $content = null ) {

	// Attributes
	$atts = shortcode_atts(
		array(
			'posts' => '5',
		),
		$atts,
		'recent-posts'
	);

	// Query
	$the_query = new WP_Query( array ( 'posts_per_page' => $atts['posts'] ) );
	
	// Posts
	$output = '<ul class="ul_posts">';
	while ( $the_query->have_posts() ) :
		$the_query->the_post();
		$output .= '<li>' . get_the_title() . '</li>';
	endwhile;
	$output .= '</ul>';
	
	// Reset post data
	wp_reset_postdata();
	
	// Return code
	return $output;

}
add_shortcode( 'recent-posts', 'recent_posts_shortcode' );