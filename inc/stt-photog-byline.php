<?php

// Adds a dual byline - writer and photographer. See GitHub for more info:
// https://github.com/davidk132/photog-byline

// Create the metabox in the post where the photographer is designated.
// Photographer must be a registered user on the site.
add_action( 'add_meta_boxes', 'dkd_id_photog_create' );
function dkd_id_photog_create() {
  add_meta_box( 'photog-by', 'Photographer', 'dkd_id_photog', 'post', 'normal', 'high' );
}

function dkd_id_photog( $post ) {
  echo "<p>Photographer credited on this post. Must be a registered user of any permissions level. If there is no photographer listed on this post, then the byline will only show the author.</p>";
  $allusers = get_users();  
  // determine if a photographer is picked and display. 
  $stt_photog = get_post_meta( $post->ID, '_stt_photog', true );
  if (! $stt_photog ) {
    echo "There is no photographer on this post.<br />";
  } else {
    echo "<h4>The current photographer on this post is $stt_photog </h4><br />";
  }
  echo "Check the photographer on this post:"; // display list for writer to select photographer
  ?> 
  <p>Photographer
  <select name="stt_photog">
    <option value="" <?php selected( $stt_photog, "none" ); ?>>
      none
    </option>
    <?php 
    foreach ( $allusers as $eachuser ) : // display list of users on dropdown pick list 
      $listed_user = $eachuser->display_name; ?>
      <option value="<?php echo $listed_user ?>" <?php selected( $stt_photog, $listed_user ); ?>>
        <?php echo esc_html( $listed_user ); ?>
      </option>
    <?php endforeach; ?>
  </select>
  </p>
  <?php  
}
add_action( 'save_post', 'stt_save_photog' ); // hook to save selected photographer in post meta
function stt_save_photog( $post_id ) {
  if (isset( $_POST['stt_photog'] ) ) {
    update_post_meta( $post_id, '_stt_photog', strip_tags( $_POST['stt_photog'] ) );
  }
}

// On post, insert photographer into the standard post byline if one is designated
if ( ! function_exists( 'stt_get_photog_id' ) ) : // iterate through user list to match display name and return ID
function stt_get_photog_id( $photog ) {
  $allusers = get_users();
  $photog_id = 0; // default to zero. This could be set to default to any user ID
  foreach ( $allusers as $eachuser ) :
    if ( $photog == $eachuser->display_name ) {
      $photog_id = $eachuser->ID;
    }
  endforeach;
  return $photog_id;
  }
endif;
if ( ! function_exists( 'et_postinfo_meta' ) ) :
function et_postinfo_meta() {
  $photog = get_post_meta( get_the_ID(), '_stt_photog', true ); // get photographer display name picked by metabox
	$photog_id = stt_get_photog_id( $photog ); // get photographer ID by iterating through list
  $photog_url = '<a href="' . get_author_posts_url( $photog_id ) . '">' . $photog . '</a>'; // create photographer link
  echo '<p class="meta-info">';
	// Translators: 1 is author, 2 is category list.
	if ( $photog == '' ) { // for no photographer print original Serene byline
    printf( __( 'Written by %1$s in %2$s', 'Serene' ),
		  et_get_the_author_posts_link(),
		  get_the_category_list(', ')
	  );  
  } else { // print byline to include photographer
    printf( __( 'Written by %1$s and photography by %2$s in %3$s', 'Serene' ),
		  et_get_the_author_posts_link(),
      $photog_url,
		  get_the_category_list(', ')
	  );
  }
	echo '</p> <!-- .meta-info -->';
}
endif;