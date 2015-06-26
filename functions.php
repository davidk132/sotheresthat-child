<?php // functions.php template file for So There's That theme - child of Serene Theme

// enqueue parent theme style scripts
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

// enqueue child theme scripts if needed:
// https://codex.wordpress.org/Child_Themes#How_to_Create_a_Child_Theme


//  Enqueue script for return to top

function stt_scripts() {
    wp_enqueue_script( 'stt-rtt-js', get_stylesheet_directory_uri() . '/js/stt-rtt.js', array( 'jquery' ), false, true );
}
add_action( 'wp_enqueue_scripts', 'stt_scripts' );

// add RTT anchor to the top of the page
function stt_add_anchor( $content ) {
  global $post;
  
  /* Exit if not a post, page, or attachment */
  if ( ! is_singular() ) {
    return $content;
  }
  
  if( ! is_admin() ) {
    $stt_rtt_link = '<a href="#" class="rtt_button"><i class="arrow_carrot_up_alt"></i>&nbsp;&nbsp;top</a>';
    $content = $content . $stt_rtt_link;
    return $content;
  } else {
    return $content;
  }
}
add_filter( "the_content", "stt_add_anchor" );

// load script for related posts field at bottom of post
require_once get_stylesheet_directory() . '/inc/stt-related-posts.php';

// load script for dual byline, writer and photographer
require_once get_stylesheet_directory() . '/inc/stt-photog-byline.php';
