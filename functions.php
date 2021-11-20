<?php

// Parent Theme 
require_once get_template_directory() . '/includes/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'wp_bootstrap_register_required_plugins' );
if( !function_exists( "wp_bootstrap_register_required_plugins" ) ) {  
  function wp_bootstrap_register_required_plugins() {
    /*
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
      // Include plugins from the WordPress Plugin Repository.
      array(
        'name'      => 'CMB2',
        'slug'      => 'cmb2',
        'required'  => true,
      ),
      array(
        'name'  => 'WPBakery Page Builder', // The plugin name
        'slug'  => 'js_composer', // The plugin slug (typically the folder name)
        'source'  => get_template_directory() . '/pkg/js_composer.zip', // The plugin source
        'required'  => true, // If false, the plugin is only 'recommended' instead of required
        'version' => '6.2.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
        'force_activation'  => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
        'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      ),
      array(
        'name'  => 'FS Theme Extensions', // The plugin name
        'slug'  => 'wpbootstrap-theme-extensions', // The plugin slug (typically the folder name)
        'source'  => get_template_directory() . '/pkg/wpbootstrap-theme-extensions-master.zip', // The plugin source
        'required'  => true, // If false, the plugin is only 'recommended' instead of required
        'version' => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
        'force_activation'  => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
        'force_deactivation'  => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
      )
    );
    $config = array(
      'id'           => 'wpbootstrap-base',                 // Unique ID for hashing notices for multiple instances of TGMPA.
      'default_path' => '',                      // Default absolute path to bundled plugins.
      'menu'         => 'tgmpa-install-plugins', // Menu slug.
      'parent_slug'  => 'themes.php',            // Parent menu slug.
      'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
      'has_notices'  => true,                    // Show admin notices or not.
      'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
      'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
      'is_automatic' => false,                   // Automatically activate plugins after installation or not.
      'message'      => '',                      // Message to output right before the plugins table.
    );
    tgmpa( $plugins, $config );
  }
}

// Add Translation Option
load_theme_textdomain( 'wpbootstrap', TEMPLATEPATH.'/languages' );
$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) ) require_once( $locale_file );

/************* Include all Files from includes ********************/
if ( ! function_exists('wp_bootstrap_init_includes')) {
  function wp_bootstrap_init_includes() {
    $setup = TEMPLATEPATH . "/includes/theme_setup.php";
    if ( is_readable( $setup ) ) require_once( $setup );
  }
}
add_action( 'init', 'wp_bootstrap_init_includes', 20 );

add_action( 'admin_enqueue_scripts', 'wp_bootstrap_admin_media' );   

if ( ! function_exists( 'wp_bootstrap_admin_media' ) ) {
  function wp_bootstrap_admin_media() {
    global $post;

    wp_enqueue_script('admin-scripts', get_template_directory_uri() . '/library/dist/admin/js/admin-scripts.min.js', array('jquery'), '1.0' );
    wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/library/dist/admin/css/admin-styles.min.css' );

  }
}

// Clean up the WordPress Head
if( !function_exists( "wp_bootstrap_head_cleanup" ) ) {  
  function wp_bootstrap_head_cleanup() {
    // remove header links
    remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
    remove_action( 'wp_head', 'feed_links', 2 );                          // Post and Comment Feeds
    remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
    remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
    remove_action( 'wp_head', 'index_rel_link' );                         // index link
    remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
    remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
    remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
    remove_action( 'wp_head', 'wp_generator' );                           // WP version
  }
}
// Launch operation cleanup
add_action( 'init', 'wp_bootstrap_head_cleanup' );

// remove WP version from RSS
if( !function_exists( "wp_bootstrap_rss_version" ) ) {  
  function wp_bootstrap_rss_version() { return ''; }
}
add_filter( 'the_generator', 'wp_bootstrap_rss_version' );

// Remove the […] in a Read More link
if( !function_exists( "wp_bootstrap_excerpt_more" ) ) {  
  function wp_bootstrap_excerpt_more( $more ) {
    global $post;
    return '...  <a href="'. get_permalink($post->ID) . '" class="more-link" title="Read '.get_the_title($post->ID).'">Read more &raquo;</a>';
  }
}
add_filter('excerpt_more', 'wp_bootstrap_excerpt_more');

// Add WP 3+ Functions & Theme Support
if( !function_exists( "wp_bootstrap_theme_support" ) ) {  
  function wp_bootstrap_theme_support() {
    add_theme_support( 'post-thumbnails' );      // wp thumbnails (sizes handled in functions.php)
    set_post_thumbnail_size( 125, 125, true );   // default thumb size
    add_theme_support( 'custom-background' );  // wp custom background
    add_theme_support( 'automatic-feed-links' ); // rss

    // Add post format support - if these are not needed, comment them out
    add_theme_support( 'post-formats',      // post formats
      array( 
        'aside',   // title less blurb
        'gallery', // gallery of images
        'link',    // quick link to other site
        'image',   // an image
        'quote',   // a quick quote
        'status',  // a Facebook like status update
        'video',   // video 
        'audio',   // audio
        'chat'     // chat transcript 
      )
    );  

    add_theme_support( 'menus' );            // wp menus
    
    register_nav_menus(                      // wp3+ menus
      array( 
        'main_nav' => 'The Main Menu',   // main nav in header
        'footer_links' => 'Footer Links' // secondary nav in footer
      )
    );  
  }
}
// launching this stuff after theme setup
add_action( 'after_setup_theme','wp_bootstrap_theme_support' );

if( !function_exists( "wp_bootstrap_main_nav" ) ) {
  function wp_bootstrap_main_nav() {
    // Display the WordPress menu if available
    wp_nav_menu( 
      array( 
        'menu' => 'main_nav', /* menu name */
        'menu_class' => 'nav navbar-nav nav-link px-2 link-secondary',
        'menu_id' => 'navigation',
        'theme_location' => 'main_nav', /* where in the theme it's assigned */
        'container' => 'false', /* container class */
        'fallback_cb' => 'wp_bootstrap_main_nav_fallback', /* menu fallback */
        'walker' => new Bootstrap_walker()
      )
    );
  }
}
if( !function_exists( "wp_bootstrap_footer_links" ) ) { 
  function wp_bootstrap_footer_links() { 
    // Display the WordPress menu if available
    wp_nav_menu(
      array(
        'menu' => 'footer_links', /* menu name */
        'theme_location' => 'footer_links', /* where in the theme it's assigned */
        'container_class' => 'footer-links clearfix', /* container class */
        'fallback_cb' => 'wp_bootstrap_footer_links_fallback' /* menu fallback */
      )
    );
  }
}
// this is the fallback for header menu
if( !function_exists( "wp_bootstrap_main_nav_fallback" ) ) { 
  function wp_bootstrap_main_nav_fallback() { 
    /* you can put a default here if you like */ 
  }
}

// this is the fallback for footer menu
if( !function_exists( "wp_bootstrap_footer_links" ) ) { 
  function wp_bootstrap_footer_links() { 
    /* you can put a default here if you like */ 
  }
}

// Admin Functions (commented out by default)
// require_once('library/admin.php');         // custom admin functions

// Custom Backend Footer
// add_filter('admin_footer_text', 'wp_bootstrap_custom_admin_footer');
function wp_bootstrap_custom_admin_footer() {
	echo '<span id="footer-thankyou">Developed by <a href="http://tonystaffiero.com" target="_blank">Tony Staffiero</a></span>';
}

// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'wpbootstrap-featured-full', '', 250, true );
add_image_size( 'wpbootstrap-featured', 780, 300, true );
add_image_size( 'wpbootstrap-featured-home', 970, 311, true);
add_image_size( 'wpbootstrap-featured-carousel', 900, 600, true);

/* 
to add more sizes, simply copy a line from above 
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image, 
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
if( !function_exists( "wp_bootstrap_register_sidebars" ) ) {  
  function wp_bootstrap_register_sidebars() {
    register_sidebar(array(
    	'id' => 'sidebar1',
    	'name' => 'Main Sidebar',
    	'description' => 'Used on every page BUT the homepage page template.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
      
    register_sidebar(array(
    	'id' => 'sidebar2',
    	'name' => 'Homepage Sidebar',
    	'description' => 'Used only on the homepage page template.',
    	'before_widget' => '<div id="%1$s" class="widget %2$s">',
    	'after_widget' => '</div>',
    	'before_title' => '<h4 class="widgettitle">',
    	'after_title' => '</h4>',
    ));
      
    register_sidebar(array(
      'id' => 'footer1',
      'name' => 'Footer 1',
      'before_widget' => '<div id="%1$s" class="widget col-sm-4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));

    register_sidebar(array(
      'id' => 'footer2',
      'name' => 'Footer 2',
      'before_widget' => '<div id="%1$s" class="widget col-sm-4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));

    register_sidebar(array(
      'id' => 'footer3',
      'name' => 'Footer 3',
      'before_widget' => '<div id="%1$s" class="widget col-sm-4 %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h4 class="widgettitle">',
      'after_title' => '</h4>',
    ));
      
      
    /* 
    to add more sidebars or widgetized areas, just copy
    and edit the above sidebar code. In order to call 
    your new sidebar just use the following code:
    
    Just change the name to whatever your new
    sidebar's id is, for example:
    
    To call the sidebar in your template, you can just copy
    the sidebar.php file and rename it to your sidebar's name.
    So using the above example, it would be:
    sidebar-sidebar2.php
    
    */
  } // don't remove this bracket!
}
add_action( 'widgets_init', 'wp_bootstrap_register_sidebars' );

