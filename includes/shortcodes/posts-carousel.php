<?php

function wpbs_posts_carousel($atts){
global $wp_query;
	extract(shortcode_atts(array(
		'bg' => 'false',
		'pages' => 'false',	
		'posts_per_page' => '7',
		'button' => 'true',
		'button_url' => '',
		'carousel' => 'true',
		'featured' => 'false',
		'orderby' => '',
		'columns' => '3',
		'headline' => '',
		'full_width' => 'true',
		'category_name' => '',
		//These settings modify the slick.js config
		'arrows' => 'true',
		'dots' => 'true',
		'infinite' => 'false'

	), $atts));

$config = array(
	'config' => array(
		'arrows' => $arrows,
		'dots' => $dots,
		'infinite' => $infinite
	)

);

wp_enqueue_script( 'slick-js', 
  get_template_directory_uri() . '/library/js/slick.js', 
  array('jquery'), 
  '1.1', false );

//after wp_enqueue_script
wp_localize_script( 'slick-js', 'slick', $config );

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
	'posts_per_page' => $posts_per_page,
	'category_name' => $category_name,
	'paged' => $paged
	);
ob_start();
wp_reset_postdata();
// the query
$the_query = new WP_Query( $args ); ?>


<?php if ( $the_query->have_posts() ) : ?>

	<?php 
	$i = -1;
	$colnum = 12 / $columns; 
	?>
	<!-- the loop -->
	<?php if ($carousel == 'true') { ?>
	<div class="carousel">
	  <div class="container-carousel">
    	<div class="multiple-items">
	<?php } else { ?>
	<div class="row section">
		<?php if ($carousel == 'true') { ?>
		<div class="col-sm-12">		
		<?php } else { ?>
		<div class="col-md-10 col-md-offset-1">	
		<?php } ?>
		<div class="row section daily-tips">
	<?php } ?>
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<?php if (($i < 0 && $featured == 'true')) : ?>
		<div class="col-sm-12 featured clearfix">
			<div class="inner-wrapper">
				<div class="col col-sm-6">
				<?php if ( has_post_thumbnail() ) { ?>
				<?php $post_thumbnail_id = get_post_thumbnail_id(); ?>
				<?php $featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'feat-lg' ); ?>
				<?php } ?>	
				<a href="<?php the_permalink(); ?>"><img src="<?php echo $featured_src[0]; ?>" class="alignnone img-responsive" /></a>
				</div>
				<div class="col col-sm-6 vertical-align-wrap">
					<div class="inner-content vertical-align">		
					<h4><?php the_title(); ?></h4>
					<p><?php echo substr(get_the_excerpt(), 0,72).'&#8230;'; ?></p>
					<a href="<?php the_permalink(); ?>" class="btn btn-green">Read More</a>
					</div>
				</div>
			</div>
		</div>
		<?php if ($headline !='' && $paged <= 1) { ?>
			<h2><?php echo $headline; ?></h2>
		<?php } ?>
		<?php 
		$i++;
		else : ?>	
		<?php if ($carousel == 'true') { ?>
			<div class="item">
		<?php } else { ?>
			<?php if(!($i % $columns) && $i > 0) {?>
			</div> <!--end .row .faq-list -->
			<div class="row section">
			<?php } ?>
			<div class="item col col-sm-<?php echo $colnum; ?>">
		<?php } ?>
		<div class="inner-wrapper">
		<?php if ( has_post_thumbnail() ) { ?>
		<?php $post_thumbnail_id = get_post_thumbnail_id(); ?>
		<?php $featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'carousel-thumbnail' ); ?>
		<?php } ?>

			<a href="<?php the_permalink(); ?>"><img src="<?php echo $featured_src[0]; ?>" class="alignnone img-responsive" /></a>
			<div class="inner-content">
			<h4><?php the_title(); ?></h4>
			<p><?php echo substr(get_the_excerpt(), 0,72).'&#8230;'; ?></p>
			<a href="<?php the_permalink(); ?>" class="btn btn-green">Read More</a>
			</div>

		</div>
		</div>				
		<?php $i++; 
		endif; ?>

	<?php endwhile; ?>
	<?php if ($carousel == 'true') { ?>
		</div>
	  </div>
    </div>
	<?php } else { ?>
	</div>
	</div>
</div>
	<?php } ?>
	<?php if ($pages == 'true') { ?> 
	<nav class="wp-prev-next">
		<ul class="pager">
		<?php if (get_previous_posts_link('', $the_query->max_num_pages)) { ?>
			<li class="previous"><?php previous_posts_link('Newer Entries', $the_query->max_num_pages) ?></li>
		<?php } ?>
		<?php if (get_next_posts_link('', $the_query->max_num_pages)) { ?>
			<li class="next"><?php next_posts_link('Older Entries', $the_query->max_num_pages) ?></li>
		<?php } ?>

		</ul>
	</nav>
	<?php } ?>
	<!-- end of the loop -->
	<?php wp_reset_postdata(); ?>

<?php else : ?>
	<p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
<?php endif; ?>	

<?php
	return ob_get_clean();
}
add_shortcode('posts_carousel', 'wpbs_posts_carousel');