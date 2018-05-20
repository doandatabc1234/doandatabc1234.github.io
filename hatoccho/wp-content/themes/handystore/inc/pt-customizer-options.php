<?php
if (class_exists('Handy_Kirki')) {

	function handy_disable_kirki_google_fonts() {
		return array( 'disable_google_fonts' => true );
	}
	//add_filter( 'kirki/config', 'handy_disable_kirki_google_fonts' );

	/* Add configuration */
	Handy_Kirki::add_config( 'handy', array(
	  'capability'    => 'edit_theme_options',
	  'option_type'   => 'theme_mod',
	) );


	/* New Controls in "Site Identity" section */
	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'radio',
		'settings'    => 'site_logo_position',
		'label'       => esc_html__( 'Select position for logo', 'handystore' ),
		'section'     => 'title_tagline',
		'default'     => 'left',
		'choices'     => array(
			'left'  => esc_html__('Left', 'handystore'),
			'center' => esc_html__('Center', 'handystore'),
			'right' => esc_html__('Right', 'handystore'),
		),
	) );


	/* Header Color & Typography Options */
	$font_options = array(
		"Open Sans" => "Open Sans",
		"Roboto" => "Roboto" ,
	);
	if (class_exists('Kirki_Fonts')) {
		$font_options = Kirki_Fonts::get_font_choices();
	}

	Handy_Kirki::add_section( 'handy-header', array(
		'priority'    => 30,
		'title'       => esc_html__( 'Header Color & Typography Options', 'handystore' ),
		'description' => '',
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'top_panel_bg_color',
		'label'       => esc_html__( 'Background color for header top panel', 'handystore' ),
		'section'     => 'handy-header',
		'default'     => 'rgba(255, 255, 255, 0.5)',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.header-top'),
				'property' => 'background-color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'header_text_color',
		'label'       => esc_html__( 'Text color for header', 'handystore' ),
		'section'     => 'handy-header',
		'default'     => '#898e91',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.header-top','.header-top a',),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'     => 'select',
		'settings'  => 'header_font_family',
		'label'    => __( 'Header font', 'handystore' ),
		'section'  => 'handy-header',
		'default'  => 'Roboto',
		'choices'  => $font_options,
		'output'   => array(
			array(
					'element'  => '.site-header',
					'property' => 'font-family'
			)
		),
	) );

	/* Content Typography and Colors */
	Handy_Kirki::add_section( 'handy-colors', array(
		'title'       => esc_html__( 'Content Typography and Colors', 'handystore' ),
		'description' => '',
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'typography',
		'settings'    => 'primary_text_typography',
		'label'       => esc_attr__( 'Primary text typography options', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => array(
			'font-family'    => 'Open Sans',
			'variant'        => 'regular',
			'font-size'      => '14px',
			'line-height'    => '21px',
			'letter-spacing' => '0',
			'subsets'        => array( 'latin-ext' ),
			'color'          => '#646565',
			'text-transform' => 'none',
			'text-align'     => 'left'
		),
		'transport' => 'auto',
		'output'      => array(
			array(
				'element' => 'body',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$secondary_text_color_defaults = '#898e91';
	if ( handy_get_option('secondary_text_color') && handy_get_option('secondary_text_color')!=='' ) {
		$secondary_text_color_defaults = handy_get_option('secondary_text_color');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'secondary_text_color',
		'label'       => esc_html__( 'Secondary text color', 'handystore' ),
		'description' => esc_html__( 'Specify secondary color for all meta content(categories, tags, excerpts)', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $secondary_text_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('del','p> cite','.site-content .entry-meta','.site-content .entry-additional-meta',
													 '.navigation.post-navigation .nav-links a+ a:before','.breadcrumbs-wrapper .breadcrumbs',
													 '.entry-meta-bottom','.author-info .author-bio','.comments-area .comment-meta','.post-list .item-content',
												 	 '.widget.yith-woocommerce-ajax-product-filter .yith-wcan-list li a','.woocommerce-message','.woocommerce-error',
													 '.woocommerce-info','div.product .woocommerce-review-link','div.product .yith-wcwl-add-to-wishlist a',
													 'div.product a.compare','div.product a.compare + .yith-wcwl-add-to-wishlist:before','.variations_form select',
												 	 '.variations_form .select-wrapper::after','div.product .product_meta','div.product .social-links>span',
												 	 '.woocommerce-result-count+.view-all:before','.woocommerce-ordering select','.cart-collaterals .cart_totals table td',
													 '.breadcrumbs-wrapper .woocommerce-breadcrumb','.breadcrumbs-wrapper .single-product-navi a + a::before',
												 	 '.woocommerce .checkout .create-account small','.woocommerce .checkout .woocommerce-checkout-review-order-table .product-quantity',
												 	 '.woocommerce .checkout .woocommerce-checkout-review-order-table .product-total','.woocommerce table.order_details td',
												 	 '.woocommerce .checkout .woocommerce-checkout-review-order-table .cart-subtotal td',
												 	 '.woocommerce .checkout .woocommerce-checkout-review-order-table .order-tax td',
												 	 '.woocommerce .checkout .woocommerce-checkout-review-order-table .shipping td','.widget.woocommerce .product_list_widget li .price del',
													 '.widget_pt_vendor_products_widget .product_list_widget li .price del','.woocommerce .checkout div.payment_box span.help',
													 '.woocommerce .checkout label','.widget_layered_nav ul small.count','.hgroup-sidebar .woocommerce ul.cart_list',
													 '.hgroup-sidebar .woocommerce ul.product_list_widget','.hgroup-sidebar .widget_shopping_cart .cart-excerpt',
												 	 '.sidebar .recent-posts-entry-meta a','.sidebar  .most-viewed-entry-meta a','.pt-member-contact p',
												 	 '.header-container #inner-element ul.social-icons li+ li:before'),
				'property' => 'color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$global_decorative_color_defaults = '#c2d44e';
	if ( handy_get_option('main_decor_color') && handy_get_option('main_decor_color')!=='' ) {
		$global_decorative_color_defaults = handy_get_option('main_decor_color');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'global_decorative_color',
		'label'       => esc_html__( 'Decorative color', 'handystore' ),
		'description' => esc_html__( 'Specify decorative color (used for highlighting different elements)', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $global_decorative_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('q:before','q:after','.entry-meta-bottom .social-links a:hover','.entry-meta-bottom .like-wrapper a:hover',
													 '.author-info .author-contacts a:hover','.widget .current-cat','.widget .current-cat a',
												 	 '.widget.yith-woocommerce-ajax-product-filter .yith-wcan-list li a:hover','div.product div.images span.prev',
													 'div.product div.images span.next','div.product div.images span.prev:before','div.product div.images span.next:before',
												 	 'div.product .woocommerce-review-link:hover','div.product .social-links a:hover','.woocommerce p.stars a',
													 '.woocommerce p.stars a:before','.woocommerce .star-rating:before','.woocommerce .star-rating span:before',
												 	 '.pt-view-switcher span.active','table.shop_table.cart td.product-subtotal','.slider-navi span',
												 	 '.woocommerce .checkout .woocommerce-checkout-review-order-table .order-total td',
												 	 '.woocommerce table.order_details tfoot tr:last-of-type .amount','.hgroup-sidebar .widget_shopping_cart .cart-excerpt .total .amount',
													 '.hgroup-sidebar .widget_shopping_cart_content .total .amount','.recent-post-list .comments-qty',
													 '.recent-post-list .views-qty','.most-viewed-list .comments-qty','.most-viewed-list .views-qty i',
												 	 '.pt-sales-carousel span.prev:before','.pt-sales-carousel span.next:before','.pt-testimonials .occupation',
												 	 '.pt-member-contact span','.header-container #inner-element .rating-container i'),
				'property' => 'color',
			),
			array(
				'element'  => array('mark','ins','.wp-caption','.site-content article.sticky .sticky-post','.navigation.pagination a:hover',
														'.comment-numeric-navigation a:hover','.comment-navigation a:hover','.page-links a:hover span',
														'.owl-theme .owl-controls .owl-page span','.post-list .item-content:hover .link-to-post a',
														'.portfolio-filters-wrapper li:hover','#portfolio-gallery .gallery-icon .quick-view:hover',
														'#portfolio-gallery .link-to-post a:hover','.woocommerce .loading:before','.woocommerce a.button.loading:before',
														'.woocommerce-pagination a:hover','.hgroup-sidebar .widget.widget_shopping_cart .count','.slider-navi span:hover',
														'.pt-sales-carousel span.prev:hover','.pt-sales-carousel span.next:hover',
														'.pt-member-contact.img-pos-center:hover .text-wrapper:before','.vendor-shop-tabs .nav-tabs li a:before'),
				'property' => 'background-color',
			),
			array(
				'element'  => array('.site-content article.sticky','.navigation.pagination a:hover','.comment-numeric-navigation a:hover',
														'.comment-navigation a:hover','.page-links a:hover span','div.product div.images span.prev',
														'div.product div.images span.next','.pt-view-switcher span:hover','.pt-view-switcher span.active',
														'.woocommerce-pagination a:hover','.widget_pt_categories .pt-categories li .show-children:hover','.slider-navi span',
														'.pt-sales-carousel span.prev','.pt-sales-carousel span.next'),
				'property' => 'border-color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'secondary_decorative_color',
		'label'       => esc_html__( 'Secondary decorative color', 'handystore' ),
		'description' => esc_html__( 'Specify secondary decorative color (used for product prices & styling other store elements)', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => '#81cfdc',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('div.product span.price','div.product p.price','li.product .product-description-wrapper .price',
													 '.widget.woocommerce .product_list_widget li .price','.widget_pt_vendor_products_widget .product_list_widget li .price',
												 	 '.pt-sales-carousel ul.products .price-wrapper ins','.wcv-description-inner .products-count'),
				'property' => 'color',
			),
			array(
				'element'  => array('.woocommerce .added_to_cart','div.product span.onsale','div.product span.custom-badge',
														'li.product span.onsale','li.product span.custom-badge','.wcv-verified-vendor'),
				'property' => 'background-color',
			),
			array(
				'element'  => array(),
				'property' => 'border-color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$link_color_defaults = '#000000';
	if ( handy_get_option('link_color') && handy_get_option('link_color')!=='' ) {
		$link_color_defaults = handy_get_option('link_color');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'link_color',
		'label'       => esc_html__( 'Link color', 'handystore' ),
		'description' => esc_html__( 'Specify color for all text links', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $link_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('a','q','blockquote','.site-content .entry-meta .entry-date','article.attachment .entry-meta strong',
													 '.entry-meta-bottom .social-links> span','.ajax-auth a'),
				'property' => 'color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$link_color_hover_defaults = '#c2d44e';
	if ( handy_get_option('link_color_hover') && handy_get_option('link_color_hover')!=='' ) {
		$link_color_hover_defaults = handy_get_option('link_color_hover');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'link_color_hover',
		'label'       => esc_html__( 'Link color on hover', 'handystore' ),
		'description' => esc_html__( 'Specify color for all hovered text links', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $link_color_hover_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('a:hover','a:focus','a:active','.header-top-nav a:hover','.site-content .entry-title a:hover',
													 '.widget.yith-woocommerce-ajax-product-filter li.chosen','.widget.yith-woocommerce-ajax-product-filter li:hover',
												 	 'li.product .product-description-wrapper a.link-to-product:hover','.ajax-auth a:hover',
												 	 '.pv_additional_seller_info .social-icons li a:hover'),
				'property' => 'color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$buttons_font_family_defaults = 'Roboto';
	$buttons_color_defaults = '#ffffff';
	$buttons_bg_color_defaults = '#c2d44e';
	if ( handy_get_option('button_typography') ) {
		$old_options_2 = handy_get_option('button_typography');
		$buttons_font_family_defaults = esc_attr(str_replace('_', ' ',$old_options_2['face']));
		$buttons_color_defaults = $old_options_2['color'];
	}
	if ( handy_get_option('button_background_color') && handy_get_option('button_background_color')!=='' ) {
		$buttons_bg_color_defaults = handy_get_option('button_background_color');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'     		=> 'select',
		'settings'  		=> 'buttons_font_family',
		'label'    		=> __( 'Buttons font', 'handystore' ),
		'description' => esc_html__( 'Specify font for buttons & inputs', 'handystore' ),
		'section'  		=> 'handy-colors',
		'default'  		=> $buttons_font_family_defaults,
		'choices'  		=> $font_options,
		'output'   		=> array(
			array(
					'element'  => array('button','html input[type="button"]','input[type="reset"]','input[type="submit"]',
															'.woocommerce a.button','.woocommerce input.button','.woocommerce .add_to_cart_button',
															'.woocommerce .button.product_type_variable','.woocommerce .product_type_simple',
															'.woocommerce .outofstock .button','.wcv-pro-dashboard a.button','.wcv-pro-dashboard .btn-inverse',
															'.pt-vendors-carousel ul li a.button','figure.handy-banner .button','.wcv-pro-vendorlist a.button'),
					'property' => 'font-family'
			)
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'buttons_color',
		'label'       => esc_html__( 'Buttons color', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $buttons_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('button','html input[type="button"]','input[type="reset"]','input[type="submit"]',
													 '.woocommerce a.button','.woocommerce input.button','.woocommerce .add_to_cart_button',
													 '.woocommerce .button.product_type_variable','.woocommerce .product_type_simple',
													 '.woocommerce .outofstock .button','li.product .additional-buttons a','figure.handy-banner .button',
												   '.wcv-pro-dashboard a.button','.wcv-pro-dashboard .btn-inverse','.pt-vendors-carousel ul li a.button',
												 	 '.pt-sales-carousel ul.products .sale-value','.pt-carousel .item-wrapper.rotator a:hover',
													 '.wcv-pro-vendorlist a.button','li.product.list-view.outofstock .button.disabled',
												 	 'div.product .single_add_to_cart_button.disabled'),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'buttons_bg_color',
		'label'       => esc_html__( 'Buttons background color', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $buttons_bg_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('button','html input[type="button"]','input[type="reset"]','input[type="submit"]',
													 '.woocommerce a.button','.woocommerce input.button','.woocommerce .add_to_cart_button',
													 '.woocommerce .button.product_type_variable','.woocommerce .product_type_simple','.pt-carousel figcaption a:hover',
													 '.woocommerce .outofstock .button','li.product .additional-buttons a','figure.handy-banner .button',
												 	 '.wcv-pro-dashboard a.button','.wcv-pro-dashboard .btn-inverse','.pt-vendors-carousel ul li a.button',
												 	 '.pt-sales-carousel ul.products .sale-value','.pt-carousel.animation-bottom-sliding figcaption a:hover',
												 	 '.wcv-pro-vendorlist a.button','li.product.list-view.outofstock .button.disabled',
													 'div.product .single_add_to_cart_button.disabled'),
				'property' => 'background-color',
			),
			array(
				'element'  => array('.woocommerce a.button','.woocommerce input.button','.woocommerce .add_to_cart_button',
														'.woocommerce .button.product_type_variable','.woocommerce .product_type_simple',
														'.woocommerce .outofstock .button'),
				'property' => 'border-color',
			),
			array(
				'element'  => array('.woocommerce .add_to_cart_button:hover','.woocommerce .button.product_type_variable:hover',
														'.woocommerce .product_type_simple:hover','.woocommerce .outofstock .button:hover',
														'.woocommerce .button.product_type_external:hover'),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'buttons_bg_hover_color',
		'label'       => esc_html__( 'Buttons background color on hover', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => '#b5c648',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element'  => array('button:hover','html input[type="button"]:hover','input[type="reset"]:hover','input[type="submit"]:hover',
														'.woocommerce a.button:hover','.woocommerce input.button:hover','li.product .additional-buttons a:hover',
														'.pt-searchform button.search-button:hover','.wcv-pro-dashboard a.button:hover','.wcv-pro-dashboard .btn-inverse:hover',
														'.pt-vendors-carousel ul li a.button:hover','figure.handy-banner .button:hover','.pt-carousel .item-wrapper.rotator a:hover',
														'.wcv-pro-vendorlist a.button:hover','li.product.list-view.outofstock .button.disabled:hover',
														'div.product .single_add_to_cart_button.disabled:hover'),
				'property' => 'background-color',
			),
			array(
				'element'  => array('.woocommerce a.button:hover','.woocommerce input.button:hover','.pt-carousel .item-wrapper.rotator a:hover'),
				'property' => 'border-color',
			),
			array(
				'element' => array(),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'icons_color',
		'label'       => esc_html__( 'Icons color', 'handystore' ),
		'description' => esc_html__( 'Specify color for icons', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => '#a3a2a2',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('blockquote:before','blockquote:after','.entry-meta-bottom .social-links a','.entry-meta-bottom .like-wrapper a',
													 '.entry-meta-bottom .post-views i','.author-info .author-total-comments i','.author-info .author-contacts a',
													 '.author-info .author-contacts a','.post-list .buttons-wrapper i','.post-list .buttons-wrapper .link-to-post a',
												 	 '#portfolio-gallery .portfolio-item-description i','#portfolio-gallery .link-to-post a','div.product .social-links a',
												 	 '.pt-view-switcher span','a.login_button i','.pv_additional_seller_info .social-icons li a'),
				'property' => 'color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$borders_color_defaults = '#e1e1e1';
	if ( handy_get_option('main_border_color') && handy_get_option('main_border_color')!=='' ) {
		$borders_color_defaults = handy_get_option('main_border_color');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'borders_color',
		'label'       => esc_html__( 'Borders color', 'handystore' ),
		'description' => esc_html__( 'Specify color for borders', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => '#e1e1e1',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('abbr[title]','blockquote','pre','table','th','td','input','select','textarea','.hgroup-sidebar .widget',
													 '.site-content .blog-grid-wrapper article .content-wrapper','.site-content article','.wcv-pro-vendorlist',
													 '.navigation.pagination .page-numbers','.comment-numeric-navigation .page-numbers.current',
													 '.comment-numeric-navigation .page-numbers','.comment-navigation a','.page-links a span',
													 '.page-links span','.breadcrumbs-wrapper .container','article.attachment .entry-title','.entry-meta-bottom',
													 '.author-info','.widget ul li','.post-list .item-content','#special-sidebar-front .row',
												 	 '.post-list .item-content .buttons-wrapper','#portfolio-gallery .portfolio-item-description',
												 	 '.widget.yith-woocommerce-ajax-product-filter','.yith-woocommerce-ajax-product-filter .yith-wcan-list li',
												 	 '#filters-sidebar .widget.yith-woocommerce-ajax-product-filter .yith-wcan','#filters-sidebar .dropdown-filters-title',
												 	 'div.product div.images-wrapper .thumb-slider .synced .slide img','div.product .thumb-slider .owl-item:hover .slide img',
												 	 'div.product .social-links .pt-post-share','div.product .woocommerce-tabs ul.tabs li','#reviews #respond',
													 '.woocommerce-MyAccount-navigation ul li','div.product .woocommerce-tabs ul.tabs:before',
													 '.woocommerce-MyAccount-navigation ul::before','div.product .woocommerce-tabs .panel','.woocommerce-MyAccount-content',
												 	 '.pt-view-switcher span','li.product .inner-product-content','li.product .pt-extra-gallery-thumbs img',
												 	 '.woocommerce-pagination .page-numbers','.cart-collaterals .cart_totals h2','.woocommerce .order_details li',
												 	 '.cart-collaterals .cross-sells>h2','.cart-collaterals .cross-sells ul.products','.widget.widget_shopping_cart .total',
												 	 '.woocommerce table.wishlist_table thead th','.woocommerce table.wishlist_table tbody td',
												 	 '.woocommerce .checkout .order-wrapper','.woocommerce .checkout #order_review_heading','.vendor-shop-tabs .nav-tabs',
													 '.woocommerce .checkout #payment_heading','.woocommerce .checkout ul.payment_methods','.single-rating',
												 	 '.widget.woocommerce','.widget_pt_vendor_products_widget','#filters-sidebar .widget_price_filter form',
												 	 '.mega-sub-menu .product_list_widget li','.pt-searchform .select-wrapper','.hgroup-sidebar .woocommerce ul.cart_list',
													 '.hgroup-sidebar .woocommerce ul.product_list_widget','.widget_pt_categories','.pt-testimonials .style_2 p q',
													 '.widget_pt_categories .pt-categories li .show-children','.hgroup-sidebar .widget_shopping_cart .cart-excerpt .message',
													 '.hgroup-sidebar .widget_shopping_cart .total','.widget_pt_pay_icons_widget','.mega-menu-item .recent-post-list .thumb-wrapper',
												 	 '.mega-menu-item .recent-post-list .content-wrapper','.woocommerce div.product div.images .flex-control-thumbs li:hover img',
												 	 '.woocommerce div.product div.images .flex-control-thumbs li img.flex-active','.pt-testimonials .style_2 .item-wrapper',
												 	 '.pt-sales-carousel ul.products','.pt-sales-carousel ul.products .countdown-wrapper','.pt-testimonials .style_3 .text-wrapper',
												 	 '.pt-carousel .item-wrapper.rotator figure','.pt-carousel .item-wrapper.rotator figcaption h3',
												 	 '.pt-carousel .item-wrapper.rotator a','.pt-member-contact.img-pos-left .text-wrapper','.pt-member-contact.img-pos-top .text-wrapper',
												 	 '.pt-member-contact.img-pos-top .text-wrapper .contact-btns','.header-container #inner-element',
												 	 '.header-container #inner-element .store-brand','.store-aurhor-inner','.pt-woo-shortcode+ .shop-controls-wrapper',
													 '.header-container+ .shop-controls-wrapper','.store-address-container+ .shop-controls-wrapper',
												 	 '.vendor-shop-tabs .nav-tabs li a','.vendor-shop-tabs .tab-content','.pv_additional_seller_info',
												 	 '.vendor-favourite-list .meta-container','.vendor-favourite-list .single-vendor'),
				'property' => 'border-color',
			),
			array(
				'element' => array(),
				'property' => 'color',
			),
			array(
				'element' => array('.navigation.pagination .page-numbers.current','.comment-numeric-navigation .page-numbers.current',
													 '.page-links span','.post-list .buttons-wrapper .link-to-post a','.portfolio-filters-wrapper li',
												 	 '#portfolio-gallery .link-to-post a','.woocommerce-pagination .page-numbers.current',
												 	 '.pt-searchform button.search-button'),
				'property' => 'background-color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$content_headings_font_family_defaults = 'Roboto';
	$content_headings_color_defaults = '#484747';
	if ( handy_get_option('content_headings_typography') ) {
		$old_options_3 = handy_get_option('content_headings_typography');
		$content_headings_font_family_defaults = esc_attr(str_replace('_', ' ',$old_options_3['face']));
		$content_headings_color_defaults = $old_options_3['color'];
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'     		=> 'select',
		'settings'  		=> 'content_headings_font_family',
		'label'    		=> __( 'Headings font', 'handystore' ),
		'section'  		=> 'handy-colors',
		'default'  		=> $content_headings_font_family_defaults,
		'choices'  		=> $font_options,
		'output'   		=> array(
			array(
					'element'  => array('.site-content h1','.site-content h2','.site-content h3','.site-content h4','.site-content h5',
															'.site-content h6','blockquote','.wp-caption-text','.entry-meta-bottom .social-links> span',
															'.entry-meta-bottom .like-wrapper span','.entry-meta-bottom .post-views span','.comments-area .comments-title',
															'.comments-area .comment-reply-title','#pt-gallery .gallery-item-description h3','.portfolio-filters-wrapper label',
															'div.product .product_title','div.product .woocommerce-tabs .panel h2:first-of-type',
															'.woocommerce-Tabs-panel--wcv_shipping_tab h3','#reviews #respond .comment-reply-title',
															'#reviews #respond label','li.product .product-description-wrapper .woocommerce-loop-product__title',
															'.related>h2','.upsells>h2','.wpb_content_element .shortcode-title','.pt-carousel figcaption h3',
															'.wcv-related>h2','table.shop_table.cart th','.woocommerce ul#shipping_method li input + label',
															'table.shop_table.cart td.actions .coupon label','.cart-collaterals .cart_totals h2',
															'.woocommerce-account h3','.woocommerce-account h2','.woocommerce-account legend',
															'.widget.widget_pt_contacts_widget ul.pt-widget-contacts li.a-name','.sold-by-container.bottom-slide',
															'.ajax-auth h1','.pt-sales-carousel ul.products h4','.pt-sales-carousel ul.products .sale-value',
															'.pt-carousel .item-wrapper.rotator figcaption h3','.store-address-container a'),
					'property' => 'font-family'
			)
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'content_headings_color',
		'label'       => esc_html__( 'Headings color', 'handystore' ),
		'section'     => 'handy-colors',
		'default'     => $content_headings_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.site-content h1','.site-content h2','.site-content h3','.site-content h4','.site-content h5',
													 '.site-content h6','.entry-meta-bottom .like-wrapper span','.entry-meta-bottom .post-views span',
													 '.comments-area .comments-title','.comments-area .comment-reply-title','.portfolio-filters-wrapper li',
												 	 'div.product .product_title','div.product .woocommerce-tabs .panel h2:first-of-type',
													 '.woocommerce-Tabs-panel--wcv_shipping_tab h3','#reviews #respond .comment-reply-title',
												 	 '#reviews #respond label','li.product .product-description-wrapper a.link-to-product',
													 '.related>h2','.upsells>h2','.wcv-related>h2','table.shop_table.cart th','.ajax-auth h1',
													 '.woocommerce ul#shipping_method li input + label:after','.woocommerce ul#shipping_method .amount',
												 	 'table.shop_table.cart td.actions .coupon label','.cart-collaterals .cart_totals h2',
												 	 '.cart-collaterals .cart_totals table .order-total td','.woocommerce-checkout #payment ul.payment_methods li input+label',
												 	 '.woocommerce .checkout .required','.woocommerce .checkout h3#ship-to-different-address',
												 	 '.woocommerce form.login label','.woocommerce form.register label','.wpb_content_element .shortcode-title',
												 	 '.pt-sales-carousel ul.products h4','.pt-carousel .item-wrapper.rotator figcaption h3'),
				'property' => 'color',
			),
			array(
				'element' => array('hr'),
				'property' => 'background-color',
			),
		),
	) );


	/* Sidebar Color & Typography Options */
	Handy_Kirki::add_section( 'handy-sidebar', array(
		'title'       => esc_html__( 'Sidebar Color & Typography Options', 'handystore' ),
		'description' => '',
	) );

	/* Compatibility with previous theme options */
	$sidebar_headings_font_family_defaults = 'Roboto';
	$sidebar_headings_color_defaults = '#151515';
	if ( handy_get_option('sidebar_headings_typography') ) {
		$old_options_4 = handy_get_option('sidebar_headings_typography');
		$sidebar_headings_font_family_defaults = esc_attr(str_replace('_', ' ',$old_options_4['face']));
		$sidebar_headings_color_defaults = $old_options_4['color'];
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'     		=> 'select',
		'settings'  		=> 'sidebar_headings_font_family',
		'label'    		=> __( 'Sidebar headings font', 'handystore' ),
		'section'  		=> 'handy-sidebar',
		'default'  		=> $sidebar_headings_font_family_defaults,
		'choices'  		=> $font_options,
		'output'   		=> array(
			array(
					'element'  => array('.sidebar .widget-title','.widget_tag_cloud a','.widget_calendar caption','.widget_calendar',
														  '.widget.woocommerce .product_list_widget li .price','.widget_product_tag_cloud a',
															'.widget.pt-socials-widget ul li i+span'),
					'property' => 'font-family'
			)
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'sidebar_headings_color',
		'label'       => esc_html__( 'Sidebar headings color', 'handystore' ),
		'description' => esc_html__( 'Specify color for widget titles located in sidebar sections', 'handystore' ),
		'section'     => 'handy-sidebar',
		'default'     => $sidebar_headings_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
					'element' => '.sidebar .widget-title',
					'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'sidebar_link_color',
		'label'       => esc_html__( 'Sidebar link color', 'handystore' ),
		'description' => esc_html__( 'Specify color for all text links located in sidebar sections', 'handystore' ),
		'section'     => 'handy-sidebar',
		'default'     => '#646565',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.sidebar a','.sidebar a:focus'),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'sidebar_link_color_hover',
		'label'       => esc_html__( 'Sidebar link color on hover', 'handystore' ),
		'description' => esc_html__( 'Specify color for all hovered text links located in sidebar sections', 'handystore' ),
		'section'     => 'handy-sidebar',
		'default'     => '#c2d44e',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.sidebar a:not(.button):hover','.sidebar a:not(.button):active','.recent-posts-entry-meta a:hover',
													 '.most-viewed-entry-meta a:hover'),
				'property' => 'color',
			),
		),
	) );


	/* Footer Color & Typography Options */
	Handy_Kirki::add_section( 'handy-footer', array(
		'priority'    => 35,
		'title'       => esc_html__( 'Footer Color & Typography Options', 'handystore' ),
		'description' => '',
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'copyright_bg_color',
		'label'       => esc_html__( 'Background color for copyright section', 'handystore' ),
		'section'     => 'handy-footer',
		'default'     => '#24282e',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.footer-bottom'),
				'property' => 'background-color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$footer_text_color_defaults = '#aeb4bc';
	if ( handy_get_option('footer_text_color') && handy_get_option('footer_text_color')!=='' ) {
		$footer_text_color_defaults = handy_get_option('footer_text_color');
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'footer_text_color',
		'label'       => esc_html__( 'Footer text color', 'handystore' ),
		'description' => esc_html__( 'Specify color for widget content located in footer section', 'handystore' ),
		'section'     => 'handy-footer',
		'default'     => $footer_text_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.site-footer', '.site-footer a'),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'footer_link_hover_color',
		'label'       => esc_html__( 'Footer link color on hover', 'handystore' ),
		'description' => esc_html__( 'Specify color for all hovered text links located in footer section', 'handystore' ),
		'section'     => 'handy-footer',
		'default'     => '#81cfdc',
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.site-footer a:hover','.site-footer .widget ul li:before'),
				'property' => 'color',
			),
		),
	) );

	/* Compatibility with previous theme options */
	$footer_headings_font_family_defaults = 'Roboto';
	$footer_headings_color_defaults = '#ffffff';
	if ( handy_get_option('footer_headings_typography') ) {
		$old_options_5 = handy_get_option('footer_headings_typography');
		$footer_headings_font_family_defaults = esc_attr(str_replace('_', ' ',$old_options_5['face']));
		$footer_headings_color_defaults = $old_options_5['color'];
	}

	Handy_Kirki::add_field( 'handy', array(
		'type'        => 'color',
		'settings'    => 'footer_headings_color',
		'label'       => esc_html__( 'Footer headings color', 'handystore' ),
		'description' => esc_html__( 'Specify color for widget titles located in footer section', 'handystore' ),
		'section'     => 'handy-footer',
		'default'     => $footer_headings_color_defaults,
		'choices'     => array(
			'alpha' => true,
		),
		'output'      => array(
			array(
				'element' => array('.site-footer .widget-title'),
				'property' => 'color',
			),
		),
	) );

	Handy_Kirki::add_field( 'handy', array(
		'type'     => 'select',
		'settings'  => 'footer_font_family',
		'label'    => __( 'Footer headings font', 'handystore' ),
		'section'  => 'handy-footer',
		'default'  => $footer_headings_font_family_defaults,
		'choices'  => $font_options,
		'output'   => array(
			array(
					'element'  => '.site-footer .widget-title',
					'property' => 'font-family'
			)
		),
	) );

}
