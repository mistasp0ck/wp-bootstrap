<?php

add_action( 'cmb2_admin_init', 'wpbs_register_page_metabox' );
/**
 * Hook in and add a metabox that only appears on most pages, 'page' to begin with, but feel free to add to any!
 */
if( !function_exists( "wpbs_register_page_metabox" ) ) {  
  function wpbs_register_page_metabox() {
    $prefix = 'fs_';

    /**
     * Metabox to be displayed on a single page ID
     */
    $wpbs_pages = new_cmb2_box( array(
      'id'           => $prefix . 'metabox',
      'title'        => __( 'Page Settings', 'cmb2' ),
      'object_types' => array( 'page','services' ), // Post type
      'context'      => 'normal',
      'priority'     => 'low',
      'show_names'   => true, // Show field names on the left
      //'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
    ) );

    $wpbs_pages->add_field( array(
        'name'    => 'Menu Style',
        'id'      => $prefix . 'menu_style',
        'type'    => 'radio_inline',
        'options' => array(
            'dark' => __( 'Dark', 'cmb2' ),
            'light'   => __( 'Light', 'cmb2' ),
            ''     => __( 'Global <em>(set in theme options)</em>', 'cmb2' ),
        ),
        'default' => '',
    ) );

    $wpbs_pages->add_field( array(
        'name'    => 'Menu State',
        'id'      => $prefix . 'menu_state',
        'type'    => 'radio_inline',
        'options' => array(
            'fixed' => __( 'Fixed', 'cmb2' ),
            'notfixed'   => __( 'Not Fixed', 'cmb2' ),
            ''     => __( 'Global <em>(set in theme options)</em>', 'cmb2' ),
        ),
        'default' => '',
    ) );

    // $wpbs_pages->add_field( array(
    //     'name'    => 'Enable Flyout Menu?',
    //     'id'      => $prefix . 'nav_sidebar',
    //     'type'    => 'radio_inline',
    //     'options' => array(
    //       'true' => __( 'Yes', 'cmb2' ),
    //       'false'   => __( 'No', 'cmb2' )
    //     ),
    //     'default' => 'false',
    // ) );

    $wpbs_pages->add_field( array(
        'name'    => 'Mobile Menu Style',
        'id'      => $prefix . 'nav_sidebar_style',
        'type'    => 'radio_inline',
        'options' => array(
          'right-flyout-menu' => __( 'Right Sidebar', 'cmb2' ),
          'full-flyout-menu'   => __( 'Full Width', 'cmb2' ),
          ''     => __( 'Global <em>(set in theme options)</em>', 'cmb2' ),
        ),
        'default' => '',
    ) );

    $wpbs_pages->add_field( array(
      'name' => __( 'Icon', 'cmb2' ),
      'desc' => __( 'add an icon for Listings', 'cmb2' ),
      'id'   => $prefix . 'icon',
      'type' => 'file',
      // Optional:
      'options' => array(
          'url' => false, // Hide the text input for the url
          'add_upload_file_text' => 'Add Icon' // Change upload button text. Default: "Add or Upload File"
      )
    ) );

    $wpbs_pages->add_field( array(
      'name' => 'Hero Settings',
      'type' => 'title',
      'id'   => 'hero_settings'
    ) );

    $wpbs_pages->add_field( array(
      'name' => __( 'Slider Revolution in Header', 'cmb2' ),
      // 'desc' => __( '', 'cmb2' ),
      'id'   => $prefix . 'revolution_slider',
      'type' => 'select',
      'options_cb' => 'get_revolution_sliders',
    ) );

    $wpbs_pages->add_field( array(  
      'name'=> 'Overlay Transparent Menu', 
      'label'=> 'If Revolution Slider is active, use a transparent menu',  
      'desc'  => '',  
      'id'    => $prefix. 'revolution_overlay',  
      'type'  => 'checkbox' 
    ));

    $wpbs_pages->add_field( array(  
      'name'=> 'Show Featured Image for Hero', 
      'label'=> 'Show Featured Image for Hero',  
      'desc'  => '',  
      'id'    => $prefix. 'hero',  
      'type'  => 'checkbox' 
    ));


    $wpbs_pages->add_field( array(
      'name' => __( 'Featured Image Title', 'cmb2' ),
      'desc' => __( 'Optional Title that appears on top of the featured image', 'cmb2' ),
      'id'   => $prefix . 'featured_title',
      'type' => 'text',
    ) );  

    $wpbs_pages->add_field( array(
      'before'=> '<div class="messageBox"></div>',
      'name' => __( 'Featured Image Description', 'cmb2' ),
      'desc' => __( 'Optional Description that appears on top of the featured image', 'cmb2' ),
      'id'   => $prefix . 'featured_desc',
      'type' => 'textarea',
    ) );


    $wpbs_pages->add_field( array(
      'name' => __( 'Featured Text Alignment', 'cmb2' ),
      'desc' => __( 'Align Title and Description', 'cmb2' ),
      'id'   => $prefix . 'featured_align',
      'type'    => 'radio_inline',
      'options' => array(
          'left' => __( 'Left', 'cmb2' ),
          'center'   => __( 'Center', 'cmb2' ),
          'right'   => __( 'Right', 'cmb2' ),
          ''     => __( 'Default <em>(set in theme options)</em>', 'cmb2' ),
      ),
    ) );

 

    


  }
}
