<?php
add_action( 'tgmpa_register', 'handy_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function handy_register_required_plugins() {
    /*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
    $plugins = array(

        // This is an example of how to include a plugin bundled with a theme.
        array(
            'name'               => 'Handy Feature Pack', // The plugin name.
            'slug'               => 'handy-feature-pack', // The plugin slug (typically the folder name).
            'source'             => get_template_directory() . '/required-plugins/handy-feature-pack.zip', // The plugin source.
            'required'           => true, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '1.0.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
            'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
        ),

        array(
            'name'      => 'Max Mega Menu',
            'slug'      => 'megamenu',
            'required'  => false,
        ),

        array(
            'name'      => 'WooCommerce',
            'slug'      => 'woocommerce',
            'required'  => false,
        ),

        array(
            'name'      => 'Force Regenerate Thumbnails',
            'slug'      => 'force-regenerate-thumbnails',
            'required'  => false,
        ),

        array(
            'name'      => 'Contact Form 7',
            'slug'      => 'contact-form-7',
            'required'  => false,
        ),

        array(
            'name'      => 'Google Maps Easy',
            'slug'      => 'google-maps-easy',
            'required'  => false,
        ),

        array(
            'name'      => 'WC Vendors',
            'slug'      => 'wc-vendors',
            'required'  => false,
        ),

        array(
            'name'      => 'YITH WooCommerce Ajax Product Filter',
            'slug'      => 'yith-woocommerce-ajax-navigation',
            'required'  => false,
        ),

        array(
            'name'      => 'YITH WooCommerce Compare',
            'slug'      => 'yith-woocommerce-compare',
            'required'  => false,
        ),

        array(
            'name'      => 'YITH WooCommerce Wishlist',
            'slug'      => 'yith-woocommerce-wishlist',
            'required'  => false,
        ),

        array(
            'name'      => 'Email Subscribers',
            'slug'      => 'email-subscribers',
            'required'  => false,
        ),

        array(
            'name'      => 'Kirki Toolkit',
            'slug'      => 'kirki',
            'required'  => false,
        ),

        array(
            'name'      => 'Social Login',
            'slug'      => 'oa-social-login',
            'required'  => false,
        ),

        array(
            'name'      => 'Yoast SEO',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ),

        array(
            'name'      => 'One Click Demo Import',
            'slug'      => 'one-click-demo-import',
            'required'  => false,
        ),

    );

  /*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
    $config = array(
        'id'           => 'handystore',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => wp_kses_post( '<div class="notice error"><p><strong>'. esc_html__('If you are about to install the plugins on your existing WordPress site then please back up your site, if it is a new installation just ignore the message.', 'handystore')."<br>". esc_html__('Due to high volume of piracy of our themes please contact our support with your purchase code to get your copy of Revolution Slider and Visual Composer.', 'handystore').'</strong></p></div>'),                      // Message to output right before the plugins table.

    );

    tgmpa( $plugins, $config );
}

/* Sample Data Installation filter */
if (class_exists('OCDI_Plugin')) {

  /* Import data */
	function handy_import_sample_data() {
	 return array(
			 array(
					 'import_file_name'             => 'HandyStore Demo Import',
           'local_import_file'            => get_template_directory() . '/required-plugins/dummy-data/handystore.xml',
					 'local_import_widget_file'     => get_template_directory() . '/required-plugins/dummy-data/handy-widgets.wie',
					 'local_import_customizer_file' => get_template_directory() . '/required-plugins/dummy-data/handystore-customizer.dat',
					 'import_preview_image_url'     => get_template_directory() . '/screenshot.png',
					 'import_notice'                => esc_html__( "After you import this demo, you will have to setup the slider and map separately. Don't forget to rebuild all of your thumbnails after import.", 'handystore' ),
			 ),
       /*array(
           'import_file_name'             => 'HandyStore with Dokan Demo Import',
           'local_import_file'            => get_template_directory() . '/required-plugins/dummy-data/handy-dokan.xml',
           'local_import_widget_file'     => get_template_directory() . '/required-plugins/dummy-data/handy-widgets.wie',
           'local_import_customizer_file' => get_template_directory() . '/required-plugins/dummy-data/handystore-customizer.dat',
           'import_preview_image_url'     => get_template_directory() . '/screenshot.png',
           'import_notice'                => esc_html__( "After you import this demo, you will have to setup the slider and map separately. Don't forget to rebuild all of your thumbnails after import.", 'handystore' ),
       ),*/
	   );
  }
  add_filter( 'pt-ocdi/import_files', 'handy_import_sample_data' );

  /* Disable thumbs regeneration for faster installation */
  add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

  /* New Intro text for Data Installer */
  function handy_intro_text( $default_text ) {
      $default_text .= '
  		<div class="ocdi__intro-text">
  				<p><strong>PHP Requirements:</strong></p>
  				<ul>
            <li><strong>upload_max_filesize</strong> - 256M</li>
            <li><strong>max_input_time</strong> - 300</li>
            <li><strong>memory_limit</strong> - 256M</li>
            <li><strong>max_execution_time</strong> - 300</li>
            <li><strong>post_max_size</strong> - 512M</li>
  				</ul>
  				<p>You can always restore default values for PHP variables after installing sample data.</p>
  				<hr>
  		</div>';
      return $default_text;
  }
  add_filter( 'pt-ocdi/plugin_intro_text', 'handy_intro_text' );

  /* Update wp options after data installation complete */
  function handy_after_import_setup() {
    // Handy default theme options
    $handy_settings_defaults = array(
      "site_layout" => "wide",
      "site_maintenance_mode" => "off",
      "maintenance_countdown" => "",
      "site_post_likes" => "on",
      "site_post_shares" => "1",
      "share_networks" => array(
        "facebook" => "1",
        "twitter" => "1",
        "pinterest" => 0,
        "google" => 0,
        "mail" => "1",
        "linkedin" => 0,
        "vk" => "1",
        "tumblr" => 0,
      ),
      "totop_button" => "on",
      "header_bg" => array(
        "color" => "",
        "image" => get_site_url()."/wp-content/uploads/2015/02/handy_bg_03.jpg",
        "repeat" => "repeat",
        "position" => "top left",
        "attachment" => "fixed",
      ),
      "header_top_panel" => "on",
      "top_panel_info" => '<i class="fa fa-map-marker"></i> 102580 Santa Monica BLVD Los Angeles"',
      "footer_bg" => array(
        "color" => "#393E45",
        "image" => "",
        "repeat" => "repeat",
        "position" => "top center",
        "attachment" => "scroll",
      ),
      "site_copyright" => "",
      "footer_shortcode_section" => "1",
      "footer_shortcode_section_bg" => array(
        "color" => "",
        "image" => get_site_url()."/wp-content/uploads/2015/02/handy_bg_03.jpg",
        "repeat" => "repeat",
        "position" => "top left",
        "attachment" => "fixed",
      ),
      "footer_shortcode_section_shortcode" => '[handy_vendors_carousel cols_qty="5" items_number="6" el_title="Our Vendors"]',
      "front_page_shortcode_section" => 0,
      "front_page_shortcode_section_bg" => array(
        "color" => "",
        "image" => "",
        "repeat" => "repeat",
        "position" => "top center",
        "attachment" => "scroll",
      ),
      "front_page_shortcode_section_shortcode" => "",
      "front_page_special_sidebar" => "on",
      "front_layout" => "two-col-left",
      "page_layout" => "two-col-left",
      "blog_layout" => "two-col-right",
      "single_layout" => "two-col-right",
      "shop_layout" => "two-col-left",
      "product_layout" => "two-col-right",
      "vendor_layout" => "two-col-right",
      "lazyload_on_blog" => "on",
      "blog_frontend_layout" => "list",
      "blog_grid_columns" => "cols-3",
      "post_pagination" => "on",
      "post_breadcrumbs" => "on",
      "blog_share_buttons" => "on",
      "post_show_related" => "on",
      "comments_pagination" => "newold",
      "lazyload_on_post" => "on",
      "catalog_mode" => "off",
      "cart_count" => "on",
      "store_breadcrumbs" => "on",
      "filters_sidebar" => "on",
      "front_page_shop" => "off",
      "catalog_lazyload" => "on",
      "store_per_page" => "9",
      "store_columns" => "3",
      "list_grid_switcher" => "on",
      "default_list_type" => "grid",
      "product_pagination" => "on",
      "use_pt_shares_for_product" => "on",
      "use_pt_images_slider" => "off",
      "product_slider_type" => "slider-with-thumbs",
      "product_slider_effect" => "fadeUp",
      "show_upsells" => "on",
      "upsells_qty" => "2",
      "show_related_products" => "on",
      "related_products_qty" => "3",
      "show_wcv_loop_sold_by" => "on",
      "wcv_loop_sold_by_style" => "bottom-slide",
      "show_wcv_related_products" => "on",
      "wcv_qty" => "3",
      "show_wcv_favourite_vendors" => "on",
      "enable_vendors_product_feedback" => "on",
    );
    update_option( 'handystore-theme', $handy_settings_defaults );

    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Test Menu', 'nav_menu' );
    $top_menu = get_term_by( 'name', 'Test Menu (top)', 'nav_menu' );
    set_theme_mod( 'nav_menu_locations', array(
            'primary-nav' => $main_menu->term_id,
            'header-top-nav' => $top_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home Page' );
    $blog_page_id  = get_page_by_title( 'Blog' );
    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );

		// Update YITH plugins options
		if ( class_exists('YITH_Woocompare') ) {
			update_option( 'yith_woocompare_compare_button_in_products_list', 'yes' );
      update_option( 'yith_woocompare_is_button', 'link' );
		}
		if ( class_exists('YITH_WCWL_Shortcode') ) {
			update_option( 'yith_wcwl_button_position', 'shortcode' );
		}

    // Update Yoast SEO options
    if (class_exists('WPSEO_Utils')) {
      $default_yoast_settings = get_option('wpseo');
      $default_yoast_settings["enable_setting_pages"] = true;
      update_option( 'wpseo', $default_yoast_settings );
      $default_yoast_breadcrumbs_settings = get_option('wpseo_internallinks');
      $default_yoast_breadcrumbs_settings["breadcrumbs-enable"] = true;
      update_option( 'wpseo_internallinks', $default_yoast_breadcrumbs_settings );
    }

		// Update woocommerce options
		if ( class_exists( 'Woocommerce' ) ) {
      $shop_page = get_page_by_title( 'Shop' );
      $cart_page = get_page_by_title( 'Cart' );
      $checkout_page = get_page_by_title( 'Checkout' );
      $my_account_page = get_page_by_title( 'My Account' );
      update_option( 'woocommerce_shop_page_id', $shop_page->ID );
      update_option( 'woocommerce_myaccount_page_id', $my_account_page->ID );
      update_option( 'woocommerce_cart_page_id', $cart_page->ID );
      update_option( 'woocommerce_checkout_page_id', $checkout_page->ID );
		}

		// Update megamenu options
		if ( class_exists( 'Mega_Menu' ) ) {
			$megamenu_handy_defaults = array (
				"primary-nav" => array (
					"enabled" => "1",
					"event" => "hover",
					"effect" => "fade",
					"effect_speed" => "200",
					"theme" => "handy",
				),
				"second_click" => "close",
				"mobile_behaviour" => "standard",
				"css" => "head",
				"descriptions" => "enabled",
				"unbind" => "enabled",
				"prefix" => "enabled",
				"instances" => array (
					"primary-nav" => "0",
				),
			);
			update_option( 'megamenu_settings', $megamenu_handy_defaults );
		}

    /* Import Revolution Slider */
    if ( class_exists( 'RevSlider' ) ) {
      $filepath = get_template_directory()."/required-plugins/dummy-data/handy-main-slider.zip";
      $slider = new RevSlider();
      $slider->importSliderFromPost(true,true,$filepath);
    }

  }

  add_action( 'pt-ocdi/after_import', 'handy_after_import_setup' );

} /* end of class_exists('OCDI_Plugin') */

/* Handy Theme for Mega Menu */
if ( class_exists( 'Mega_Menu' ) ) {
  function megamenu_add_theme_handy($themes) {
      $themes["handy"] = array(
          'title' => 'Handy',
          'container_background_from' => 'rgb(86, 86, 86)',
          'container_background_to' => 'rgb(86, 86, 86)',
          'container_padding_left' => '8px',
          'container_padding_right' => '8px',
          'container_padding_top' => '8px',
          'container_padding_bottom' => '8px',
          'arrow_left' => 'dash-f341',
          'arrow_right' => 'dash-f345',
          'menu_item_background_hover_from' => 'rgb(194, 212, 78)',
          'menu_item_background_hover_to' => 'rgb(194, 212, 78)',
          'menu_item_spacing' => '0',
          'menu_item_link_height' => '34px',
          'menu_item_link_text_transform' => 'uppercase',
          'menu_item_link_border_radius_top_left' => '4px',
          'menu_item_link_border_radius_top_right' => '4px',
          'menu_item_link_border_radius_bottom_left' => '4px',
          'menu_item_link_border_radius_bottom_right' => '4px',
          'menu_item_border_color' => 'rgba(255, 255, 255, 0)',
          'menu_item_border_color_hover' => 'rgba(255, 255, 255, 0)',
          'menu_item_highlight_current' => 'on',
          'panel_background_from' => 'rgb(235, 235, 235)',
          'panel_background_to' => 'rgb(235, 235, 235)',
          'panel_header_color' => 'rgb(21, 21, 21)',
          'panel_header_text_transform' => 'none',
          'panel_header_font_size' => '15px',
          'panel_header_font_weight' => 'normal',
          'panel_header_margin_top' => '16px',
          'panel_header_border_color' => 'rgb(191, 191, 191)',
          'panel_header_border_bottom' => '1px',
          'panel_padding_bottom' => '16px',
          'panel_widget_padding_left' => '16px',
          'panel_widget_padding_right' => '16px',
          'panel_widget_padding_top' => '0px',
          'panel_widget_padding_bottom' => '0px',
          'panel_font_size' => '13px',
          'panel_font_color' => 'rgb(100, 101, 101)',
          'panel_font_family' => 'inherit',
          'panel_second_level_font_color' => 'rgb(21, 21, 21)',
          'panel_second_level_font_color_hover' => 'rgb(21, 21, 21)',
          'panel_second_level_text_transform' => 'none',
          'panel_second_level_font' => 'inherit',
          'panel_second_level_font_size' => '15px',
          'panel_second_level_font_weight' => 'normal',
          'panel_second_level_font_weight_hover' => 'normal',
          'panel_second_level_text_decoration' => 'none',
          'panel_second_level_text_decoration_hover' => 'none',
          'panel_second_level_background_hover_from' => 'rgba(244, 244, 244, 0)',
          'panel_second_level_background_hover_to' => 'rgba(244, 244, 244, 0)',
          'panel_second_level_padding_bottom' => '5px',
          'panel_second_level_margin_top' => '16px',
          'panel_second_level_margin_bottom' => '5px',
          'panel_second_level_border_color' => 'rgb(191, 191, 191)',
          'panel_second_level_border_bottom' => '1px',
          'panel_third_level_font_color' => 'rgb(100, 101, 101)',
          'panel_third_level_font_color_hover' => 'rgb(100, 101, 101)',
          'panel_third_level_font' => 'inherit',
          'panel_third_level_font_size' => '13px',
          'panel_third_level_padding_right' => '10px',
          'panel_third_level_padding_top' => '6px',
          'flyout_width' => '180px',
          'flyout_menu_background_from' => 'rgb(235, 235, 235)',
          'flyout_menu_background_to' => 'rgb(235, 235, 235)',
          'flyout_menu_item_divider' => 'on',
          'flyout_menu_item_divider_color' => 'rgb(228, 228, 228)',
          'flyout_link_padding_left' => '26px',
          'flyout_link_padding_right' => '26px',
          'flyout_link_height' => '40px',
          'flyout_background_from' => 'rgb(235, 235, 235)',
          'flyout_background_to' => 'rgb(235, 235, 235)',
          'flyout_background_hover_from' => 'rgb(244, 244, 244)',
          'flyout_background_hover_to' => 'rgb(244, 244, 244)',
          'flyout_link_size' => '14px',
          'flyout_link_color' => '#666',
          'flyout_link_color_hover' => '#666',
          'flyout_link_family' => 'inherit',
          'responsive_breakpoint' => '768px',
          'z_index' => '300',
          'transitions' => 'on',
          'mobile_columns' => '1',
          'toggle_background_from' => 'rgb(86, 86, 86)',
          'toggle_background_to' => 'rgb(86, 86, 86)',
          'toggle_font_color' => '#ffffff',
          'toggle_bar_height' => '50px',
          'mobile_menu_item_height' => '50px',
          'mobile_background_from' => 'rgb(86, 86, 86)',
          'mobile_background_to' => 'rgb(86, 86, 86)',
          'custom_css' => '/** Push menu onto new line **/

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item:after {
  	content: \"\";
      display: inline-block;
      border-right: 1px solid #676767 !important;
      background: #454545 !important;
      width: 2px;
      height: 20px;
      position: relative;
      right: 0px;
      top: 5px;
      margin: 0 10px 0 7px;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item:last-of-type::after {
      display: none;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu:before {
      width: 6px;
      height: 6px;
      position: absolute;
      top: -3px;
      left: 10px;
      transform: rotate(45deg);
      background-color: #ebebeb;
      display: block;
      content: \"\";
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu ul.mega-sub-menu:before {
      display: none;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu.mega-fixed-width ul.mega-sub-menu {
      top: 42px;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu ul.mega-sub-menu {
      top: 50px;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu ul.mega-sub-menu ul.mega-sub-menu {
      top: 0px;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item:not(.mega-menu-item-has-children) a.mega-menu-link::after {
      display: block;
      content: \"\";
      height: 100%;
      width: 3px;
      background: #c2d44e;
      opacity: 0;
      right: 0;
      bottom: 0;
      position: absolute;
      -webkit-transition: opacity 0.3s ease-out;
      -ms-transition: opacity 0.3s ease-out;
      transition: opacity 0.3s ease-out;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:hover::after {
      opacity: 1;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link,
  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link{
      -webkit-transition: padding 0.3s ease-out;
      -ms-transition: padding 0.3s ease-out;
      transition: padding 0.3s ease-out;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu li.mega-menu-item a.mega-menu-link:hover {
      padding: 0 16px 0 36px;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link {
  	border-radius: 4px !important;
      display: inline-block;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu.mega-fixed-width > ul.mega-sub-menu {
  	width: 560px;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu.mega-menu-item.mega-fixed-width {
  	position: relative;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-megamenu > ul.mega-sub-menu > li.mega-menu-item li.mega-menu-item > a.mega-menu-link:hover {
  	padding: 6px 0 0 10px;
      color: #c2d44e;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav:after {
  	display: table;
      conyent: \"\";
      clear: both;
  }

  #mega-menu-wrap-primary-nav #mega-menu-primary-nav p.price {
      margin-bottom: 0px;
  }

  @media (max-width: 768px) {

      #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-flyout ul.mega-sub-menu::before,
      #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item::after {
      	display: none;
  	}

      #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item::before {
      	width: 100%;
          height: 2px;
          top: 0;
          background-color: #454545;
          border-top: 1px solid #676767;
          content: \"\";
          display: block;
      }

      #mega-menu-wrap-primary-nav #mega-menu-primary-nav > li.mega-menu-item > a.mega-menu-link {
      	border-radius: 0 !important;
      	display: block;
  	}

  }

  ',
      );
      return $themes;
  }
	add_filter("megamenu_themes", "megamenu_add_theme_handy");
}