/**
 * Check whether we are on this page or a sub page
 *
 * @param int $pid Page ID to check against.
 * @return bool True if we are on this page or a sub page of this page.
 */
function page_is_tree( $pid ) {      // $pid = The ID of the page we're looking for pages underneath
    $post = get_post();               // load details about this page
 
    $is_tree = false;
    if ( is_page( $pid ) ) {
        $is_tree = true;            // we're at the page or at a sub page
    }
 
    $anc = get_post_ancestors( $post->ID );
    foreach ( $anc as $ancestor ) {
        if ( is_page() && $ancestor == $pid ) {
            $is_tree = true;
        }
    }
    return $is_tree;  // we arn't at the page, and the page is not an ancestor
}
// Fix for Shortcodes in Search Results using Relevanssi
add_filter('relevanssi_pre_excerpt_content', 'wp_bootstrap_trim_vc_shortcodes');
function wp_bootstrap_trim_vc_shortcodes($content) {
    $content = preg_replace('/\[\/?vc.*?\]/', '', $content);
    $content = preg_replace('/\[\/?mk.*?\]/', '', $content);
    return $content;
}
// Callback for CMB2
function service_page_callback(){
  $args = array(
      'post_type' => 'services',
      'posts_per_page' => -1
  );

  $posts = get_posts( $args );
    if ( $posts ) {
      $services = array();
        foreach ( $posts as $post ) {
          $services[$post->ID] = $post->post_title; 

        }

      return $services;

    } else {

      return false;

    } 
}

/************* COMMENT LAYOUT *********************/

