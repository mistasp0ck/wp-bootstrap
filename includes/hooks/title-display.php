<?php 
if( !function_exists( "wpbs_title_display" ) ) {  
  function wpbs_show_title($id = '') {
    // Hide default Title if Featured image Hero or Revolution slider is detected (make sure to add the <h1></h1> tag!)
    global $post;

    if ($id == '') {
      $id = $post->ID;
    }
    if (!is_single() || !is_archive()) :
        // Featured header and Revolution slider
        if( get_post_meta($id, 'wpbs_revolution_slider', true) != ''){ 
            return false;

        } else if ( has_post_thumbnail($id) && get_post_meta($id, 'wpbs_hero', true) == true) {
            return false;     
      } else {
        return true; 
      }
    endif;
    error_log('$hide_title: '. $hide_title);

  }
}

?>