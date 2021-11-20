<?php 
    $page_id = $post->ID;
    $hide_title = false;
    $title = get_the_title();
    $desc = '';
    
    // Featured header and Revolution slider
    if ( is_front_page() && is_home() ) {
      // Default homepage
    } elseif ( is_front_page() ) {
      // static homepage
    } elseif ( is_home() ) {
      $posts_page = get_option( 'page_for_posts' ); 
      $page_id = get_post( $posts_page )->ID;
      $title   = get_post( $posts_page )->post_title;
      $desc = get_post( $posts_page )->post_content;
    } else {
      //everything else
    }

    if( get_post_meta($page_id, 'wpbs_revolution_slider', true) != 'disable' && get_post_meta($page_id, 'wpbs_revolution_slider', true) != ''){   

        $revolution_slider = get_post_meta($page_id, 'wpbs_revolution_slider', true);
        $revolution_slider = '[rev_slider alias="'.$revolution_slider.'"]'; 
        echo do_shortcode($revolution_slider);
        $hide_title = true;

    } elseif ( has_post_thumbnail($page_id)) {
        if (get_post_meta($page_id, 'wpbs_hero', true) == true) {

            if (get_post_meta($page_id, 'wpbs_featured_title', true)) {
                $title = get_post_meta($page_id, 'wpbs_featured_title', true);
            }
            $desc = get_post_meta($page_id, 'wpbs_featured_desc', true);
            $post_thumbnail_id = get_post_thumbnail_id($page_id);
            $featured_src = wp_get_attachment_image_src( $post_thumbnail_id, 'fs-featured-full' );
            $hide_title = true;   

            if ($align = get_option('wpbs_featured_align')) {
                $align = ' '.$align;
            } else if ($align = get_post_meta($page_id, 'wpbs_featured_align', true)) {
                $align = ' '.$align;
            } else {
                $align = '';
            }
            ?>
            </div><!-- end .container /--> 

            <div class="container-fluid featured-full" style="background-image: url('<?php echo $featured_src[0]; ?>'); background-repeat: no-repeat;   background-position: 0% 50%; background-size:cover;">

                <div class="container">
                    <div class="vertical-align-wrap featured-header<?php echo $align;?>">
                        <div class="vertical-align">
                            <div class="page-header"><h1><?php echo $title; ?></h1>
                                <?php if($desc != ''){ ?><p><?php echo $desc; ?></p><?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">

        <?php } ?>
<?php } ?>