if( !function_exists( "wp_bootstrap_comments" ) ) {  
  function wp_bootstrap_comments($comment, $args, $depth) {
     $GLOBALS['comment'] = $comment; ?>
  	<li <?php comment_class(); ?>>
  		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
  			<div class="comment-author vcard clearfix">
  				<div class="avatar col-sm-3">
  					<?php echo get_avatar( $comment, $size='75' ); ?>
  				</div>
  				<div class="col-sm-9 comment-text">
  					<?php printf('<h4>%s</h4>', get_comment_author_link()) ?>
  					<?php edit_comment_link(__('Edit','wpbootstrap'),'<span class="edit-comment btn btn-sm btn-info"><i class="glyphicon-white glyphicon-pencil"></i>','</span>') ?>
                      
                      <?php if ($comment->comment_approved == '0') : ?>
         					<div class="alert-message success">
            				<p><?php _e('Your comment is awaiting moderation.','wpbootstrap') ?></p>
            				</div>
  					<?php endif; ?>
                      
                      <?php comment_text() ?>
                      
                      <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time('F jS, Y'); ?> </a></time>
                      
  					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
                  </div>
  			</div>
  		</article>
  <?php
  } // don't remove this bracket!
}
if( !function_exists( "get_wp_bootstrap_comment_form" ) ) {  
  function get_wp_bootstrap_comment_form () {

    $args = array(
      'id_form'           => 'commentform',
      'class_form'      => 'comment-form',
      'id_submit'         => 'submit',
      'class_submit'      => 'submit',
      'name_submit'       => 'submit',
      'title_reply'       => __( 'Leave a Reply' ),
      'title_reply_to'    => __( 'Leave a Reply to %s' ),
      'cancel_reply_link' => __( 'Cancel Reply' ),
      'label_submit'      => __( 'Post Comment' ),
      'format'            => 'xhtml',

      'comment_field' =>  '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) .
        '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true">' .
        '</textarea></p>',

      'must_log_in' => '<p class="must-log-in">' .
        sprintf(
          __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
          wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
        ) . '</p>',

      'logged_in_as' => '<p class="logged-in-as">' .
        sprintf(
        __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
          admin_url( 'profile.php' ),
          $user_identity,
          wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
        ) . '</p>',

      'comment_notes_before' => '<p class="comment-notes">' .
        __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) .
        '</p>',

      'comment_notes_after' => '<p class="form-allowed-tags">' .
        sprintf(
          __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ),
          ' <code>' . allowed_tags() . '</code>'
        ) . '</p>',

      'fields' => apply_filters( 'comment_form_default_fields', $fields ),
    );

    return $args;

  }
}

if( !function_exists( "filter_comment_form_submit_button" ) ) { 
  // define the comment_form_submit_button callback
  function filter_comment_form_submit_button( $submit_button, $args ) {
      // make filter magic happen here...
      $submit_before = '<div class="form-group">';
      $submit_button = '<input name="submit" type="submit" id="submit" class="submit btn-primary btn" value="Post Comment">';
      $submit_after = '</div>';
      return $submit_before . $submit_button . $submit_after;
  }
}
 
// add the filter
add_filter( 'comment_form_submit_button', 'filter_comment_form_submit_button', 10, 2 );

// Display trackbacks/pings callback function
if( !function_exists( "list_pings" ) ) {  
  function list_pings($comment, $args, $depth) {
         $GLOBALS['comment'] = $comment;
  ?>
          <li id="comment-<?php comment_ID(); ?>"><i class="icon icon-share-alt"></i>&nbsp;<?php comment_author_link(); ?>
  <?php 

  }
}

/************* SEARCH FORM LAYOUT *****************/

/****************** password protected post form *****/

add_filter( 'the_password_form', 'wp_bootstrap_custom_password_form' );

if( !function_exists( "wp_bootstrap_custom_password_form" ) ) { 
  function wp_bootstrap_custom_password_form() {
  	global $post;
  	$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
  	$o = '<div class="clearfix"><form class="protected-post-form" action="' . get_option('siteurl') . '/wp-login.php?action=postpass" method="post">
  	' . '<p>' . __( "This post is password protected. To view it please enter your password below:" ,'wpbootstrap') . '</p>' . '
  	<label for="' . $label . '">' . __( "Password:" ,'wpbootstrap') . ' </label><div class="input-append"><input name="post_password" id="' . $label . '" type="password" size="20" /><input type="submit" name="Submit" class="btn btn-primary" value="' . esc_attr__( "Submit",'wpbootstrap' ) . '" /></div>
  	</form></div>
  	';
  	return $o;
  }
}

/*********** update standard wp tag cloud widget so it looks better ************/

add_filter( 'widget_tag_cloud_args', 'wp_bootstrap_my_widget_tag_cloud_args' );

if( !function_exists( "wp_bootstrap_my_widget_tag_cloud_args" ) ) { 
  function wp_bootstrap_my_widget_tag_cloud_args( $args ) {
  	$args['number'] = 20; // show less tags
  	$args['largest'] = 9.75; // make largest and smallest the same - i don't like the varying font-size look
  	$args['smallest'] = 9.75;
  	$args['unit'] = 'px';
  	return $args;
  }
}
// filter tag clould output so that it can be styled by CSS
if( !function_exists( "wp_bootstrap_add_tag_class" ) ) { 
  function wp_bootstrap_add_tag_class( $taglinks ) {
      $tags = explode('</a>', $taglinks);
      $regex = "#(.*tag-link[-])(.*)(' title.*)#e";

      foreach( $tags as $tag ) {
      	$tagn[] = preg_replace($regex, "('$1$2 label tag-'.get_tag($2)->slug.'$3')", $tag );
      }

      $taglinks = implode('</a>', $tagn);

      return $taglinks;
  }
}

add_action( 'wp_tag_cloud', 'wp_bootstrap_add_tag_class' );

add_filter( 'wp_tag_cloud','wp_bootstrap_wp_tag_cloud_filter', 10, 2) ;

