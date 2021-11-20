<?php
function wpbs_snippet($atts){
	global $wp_query;
		extract(shortcode_atts(array(	
			'name' => ''
		), $atts));


	$args = array(
		'post_type' => 'snippet'
		);
	if ($name != ''){
		$args['name'] = $name;	
	}

	ob_start();
	// the query
	$the_query = new WP_Query( $args ); ?>

	<?php if ( $the_query->have_posts() ) : ?>
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	<?php else : ?>

	<?php endif; ?>	

	<?php
	return ob_get_clean();
}

add_shortcode('snippet', 'wpbs_snippet');