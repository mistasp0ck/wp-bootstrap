<?php
function wpbs_team($atts){
global $wp_query;
	extract(shortcode_atts(array(
		'bg' => 'false',
		'columns' => '3',	
		'posts_per_page' => '4',
		'button_vis' => 'false',
		'button_url' => '',
		'orderby' => 'last',
		'title' => '',		

	), $atts));

$args = array(
	'post_type' => 'team',
	'posts_per_page' => $posts_per_page
	);
if ($orderby == 'last') {
	$args['meta_key'] = 'team_last';
	$args['orderby'] = array ('menu_order'=> 'DESC', 'meta_value' => 'ASC');
}
elseif ($orderby == 'menu_order') {
	$args['orderby'] = 'menu_order';
}
elseif ($orderby == 'date') {
	$args['orderby'] = 'date';
}
ob_start();
// the query
$the_query = new WP_Query( $args ); ?>


<?php if ( $the_query->have_posts() ) : ?>
<div class="force-full-width-wrapper section meet-team">
<?php if ($bg == 'true') { ?>	
	<div class="force-full-width grey-bg"></div>
<? } else { ?>

<?php } ?>	
<?php if ($title != '') { ?>
	<h2 class="heading-med heading-blue"><?php echo $title ?></h2>
<?php } ?>
	<?php 
	$i = 0; 

	$colnum = 12 / $columns;
	$job_title = '';
	if (get_post_meta(get_the_ID(),'team_title', true)) {
		$job_title = get_post_meta(get_the_ID(),'team_title', true);
	}
	if (get_post_meta(get_the_ID(),'team_title', true)) {
		$bio = get_post_meta(get_the_ID(),'bio', true);
	}

	?>
	<!-- the loop -->
	<div class="row section team-list">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>	
		<?php if(!($i % $columns) && $i > 0) {?>
	</div> <!--end .row .faq-list -->
	<div class="row section team-list">
		<?php } ?>
		<div class="col col-sm-<?php echo $colnum; ?>">

		<?php if ( has_post_thumbnail() ) { ?>
		<?php $post_thumbnail_id = get_post_thumbnail_id(); ?>
		<?php $featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'team-thumb' ); ?>
		<?php } ?>

			<img src="<?php echo $featured_src[0]; ?>" class="aligncenter img-responsive" />

			<h3><?php the_title(); ?></h3>
			<?php if (get_post_meta(get_the_ID(),'team_title', true)) { ?>
			<h4><?php echo get_post_meta(get_the_ID(),'team_title', true); ?></h4>
			<?php } ?>

			<?php if (get_post_meta(get_the_ID(),'team_bio', true)) { ?>
			<p><?php echo get_post_meta(get_the_ID(),'team_bio', true); ?></p>
			<?php } ?>
		</div>
						
		<?php $i++; ?>
	<?php endwhile; ?>
	 </div> <!--end .row .faq-list -->
	<!-- end of the loop -->
	<?php wp_reset_postdata(); ?>
	<?php if ($button_vis == 'true' && $button_url != '') { ?>
		<div class="row" style="margin-bottom: 54px;">
			<div class="col-sm-12" style="text-align:center">
				<a href="<?php echo $button_url; ?>" class="btn btn-primary btn-lg btn-blue-inv" style="margin-top: 20px;">Meet The Whole Team</a>
			</div>
		</div>
	<?php } ?>	
</div>
<?php else : ?>
	<p><?php _e( 'Sorry, no team members found.' ); ?></p>
<?php endif; ?>	

<?php
	return ob_get_clean();
}
add_shortcode('team', 'wpbs_team');