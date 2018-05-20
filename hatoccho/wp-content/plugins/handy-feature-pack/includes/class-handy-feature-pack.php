<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://themes.zone/
 * @since      1.0.0
 *
 * @package    Handy_Feature_Pack
 * @subpackage Handy_Feature_Pack/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Handy_Feature_Pack
 * @subpackage Handy_Feature_Pack/includes
 * @author     Themes Zone <themes.zonehelp@gmail.com>
 */
class Handy_Feature_Pack {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Handy_Feature_Pack_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'handy-feature-pack';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->define_widget_hooks();
		$this->define_shortcodes_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Handy_Feature_Pack_Loader. Orchestrates the hooks of the plugin.
	 * - Handy_Feature_Pack_i18n. Defines internationalization functionality.
	 * - Handy_Feature_Pack_Admin. Defines all hooks for the admin area.
	 * - Handy_Feature_Pack_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-handy-feature-pack-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-handy-feature-pack-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-handy-feature-pack-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-handy-feature-pack-public.php';

		/* Adding extra functions */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-handy-feature-pack-login-register.php';

		/* Adding widgets */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-cart.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-categories.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-comments-with-avatars.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-contacts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-login.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-most-viewed-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-pay-icons.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-popular-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-recent-posts.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-search.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-socials.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-user-likes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-vendors-products.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/widgets/class-pt-widget-output-shortcode.php';

		/* Add do_shortcode filter */
		add_filter('widget_text','do_shortcode');

		$this->loader = new Handy_Feature_Pack_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Handy_Feature_Pack_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {
		$plugin_i18n = new Handy_Feature_Pack_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		$plugin_admin = new Handy_Feature_Pack_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Handy_Feature_Pack_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Handy_Feature_Pack_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_widget_hooks() {
		$this->loader->add_action( 'widgets_init', $this, 'widgets_init' );
	}

	/**
	 * Registers widgets with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function widgets_init() {
		register_widget( 'pt_woocommerce_widget_cart' );
		register_widget( 'pt_categories' );
		register_widget( 'pt_recent_comments' );
		register_widget( 'pt_contacts_widget' );
		register_widget( 'pt_login_widget' );
		register_widget( 'pt_most_viewed_post_widget' );
		register_widget( 'pt_pay_icons_widget' );
		register_widget( 'pt_popular_posts_widget' );
		register_widget( 'pt_recent_post_widget' );
		register_widget( 'pt_search_widget' );
		register_widget( 'pt_socials_widget' );
		register_widget( 'pt_user_likes_widget' );
		register_widget( 'pt_vendor_products_widget' );
		//register_widget( 'pt_output_shortcode' );
	}

	/**
	 * Register all of the hooks shared between public-facing and admin functionality
	 * of the plugin.
	 *
	 * @since 		1.0.0
	 * @access 		private
	 */
	private function define_shortcodes_hooks() {
		$this->loader->add_action( 'plugins_loaded', $this, 'shortcodes_init' );
	}

	/**
	 * Registers widgets with WordPress
	 *
	 * @since 		1.0.0
	 * @access 		public
	 */
	public function shortcodes_init() {
		if ( class_exists('Woocommerce') ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/sale-carousel.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/woo-codes.php';
			if ( class_exists('WC_Vendors') ) {
				require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/vendors-carousel.php';
			}
		}
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-handy-feature-pack-vc-modification.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/banner.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/carousel.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/contact-member.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/promo-text.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/recent-post.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/shortcodes/testimonials.php';
		if (class_exists('IG_Pb_Init')) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-handy-feature-pack-contentbuilder.php';
		}
	}

}
