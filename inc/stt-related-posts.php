<?php 
/* Do stuff on public pages */
function do_something_with_content( $content ) {
  global $post; // You'll need this, especially in the Loop, or else the post is invisible inside the function.
  
  /* Exit if not a post, page, or attachment. Unless you want plugin active in post lists, in which case remove this statement */
  if ( ! is_single() ) {
    return $content;
  }
  
  /* Do stuff as long as it's not the admin page, but rather on public posts and pages  */
  if( ! is_admin() ) {
    // Set up variables
    $posts_per_page = 3;
    $rp_copy = "<div class='related-posts'><h4 class='rp-header'>You May Also Like</h4><ul class='related-posts-grid'>";
    $related_tags = wp_get_post_tags( $post->ID, array( 'fields' => 'ids') );
    /* Set up WP query for related posts. Find related tags. If none, find related category */
    if( $related_tags ) {
      $rp_args = array( 'tag__in' => $related_tags, 'post__not_in' => array( $post->ID ), 'posts_per_page' => intval($posts_per_page) );
    } else {
      $related_categories = wp_get_post_categories( $post->ID );
      $rp_args = array( 'category__in' => $related_categories, 'post__not_in' => array( $post->ID ), 'posts_per_page' => intval($posts_per_page) );      
    }
    $rp_query = new WP_Query( $rp_args );
    
    /* Finish copy to return with content with a custom Loop */
    if( $rp_query->have_posts() ) {
      while( $rp_query->have_posts() ) {
        $rp_query->the_post();
        /* Concatenate the rp list for each found post */
        $rp_copy .= '<li class="rp-list-item">';
        
        // Add title
          $rp_copy .= '<h2><a class="rp-title" href="' . get_permalink() . '">' . get_the_title() . '</a></h2><br/>';
        
        // Add thumbnail
          $rp_copy .= '<a class="rp-thumb" href="' . get_permalink() . '">' . get_the_post_thumbnail( $post->ID ) . '</a><br/>';
        
        // Add post-date
          $rp_copy .= '<p class="rp-postdate">' . get_the_date( 'F j, Y' ) . '</p>';
        
        // end list item
        $rp_copy .= '</li>';
        
      } // end the Loop
      $rp_copy .=  '</ul></div>'; // end the whole list
       $content .= $rp_copy; // add rp list to post content
    // end conditional check for the Loop
    } else {
      // no related items found in query
    } // end else for conditional check for the Loop
    /* Reset wp query */
    wp_reset_postdata();
    return $content;
  }
  return $content; // if we are on an admin page
}
add_filter( "the_content", "do_something_with_content" ); // i.e., we're inside the Loop