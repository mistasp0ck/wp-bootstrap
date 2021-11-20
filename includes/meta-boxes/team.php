<?php
add_action( 'cmb2_admin_init', 'wpbs_register_team_metabox' );
/**
 * Hook in and add a metabox that only appears on most pages, 'page' to begin with, but feel free to add to any!
 */
if( !function_exists( "wpbs_register_team_metabox" ) ) {  
  function wpbs_register_team_metabox() {
    $prefix = 'team_';

    /**
     * Metabox to be displayed on a single page ID
     */
    $team = new_cmb2_box( array(
      'id'           => $prefix . 'metabox',
      'title'        => __( 'Team Member\'s Info', 'cmb2' ),
      'object_types' => array( 'team', ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
      //'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
    ) );

    $team->add_field( array(
      'name' => __( 'First Name', 'cmb2' ),
      'desc' => __( '', 'cmb2' ),
      'id'   => $prefix . 'first',
      'type' => 'text'
      ));

    $team->add_field( array(
      'name' => __( 'Last Name', 'cmb2' ),
      'desc' => __( '', 'cmb2' ),
      'id'   => $prefix . 'last',
      'type' => 'text'
      ));

    $team->add_field( array(
      'name' => __( 'Job Title', 'cmb2' ),
      'desc' => __( '', 'cmb2' ),
      'id'   => $prefix . 'title',
      'type' => 'text'
      ));


    $team_additional = new_cmb2_box( array(
      'id'           => 'additional_metabox2',
      'title'        => __( 'Meet the Team Area (for service pages)', 'cmb2' ),
      'object_types' => array( 'team', ), // Post type
      'context'      => 'normal',
      'priority'     => 'high',
      'show_names'   => true, // Show field names on the left
      //'show_on'      => array( 'id' => array( 2, ) ), // Specific post IDs to display this metabox
    ) );

    $team_additional->add_field( array(
      'name' => __( 'Shorter Bio', 'cmb2' ),
      'desc' => __( 'A short bio that will appear on any service page that is checked.', 'cmb2' ),
      'id'   => $prefix . 'bio',
      'type' => 'textarea'
      ));

    $team_additional->add_field( array(
        'name'    => 'Service Pages',
        'desc'    => 'Add the team member to any service page by checking the name',
        'id'      => 'service-page',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options_cb' => 'service_page_callback'
    ) );

  }
}
?>