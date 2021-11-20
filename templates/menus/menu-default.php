<div id="nav-container" class="collapse navbar-collapse navbar-responsive-collapse">
  <?php wpbs_main_nav(); // Adjust using Menus in Wordpress Admin ?>

  <?php if( wpbs_get_option( 'wpbs_menu_search' ) == 'true') { ?>
    <!-- <div class="search-form"> -->
      <form class="<?php echo $options['form_class'] ?>" role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">

        <div class="<?php echo $options['form_group'] ?>">
          <input name="s" id="s" type="search" class="search-query form-control searchbox-input" autocomplete="off" placeholder="<?php _e('Search','wpbootstrap'); ?>">
          <?php echo $options['form_icon'] ?>
          <!-- <input type="submit" class="searchbox-submit" value="Search"> -->

        </div>
      </form>
  <?php } ?>
</div>