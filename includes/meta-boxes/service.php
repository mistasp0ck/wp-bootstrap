<?php
add_action( 'cmb2_admin_init', 'wpbs_register_services_metabox' );
/**
 * Hook in and add a metabox that only appears for the 'services' post_type
 */
if( !function_exists( "wpbs_register_services_metabox" ) ) {  
  function wpbs_register_services_metabox() {
    $prefix = 'services_';

    /**
     * Metabox to be displayed on a single page ID
     */
    $service = new_cmb2_box( array(
      'id'           => $prefix . 'metabox',
      'title'        => __( 'Service Details', 'cmb2' ),
      'object_types' => array( 'services' ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true // Show field names on the left
    ) );

    $service->add_field( array(
      'name' => __( 'Slider Revolution in Header', 'cmb2' ),
      // 'desc' => __( '', 'cmb2' ),
      'id'   => 'wpbs_' . 'revolution_slider',
      'type' => 'select',
      'options_cb' => 'get_revolution_sliders',
    ) );

    $service->add_field( array(
      'name' => __( 'Icon', 'cmb2' ),
      'desc' => __( 'add an icon for Service Listing', 'cmb2' ),
      'id'   => $prefix . 'icon',
      'type' => 'file',
      // Optional:
      'options' => array(
          'url' => false, // Hide the text input for the url
          'add_upload_file_text' => 'Add Icon' // Change upload button text. Default: "Add or Upload File"
      )
    ) );

  }  
}