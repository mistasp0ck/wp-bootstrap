<?php
/**
 * CMB2 Theme Options
 * @version 0.1.0
 */
if (!class_exists('WpbsCustom_Admin')) {
class WpbsCustom_Admin {

	/**
 	 * Option key, and option page slug
 	 * @var string
 	 */
	private $key = 'wpbs_options';

	/**
 	 * Options page metabox id
 	 * @var string
 	 */
	private $metabox_id = 'wpbs_option_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Holds an instance of the object
	 *
	 * @var wpbs_Admin
	 **/
	private static $instance = null;

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	private function __construct() {
		// Set our title
		$this->title = __( 'Theme Options', 'fscustom' );
	}

	/**
	 * Returns the running object
	 *
	 * @return wpbs_Admin
	 **/
	public static function get_instance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->hooks();
		}
		return self::$instance;
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page( $this->title, $this->title, 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

		// hook in our save notices
		add_action( "cmb2_save_options-page_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$prefix = 'wpbs_';

		$wpbs_options = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page',
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields
		$wpbs_options->add_field( array(
			'name'    => 'Header Settings',
			'desc'    => 'These are the global settings for the header, some can be overridden separately.',
			'type' => 'title',
			'id'   => 'wiki_test_title'
		) );

		$wpbs_options->add_field( array(
		    'name'    => 'Menu Style',
		    'id'      => $prefix . 'menu_style',
		    'type'    => 'radio_inline',
		    'options' => array(
		        'dark' => __( 'Dark', 'cmb2' ),
		        'light'   => __( 'Light', 'cmb2' )
		    ),
		    'default' => 'light',
		) );

		$wpbs_options->add_field( array(
		    'name'    => 'Menu State',
		    'id'      => $prefix . 'menu_state',
		    'type'    => 'radio_inline',
		    'options' => array(
		        'fixed' => __( 'Fixed', 'cmb2' ),
		        'notfixed'   => __( 'Not Fixed', 'cmb2' )
		    ),
		    'default' => 'notfixed',
		) );

		// $wpbs_options->add_field( array(
		//     'name'    => 'Enable Flyout Menu?',
		//     'id'      => $prefix . 'nav_sidebar',
		//     'type'    => 'radio_inline',
		//     'options' => array(
		//     	'true' => __( 'Yes', 'cmb2' ),
		//     	'false'   => __( 'No', 'cmb2' )
		//     ),
		//     'default' => 'false',
		// ) );

		$wpbs_options->add_field( array(
		    'name'    => 'Mobile Menu Style',
		    'id'      => $prefix . 'nav_sidebar_style',
		    'type'    => 'radio_inline',
		    'options' => array(
		    	'default' => __('Default', 'cmb2'),
		    	'right-flyout-menu' => __( 'Right Sidebar', 'cmb2' ),
		    	'full-flyout-menu'   => __( 'Full Width', 'cmb2' )
		    ),
		    'default' => 'false',
		) );

		$wpbs_options->add_field( array(
		    'name'    => 'Hamburger Menu Breakpoint',
		    'id'      => $prefix . 'nav_hamburger',
		    'type'    => 'radio_inline',
		    'options' => array(
		    	'mobile' => __( 'Mobile', 'cmb2' ),
		    	'tablet'   => __( 'Tablet', 'cmb2' ),
		    	'desktop'   => __( 'Desktop', 'cmb2' ),
		    ),
		    'default' => 'mobile',
		) );

		$wpbs_options->add_field( array(
		    'name'    => 'Search Bar in Menu?',
		    'id'      => $prefix . 'menu_search',
		    'type'    => 'radio_inline',
		    'options' => array(
		        'true' => __( 'Yes', 'cmb2' ),
		        'false'   => __( 'No', 'cmb2' )
		    ),
		    'default' => 'false',
		) );

		$wpbs_options->add_field( array(
		    'name'    => 'Enable Sliding Search?',
		    'id'      => $prefix . 'menu_slide',
		    'type'    => 'radio_inline',
		    'options' => array(
		        'true' => __( 'Yes', 'cmb2' ),
		        'false'   => __( 'No', 'cmb2' )
		    ),
		    'default' => 'false',
		) );


		$wpbs_options->add_field( array(
			'name'    => 'Logo for Light Menu (default)',
			'desc'    => 'Logo used for light color menu',
			'id'      => $prefix . 'logo_light',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				//'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin.
		) );	

		$wpbs_options->add_field( array(
			'name'    => 'Logo for Inverse Menu',
			'desc'    => 'Logo used for inverse (dark) color menu',
			'id'      => $prefix . 'logo_dark',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				//'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin.
		) );

		$wpbs_options->add_field( array(
			'name'    => 'Logo for Transparent Menu',
			'desc'    => 'Logo used for transparent menu',
			'id'      => $prefix . 'logo_trans',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				//'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin.
		) );	

		$wpbs_options->add_field( array(
		  'name' => __( 'Featured Text Alignment', 'cmb2' ),
		  'desc' => __( 'Optional Title that appears on top of the featured image', 'cmb2' ),
		  'id'   => $prefix . 'featured_align',
		  'type'    => 'radio_inline',
		  'options' => array(
		      'left' => __( 'Left', 'cmb2' ),
		      'center'   => __( 'Center', 'cmb2' ),
		      'right'   => __( 'Right', 'cmb2' ),
		  ),
		  'default' => 'left',
		) );

		$wpbs_options->add_field( array(
			'name'    => 'Social Settings',
			// 'desc'    => 'These are the global settings for the header, some can be overridden separately.',
			'type' => 'title',
			'id'   => 'wpbs_social_heading'
		) );

		$wpbs_options->add_field( array(
			'name' => __( 'Twitter', 'fscustom' ),
			'desc' => __( 'Twitter Url', 'fscustom' ),
			'id'   => $prefix . 'twitter',
			'type' => 'text',
			'default' => '',
		) );

		$wpbs_options->add_field( array(
			'name' => __( 'Facebook', 'fscustom' ),
			'desc' => __( 'Facebook Url', 'fscustom' ),
			'id'   => $prefix . 'facebook',
			'type' => 'text',
			'default' => '',
		) );

		$wpbs_options->add_field( array(
			'name' => __( 'LinkedIn', 'fscustom' ),
			'desc' => __( 'LinkedIn Url', 'fscustom' ),
			'id'   => $prefix . 'linkedin',
			'type' => 'text',
			'default' => '',
		) );

		$wpbs_options->add_field( array(
			'name' => __( 'Youtube', 'fscustom' ),
			'desc' => __( 'Youtube Url', 'fscustom' ),
			'id'   => $prefix . 'youtube',
			'type' => 'text',
			'default' => '',
		) );

		$wpbs_options->add_field( array(
			'name' => __( 'Instagram', 'fscustom' ),
			'desc' => __( 'Instagram Url', 'fscustom' ),
			'id'   => $prefix . 'instagram',
			'type' => 'text',
			'default' => '',
		) );


		$wpbs_options->add_field( array(
			'name' => __( 'Tracking Code &lt;header&gt;', 'fscustom' ),
			'desc' => __( 'Add tracking code(s) that need to go in the <head> tag', 'fscustom' ),
			'id'   => $prefix . 'scripts_header',
			'type' => 'textarea_code',
			'default' => '',
		) );	
		$wpbs_options->add_field( array(
			'name' => __( 'Tracking Code &lt;body&gt', 'fscustom' ),
			'desc' => __( 'Add tracking code(s) that need to go below the opening <body> tag', 'fscustom' ),
			'id'   => $prefix . 'scripts_body',
			'type' => 'textarea_code',
			'default' => '',
		) );				
				

		// $wpbs_options->add_field( array(
		// 	'name'    => __( 'Test Color Picker', 'fscustom' ),
		// 	'desc'    => __( 'field description (optional)', 'fscustom' ),
		// 	'id'      => 'test_colorpicker',
		// 	'type'    => 'colorpicker',
		// 	'default' => '#bada55',
		// ) );

		// Set our CMB2 fields
		$wpbs_options->add_field( array(
			'name'    => 'Footer Settings',
			'desc'    => 'These are the global settings for the footer.',
			'type' => 'title',
			'id'   => 'footer_title'
		) );

		$wpbs_options->add_field( array(
			'name'    => 'Logo for Footer',
			// 'desc'    => 'Logo used for transparent menu',
			'id'      => $prefix . 'logo_footer',
			'type'    => 'file',
			// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add Image' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
				//'type' => 'application/pdf', // Make library only display PDFs.
				// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'large', // Image size to use when previewing in the admin.
		) );

	}

	/**
	 * Register settings notices for display
	 *
	 * @since  0.1.0
	 * @param  int   $object_id Option key
	 * @param  array $updated   Array of updated fields
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== $this->key || empty( $updated ) ) {
			return;
		}

		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'fscustom' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array( 'key', 'metabox_id', 'title', 'options_page' ), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

/**
 * Helper function to get/return the wpbs_Admin object
 * @since  0.1.0
 * @return wpbs_Admin object
 */
function wpbs_admin() {
	return wpbs_Admin::get_instance();
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function wpbs_get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'wpbs_options', $key, $default );
	}
	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'wpbs_options', $default );
	$val = $default;
	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}
	return $val;
}

// Get it started
wpbs_admin();
}