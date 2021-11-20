<?php
/************* Shortcodes ********************/

$shortcodes = TEMPLATEPATH . "/includes/shortcodes/shortcodes.php";
if ( is_readable( $shortcodes ) ) require_once( $shortcodes );

$posts_carousel = TEMPLATEPATH . "/includes/shortcodes/posts-carousel.php";
if ( is_readable( $posts_carousel ) ) require_once( $posts_carousel );

// Add simple,repeatable snippets
$snippet = TEMPLATEPATH . "/includes/shortcodes/snippet.php";
if ( is_readable( $snippet ) ) require_once( $snippet );

$services = TEMPLATEPATH . "/includes/shortcodes/services.php";
if ( is_readable( $services ) ) require_once( $services );

$video = TEMPLATEPATH . "/includes/shortcodes/videos.php";
if ( is_readable( $video ) ) require_once( $video );

$social = TEMPLATEPATH . "/includes/shortcodes/social.php";
if ( is_readable( $social ) ) require_once( $social );

/************* Meta Boxes using CMB2 plugin ********************/
/**
 * @todo detect plugin before includes
 */

$validation = TEMPLATEPATH . "/includes/meta-boxes/validation.php";
if ( is_readable( $validation ) ) require_once( $validation );

$page = TEMPLATEPATH . "/includes/meta-boxes/page.php";
if ( is_readable( $page ) ) require_once( $page );

$team = TEMPLATEPATH . "/includes/meta-boxes/team.php";
if ( is_readable( $team ) ) require_once( $team );

$faqs = TEMPLATEPATH . "/includes/meta-boxes/faqs.php";
if ( is_readable( $faqs ) ) require_once( $faqs );

$services = TEMPLATEPATH . "/includes/meta-boxes/services.php";
if ( is_readable( $services ) ) require_once( $services );

$portfolio = TEMPLATEPATH . "/includes/meta-boxes/portfolio.php";
if ( is_readable( $portfolio ) ) require_once( $portfolio );

$video = TEMPLATEPATH . "/includes/meta-boxes/video.php";
if ( is_readable( $video ) ) require_once( $video );

/************* Theme Options ********************/

$options = TEMPLATEPATH . "/includes/theme-options/options-cmb.php";
if ( is_readable( $options ) ) require_once( $options );

/************* Theme Hooks ********************/

$hero = TEMPLATEPATH . "/includes/hooks/hero-display.php";
if ( is_readable( $hero ) ) require_once( $hero );

$pagetitle = TEMPLATEPATH . "/includes/hooks/title-display.php";
if ( is_readable( $pagetitle ) ) require_once( $pagetitle );

$pageoptions = TEMPLATEPATH . "/includes/hooks/page-options.php";
if ( is_readable( $pageoptions ) ) require_once( $pageoptions );

// add_action('vc_after_init_base', 'wpbs_change_vc_templates_dir'); 

// /************* Override VC shortcodes ********************/
// if ( ! function_exists( 'wpbs_change_vc_templates_dir' ) ) {
//   function wpbs_change_vc_templates_dir() {
//     $dir = get_template_directory() . '/includes/vc_custom_templates';
//     vc_set_shortcodes_templates_dir( $dir );
//   }
// }


