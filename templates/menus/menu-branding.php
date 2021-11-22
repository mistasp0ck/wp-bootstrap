<?php $options = wpbs_get_page_options(); 
$blog_info = get_bloginfo( 'name' );
$header_class = '';
?>
<a class="navbar-brand<?php echo $options['logo_class'] ?> d-flex align-items-center mb-lg-0 text-white text-decoration-none" title="<?php echo get_bloginfo('description'); ?>" href="<?php echo home_url(); ?>"<?php echo $options['logo_styles'] ?>>
  <?php if ( $blog_info ) : ?>
    <?php if ( is_front_page() && ! is_paged() ) : ?>
    <h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $blog_info ); ?></h1>
    <?php elseif ( is_front_page() || is_home() ) : ?>
    <h1 class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $blog_info ); ?></h1>
    <?php else : ?>
      <p class="<?php echo esc_attr( $header_class ); ?>"><?php echo esc_html( $blog_info ); ?></p>
    <?php endif; ?>
  <?php endif; ?>
  <?php echo $options['logo_affix']; ?></a>