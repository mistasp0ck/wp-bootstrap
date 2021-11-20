<?php
add_action( 'cmb2_admin_init', 'wpbs_register_faqs_metabox' );
/**
 * Hook in and add a metabox that only appears on the 'Faqs' post_type
 */
if( !function_exists( "wpbs_register_faqs_page_metabox" ) ) {  
  function wpbs_register_faqs_metabox() {
    $prefix = 'faq_';

    /**
     * Metabox to be displayed on a single page ID
     */
    $faqs = new_cmb2_box( array(
      'id'           => $prefix . 'metabox',
      'title'        => __( 'Faqs Settings', 'cmb2' ),
      'object_types' => array( 'faqs' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
    ) );

    $faqs->add_field( array(
      'name' => __( 'Answer', 'cmb2' ),
      'desc' => __( 'Enter your Answer', 'cmb2' ),
      'id'   => $prefix . 'answer',
      'type' => 'wysiwyg',
    ) );

  }
}  