if( !function_exists( "wp_bootstrap_wp_tag_cloud_filter" ) ) { 
  function wp_bootstrap_wp_tag_cloud_filter( $return, $args )
  {
    return '<div id="tag-cloud">' . $return . '</div>';
  }
}

// Enable shortcodes in widgets
add_filter( 'widget_text', 'do_shortcode' );

// Disable jump in 'read more' link
if( !function_exists( "wp_bootstrap_remove_more_jump_link" ) ) { 
  function wp_bootstrap_remove_more_jump_link( $link ) {
  	$offset = strpos($link, '#more-');
  	if ( $offset ) {
  		$end = strpos( $link, '"',$offset );
  	}
  	if ( $end ) {
  		$link = substr_replace( $link, '', $offset, $end-$offset );
  	}
  	return $link;
  }
}
add_filter( 'the_content_more_link', 'wp_bootstrap_remove_more_jump_link' );

// Add Posttypes
add_action( 'after_setup_theme', 'create_posttype' ); 

if( !function_exists( "create_posttype" ) ) { 
  function create_posttype() {

      $labels = array(
      'name'               => _x( 'Snippets', 'post type general name', 'metro_health' ),
      'singular_name'      => _x( 'Snippet', 'post type singular name', 'metro_health' ),
      'menu_name'          => _x( 'Snippets', 'admin menu', 'metro_health' ),
      'name_admin_bar'     => _x( 'Snippets', 'add new on admin bar', 'metro_health' ),
      'add_new'            => _x( 'Add New', 'Member', 'metro_health' ),
      'add_new_item'       => __( 'Add New Snippet', 'metro_health' ),
      'new_item'           => __( 'New Snippet', 'metro_health' ),
      'edit_item'          => __( 'Edit Snippet', 'metro_health' ),
      'view_item'          => __( 'View Snippet', 'metro_health' ),
      'all_items'          => __( 'All Snippets', 'metro_health' ),
      'search_items'       => __( 'Search Snippets', 'metro_health' ),
      'parent_item_colon'  => __( 'Parent Snippets:', 'metro_health' ),
      'not_found'          => __( 'No Snippets found.', 'metro_health' ),
      'not_found_in_trash' => __( 'No Snippets found in Trash.', 'metro_health' )
    );

    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'vidant' ),
      'public'             => true,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'menu_position'       => 5,
      'menu_icon'          => 'dashicons-clipboard', 
      // 'show_in_menu'       => true,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => false,    
      'query_var'          => true,
      'capability_type'    => 'page',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'editor' )
    );

    register_post_type( 'snippet', $args ); 

    $labels = array(
      'name'               => _x( 'Videos', 'post type general name', 'fsbase' ),
      'singular_name'      => _x( 'Videos', 'post type singular name', 'fsbase' ),
      'menu_name'          => _x( 'Videos', 'admin menu', 'fsbase' ),
      'name_admin_bar'     => _x( 'Videos', 'add new on admin bar', 'fsbase' ),
      'add_new'            => _x( 'Add New', 'Video', 'fsbase' ),
      'add_new_item'       => __( 'Add New Video', 'fsbase' ),
      'new_item'           => __( 'New Video', 'fsbase' ),
      'edit_item'          => __( 'Edit Video', 'fsbase' ),
      'view_item'          => __( 'View Video', 'fsbase' ),
      'all_items'          => __( 'All Videos', 'fsbase' ),
      'search_items'       => __( 'Search Videos', 'fsbase' ),
      'parent_item_colon'  => __( 'Parent Videos:', 'fsbase' ),
      'not_found'          => __( 'No Videos found.', 'fsbase' ),
      'not_found_in_trash' => __( 'No Videos found in Trash.', 'fsbase' )
    );

    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'fsbase' ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'menu_position'       => 5,
      'menu_icon'          => 'dashicons-format-video', 
      'show_in_menu'       => true,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,    
      'query_var'          => true,
      'capability_type'    => 'page',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'thumbnail', 'page-attributes', 'excerpt', 'editor' )
    );

    register_post_type( 'video', $args ); 

    $labels = array(
      'name'               => _x( 'Team', 'post type general name', 'fsbase' ),
      'singular_name'      => _x( 'Team', 'post type singular name', 'fsbase' ),
      'menu_name'          => _x( 'Team', 'admin menu', 'fsbase' ),
      'name_admin_bar'     => _x( 'Team', 'add new on admin bar', 'fsbase' ),
      'add_new'            => _x( 'Add New', 'Member', 'fsbase' ),
      'add_new_item'       => __( 'Add New Member', 'fsbase' ),
      'new_item'           => __( 'New Member', 'fsbase' ),
      'edit_item'          => __( 'Edit Member', 'fsbase' ),
      'view_item'          => __( 'View Member', 'fsbase' ),
      'all_items'          => __( 'All Members', 'fsbase' ),
      'search_items'       => __( 'Search Members', 'fsbase' ),
      'parent_item_colon'  => __( 'Parent Members:', 'fsbase' ),
      'not_found'          => __( 'No Members found.', 'fsbase' ),
      'not_found_in_trash' => __( 'No Members found in Trash.', 'fsbase' )
    );

    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'fsbase' ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'menu_position'       => 5,
      'menu_icon'          => 'dashicons-groups', 
      'show_in_menu'       => true,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,    
      'query_var'          => true,
      'capability_type'    => 'page',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'thumbnail', 'page-attributes' )
    );

    register_post_type( 'team', $args );  

    register_taxonomy(
      'team-category',
      'team',
      array(
        'label' => __( 'Team Categories' ),
        'rewrite' => array( 'slug' => 'team-category' ),
        'hierarchical' => true,
        'show_admin_column' => true
      )
    );

    $labels = array(
      'name'              => _x( 'Service Categories', 'taxonomy general name' ),
      'singular_name'     => _x( 'Service Category', 'taxonomy singular name' ),
      'menu_name'         => __( 'Categories' ),
    );


      register_taxonomy(
          'services-category',
          'services',
          array(
            'labels' => $labels,
            'rewrite' => array( 'slug' => 'services-category' ),
            'hierarchical' => true,
            'show_admin_column' => true
          )
      ); 


      $labels = array(
      'name'               => _x( 'Services', 'post type general name', 'fsbase' ),
      'singular_name'      => _x( 'Services', 'post type singular name', 'fsbase' ),
      'menu_name'          => _x( 'Services', 'admin menu', 'fsbase' ),
      'name_admin_bar'     => _x( 'Services', 'add new on admin bar', 'fsbase' ),
      'add_new'            => _x( 'Add New', 'Service', 'fsbase' ),
      'add_new_item'       => __( 'Add New Service', 'fsbase' ),
      'new_item'           => __( 'New Service', 'fsbase' ),
      'edit_item'          => __( 'Edit Service', 'fsbase' ),
      'view_item'          => __( 'View Service', 'fsbase' ),
      'all_items'          => __( 'All Services', 'fsbase' ),
      'search_items'       => __( 'Search Services', 'fsbase' ),
      'parent_item_colon'  => __( 'Parent Services:', 'fsbase' ),
      'not_found'          => __( 'No Services found.', 'fsbase' ),
      'not_found_in_trash' => __( 'No Services found in Trash.', 'fsbase' )
    );

    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'fsbase' ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'menu_position'       => 5,
      'menu_icon'          => 'dashicons-admin-multisite', 
      'show_in_menu'       => true,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,    
      'query_var'          => true,
      'capability_type'    => 'page',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'thumbnail', 'page-attributes', 'excerpt', 'editor' )
    );

    register_post_type( 'services', $args );  

    $labels = array(
      'name'                => _x( 'Portfolio', 'Post Type General Name', 'text_case_studies' ),
      'singular_name'       => _x( 'Portfolio', 'Post Type Singular Name', 'text_case_studies' ),
      'menu_name'           => __( 'Portfolio', 'text_case_studies' ),
      'name_admin_bar'      => __( 'Portfolio', 'text_case_studies' ),
      'parent_item_colon'   => __( 'Parent Item:', 'text_case_studies' ),
      'all_items'           => __( 'All Items', 'text_case_studies' ),
      'add_new_item'        => __( 'Add New Item', 'text_case_studies' ),
      'add_new'             => __( 'Add New', 'text_case_studies' ),
      'new_item'            => __( 'New Item', 'text_case_studies' ),
      'edit_item'           => __( 'Edit Item', 'text_case_studies' ),
      'update_item'         => __( 'Update Item', 'text_case_studies' ),
      'view_item'           => __( 'View Item', 'text_case_studies' ),
      'search_items'        => __( 'Search Item', 'text_case_studies' ),
      'not_found'           => __( 'Not found', 'text_case_studies' ),
      'not_found_in_trash'  => __( 'Not found in Trash', 'text_case_studies' ),
    );
    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'fsbase' ),
      'public'             => true,
      'publicly_queryable' => true,
      'show_ui'            => true,
      'menu_position'       => 5,
      'menu_icon'          => 'dashicons-images-alt2', 
      'show_in_menu'       => true,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,    
      'query_var'          => true,
      'rewrite'            => array( 'slug' => 'portfolio' ),
      'capability_type'    => 'page',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title', 'thumbnail', 'page-attributes','categories' )
      
    );
    register_post_type( 'portfolio', $args );

    $labels = array(
      'name'              => _x( 'Portfolio Categories', 'taxonomy general name' ),
      'singular_name'     => _x( 'Portfolio Category', 'taxonomy singular name' ),
      'menu_name'         => __( 'Categories' ),
    );

    register_taxonomy(
      'portfolio-category',
      'commercial',
      array(
        'labels' => $labels,
        'rewrite' => array( 'slug' => 'portfolio-category' ),
        'hierarchical' => true,
      )
    );

    $labels = array(
      'name'               => _x( 'Faqs', 'post type general name', 'metro_health' ),
      'singular_name'      => _x( 'Question', 'post type singular name', 'metro_health' ),
      'menu_name'          => _x( 'Faqs', 'admin menu', 'metro_health' ),
      'name_admin_bar'     => _x( 'Faqs', 'add new on admin bar', 'metro_health' ),
      'add_new'            => _x( 'Add New', 'Question', 'metro_health' ),
      'add_new_item'       => __( 'Add New Question', 'metro_health' ),
      'new_item'           => __( 'New Question', 'metro_health' ),
      'edit_item'          => __( 'Edit Question', 'metro_health' ),
      'view_item'          => __( 'View Question', 'metro_health' ),
      'all_items'          => __( 'All Faqs', 'metro_health' ),
      'search_items'       => __( 'Search Faqs', 'metro_health' ),
      'parent_item_colon'  => __( 'Parent Faqs:', 'metro_health' ),
      'not_found'          => __( 'No Faqs found.', 'metro_health' ),
      'not_found_in_trash' => __( 'No Faqs found in Trash.', 'metro_health' )
    );

    $args = array(
      'labels'             => $labels,
      'description'        => __( 'Description.', 'metro_health' ),
      'public'             => false,
      'publicly_queryable' => false,
      'show_ui'            => true,
      'menu_position'       => 5,
      'menu_icon'          => 'dashicons-format-status', 
      'show_in_menu'       => true,
      'show_in_admin_bar'   => true,
      'show_in_nav_menus'   => true,    
      'query_var'          => true,
      'capability_type'    => 'page',
      'has_archive'        => false,
      'hierarchical'       => false,
      'menu_position'      => null,
      'supports'           => array( 'title','page-attributes','category' )
    );

      register_taxonomy(
      'faqs-category',
      'faqs',
      array(
        'label' => __( 'Categories' ),
        'rewrite' => array( 'slug' => 'faqs-category' ),
        'show_admin_column' => true,
        'hierarchical' => true,
      )
    );

    register_post_type( 'faqs', $args );    
  }  
}


