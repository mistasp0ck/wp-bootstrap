<?php
function wpbs_recent_posts($atts){
global $wp_query;
	extract(shortcode_atts(array(	
		'posts_per_page' => '3',

	), $atts));


$args = array(
	'posts_per_page' => 3
	);
ob_start();
// the query
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>
<div id="news" class="col col-sm-12 col-feed clearfix" role="main">
	<?php 
	$i = 0; 
	$cols = 3;
	
	
	?>
	<!-- the loop -->
	<div class="row col-fix">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>	
		<?php if(!($i % $cols) && $i > 0) {?>
	</div> <!--end .row .col-fix -->
	<div class="row col-fix">
		<?php } ?>
		<div class="col col-sm-12 col-md-4">

			<?php if(has_post_thumbnail()) { ?>			
			<a href="<?php the_permalink(); ?>"><?php
				//If it has one, display the thumbnail
				the_post_thumbnail('crisp-thumb-event',array('class' => 'img-responsive'));
			?></a><?php } ?>
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<p><?php echo substr(wptexturize(get_the_excerpt()), 0,110).'&#8230;'; ?></p>
			<a class="btn btn-primary btn-lg" href="<?php the_permalink(); ?>" role="button">Read More</a>

		</div>
						
		<?php $i++; ?>
	<?php endwhile; ?>
	 </div> <!--end .row .col-fix -->
	<!-- end of the loop -->
	<?php wp_reset_postdata(); ?>
</div>
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>	

<?php
	return ob_get_clean();
}
add_shortcode('recent_posts', 'wpbs_recent_posts');