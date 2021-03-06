<?php

/**
 * Shop functions for each vendor.
 *
 * @author  Matt Gates <http://mgates.me>
 * @package ProductVendor
 */


class WCV_Vendor_Shop
{

	public static $seller_info;

	/**
	 * init
	 */
	function __construct()
	{

		add_filter( 'product_enquiry_send_to', array( 'WCV_Vendor_Shop', 'product_enquiry_compatibility' ), 10, 2 );

		add_action( 'woocommerce_product_query', array( $this, 'vendor_shop_query' ), 10, 2 );
		add_filter( 'init', array( $this, 'add_rewrite_rules' ), 0 );

		add_action( 'woocommerce_before_main_content', array( 'WCV_Vendor_Shop', 'shop_description' ), 30 );
		add_filter( 'woocommerce_product_tabs', array( 'WCV_Vendor_Shop', 'seller_info_tab' ) );
		add_filter( 'post_type_archive_link', array( 'WCV_Vendor_Shop', 'change_archive_link' ) );

		// Add sold by to product loop before add to cart
		if ( apply_filters( 'wcvendors_disable_sold_by_labels', get_option( 'wcvendors_display_label_sold_by_enable' ) ) ) {
			add_action( 'woocommerce_after_shop_loop_item', array('WCV_Vendor_Shop', 'template_loop_sold_by'), 9 );
		}

		// Remove Page Title if on Vendor Shop
		add_filter ( 'woocommerce_show_page_title', array( 'WCV_Vendor_Shop', 'remove_vendor_title' ) );

		// Show vendor on all sales related invoices
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this, 'add_vendor_to_order_item_meta' ), 50, 3 );

		// Add a vendor header
		if ( apply_filters( 'wcvendors_disable_shop_headers', get_option( 'wcvendors_display_shop_headers' ) ) ) {
			add_action( 'woocommerce_before_main_content', array('WCV_Vendor_Shop', 'vendor_main_header'), 20 );
			add_action( 'woocommerce_before_single_product', array('WCV_Vendor_Shop', 'vendor_mini_header'));
		}

		add_filter( 'document_title_parts', array( $this, 'vendor_page_title' ) );

	}

	public static function change_archive_link( $link )
	{
		$vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
		$vendor_id   = WCV_Vendors::get_vendor_id( $vendor_shop );

		return !$vendor_id ? $link : WCV_Vendors::get_vendor_shop_page( $vendor_id );
	}

	/**
	 * Filter WooCommerce main query to include vendor shop pages.
	 *
	 * @param object $q    Existing query object.
	 * @param object $that Instance of WC_Query.
	 * @return void
	 */
	public static function vendor_shop_query( $q, $that )
	{
		$vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
		if ( empty( $vendor_shop ) ) {
			return;
		}

		$vendor_id   = WCV_Vendors::get_vendor_id( $vendor_shop );
		if ( !$vendor_id ) {
			$q->set_404();
			status_header( 404 );

			return;
		}

		add_filter( 'woocommerce_page_title', array( 'WCV_Vendor_Shop', 'page_title' ) );

		$q->set( 'author', $vendor_id );
	}

	public static function product_enquiry_compatibility( $send_to, $product_id )
	{
		$author_id = get_post( $product_id )->post_author;
		if ( WCV_Vendors::is_vendor( $author_id ) ) {
			$send_to = get_userdata( $author_id )->user_email;
		}

		return $send_to;
	}


	/**
	 *
	 *
	 * @param unknown $tabs
	 *
	 * @return unknown
	 */
	public static function seller_info_tab( $tabs )
	{
		global $post;

		if ( WCV_Vendors::is_vendor( $post->post_author ) ) {

			$seller_info = get_user_meta( $post->post_author, 'pv_seller_info', true );
			$has_html    = get_user_meta( $post->post_author, 'pv_shop_html_enabled', true );
			$global_html = get_option( 'wcvendors_display_shop_description_html' );

			$seller_info_label = get_option( 'wcvendors_display_label_store_info' );

			if ( !empty( $seller_info ) ) {

				$seller_info = do_shortcode( $seller_info );
				self::$seller_info = '<div class="pv_seller_info">';
				self::$seller_info .= apply_filters('wcv_before_seller_info_tab', '');
				self::$seller_info .= ( $global_html || $has_html ) ? wpautop( wptexturize( wp_kses_post( $seller_info ) ) ) : sanitize_text_field( $seller_info );
				self::$seller_info .= apply_filters('wcv_after_seller_info_tab', '');
				self::$seller_info .= '</div>';

				$tabs[ 'seller_info' ] = array(
					'title'    => apply_filters( 'wcvendors_seller_info_label', $seller_info_label ),
					'priority' => 50,
					'callback' => array( 'WCV_Vendor_Shop', 'seller_info_tab_panel' ),
				);
			}
		}

		return $tabs;
	}


	/**
	 *
	 */
	public static function seller_info_tab_panel()
	{
		echo self::$seller_info;
	}


	/**
	 * Show the description a vendor sets when viewing products by that vendor
	 */
	public static function shop_description()
	{
		$vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
		$vendor_id   = WCV_Vendors::get_vendor_id( $vendor_shop );

		if ( $vendor_id ) {
			$has_html    = get_user_meta( $vendor_id, 'pv_shop_html_enabled', true );
			$global_html = get_option( 'wcvendors_display_shop_description_html' );
			$description = do_shortcode( get_user_meta( $vendor_id, 'pv_shop_description', true ) );

			echo '<div class="pv_shop_description">';
			echo ( $global_html || $has_html ) ? wpautop( wptexturize( wp_kses_post( $description ) ) ) : sanitize_text_field( $description );
			echo '</div>';
		}
	}

	/**
	 *
	 */
	public static function add_rewrite_rules()
	{
		$permalink = untrailingslashit( get_option( 'wcvendors_vendor_shop_permalink' ) );

		// Remove beginning slash
		if ( substr( $permalink, 0, 1 ) == '/' ) {
			$permalink = substr( $permalink, 1, strlen( $permalink ) );
		}

		add_rewrite_tag( '%vendor_shop%', '([^&]+)' );

		add_rewrite_rule( $permalink . '/([^/]*)/page/([0-9]+)', 'index.php?post_type=product&vendor_shop=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( $permalink . '/([^/]*)', 'index.php?post_type=product&vendor_shop=$matches[1]', 'top' );
	}


	public static function page_title( $page_title = "" )
	{
		$vendor_shop = urldecode( get_query_var( 'vendor_shop' ) );
		$vendor_id   = WCV_Vendors::get_vendor_id( $vendor_shop );

		return $vendor_id ? WCV_Vendors::get_vendor_shop_name( $vendor_id ) : $page_title;
	}


	/*
		Adding sold by to product loop
	*/
	public static function template_loop_sold_by($product_id) {
		$vendor_id     = WCV_Vendors::get_vendor_from_product( $product_id );
		$sold_by_label = get_option( 'wcvendors_label_sold_by' );
		$sold_by = WCV_Vendors::is_vendor( $vendor_id )
			? sprintf( '<a href="%s">%s</a>', WCV_Vendors::get_vendor_shop_page( $vendor_id ), WCV_Vendors::get_vendor_sold_by( $vendor_id ) )
			: get_bloginfo( 'name' );

			wc_get_template( 'vendor-sold-by.php', array(
													'vendor_id' 		=> $vendor_id,
													'sold_by_label'		=> $sold_by_label,
													'sold_by'			=> $sold_by,

											   ), 'wc-vendors/front/', wcv_plugin_dir . 'templates/front/' );

	}


	/*
	* Remove the Page title from Archive-Product while on a vendor Page
	*/
	public static function remove_vendor_title( $b ) {

		if ( WCV_Vendors::is_vendor_page() ) {
			return false;
		}
			return $b;
		}

	/*
	* 	Display a vendor header at the top of the vendors product archive page
	*/
	public static function vendor_main_header() {

		// Remove the basic shop description from the loop
		remove_action( 'woocommerce_before_main_content', array('WCV_Vendor_Shop', 'shop_description' ), 30);

		if (WCV_Vendors::is_vendor_page()) {
			$vendor_shop 		= urldecode( get_query_var( 'vendor_shop' ) );
			$vendor_id   		= WCV_Vendors::get_vendor_id( $vendor_shop );
			$shop_name 			=  get_user_meta( $vendor_id, 'pv_shop_name', true );

			// Shop description
			$has_html    		= get_user_meta( $vendor_id, 'pv_shop_html_enabled', true );
			$global_html 		= get_option( 'wcvendors_display_shop_description_html' );
			$description 		= do_shortcode( get_user_meta( $vendor_id, 'pv_shop_description', true ) );
			$shop_description 	= ( $global_html || $has_html ) ? wpautop( wptexturize( wp_kses_post( $description ) ) ) : sanitize_text_field( $description );
			$seller_info 		= ( $global_html || $has_html ) ? wpautop( get_user_meta( $vendor_id, 'pv_seller_info', true ) ) : sanitize_text_field( get_user_meta( $vendor_id, 'pv_seller_info', true ) );
			$vendor				= get_userdata( $vendor_id );
			$vendor_email		= $vendor->user_email;
			$vendor_login		= $vendor->user_login;


			do_action('wcv_before_main_header', $vendor_id);

			wc_get_template( 'vendor-main-header.php', array(
													'vendor'			=> $vendor,
													'vendor_id' 		=> $vendor_id,
													'shop_name'			=> $shop_name,
													'shop_description'	=> $shop_description,
													'seller_info'		=> $seller_info,
													'vendor_email'		=> $vendor_email,
													'vendor_login'		=> $vendor_login,
											   ), 'wc-vendors/front/', wcv_plugin_dir . 'templates/front/' );

			do_action('wcv_after_main_header', $vendor_id);

		}
	}


	/*
	* 	Display a vendor header at the top of the single-product page
	*/
	public static function vendor_mini_header() {

		global $product;

		$post 			= get_post( $product->get_id() );

		if ( WCV_Vendors::is_vendor_product_page( $post->post_author ) ) {

			$vendor 			= get_userdata( $post->post_author );
			$vendor_id   		= $post->post_author;
			$vendor_shop_link 	= site_url( get_option( 'wcvendors_vendor_approve_registration' ) .'/' .$vendor->pv_shop_slug );
			$shop_name 			= get_user_meta( $vendor_id, 'pv_shop_name', true );
			$has_html    		= $vendor->pv_shop_html_enabled;
			$global_html 		= get_option( 'wcvendors_display_shop_description_html' );
			$description 		= do_shortcode( $vendor->pv_shop_description );
			$shop_description 	= ( $global_html || $has_html ) ? wpautop( wptexturize( wp_kses_post( $description ) ) ) : sanitize_text_field( $description );
			$seller_info 		= ( $global_html || $has_html ) ? wpautop( get_user_meta( $vendor_id, 'pv_seller_info', true ) ) : sanitize_text_field( get_user_meta( $vendor_id, 'pv_seller_info', true ) );
			$vendor_email		= $vendor->user_email;
			$vendor_login		= $vendor->user_login;

			do_action('wcv_before_mini_header', $vendor->ID);

			wc_get_template( 'vendor-mini-header.php', array(
													'vendor'			=> $vendor,
													'vendor_id'			=> $vendor_id,
													'vendor_shop_link' 	=> $vendor_shop_link,
													'shop_name'			=> $vendor->pv_shop_name,
													'shop_description'	=> $shop_description,
													'seller_info'		=> $seller_info,
													'shop_name'			=> $shop_name,
													'vendor_email'		=> $vendor_email,
													'vendor_login'		=> $vendor_login,
											   ), 'wc-vendors/front/', wcv_plugin_dir . 'templates/front/' );

			do_action('wcv_after_mini_header', $vendor->ID);

		}
	}

	/*
	* Add Vendor to Order item Meta legacy
	* Thanks to Asbjoern Andersen for the code
	*
	* @depreciated
	*/
	public static function add_vendor_to_order_item_meta_legacy( $item_id, $cart_item) {

		if ( get_option( 'wcvendors_display_label_sold_by_enable' ) ) {

			$vendor_id 		= $cart_item[ 'data' ]->post->post_author;
			$sold_by_label 	= get_option( 'wcvendors_label_sold_by' );
	      	$sold_by 		= WCV_Vendors::is_vendor( $vendor_id ) ? sprintf( WCV_Vendors::get_vendor_sold_by( $vendor_id ) ): get_bloginfo( 'name' );

	        wc_add_order_item_meta( $item_id, apply_filters( 'wcvendors_sold_by_in_email', $sold_by_label ), $sold_by );
	    }
	}


	/**
	 * Add vendor to order item meta WC2.7 and above
	 *
	 * @since 1.9.9
	 * @access public
	 */
	public function add_vendor_to_order_item_meta( $item, $cart_item_key, $values ) {

		if ( get_option( 'wcvendors_display_label_sold_by_enable' ) ) {

			$cart      		= WC()->cart->get_cart();
			$cart_item 		= $cart[ $cart_item_key ];
			$product_id 	= $cart_item[ 'product_id'];
			$post 			= get_post( $product_id );
			$vendor_id 		= $post->post_author;
			$sold_by_label 	= get_option( 'wcvendors_label_sold_by' );
			$sold_by 		= WCV_Vendors::is_vendor( $vendor_id ) ? sprintf( WCV_Vendors::get_vendor_sold_by( $vendor_id ) ): get_bloginfo( 'name' );

			$item->add_meta_data( apply_filters( 'wcvendors_sold_by_in_email', $sold_by_label ), $sold_by );
		}


	} // add_vendor_to_order_item_meta()


	/**
	 * Add the Vendor shop name to the <title> tag on archive and single product page
	 *
	 * @since 1.9.9
	 */
	public function vendor_page_title( $title ){

		if ( WCV_Vendors::is_vendor_page() ) {

			$title[ 'title' ] = self::page_title();
		}

		return $title;

	} // vendor_page_title


}