// Add thumbnail class to thumbnail links
if( !function_exists( "wp_bootstrap_add_class_attachment_link" ) ) { 
  function wp_bootstrap_add_class_attachment_link( $html ) {
      $postid = get_the_ID();
      $html = str_replace( '<a','<a class="thumbnail"',$html );
      return $html;
  }
}
add_filter( 'wp_get_attachment_link', 'wp_bootstrap_add_class_attachment_link', 10, 1 );

// Add lead class to first paragraph
if( !function_exists( "wp_bootstrap_first_paragraph" ) ) { 
  function wp_bootstrap_first_paragraph( $content ){
      global $post;

      // if we're on the homepage, don't add the lead class to the first paragraph of text
      if( is_page_template( 'page-homepage.php' ) )
          return $content;
      else
          return preg_replace('/<p([^>]+)?>/', '<p$1 class="lead">', $content, 1);
  }
}
// add_filter( 'the_content', 'wp_bootstrap_first_paragraph' );

// Menu output mods
class Bootstrap_walker extends Walker_Nav_Menu{

  function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

    if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
      $t = '';
      $n = '';
    } else {
      $t = "\t";
      $n = "\n";
    }
    $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

    $classes = empty( $item->classes ) ? array() : (array) $item->classes;
    $classes[] = 'nav-item menu-item-' . $item->ID;

    if ( $args->walker->has_children ) {
      $classes[] = 'dropdown';
    }

    $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
    $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

    $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth );
    $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

    $output .= $indent . '<li' . $id . $class_names .'>';

    $atts = array();
    $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
    $atts['target'] = ! empty( $item->target )     ? $item->target     : '';
    $atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';
    $atts['href']   = ! empty( $item->url )        ? $item->url        : '';

    // error_log(print_r($args,true));  

    $args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );


    // if the item has children add these two attributes to the anchor tag
    if ( $args->walker->has_children ) {
      // error_log('dropdown found!');
      $atts['data-bs-toggle'] = 'dropdown';
      $atts['class'] = 'dropdown-toggle nav-link px-2';
    } else {
      $atts['class'] = 'nav-link px-2';
    }

    $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

    $attributes = '';
    foreach ( $atts as $attr => $value ) {
      if ( ! empty( $value ) ) {
        $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
        $attributes .= ' ' . $attr . '="' . $value . '"';
        // error_log($attributes);
      }
    }
    // add new bs5 classes to menu
    // $attributes .= ' ' . $attr . '="' . $value . '"';
    // error_log(print_r($attributes,true));

    /** This filter is documented in wp-includes/post-template.php */
    $title = apply_filters( 'the_title', $item->title, $item->ID );
    $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before . $title . $args->link_after;
    if ( $args->walker->has_children ) {
      $item_output .= '<div class="caret icon-chev-down"></div>';
    }
    $item_output .= '</a>';
    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
  }
}

