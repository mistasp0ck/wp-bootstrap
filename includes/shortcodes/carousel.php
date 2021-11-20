<?php
/**
 * The Shortcode
 */
function wpbs_image_slider_shortcode( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'bg' => 'false',
		'button' => 'true',
		'button_url' => '',
		'carousel' => 'true',
		'featured' => 'false',
		'headline' => '',
		'full_width' => 'true',
		//These settings modify the slick.js config
		'slides_per_view' => 3,
		'autoplay' => false,
		'speed' => 3000,
		'arrows' => true,
		'dots' => true,
		'wrap' => 'false',
		'images' => '',
		'img_size' => 'thumbnail',
		'link_image' => true,
		'align' => '',
		'el_class' => ''
	), $atts));
	$align = '';

	$config = array(
			'arrows' => $arrows,
			'dots' => $dots,
			'slides_per_view' => $slides_per_view,
			'autoplay' => $autoplay,
			'infinite' => $wrap,
			'autoplaySpeed' => $speed
	);
	$config = json_encode($config);

	wp_enqueue_script( 'slick-js', 
	  get_template_directory_uri() . '/library/js/slick.js', 
	  array('jquery'), 
	  '1.6.0', true );

	if ($align != '') {
		$align = ' align-'.$align;
	} else {
		$align = '';
	}

	if ($el_class != '') {
		$class = ' '.$el_class;
	} else {
		$class = '';
	}
	$output = '';

	$output .= "<div class='carousel'>";

	if ($full_width == 'true') { 
		$output .='<div class="vc-full-width"></div>';
	} 
	$output .= "<div class='container-carousel'>
				    	<div class='multiple-items".$align."' data-slick='". $config ."'>
				  			<!-- Wrapper for slides -->";
	$output .= do_shortcode($content);
	$output .= '</div></div></div>';	
	return $output;
}
add_shortcode( 'carousel', 'wpbs_image_slider_shortcode' );

/**
 * The Shortcode
 */
function wpbs_image_slider_content_shortcode( $atts, $content = null ) {

	extract( 
		shortcode_atts( 
			array(
				'title' => '',
				'link' => '',
				'image' => '',
				'img_size' => 'thumbnail',
				'el_class' => ''
			), $atts 
		) 
	);

	if ($el_class != '') {
		$class = ' '.$el_class;
	} else {
		$class = '';
	}
	$output = '';
	$attachment = wp_get_attachment_image( $image, $img_size );
	$imagefull = wp_get_attachment_image_src($image, 'full');
	$align = '';
		if($link != '') {
			$output .= '<div class="item'.$align.$class.'"><a href="'.$link.'">' . $attachment . $title . '</a></div>';	
		} else {
			$output .= '<div class="item'.$align.$class.'">' . $attachment . $title . '</div>';
		}	
	
	return $output;
}
add_shortcode( 'item', 'wpbs_image_slider_content_shortcode' );

