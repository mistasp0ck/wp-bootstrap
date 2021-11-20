<?php 
$options = wpbs_get_page_options();
$blog_info    = get_bloginfo( 'name' );

if ($options['menu_type'] === 'right-flyout-menu' || $options['menu_type'] === 'full-flyout-menu') {
  $sidebar = true;  
} else {
  $sidebar = false;
}
$header_class = '';
?>

<header role="banner">
    <?php error_log($options['menuclasses']); ?>
  <div class="navbar navbar-expand-md navbar-default<?php echo $options['menuclasses']; ?> <?php echo wpbs_get_option( 'wpbs_nav_hamburger' ) ?>" data-spy="<?php echo $options['affix']; ?>" data-offset-top="46">
    <div class="container">
    
      <div class="navbar-header">
        <?php if($sidebar === true) { ?> 
          <button type="button" class="hamburger is-closed animated fadeInRight" data-toggle="offcanvas">
            <span class="hamb-top"></span>
            <span class="hamb-middle"></span>
            <span class="hamb-bottom"></span>
            <span class="menu-text">Menu</span>
          </button>
        <?php } else { ?>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbar-responsive-collapse" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        <?php } ?>
        <?php get_template_part ( 'templates/menus/menu', 'branding' ) ?>
      </div>
      <?php if( $options['menu_type'] === 'right-flyout-menu') { ?>
        <?php get_template_part ( 'templates/menus/menu', 'sidebar' ) ?>
      <?php } else if ( $options['menu_type'] === 'full-flyout-menu'){ ?>
        <?php get_template_part ( 'templates/menus/menu', 'fullscreen' ) ?>
      <?php } else { ?>
        <?php get_template_part ( 'templates/menus/menu', 'default' ) ?>
      <?php } ?>
      

    </div> <!-- end .container -->
  </div> <!-- end .navbar -->

</header> <!-- end header -->