add_editor_style('editor-style.css');

add_filter('nav_menu_submenu_css_class', 'wp_bootstrap_nav_menu_submenu_css_class',10,3);

if( !function_exists( "wp_bootstrap_nav_menu_submenu_css_class" ) ) { 
  function wp_bootstrap_nav_menu_submenu_css_class($classes, $args, $depth) {
    array_push($classes, 'dropdown-menu shadow');
    return $classes;
  }
}

if( !function_exists( "wp_bootstrap_add_active_class" ) ) { 
  function wp_bootstrap_add_active_class($classes, $item) {
  	if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
      $classes[] = "active";
  	}
    
    return $classes;
  }
}

// Add Twitter Bootstrap's standard 'active' class name to the active nav link item
add_filter('nav_menu_css_class', 'wp_bootstrap_add_active_class', 10, 2 );

// enqueue styles
if( !function_exists("wp_bootstrap_theme_styles") ) {  
    function wp_bootstrap_theme_styles() { 

      wp_enqueue_style('lightbox', get_template_directory_uri() . '/bower_components/lity/dist/lity.min.css', '1.6.5');

      // This is the compiled css file from SASS - this means you compile the SASS file locally and put it in the appropriate directory if you want to make any changes to the master bootstrap.css.

      wp_register_style( 'wpbootstrap-style', get_template_directory_uri() . '/library/dist/css/styles.14e7293f.min.css', array(), '1.0', 'all' );

      wp_enqueue_style( 'wpbootstrap-style' );

      // // For child themes
      // wp_register_style( 'wpbootstrap-style', get_stylesheet_directory_uri() . '/style.css', array(), '1.0', 'all' );
      // wp_enqueue_style( 'wpbootstrap-style' );
    }
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_theme_styles' );

// enqueue javascript
if( !function_exists( "wp_bootstrap_theme_js" ) ) {  
  function wp_bootstrap_theme_js(){

    if ( !is_admin() ){
      if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1) ) 
        wp_enqueue_script( 'comment-reply' );
    }

    // This is the full Bootstrap js distribution file. If you only use a few components that require the js files consider loading them individually instead
    // wp_register_script( 'bootstrap', 
    //   get_template_directory_uri() . '/bower_components/bootstrap-sass/assets/javascript/bootstrap.js', 
    //   array('jquery'), 
    //   '1.2' );
    wp_enqueue_script('lightbox', get_template_directory_uri() . '/bower_components/lity/dist/lity.min.js', array('jquery'), '1.6.5', true);

    // wp_enqueue_script('fancybox', get_stylesheet_directory_uri() . '/library/js/jquery.fancybox.min.js', '3.5.7'); 

    wp_register_script( 'wpbootstrap-js', 
      get_template_directory_uri() . '/library/dist/js/scripts.33821fbe.min.js',
      array('jquery'), 
      '1.2' );
  
    wp_register_script( 'modernizr', 
      get_template_directory_uri() . '/bower_components/modernizer/modernizr.js', 
      array('jquery'), 
      '1.2' );
    // **** Uncomment if using grunticon ****
    // wp_register_script( 'grunticon-loader', 
    //   get_template_directory_uri() . '/library/dist/img/grunticon.loader.js', '1.2' );  

    // wp_enqueue_script( 'grunticon-loader' );    

    wp_enqueue_script( 'wpbootstrap-js' );

    wp_localize_script( 'wpbootstrap-js', 'wp_bootstrap_vars', array(
          'wp_bootstrap_nonce' => wp_create_nonce( 'wp_bootstrap_nonce' ), // Create nonce which we later will use to verify AJAX request
          'wp_bootstrap_ajax_url' => admin_url( 'admin-ajax.php' ),

        )
    );   

    $variables_array = array( 
      'templateUrl' => get_stylesheet_directory_uri(),
      'logos' => wp_bootstrap_logo_options()
    );
    //after wp_enqueue_script
    wp_localize_script( 'wpbootstrap-js', 'url', $variables_array );

    wp_enqueue_script( 'modernizr' );

  }
}
add_action( 'wp_enqueue_scripts', 'wp_bootstrap_theme_js' );


