<?php
/**
 * Snippet Name: Add form validation script to custom post types
 * script download URL : http://www.javascript-coder.com/files/form-validation/javascript_form.zip
 * replace 'custom post type name' with your post type name
 */

// function to add validation scripts to post type page
// if( !function_exists( "cmb2_validation_script_post_type" ) ) {  
//   function cmb2_validation_script_post_type( $pagearg ) {
//       global $post;

//       // check if we are on custom post edit or add new page
//       // if ( $pagearg == 'post-new.php' || $pagearg == 'post.php') {
//               wp_enqueue_script(  'jquery-validate', get_stylesheet_directory_uri().'/bower_components/jquery-validation/dist/jquery.validate.min.js',array('jquery','admin-scripts') );
//               wp_enqueue_script(  'jquery-validate-methods', get_stylesheet_directory_uri().'/bower_components/jquery-validation/dist/additional-methods.min.js',array('jquery','admin-scripts') );
//       // }
//   }
// }
// add_action( 'admin_enqueue_scripts', 'cmb2_validation_script_post_type', 10, 1 );