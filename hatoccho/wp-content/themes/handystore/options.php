<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'handystore-theme';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 */

function optionsframework_options() {

	// On/Off array
	$on_off_array = array(
		'on' => esc_html__( 'On', 'handystore' ),
		'off' => esc_html__( 'Off', 'handystore' ),
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	);

	/**
	 * For $settings options see:
	 * http://codex.wordpress.org/Function_Reference/wp_editor
	 *
	 * 'media_buttons' are not supported as there is no post to attach items to
	 * 'textarea_name' is set by the 'id' you choose
	 */

	$wp_editor_settings = array(
		'wpautop' => false,
		'textarea_rows' => 3,
		'tinymce' => array( 'plugins' => 'wordpress,wplink' )
	);

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/theme-options/images/';

	// Layout options
	$layout_options = array(
		'one-col' => $imagepath . 'one-col.png',
		'two-col-left' => $imagepath . 'two-col-left.png',
		'two-col-right' => $imagepath . 'two-col-right.png'
	);

	$options = array();

	/* Global Site Settings */
	$options[] = array(
		'name' => esc_html__( 'Site Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'site'
	);

	$options[] = array(
		'name' => esc_html__( 'Select layout for site', 'handystore' ),
		'id' => 'site_layout',
		'std' => 'wide',
		'type' => 'radio',
		'options' => array(
			'wide'  => esc_html__('Wide', 'handystore'),
			'boxed' => esc_html__('Boxed', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Enable "Maintenance Mode" for site?', 'handystore' ),
		'desc' => esc_html__( 'When is ON use /wp-login.php to login to your site', 'handystore' ),
		'id' => 'site_maintenance_mode',
		'std' => 'off',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__('Enter the date when "Maintenance Mode" expired', 'handystore'),
		'desc' => esc_html__('Set date in following format (YYYY-MM-DD). If you leave this field blank, countdown clock won&rsquo;t be shown', 'handystore'),
		'id' => 'maintenance_countdown',
		'std' => '',
		'placeholder' => 'YYYY-MM-DD',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__( 'Extra Features', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Enable "Post like system" for site?', 'handystore' ),
		'desc' => esc_html__( 'Enabling post like functionality on your site + Extra Widgets (Popular Posts, User Likes)', 'handystore' ),
		'id' => 'site_post_likes',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array,
	);

	$options[] = array(
		'name' => esc_html__( 'Enable "Post share system" for site?', 'handystore' ),
		'desc' => esc_html__( 'Enabling post share functionality on your site (available for posts, products, attachments)', 'handystore' ),
		'id' => 'site_post_shares',
		'std' => true,
		'type' => 'checkbox',
		'class' => 'has_hidden_child'
	);

	$multicheck_array = array(
		'facebook' => esc_html__('Share on Facebook', 'handystore'),
		'twitter' => esc_html__('Share on Twitter', 'handystore'),
		'pinterest' => esc_html__('Share on Pinterest', 'handystore'),
		'google' => esc_html__('Share on Google+', 'handystore'),
		'mail' => esc_html__('Email to a friend', 'handystore'),
		'linkedin' => esc_html__('Share on LinkedIn', 'handystore'),
		'vk' => esc_html__('Share on Vkontakte', 'handystore'),
		'tumblr' => esc_html__('Share on Tumblr', 'handystore'),
	);

	$multicheck_defaults = array(
		'facebook' => '1',
		'twitter' => '1',
		'pinterest' => '1',
		'google' => '1',
		'mail' => '1',
		'linkedin' => '1',
		'vk' => '1',
		'tumblr' => '1',
	);

	$options[] = array(
		'name' => __( 'Social Networks for Post Share', 'handystore' ),
		'desc' => __( 'Check all networks you want to appear in share section', 'handystore' ),
		'id' => 'share_networks',
		'std' => $multicheck_defaults,
		'type' => 'multicheck',
		'class' => 'hidden',
		'options' => $multicheck_array
	);

	$options[] = array(
		'name' => esc_html__( 'Enable "Scroll to Top button" for site?', 'handystore' ),
		'desc' => esc_html__( 'If "ON" appears in bottom right corner of site', 'handystore' ),
		'id' => 'totop_button',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	/* Header Options */
	$options[] = array(
		'name' => esc_html__( 'Header Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'header'
	);

	$header_bg_default = get_site_url().'/wp-content/uploads/2015/02/handy_bg_03.jpg';
	$options[] = array(
		'name' => esc_html__( 'Background for header', 'handystore' ),
		'desc' => esc_html__( 'Add custom background color or image for header section.', 'handystore' ),
		'id' => 'header_bg',
		'std' => array(
				'color' => '',
				'image' => $header_bg_default,
				'repeat' => 'repeat',
				'position' => 'top left',
				'attachment' => 'fixed'
		),
		'type' => 'background'
	);

	$options[] = array(
		'name' => esc_html__( 'Top Panel Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Enable header&rsquo;s top panel?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use header top panel', 'handystore' ),
		'id' => 'header_top_panel',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Enter info contents', 'handystore' ),
		'desc' => esc_html__( 'Info appears at center of headers top panel', 'handystore' ),
		'id' => 'top_panel_info',
		'std' => '<i class="fa fa-map-marker"></i> 102580 Santa Monica BLVD Los Angeles',
		'type' => 'textarea'
	);

	/* Footer Options */
	$options[] = array(
		'name' => esc_html__( 'Footer Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'footer'
	);

	$options[] = array(
		'name' => esc_html__( 'Background for footer', 'handystore' ),
		'desc' => esc_html__( 'Add custom background color or image for footer section.', 'handystore' ),
		'id' => 'footer_bg',
		'std' => array(
				'color' => '#393E45',
				'image' => '',
				'repeat' => 'repeat',
				'position' => 'top center',
				'attachment' => 'scroll'
		),
		'type' => 'background'
	);

	$options[] = array(
		'name' => esc_html__( 'Enter sites copyright', 'handystore' ),
		'desc' => esc_html__( 'Enter copyright (appears at the bottom of site)', 'handystore' ),
		'id' => 'site_copyright',
		'std' => '',
		'type' => 'textarea'
	);

	$options[] = array(
		'name' => esc_html__( 'Footer shortcode section Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Footer shortcode section', 'handystore' ),
		'desc' => esc_html__( 'Check to use shortcode section located above footer', 'handystore' ),
		'id' => 'footer_shortcode_section',
		'std' => true,
		'class' => 'has_hidden_childs',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__( 'Background for footer shortcode section', 'handystore' ),
		'desc' => esc_html__( 'Add custom background color or image for shortcode section.', 'handystore' ),
		'id' => 'footer_shortcode_section_bg',
		'class' => 'hidden',
		'std' => array(
				'color' => '',
				'image' => $header_bg_default,
				'repeat' => 'repeat',
				'position' => 'top left',
				'attachment' => 'fixed'
		),
		'type' => 'background'
	);

	$default_footer_shortcode = '[handy_vendors_carousel cols_qty="5" items_number="6" el_title="Our Vendors"]';
	$options[] = array(
		'name' => esc_html__( 'Enter shortcode', 'handystore' ),
		'id' => 'footer_shortcode_section_shortcode',
		'std' => $default_footer_shortcode,
		'class' => 'hidden',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	/* Page Templates Options */
	$options[] = array(
		'name' => esc_html__( 'Page Templates Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'templates'
	);

	$options[] = array(
		'name' => esc_html__( 'Front Page Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Front Page shortcode section', 'handystore' ),
		'desc' => esc_html__( 'Check to use shortcode section located under primary navigation menu', 'handystore' ),
		'id' => 'front_page_shortcode_section',
		'std' => false,
		'class' => 'has_hidden_childs',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => esc_html__( 'Background for shortcode section', 'handystore' ),
		'desc' => esc_html__( 'Add custom background color or image for shortcode section.', 'handystore' ),
		'id' => 'front_page_shortcode_section_bg',
		'class' => 'hidden',
		'std' => $background_defaults,
		'type' => 'background'
	);

	$options[] = array(
		'name' => esc_html__( 'Enter shortcode', 'handystore' ),
		'id' => 'front_page_shortcode_section_shortcode',
		'std' => '',
		'class' => 'hidden',
		'type' => 'editor',
		'settings' => $wp_editor_settings
	);

	$options[] = array(
		'name' => esc_html__( 'Enable Front Page special sidebar?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use front page special sidebar located at the bottom of Front Page Template', 'handystore' ),
		'id' => 'front_page_special_sidebar',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	/* Layout Options */
	$options[] = array(
		'name' => esc_html__( 'Layout Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'layout'
	);

	$options[] = array(
		'name' => esc_html__('Set Front page layout', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the front page', 'handystore'),
		'id' => "front_layout",
		'std' => "two-col-left",
		'type' => "images",
		'options' => $layout_options
	);

	$options[] = array(
		'name' => esc_html__('Set global layout for Pages', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the Pages of your site', 'handystore'),
		'id' => "page_layout",
		'std' => "two-col-left",
		'type' => "images",
		'options' => $layout_options
	);

	$options[] = array(
		'name' => esc_html__('Set Blog page layout', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the Blog page', 'handystore'),
		'id' => "blog_layout",
		'std' => "one-col",
		'type' => "images",
		'options' => $layout_options
	);

	$options[] = array(
		'name' => esc_html__('Set Single post view layout', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the single posts', 'handystore'),
		'id' => "single_layout",
		'std' => "two-col-right",
		'type' => "images",
		'options' => $layout_options
	);

	$options[] = array(
		'name' => esc_html__('Set Products page (Shop page) layout', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the products page', 'handystore'),
		'id' => "shop_layout",
		'std' => "two-col-left",
		'type' => "images",
		'options' => $layout_options
	);

	$options[] = array(
		'name' => esc_html__('Set Single Product pages layout', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the single product pages', 'handystore'),
		'id' => "product_layout",
		'std' => "two-col-right",
		'type' => "images",
		'options' => $layout_options
	);

	$options[] = array(
		'name' => esc_html__('Set Vendor Store pages layout', 'handystore'),
		'desc' => esc_html__('Specify the location of sidebars about the content on the vendor store pages', 'handystore'),
		'id' => "vendor_layout",
		'std' => "two-col-right",
		'type' => "images",
		'options' => $layout_options
	);

	/* Blog Options */
	$options[] = array(
		'name' => esc_html__( 'Blog Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'wordpress'
	);

	$options[] = array(
		'name' => esc_html__( 'Blog Layout Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Enable lazyload effects on blog page?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use Lazyload effects on blog page', 'handystore' ),
		'id' => 'lazyload_on_blog',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Select layout for blog', 'handystore' ),
		'id' => 'blog_frontend_layout',
		'std' => 'grid',
		'type' => 'radio',
		'class' => 'hidden-radio-control',
		'options' => array(
			'list'  => esc_html__('List', 'handystore'),
			'grid'  => esc_html__('Grid', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Select number of columns for Blog "grid layout"', 'handystore' ),
		'id' => 'blog_grid_columns',
		'std' => 'cols-3',
		'type' => 'radio',
		'class' => 'hidden',
		'options' => array(
			'cols-2'  => esc_html__('2 Columns', 'handystore'),
			'cols-3'  => esc_html__('3 Columns', 'handystore'),
			'cols-4' => esc_html__('4 Columns', 'handystore')
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Single Post Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Enable single post Prev/Next navigation output?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use single post navigation', 'handystore' ),
		'id' => 'post_pagination',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Enable single post breadcrumbs?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs on Single post view', 'handystore' ),
		'id' => 'post_breadcrumbs',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Enable single post share buttons output?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use share buttons', 'handystore' ),
		'id' => 'blog_share_buttons',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Enable single post Related Posts output?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to show related posts', 'handystore' ),
		'id' => 'post_show_related',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Select pagination type for comments', 'handystore' ),
		'id' => 'comments_pagination',
		'std' => 'numeric',
		'type' => 'radio',
		'options' => array(
			'newold'  => esc_html__('Newer/Older pagination', 'handystore'),
			'numeric'  => esc_html__('Numeric pagination', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Enable lazyload effects on single post?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use Lazyload effects on single post', 'handystore' ),
		'id' => 'lazyload_on_post',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	/* Store Options */
	$options[] = array(
		'name' => esc_html__( 'Store Options', 'handystore' ),
		'type' => 'heading',
		'icon' => 'basket'
	);

	$options[] = array(
		'name' => esc_html__( 'Show number of products in the cart widget?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "ON" if you want to show a a number of products currently in the cart widget', 'handystore' ),
		'id' => 'cart_count',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Show store Breadcrumbs?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use breadcrumbs on store page', 'handystore' ),
		'id' => 'store_breadcrumbs',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Add special sidebar for filters on Store page?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use special sidebar on products page', 'handystore' ),
		'id' => 'filters_sidebar',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Store as Front page?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "On" if you want to display Store page on Front page. Don&rsquo;t forget to specify Products Page as static front page in WordPress "Reading Settings".', 'handystore' ),
		'id' => 'front_page_shop',
		'std' => 'off',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Add "Lazyload" to products?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use Lazyload effects on products.', 'handystore' ),
		'id' => 'catalog_lazyload',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Hide Product Prices?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "ON" if you want to switch your shop into a catalog mode (no prices, no "add to cart")', 'handystore' ),
		'id' => 'catalog_mode',
		'std' => 'off',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Store Layout Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Enter number of products to show on Store page', 'handystore' ),
		'id' => 'store_per_page',
		'std' => '9',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		'name' => esc_html__( 'Select product quantity per row on Store page', 'handystore' ),
		'id' => 'store_columns',
		'std' => '3',
		'type' => 'radio',
		'options' => array(
			'3'  => esc_html__('3 Products', 'handystore'),
			'4'  => esc_html__('4 Products', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Show List/Grid products switcher?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use switcher on products page', 'handystore' ),
		'id' => 'list_grid_switcher',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Set default view for products (list or grid)', 'handystore' ),
		'id' => 'default_list_type',
		'std' => 'grid',
		'type' => 'radio',
		'options' => array(
			'grid'  => esc_html__('Grid', 'handystore'),
			'list'  => esc_html__('List', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Single Product Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Show Single Product pagination (prev/next product)?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use single pagination on product page', 'handystore' ),
		'id' => 'product_pagination',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Show single product share buttons?', 'handystore' ),
		'desc' => esc_html__( 'Switch to "Off" if you don&rsquo;t want to use single product share buttons', 'handystore' ),
		'id' => 'use_pt_shares_for_product',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Show single product up-sells?', 'handystore' ),
		'id' => 'show_upsells',
		'std' => 'on',
		'type' => 'radio',
		'class' => 'has_hidden_childs_radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Select how many Up-Sell Products to show on Single product page', 'handystore' ),
		'id' => 'upsells_qty',
		'std' => '2',
		'type' => 'select',
		'class' => 'hidden',
		'options' => array(
			'2'  => esc_html__('2 products', 'handystore'),
			'3'  => esc_html__('3 products', 'handystore'),
			'4'  => esc_html__('4 products', 'handystore'),
			'5'  => esc_html__('5 products', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Show single product related products?', 'handystore' ),
		'id' => 'show_related_products',
		'std' => 'on',
		'type' => 'radio',
		'class' => 'has_hidden_childs_radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Select how many Related Products to show on Single product page', 'handystore' ),
		'id' => 'related_products_qty',
		'std' => '3',
		'type' => 'select',
		'class' => 'hidden',
		'options' => array(
			'2'  => esc_html__('2 products', 'handystore'),
			'3'  => esc_html__('3 products', 'handystore'),
			'4'  => esc_html__('4 products', 'handystore'),
			'5'  => esc_html__('5 products', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'WC Vendors Options', 'handystore' ),
		'type' => 'info'
	);

	$options[] = array(
		'name' => esc_html__( 'Show WC Vendors "Sold by:" in Store page loop products?', 'handystore' ),
		'id' => 'show_wcv_loop_sold_by',
		'std' => 'on',
		'type' => 'radio',
		'class' => 'has_hidden_childs_radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Special style for "sold by" label', 'handystore' ),
		'id' => 'wcv_loop_sold_by_style',
		'std' => 'left-slide',
		'type' => 'select',
		'class' => 'hidden',
		'options' => array(
			'left-slide'  => esc_html__('Sliding from left (only icon)', 'handystore'),
			'bottom-slide'  => esc_html__('Sliding from bottom (only shop name)', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Show single product vendors related products?', 'handystore' ),
		'id' => 'show_wcv_related_products',
		'std' => 'on',
		'type' => 'radio',
		'class' => 'has_hidden_childs_radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Select how many Vendor Related Products to show on Single product page', 'handystore' ),
		'id' => 'wcv_qty',
		'std' => '3',
		'type' => 'select',
		'class' => 'hidden',
		'options' => array(
			'2'  => esc_html__('2 products', 'handystore'),
			'3'  => esc_html__('3 products', 'handystore'),
			'4'  => esc_html__('4 products', 'handystore'),
			'5'  => esc_html__('5 products', 'handystore'),
		)
	);

	$options[] = array(
		'name' => esc_html__( 'Add favourite vendor system?', 'handystore' ),
		'desc' => esc_html__( 'Special "Add to Favourites" button appears on single vendor shop when "On". So logged in users can add different vendors to their favourite lists & manage them from "My Account" page', 'handystore' ),
		'id' => 'show_wcv_favourite_vendors',
		'std' => 'off',
		'type' => 'radio',
		'options' => $on_off_array
	);

	$options[] = array(
		'name' => esc_html__( 'Enable simple feedback form for vendors?', 'handystore' ),
		'desc' => esc_html__( 'Form appears in Seller Info tab on each vendors product', 'handystore' ),
		'id' => 'enable_vendors_product_feedback',
		'std' => 'on',
		'type' => 'radio',
		'options' => $on_off_array
	);

	return $options;
}