if( !function_exists("wp_bootstrap_logo_options") ) {  
  function wp_bootstrap_logo_options() { 
    $options = array ();

    if (wpbs_get_option( 'wp_bootstrap_logo_light' )) {
      $options['light'] = wpbs_get_option( 'wp_bootstrap_logo_light' );
    }
    if (wpbs_get_option( 'wp_bootstrap_logo_dark' )) {
      $options['dark'] = wpbs_get_option( 'wp_bootstrap_logo_dark' );
    }
    if (wpbs_get_option( 'wp_bootstrap_logo_trans' )) {
      $options['trans'] = wpbs_get_option( 'wp_bootstrap_logo_trans' );
    }
    return $options;
  }

}

// Get <head> <title> to behave like other themes
if( !function_exists( "wp_bootstrap_wp_title" ) ) { 
  function wp_bootstrap_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() ) {
      return $title;
    }

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
      $title = "$title $sep $site_description";
    }

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 ) {
      $title = "$title $sep " . sprintf( __( 'Page %s', 'wpbootstrap' ), max( $paged, $page ) );
    }

    return $title;
  }
}
add_filter( 'wp_title', 'wp_bootstrap_wp_title', 10, 2 );

// Related Posts Function (call using wp_bootstrap_related_posts(); )
if( !function_exists( "wp_bootstrap_related_posts" ) ) { 
  function wp_bootstrap_related_posts() {
    echo '<ul id="bones-related-posts">';
    global $post;
    $tags = wp_get_post_tags($post->ID);
    if($tags) {
      foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
          $args = array(
            'tag' => $tag_arr,
            'numberposts' => 5, /* you can change this to show more */
            'post__not_in' => array($post->ID)
        );
          $related_posts = get_posts($args);
          if($related_posts) {
            foreach ($related_posts as $post) : setup_postdata($post); ?>
                <li class="related_post"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></li>
            <?php endforeach; } 
        else { ?>
              <li class="no_related_post">No Related Posts Yet!</li>
      <?php }
    }
    wp_reset_query();
    echo '</ul>';
  }
}
if( !function_exists( "wp_bootstrap_page_navi" ) ) { 
  // Numeric Page Navi (built into the theme by default)
  function wp_bootstrap_page_navi($before = '', $after = '') {
    global $wpdb, $wp_query;
    $request = $wp_query->request;
    $posts_per_page = intval(get_query_var('posts_per_page'));
    $paged = intval(get_query_var('paged'));
    $numposts = $wp_query->found_posts;
    $max_page = $wp_query->max_num_pages;
    if ( $numposts <= $posts_per_page ) { return; }
    if(empty($paged) || $paged == 0) {
      $paged = 1;
    }
    $pages_to_show = 7;
    $pages_to_show_minus_1 = $pages_to_show-1;
    $half_page_start = floor($pages_to_show_minus_1/2);
    $half_page_end = ceil($pages_to_show_minus_1/2);
    $start_page = $paged - $half_page_start;
    if($start_page <= 0) {
      $start_page = 1;
    }
    $end_page = $paged + $half_page_end;
    if(($end_page - $start_page) != $pages_to_show_minus_1) {
      $end_page = $start_page + $pages_to_show_minus_1;
    }
    if($end_page > $max_page) {
      $start_page = $max_page - $pages_to_show_minus_1;
      $end_page = $max_page;
    }
    if($start_page <= 0) {
      $start_page = 1;
    }
      
    echo $before.'<ul class="pagination">'."";
    if ($paged > 1) {
      $first_page_text = "&laquo";
      echo '<li class="prev"><a href="'.get_pagenum_link().'" title="' . __('First','wpbootstrap') . '">'.$first_page_text.'</a></li>';
    }
      
    $prevposts = get_previous_posts_link( __('&larr; Previous','wpbootstrap') );
    if($prevposts) { echo '<li>' . $prevposts  . '</li>'; }
    else { echo '<li class="disabled"><a href="#">' . __('&larr; Previous','wpbootstrap') . '</a></li>'; }
    
    for($i = $start_page; $i  <= $end_page; $i++) {
      if($i == $paged) {
        echo '<li class="active"><a href="#">'.$i.'</a></li>';
      } else {
        echo '<li><a href="'.get_pagenum_link($i).'">'.$i.'</a></li>';
      }
    }
    echo '<li class="">';
    next_posts_link( __('Next &rarr;','wpbootstrap') );
    echo '</li>';
    if ($end_page < $max_page) {
      $last_page_text = "&raquo;";
      echo '<li class="next"><a href="'.get_pagenum_link($max_page).'" title="' . __('Last','wpbootstrap') . '">'.$last_page_text.'</a></li>';
    }
    echo '</ul>'.$after."";
  }
}

