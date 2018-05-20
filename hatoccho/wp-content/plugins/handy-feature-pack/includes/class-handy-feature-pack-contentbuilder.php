<?php

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/recent_posts/recent_posts.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/carousel/carousel.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/banner/banner.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/woo_codes/woo_codes.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/salesCarousel/salescarousel.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/contact/contact.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/testimonials/testimonials.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/pricing/pricing.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/circle_bar/circle_bar.php';
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/builder_shortcodes/vendors_carousel/vendors_carousel.php';

/* Enqueue scripts & styles */
function pt_builder_styles() {
	wp_enqueue_style( 'builder-styles',  HANDY_FEATURE_PACK_URL . '/public/css/builder-styles.css' );
}
add_action('init', 'pt_builder_styles');


add_action( 'ig_pb_addon', 'pt_pb_sc_init' );
function pt_pb_sc_init(){

	class PT_Shortcodes extends IG_Pb_Addon {

		public function __construct() {

			// setup information
			$this->set_provider(
				array(
					'name' => 'Themes Zone',
					'file' => __FILE__,
					'shortcode_dir' => 'builder_shortcodes',

				)
			);

			// call parent construct
			parent::__construct();
		}
	}
	$this_ = new PT_Shortcodes();

}