// Parent Element
function image_slider_shortcode_map() {
	vc_map( 
		array(
			'icon' => 'icon-wpb-images-carousel',
		    'name'                    => __( 'Image Slider' , 'wpbs' ),
		    'base'                    => 'carousel',
		    'description'             => __( 'Adds an Image Slider', 'wpbs' ),
		    'as_parent'               => array('only' => 'item'), // Use only|except attributes to limit child shortcodes (separate multiple values with comma)
		    'content_element'         => true,
		    'show_settings_on_create' => true,
		    "js_view" => 'VcColumnView',
		    'params' => array(
		    	  array(
		    	    'type' => 'textfield',
		    	    'heading' => __( 'Slider speed', 'js_composer' ),
		    	    'param_name' => 'speed',
		    	    'value' => '3000',
		    	    'description' => __( 'Duration of animation between slides (in ms).', 'js_composer' ),
		    	  ),
		    	  array(
		    	    'type' => 'textfield',
		    	    'heading' => __( 'Slides per view', 'js_composer' ),
		    	    'param_name' => 'slides_per_view',
		    	    'value' => '3',
		    	    'description' => __( 'Enter number of slides to display at the same time.', 'js_composer' ),
		    	  ),
		    	  array(
		    	    'type' => 'checkbox',
		    	    'heading' => __( 'Slider autoplay', 'js_composer' ),
		    	    'param_name' => 'autoplay',
		    	    'description' => __( 'Enable autoplay mode.', 'js_composer' ),
		    	    'value' => array( __( 'Yes', 'js_composer' ) => 'true' ),
		    	  ),
		    	  array(
		    	    'type' => 'checkbox',
		    	    'heading' => __( 'Hide pagination control', 'js_composer' ),
		    	    'param_name' => 'dots',
		    	    'description' => __( 'If checked, pagination controls will be hidden.', 'js_composer' ),
		    	    'value' => array( __( 'Yes', 'js_composer' ) => 'false' ),
		    	  ),
		    	  array(
		    	    'type' => 'checkbox',
		    	    'heading' => __( 'Hide prev/next buttons', 'js_composer' ),
		    	    'param_name' => 'arrows',
		    	    'description' => __( 'If checked, prev/next buttons will be hidden.', 'js_composer' ),
		    	    'value' => array( __( 'Yes', 'js_composer' ) => 'false' ),
		    	  ),
		    	  array(
		    	    'type' => 'checkbox',
		    	    'heading' => __( 'Slider loop', 'js_composer' ),
		    	    'param_name' => 'wrap',
		    	    'description' => __( 'Enable slider loop mode.', 'js_composer' ),
		    	    'value' => array( __( 'Yes', 'js_composer' ) => 'true' ),
		    	  ),
		    	  array(
		    	  	'type' => 'dropdown',
		    	  	'heading' => __( 'Slides alignment', 'js_composer' ),
		    	  	'param_name' => 'align',
		    	  	'value' => array(
		    	  		__( 'Left', 'js_composer' ) => 'left',
		    	  		__( 'Right', 'js_composer' ) => 'right',
		    	  		__( 'Center', 'js_composer' ) => 'center',
		    	  	),
		    	  	'description' => __( 'Select global alignment of each slide.', 'js_composer' ),
		    	  ),
		    	  array(
		    	     "type" => "checkbox",
		    	     "holder" => "hidden",
		    	     "class" => "",
		    	     "heading" => __( "Full Width?", "my-text-domain" ),
		    	     "value" => array("Yes" => "true" ),
		    	     "param_name" => "full_width"
		    	  ),
		    	  array(
		    	    'type' => 'textfield',
		    	    'heading' => __( 'Extra class name', 'js_composer' ),
		    	    'param_name' => 'el_class',
		    	    'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
		    	  ),
		    	  array(
		    	    'type' => 'css_editor',
		    	    'heading' => __( 'CSS box', 'js_composer' ),
		    	    'param_name' => 'css',
		    	    'group' => __( 'Design Options', 'js_composer' ),
		    	  ),
		    	)
			)

	);
}
add_action( 'vc_before_init', 'image_slider_shortcode_map' );

// Nested Element
function image_slider_content_shortcode_map() {
	vc_map( 
		array(
			"icon" => 'icon-wpb-single-image',
		    'name'            => __('Slide', 'wpbs'),
		    'base'            => 'item',
		    'description'     => __( 'A slide for the image slider.', 'wpbs' ),
		    // "category" => __('wpbs WP Theme', 'wpbs'),
		    // 'content_element' => true,
		    'as_child'        => array('only' => 'carousel'), // Use only|except attributes to limit parent (separate multiple values with comma)
		    'params' => array(
		    	array(
		    		'type' => 'textfield',
		    		'heading' => __( 'Image title', 'js_composer' ),
		    		'param_name' => 'title',
		    		'description' => __( 'Enter text used as widget title (Note: located above content element).', 'js_composer' ),
		    	),
		    	array(
		    		'type' => 'attach_image',
		    		'heading' => __( 'Image', 'js_composer' ),
		    		'param_name' => 'image',
		    		'value' => '',
		    		'description' => __( 'Select image from media library.', 'js_composer' ),
		    		'dependency' => array(
		    			'value' => 'media_library',
		    		),
		    	),
		    	array(
		    		'type' => 'textfield',
		    		'heading' => __( 'Image size', 'js_composer' ),
		    		'param_name' => 'img_size',
		    		'value' => 'thumbnail',
		    		'description' => __( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).', 'js_composer' ),
		    		'dependency' => array(
		    			'element' => 'source',
		    			'value' => array( 'media_library', 'featured_image' ),
		    		),
		    	),
		    	array(
		    		'type' => 'textfield',
		    		'heading' => __( 'Image size', 'js_composer' ),
		    		'param_name' => 'external_img_size',
		    		'value' => '',
		    		'description' => __( 'Enter image size in pixels. Example: 200x100 (Width x Height).', 'js_composer' ),
		    		'dependency' => array(
		    			'element' => 'source',
		    			'value' => 'external_link',
		    		),
		    	),
		    	array(
		    		'type' => 'href',
		    		'heading' => __( 'Image link', 'js_composer' ),
		    		'param_name' => 'link',
		    		'description' => __( 'Enter URL if you want this image to have a link (Note: parameters like "mailto:" are also accepted).', 'js_composer' ),
		    	),
		    	array(
		    		'type' => 'textfield',
		    		'heading' => __( 'Extra class name', 'js_composer' ),
		    		'param_name' => 'el_class',
		    		'description' => __( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'js_composer' ),
		    	),
		    	array(
		    		'type' => 'css_editor',
		    		'heading' => __( 'CSS box', 'js_composer' ),
		    		'param_name' => 'css',
		    		'group' => __( 'Design Options', 'js_composer' ),
		    	),
		    	// backward compatibility. since 4.6
		    	array(
		    		'type' => 'hidden',
		    		'param_name' => 'img_link_large',
		    	),
		    ),
		) 
	);
}
add_action( 'vc_before_init', 'image_slider_content_shortcode_map' );

