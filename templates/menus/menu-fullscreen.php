<div class="side-navbar side-navbar-full navbar-wrapper navbar-fixed-top">
  <?php if( wpbs_get_option( 'wpbs_menu_search' ) == 'true') { ?>
    <form class="navbar-form" role="search" method="get" id="ssssearchform" action="<?php echo home_url( '/' ); ?>">
      <div class="<?php echo $options['form_group'] ?>">
        <input name="s" id="s" type="search" class="search-query form-control searchbox-input" autocomplete="off" placeholder="Enter a condition, symptom or term">
        <?php echo $options['form_icon'] ?>
        <button type="submit" class="fa-search fa searchbox-submit" value="Search"></button>

      </div>
    </form>
  <?php } ?>

  <div id="sidebar-wrapper" class="navbar navbar-inverse sidebar-nav" role="navigation">
    <?php wpbs_main_nav(); // Adjust using Menus in Wordpress Admin ?>
  </div>
</div>