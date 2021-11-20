<?php
if( !function_exists( "wpbs_get_page_options" ) ) {  
  function wpbs_get_page_options() {
    global $post;

    // defaults
    $options = array (
      'fixed' => '',
      'classes' => '',
      'affix' => '',
      'menuclasses' => '',
      'logo_class' => '',
      'logo_affix' => '',
      'logo_affix_uri' => '',
      'logo' => '',
      'logo_id' => '',
      'posts_page' => '',
      'page_id' => '',
      'menu_type' => 'default'
    );
    // add as theme option

    if (!empty($post->ID)) {
      $options['page_id'] = $post->ID;    
    }

    // Featured header and Revolution slider
    if ( is_front_page() && is_home() ) {
      // Default homepage
    } elseif ( is_front_page() ) {
      // static homepage
    } elseif ( is_home() ) {
      $options['posts_page'] = get_option( 'page_for_posts' ); 
      $options['page_id'] = get_post( $options['posts_page'] )->ID;
      // $title   = get_post( $options['posts_page'] )->post_title;
      // $desc = get_post( $options['posts_page'] )->post_content;
    } else {
      //everything else
    }
    //Handle Menu States on pages with theme override
    if ( get_post_meta($options['page_id'],'fs_menu_style', true) == 'light' ) {
      $options['logo_class'] = ' logo-option';
      $options['logo'] = $options['logo_affix_uri'] = wpbs_get_option( 'wpbs_logo_light' );
      $options['logo_id'] = wpbs_get_option( 'wpbs_logo_light_id' );

    } elseif ( get_post_meta($options['page_id'],'fs_menu_style', true) == 'dark'  ) {
      $options['menuclasses'] .= ' navbar-inverse';
      $options['logo_class'] = ' logo-option';
      $options['logo'] = $options['logo_affix_uri'] = wpbs_get_option( 'wpbs_logo_dark' );
      $options['logo_id'] = wpbs_get_option( 'wpbs_logo_dark_id' );

    } elseif ( get_post_meta($options['page_id'],'fs_menu_style', true) == 'none' || wpbs_get_option( 'wpbs_menu_style' ) != '' ) {
      if ( wpbs_get_option( 'wpbs_menu_style' ) == 'light' ) {
        $options['logo_class'] = ' logo-option';
        $options['logo'] = $options['logo_affix_uri'] = wpbs_get_option( 'wpbs_logo_light' );
        $options['logo_id'] = wpbs_get_option( 'wpbs_logo_light_id' );

      } elseif (wpbs_get_option( 'wpbs_menu_style' ) == 'dark' ) {
        $options['menuclasses'] .= ' navbar-inverse';
        $options['logo_class'] = ' logo-option';
        $options['logo'] = $options['logo_affix_uri'] = wpbs_get_option( 'wpbs_logo_dark' );
        $options['logo_id'] = wpbs_get_option( 'wpbs_logo_id' );
      }
    }

    if ( get_post_meta($options['page_id'],'fs_menu_state', true) == 'fixed' ) {
      $options['fixed'] = true;
      // error_log('Fixed state detected (page)');

    } elseif ( get_post_meta($options['page_id'],'fs_menu_state', true) == '' &&  wpbs_get_option( 'wpbs_menu_state' ) == 'fixed' ) {
      // error_log('Fixed state detected (theme)');
      $options['fixed'] = true;
    } 

    if ( $options['fixed'] == true ){
      //for Revolution Slider
        $options['menuclasses'] .= ' fixed-top';
        $options['logo_class'] = ' logo-option';

        if ( get_post_meta($options['page_id'],'fs_revolution_overlay', true) == 'on' ) {
          $options['affix'] = 'affix';
          $options['classes'] = 'fixed affixed transparent';

          // there has to be two images to use the transparent state
          if ( wpbs_get_option( 'wpbs_logo_trans' ) && wpbs_get_option( 'wpbs_logo_light' ) ){
            $options['logo'] = wpbs_get_option( 'wpbs_logo_trans' );
            $options['logo_id'] = wpbs_get_option( 'wpbs_logo_trans_id' );
            $options['logo_affix'] = true;
          } else {
            $options['logo'] = '';
            $options['logo_affix'] = false;
          }
        } else {
          $options['affix'] = '';
          $options['classes']='fixed no-affix';
          // $options['menuclasses'] .= ' fixed-top';
        }

    } else {
      
      // Three Criteria must be met! 
      if (get_post_meta($options['page_id'],'fs_revolution_overlay', true) == 'on' && has_post_thumbnail() && get_post_meta($options['page_id'],'fs_hero', true) == 'on' )  {
          $options['classes'] = 'transparent';
          // there has to be two images to use the transparent state
          if (wpbs_get_option( 'wpbs_logo_trans' ) && wpbs_get_option( 'wpbs_logo_light' )){
            $options['logo'] = wpbs_get_option( 'wpbs_logo_trans' );
            $options['logo_id'] = wpbs_get_option( 'wpbs_logo_trans_id' );
            $options['logo_affix'] = true;
          } else {
            $options['logo'] = '';
            $options['logo_affix'] = false;
          }
      } else {
          $options['classes'] = '';         
      }

    }

    if (!empty($options['logo'])) {
      $img_atts = wp_get_attachment_image_src($options['logo_id'],'full');

      // $img_atts = wp_getimagesize( $options['logo'] );
      // error_log(print_r($img_atts,true));
      $options['logo_styles'] = ' style="background-image:url('. $options['logo'].');width:'.$img_atts[1].'px;height:'.$img_atts[2].'px"';
    } else {
      $options['logo_styles'] = '';
    }
    // test to see if dimensions are needed for the overlay also
    if ($options['logo_affix'] == true) {
      $options['logo_affix'] = '<div class="logo-affix" style="background-image:url('. $options['logo_affix_uri'].');"></div>';
    } else {
      $options['logo_affix'] = '';
    }  

    if (wpbs_get_option( 'wpbs_menu_slide' ) == 'true') { 
      $options['form_class']= ' searchbox';
      $options['form_icon']= '<i class="searchbox-exit fa fa-remove"></i>';
      $options['form_group'] = '';
    } else {
      $options['form_group'] = 'form-group';
      $options['form_class'] = 'navbar-form navbar-right';
      $options['form_icon']= '';
    }

    if( get_post_meta($options['page_id'],'fs_nav_sidebar_style', true) == 'right-flyout-menu') {
      $options['menu_type'] = 'right-flyout-menu';
    } elseif ( get_post_meta($options['page_id'],'fs_nav_sidebar_style', true) == '' &&  wpbs_get_option( 'wpbs_nav_sidebar_style' ) == 'right-flyout-menu' ) {
      $options['menu_type'] = 'right-flyout-menu';
    }

    if( get_post_meta($options['page_id'],'fs_nav_sidebar_style', true) == 'full-flyout-menu') {
      $options['menu_type'] = 'full-flyout-menu';

    } elseif ( get_post_meta($options['page_id'],'fs_nav_sidebar_style', true) == '' &&  wpbs_get_option( 'wpbs_nav_sidebar_style' ) == 'full-flyout-menu' ) {
      $options['menu_type'] = 'full-flyout-menu';
    }

    if ($options['menu_type'] === 'right-flyout-menu') { 
      $options['menuclasses'] .= ' sidebar-nav-right flyout-nav';
    } else if ($options['menu_type'] === 'full-flyout-menu') {
      $options['menuclasses'] .= ' flyout-nav full-width full-flyout-menu';
    } else {
      // default menu classes
      $options['menuclasses'] .= ' navbar-light';
    }
    // add option for menu shadow
    if (get_post_meta($options['page_id'], 'fs_shadow', true) == true) {
      $options['menuclasses'] .= ' shadow';
    } 
    error_log($options['menuclasses']);
    return $options;
  }
}