// Remove <p> tags from around images
// function wp_bootstrap_filter_ptags_on_images( $content ){
//   return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
// }
// add_filter( 'the_content', 'wp_bootstrap_filter_ptags_on_images' );

// Script for getting posts
if( !function_exists( "ajax_filter_get_posts" ) ) { 
function ajax_filter_get_posts( $taxonomy ) {
 
  // Verify nonce
  if( !isset( $_POST['wp_bootstrap_nonce'] ) || !wp_verify_nonce( $_POST['wp_bootstrap_nonce'], 'wp_bootstrap_nonce' ) )
    die('Permission denied');
 
  $taxonomy = $_POST['taxonomy'];

  // error_log($taxonomy);
 
  // WP Query
  $args = array(
    'post_type' => 'faqs',
    'posts_per_page' => -1,
    'faqs-category' => $taxonomy,
    'orderby' => array ('menu_order'=> 'ASC', 'date' => 'ASC')
  );
 
  // If taxonomy is not set, remove key from array and get all posts
  if( !$taxonomy ) {
    unset( $args['tag'] );
  }
  $the_query = new WP_Query( $args );

  if ( $the_query->have_posts() ) :
    if (get_post_meta(get_the_ID(),'faqs_page_collapse', true) == 'on') : ?>
    <div class="contaner section faqs">
      <!-- the loop -->
      <div class="row faq-list">
      <div class="panel-group col col-sm-12" id="accordion" role="tablist" aria-multiselectable="true">
      <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?> 
        
        <div class="panel panel-default">
          <div class="panel-heading" role="tab" id="">
            <h4>              
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php the_ID(); ?>" class="collapsed" aria-expanded="false" aria-controls="collapse-<?php the_ID(); ?>">
            <?php the_title(); ?>
            </a>
            </h4>
          </div>
          <div id="collapse-<?php the_ID(); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
          <?php if (get_post_meta(get_the_ID(),'faq_answer', true)) : ?>
            <p><?php echo get_post_meta(get_the_ID(),'faq_answer', true); ?></p>
          <?php endif ; ?>
            </div>
          </div>  
        </div>
              
        <?php $i++; ?>
      <?php endwhile; ?>
      </div><!--  end .panel-group -->
       </div> <!--end .row .faq-list -->
      <!-- end of the loop -->
      <?php wp_reset_postdata(); ?>
      
    </div> <!--end .container .faqs -->
    <?php else: ?>
    <div class="contaner section faqs">
      <!-- the loop -->
      <div class="row faq-list">
      
      <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?> 
        <div class="col col-sm-12"> 
          <h4>              
          <?php the_title(); ?>
          </h4>
          <?php if (get_post_meta(get_the_ID(),'faq_answer', true)) { ?>
          <p><?php echo get_post_meta(get_the_ID(),'faq_answer', true); ?></p>
          <?php } ?>
        </div>
            
        <?php //$i++; ?>

      <?php endwhile; ?>

       </div> <!--end .row .faq-list -->
      <!-- end of the loop -->
      <?php wp_reset_postdata(); ?>
      
    </div> <!--end .container .faqs -->
    <?php endif; ?>
    <?php else : ?>
        <p><?php _e( 'Sorry, no faqs matched your criteria.' ); ?></p>
    <?php endif; 
   
    wp_die();
  }
}
 
add_action('wp_ajax_filter_posts', 'ajax_filter_get_posts');
add_action('wp_ajax_nopriv_filter_posts', 'ajax_filter_get_posts');


function get_revolution_sliders() {
    if(shortcode_exists("rev_slider")){ 
     
    $slider = new RevSlider();
    $revolution_sliders = $slider->getArrSliders();
     
    $rev_sliders = array();
    // First Default Selection
    $rev_sliders[ '' ] = 'Disabled';
    foreach ( $revolution_sliders as $revolution_slider ) {
          $checked="";
          $alias = $revolution_slider->getAlias();
          $title = $revolution_slider->getTitle();
          if($alias==$meta) $checked="selected";

          $rev_sliders[ $alias ] = $title;
      }

    }  
    return $rev_sliders;
}
// use to output wordpress auto formatting for post_meta
function get_editor_output( $meta_key, $post_id = 0 ) {
    global $post;

    $post_id = $post_id ? $post_id : get_the_id();

    $content = get_post_meta( $post_id, $meta_key, 1 );
    $content = do_shortcode( $content );
    $content = wpautop( $content );

    return $content;
}

/**
 Add Google Tag Manager script
**/

add_action('wp_head', 'scripts_header', 0);
function scripts_header() { 
  if($header_scripts = wpbs_get_option('wp_bootstrap_scripts_header')) {
    echo $header_scripts;
  } 
}
add_action('after_body', 'scripts_body');
function scripts_body() { 
  if($body_scripts = wpbs_get_option('wp_bootstrap_scripts_body')) {
    echo $body_scripts;
  } 
}

//Addon for Visual Composer Plugin
if( !function_exists( "getWpBootstrapShared" ) ) {  
  function getWpBootstrapShared( $asset = '' ) {
    switch ( $asset ) {

      case 'theme-buttons':
        $colors = array (
          __( 'Theme Color', 'js_composer' ) => 'danger',

        );
        
        return $colors;
        break;

      default:
        # code...
        break;
    }

    return '';
  }
}

?>
