<?php
function social_shortcode($atts){ 
ob_start();
  ?>
<ul class="social">
  <?php if (wpbs_get_option('wpbs_linkedin') != '') { ?>
    <li class="linkedin"><a href="<?php echo wpbs_get_option('wpbs_linkedin'); ?>" target="_blank"><i class="fab fa-linkedin-in" aria-hidden="true"></i></a></li>
  <?php } ?>
  <?php if (wpbs_get_option('wpbs_twitter') != '') { ?>
    <li class="twitter"><a href="<?php echo wpbs_get_option('wpbs_twitter'); ?>" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a></li>
  <?php } ?>
  <?php if (wpbs_get_option('wpbs_facebook') != '') { ?>
    <li class="facebook"><a href="<?php echo wpbs_get_option('wpbs_facebook'); ?>" target="_blank"><i class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
  <?php } ?>
  <?php if (wpbs_get_option('wpbs_instagram') != '') { ?>
    <li class="instagram"><a href="<?php echo wpbs_get_option('wpbs_instagram'); ?>" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a></li>
  <?php } ?>

  <?php if (wpbs_get_option('wpbs_youtube') != '') { ?>
    <li class="youtube"><a href="<?php echo wpbs_get_option('wpbs_youtube'); ?>" target="_blank"><i class="fab fa-youtube" aria-hidden="true"></i></a></li>
  <?php } ?>              
</ul>

<?php
  return ob_get_clean();
}
add_shortcode('social', 'social_shortcode');
