<?php
if( !function_exists( "hero_display" ) ) {  
	function hero_display() {
		global $post;
	    // Featured header and Revolution slider
	    $hide_title = 'false';
	    $title = get_the_title();
	    $desc = '';
	    $content = '';

		    if( get_post_meta($post->ID, 'wpbs_revolution_slider', true) != 'disable' && get_post_meta($post->ID, 'wpbs_revolution_slider', true) != ''){   

		        $revolution_slider = get_post_meta($post->ID, 'wpbs_revolution_slider', true);
		        $revolution_slider = '[rev_slider alias="'.$revolution_slider.'"]'; 
		        $content = do_shortcode($revolution_slider);
		        $hide_title = 'true';

		    } elseif ( has_post_thumbnail() ) {
		        if (get_post_meta($post->ID, 'wpbs_featured_title', true)) {
		            $title = get_post_meta($post->ID, 'wpbs_featured_title', true);
		        }
		        $desc = get_post_meta($post->ID, 'wpbs_featured_desc', true);
		        if($desc != ""){ 
		        	$desc = '<p>'.$desc.'</p>';
		        } 
		        $post_thumbnail_id = get_post_thumbnail_id();
		        $featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'fs-featured-full' );
		        $hide_title = 'true';     

				$content = '</div> 
				<!-- end .container /-->
				<div class="container-fluid featured-full" style="background-image: url('.$featured_src[0].'); background-repeat: no-repeat;   background-position: 0% 50%; background-size:cover;">

				    <div class="container">
				        <div class="vertical-align-wrap featured-header">
				            <div class="vertical-align">
				            <div class="page-header"><h1>'.$title.'</h1>
				            '.$desc.'</div>
				            </div>
				        </div>
				    </div>
				</div>
				<div class="container">	';
			}

		return $content;

		
	} 
}	

add_filter('wpbs_hook_hero', 'hero_display');


?>