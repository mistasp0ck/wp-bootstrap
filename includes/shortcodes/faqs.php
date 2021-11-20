<?php
function wpbs_faqs($atts){
global $wp_query;
	extract(shortcode_atts(array(
		'posts_per_page' => '-1',
		'categories' => '',
		'button' => 'true',
		'button_url' => ''

	), $atts));


$args = array(
	'post_type' => 'faqs',
	'posts_per_page' => $posts_per_page,
	'orderby' => array ('menu_order'=> 'ASC', 'date' => 'ASC')
	);
if ($categories != ''){

	$args['faqs-category'] = $categories;	
}
// if ($orderby != ''){

// 	$args['orderby'] = $orderby;	
// }
// if ($order != ''){

// 	$args['order'] = $order;	
// }

ob_start();
// the query
$the_query = new WP_Query( $args ); ?>

<?php if ( $the_query->have_posts() ) : ?>
<div class="contaner section faqs">
	<h2 class="heading-large heading-green">FAQs</h2>
	<?php 
	$i = 0; 
	$cols = 2;
	
	
	?>
	<!-- the loop -->
	<div class="row faq-list">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>	
		<?php if(!($i % $cols) && $i > 0) {?>
	</div> <!--end .row .faq-list -->
	<div class="row faq-list">
		<?php } ?>
		<div class="col col-md-6">
			<h3><?php the_title(); ?></h3>
			<?php if (get_post_meta(get_the_ID(),'faq_answer', true)) : ?>
				<p><?php echo get_post_meta(get_the_ID(),'faq_answer', true); ?></p>
			<?php endif ; ?>

		</div>
						
		<?php $i++; ?>
	<?php endwhile; ?>
	 </div> <!--end .row .faq-list -->
	<!-- end of the loop -->
	<?php wp_reset_postdata(); ?>
	<?php if ($button == 'true' && $button_url != '' ) { ?> 
	<div class="col-sm-12" style="text-align:center">
		<a href="<?php echo $button_url; ?>" class="btn btn-primary btn-lg btn-blue-inv">View More FAQs</a>
	</div>	
	<?php } else {?>
	<div class="col-sm-12" style="text-align:center">
		<a href="<?php bloginfo('home'); ?>/faqs/" class="btn btn-primary btn-lg btn-blue-inv">View More FAQs</a>
	</div>
	<?php } ?>
</div>
<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>	

<?php
	return ob_get_clean();
}
add_shortcode('faqs', 'wpbs_faqs');