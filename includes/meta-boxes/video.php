<?php
add_action( 'cmb2_admin_init', 'wpbs_register_video_metabox' );
/**
 * Hook in and add a metabox that only appears for the 'video' post_type
 */
if( !function_exists( "wpbs_register_video_metabox" ) ) {  
  function wpbs_register_video_metabox() {
    $prefix = 'video_';

    /**
     * Metabox to be displayed on a single page ID
     */
    $video = new_cmb2_box( array(
      'id'           => $prefix . 'metabox',
      'title'        => __( 'Video Page Settings', 'cmb2' ),
      'object_types' => array( 'video' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true // Show field names on the left
    ) );

    $video->add_field( array(
        'name' => 'Video Title',
        'desc' => '',
        'id'   => $prefix . 'title',
        'type' => 'text',
    ) );

    $video->add_field( array(
        'name' => 'Video Description',
        'desc' => '',
        'id'   => $prefix . 'desc',
        'type' => 'textarea',
    ) );

    $video->add_field( array(
        'name' => 'Video Link',
        'desc' => 'Enter a youtube, twitter, or instagram URL. Supports services listed at <a href="http://codex.wordpress.org/Embeds">http://codex.wordpress.org/Embeds</a>.',
        'id'   => $prefix . 'embed',
        'type' => 'oembed',
    ) );

  }  
}  