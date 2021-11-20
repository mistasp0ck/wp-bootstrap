<?php
function wpbs_video_feed($atts){
global $wp_query;
  extract(shortcode_atts(array( 
    'posts_per_page' => '-1',
    'post_type' => 'video',
    'link' => '',
    'title' => '',
    'full_width' => true
  ), $atts));


$args = array(
  'posts_per_page' => $posts_per_page,
  'post_type' => $post_type,
  'orderby' => 'menu_order',
  );
ob_start();
// the query
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>
<div class="row section videos">
  <?php if ($atts['full_width'] == 'true') { ?>
  <div class="col-sm-12">
  <?php } else { ?>
  <div class="col-md-10 col-md-offset-1">
  <?php } ?>
  <?php if ($title != '') { ?>
  <h2><?php echo $title; ?></h2>
  <?php } ?>
  
  <?php 
  $i = 0; 
  $cols = 2;
  
  
  ?>
  <!-- the loop -->
  <div class="row col-fix">
  <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?> 
    <?php if(!($i % $cols) && $i > 0) {?>
  </div> <!--end .row .col-fix -->
  <div class="row col-fix">
    <?php } ?>
    <div class="col col-sm-6">
    <?php $url = esc_url( get_post_meta( get_the_ID(), 'video_embed', 1 ) ); ?>
      <?php if(has_post_thumbnail()) { ?>     
      <a href="<?php echo $url.'&rel=0'; ?>" class="video-box" data-lity><?php
        //If it has one, display the thumbnail
        the_post_thumbnail('video-thumbnail',array('class' => 'img-responsive'));
        if (get_post_meta( get_the_ID(), 'video_title', true )) {
          echo ('<span class="video-title">'.get_post_meta( get_the_ID(), 'video_title', true ).'</span>'); 
        }
      ?></a><?php } ?>
      <?php if (get_post_meta( get_the_ID(), 'video_desc', true )) {
        echo ('<p>'.substr(get_post_meta( get_the_ID(), 'video_desc', true ), 0,250).'</p>'); 
      } ?>
    </div>            
    <?php $i++; ?>
  <?php endwhile; ?>
   </div> <!--end .row .col-fix -->
  <!-- end of the loop -->
  <?php wp_reset_postdata(); ?>
  <?php if ($atts['link'] != ''){ ?>
    <div class="row">
      <div class="col-sm-12">
        <a class="btn btn-primary" href="<?php echo $link; ?>">View All Videos</a>
      </div>  
    </div>
  <?php } ?>  
  </div>
</div>
<?php else : ?>
  <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?> 

<?php
  return ob_get_clean();
}
add_shortcode('videos', 'wpbs_video_feed');