// A must for container functionality, replace Wbc_Item with your base name from mapping for parent container
if(class_exists('WPBakeryShortCodesContainer')){
    class WPBakeryShortCode_carousel extends WPBakeryShortCodesContainer {

    }
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if(class_exists('WPBakeryShortCode')){
    class WPBakeryShortCode_item extends WPBakeryShortCode {

    	function __construct( $settings ) {
    		parent::__construct( $settings );

    		$this->jsScripts();
    	}

    	public function jsScripts() {
    		wp_register_script( 'zoom', vc_asset_url( 'lib/bower/zoom/jquery.zoom.min.js' ), array(), WPB_VC_VERSION );

    		wp_register_script( 'vc_image_zoom', vc_asset_url( 'lib/vc_image_zoom/vc_image_zoom.min.js' ), array(
    			'jquery',
    			'zoom',
    		), WPB_VC_VERSION, true );
    	}

    	public function singleParamHtmlHolder( $param, $value ) {
    		$output = '';
    		// Compatibility fixes
    		$old_names = array(
    			'yellow_message',
    			'blue_message',
    			'green_message',
    			'button_green',
    			'button_grey',
    			'button_yellow',
    			'button_blue',
    			'button_red',
    			'button_orange',
    		);
    		$new_names = array(
    			'alert-block',
    			'alert-info',
    			'alert-success',
    			'btn-success',
    			'btn',
    			'btn-info',
    			'btn-primary',
    			'btn-danger',
    			'btn-warning',
    		);
    		$value = str_ireplace( $old_names, $new_names, $value );

    		$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
    		$type = isset( $param['type'] ) ? $param['type'] : '';
    		$class = isset( $param['class'] ) ? $param['class'] : '';

    		if ( 'attach_image' === $param['type'] && 'image' === $param_name ) {
    			$output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
    			$element_icon = $this->settings( 'icon' );
    			$img = wpb_getImageBySize( array(
    				'attach_id' => (int) preg_replace( '/[^\d]/', '', $value ),
    				'thumb_size' => 'thumbnail',
    			) );
    			$this->setSettings( 'logo', ( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail vc_general vc_element-icon"  data-name="' . $param_name . '" alt="" title="" style="display: none;" />' ) . '<span class="no_image_image vc_element-icon' . ( ! empty( $element_icon ) ? ' ' . $element_icon : '' ) . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '">' . __( 'Add image', 'js_composer' ) . '</a>' );
    			$output .= $this->outputTitleTrue( $this->settings['name'] );
    		} elseif ( ! empty( $param['holder'] ) ) {
    			if ( 'input' === $param['holder'] ) {
    				$output .= '<' . $param['holder'] . ' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '">';
    			} elseif ( in_array( $param['holder'], array( 'img', 'iframe' ) ) ) {
    				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="' . $value . '">';
    			} elseif ( 'hidden' !== $param['holder'] ) {
    				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
    			}
    		}

    		if ( ! empty( $param['admin_label'] ) && true === $param['admin_label'] ) {
    			$output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . $param['heading'] . '</label>: ' . $value . '</span>';
    		}

    		return $output;
    	}

    	public function getImageSquareSize( $img_id, $img_size ) {
    		if ( preg_match_all( '/(\d+)x(\d+)/', $img_size, $sizes ) ) {
    			$exact_size = array(
    				'width' => isset( $sizes[1][0] ) ? $sizes[1][0] : '0',
    				'height' => isset( $sizes[2][0] ) ? $sizes[2][0] : '0',
    			);
    		} else {
    			$image_downsize = image_downsize( $img_id, $img_size );
    			$exact_size = array(
    				'width' => $image_downsize[1],
    				'height' => $image_downsize[2],
    			);
    		}
    		$exact_size_int_w = (int) $exact_size['width'];
    		$exact_size_int_h = (int) $exact_size['height'];
    		if ( isset( $exact_size['width'] ) && $exact_size_int_w !== $exact_size_int_h ) {
    			$img_size = $exact_size_int_w > $exact_size_int_h
    				? $exact_size['height'] . 'x' . $exact_size['height']
    				: $exact_size['width'] . 'x' . $exact_size['width'];
    		}

    		return $img_size;
    	}

    	protected function outputTitle( $title ) {
    		return '';
    	}

    	protected function outputTitleTrue( $title ) {
    		return '<h4 class="wpb_element_title">' . $title . ' ' . $this->settings( 'logo' ) . '</h4>';
    	}

    }
}