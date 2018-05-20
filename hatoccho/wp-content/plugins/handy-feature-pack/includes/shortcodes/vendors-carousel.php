<?php
if ( class_exists( 'WPBakeryShortCode' ) ) :

add_action( 'vc_before_init', 'handy_vendors_carousel' );

function handy_vendors_carousel(){

  vc_map( array(
      "name" => esc_html__( 'Vendors Carousel', 'handy-feature-pack' ),
      "base" => "handy_vendors_carousel",
			'category' => esc_html__( 'Handy Shortcodes', 'handy-feature-pack'),
  	  "description" => esc_html__( 'Output Carousel with Vendor stores', 'handy-feature-pack' ),
  		'icon' => HANDY_FEATURE_PACK_URL . '/public/img/vc-icon.png',

      "params" => array(
    			array(
    				'type' => 'textfield',
    				'heading' => esc_html__( 'Element Title', 'handy-feature-pack' ),
    				'param_name' => 'el_title',
    			),
    			array(
    				'type' => 'position',
    				'heading' => esc_html__( 'How many stores displayed per row', 'handy-feature-pack' ),
    				'param_name' => 'cols_qty',
    				'std' =>'5',
    			),
          array(
    				'type' => 'position',
    				'heading' => esc_html__( 'Total number of stores to show', 'handy-feature-pack' ),
    				'param_name' => 'items_number',
    				'std' =>'5',
    			),
    			array(
    				'type' => 'dropdown',
    				'heading' => esc_html__( 'Orderby Parameter', 'handy-feature-pack' ),
    				'param_name' => 'orderby',
    				'value' => array(
    						esc_html__( 'Registered date', 'handy-feature-pack' ) => 'registered' ,
                esc_html__( 'Vendor name', 'handy-feature-pack' ) => 'display_name',
                esc_html__( 'Products quantity', 'handy-feature-pack' ) => 'post_count',
                esc_html__( 'Random', 'handy-feature-pack' ) => 'rand',
    					),
    				'std'=> 'registered',
    			),
    			array(
    				'type' => 'dropdown',
    				'heading' => esc_html__( 'Order Parameter', 'handy-feature-pack' ),
    				'param_name' => 'order_param',
    				'value' => array(
                  esc_html__( 'Ascending', 'handy-feature-pack' ) => 'ASC',
                  esc_html__( 'Descending', 'handy-feature-pack' ) => 'DESC',
    					),
    				'std'=> 'DESC',
            'dependency' => array(
              'element' => 'orderby',
              'value' => array( 'registered', 'display_name', 'post_count' ),
            ),
    			),
    			array(
    				'type' => 'checkbox',
    				'heading' => esc_html__( 'Turn On autoplay', 'handy-feature-pack' ),
    				'param_name' => 'autoplay',
    				'edit_field_class' => 'vc_col-sm-3 vc_column',
    			),
    			array(
    				'type' => 'textfield',
    				'heading' => esc_html__( 'Extra class name', 'handy-feature-pack' ),
    				'param_name' => 'el_class',
    				'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'handy-feature-pack' ),
    			),
    			array(
    				'type' => 'css_editor',
    				'heading' => esc_html__( 'CSS box', 'handy-feature-pack' ),
    				'param_name' => 'css',
    				'group' => esc_html__( 'Design Options', 'handy-feature-pack' ),
    			),
      )
   ) );
}

class WPBakeryShortCode_handy_vendors_carousel extends WPBakeryShortCode {

	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'el_title'           => '',
			'cols_qty' 			     => '3',
			'items_number'       => '5',
			'orderby' 	         => 'registered',
			'order_param' 		   => 'DESC',
			'autoplay' 			     => 'false',
			'el_class'    		   => '',
			'css'         		   => '',
		), $atts ) );

    $output = '';
		$container_id = uniqid('owl',false);
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'pt-vendors-carousel '.vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

    if ( $cols_qty=='2' && (pt_show_layout()!='layout-one-col') ) {
      $qty_sm = $qty_xs = 1;
      $qty_md = 2;
    } elseif ( $cols_qty=='2' && (pt_show_layout()=='layout-one-col') ) {
      $qty_sm = $qty_xs = 1;
      $qty_md = 2;
    } elseif ( $cols_qty!='2' && (pt_show_layout()!='layout-one-col') ) {
      $qty_md = 3;
      $qty_sm = 2;
      $qty_xs = 2;
    } elseif ( $cols_qty!='2' && (pt_show_layout()=='layout-one-col') ) {
      $qty_md = $cols_qty;
      $qty_sm = 2;
      $qty_xs = 1;
    }

    add_action( "pre_user_query", function( $query ) {
    if( "rand" == $query->query_vars["orderby"] ) {
        $query->query_orderby = str_replace( "user_login", "RAND()", $query->query_orderby );
    }
});

    // Args for vendors loop
    $vendor_args = array (
        'role' 				  => 'vendor',
        'meta_key' 			=> 'pv_shop_slug',
        'meta_value'   	=> '',
        'meta_compare' 	=> '>',
        'orderby' 			=> $orderby,
        'order'				  => $order_param,
        'number' 			  => $items_number,
    );
    $vendor_query = New WP_User_Query( $vendor_args );

    // User Loop
    if ( !empty( $vendor_query->results ) ) {
      $output = '<div class="wpb_content_element '.$el_class.' '.$css_class.'" id="'.$container_id.'">';
      $output .= "<div class='title-wrapper'><h3 class='shortcode-title'>{$el_title}</h3>";
      $output .= "<div class='slider-navi'><span class='prev'></span><span class='next'></span></div>";
      $output .= "</div>";

      $output .= '<ul class="wcv_vendorslist">';
      foreach ( $vendor_query->results as $vendor ) {
        $logo_img = '';
        if ( class_exists('WCVendors_Pro') ) {
          $shop_link = WCVendors_Pro_Vendor_Controller::get_vendor_store_url( $vendor->ID );
          $shop_name = get_user_meta( $vendor->ID, 'pv_shop_name', true );
          $store_icon_src = wp_get_attachment_image_src( get_user_meta( $vendor->ID, '_wcv_store_icon_id', true ), 'full' );
          $logo_img = '';
          if ( is_array( $store_icon_src ) ) {
            $logo_img = $store_icon_src[0];
          }
        } else {
          $shop_link = WCV_Vendors::get_vendor_shop_page($vendor->ID);
          $shop_name = $vendor->pv_shop_name;
          $vendor_id = $vendor->ID;
          $logo_img = $vendor->pv_logo_image;
        }

        /* If no icon specified get default vendor img */
        if ($logo_img == '') {
          $logo_img = apply_filters( 'wcvwendors_default_vendor_logo', get_template_directory_uri() . '/images/vendor-logo.png' );
        }
        $output .= '<li>
                      <div class="wrap"><img src="'.esc_url($logo_img).'" alt="'.esc_attr($shop_name).'" />
                      <a href="'.esc_url($shop_link).'" class="button">'.__('Visit Shop', 'handy-feature-pack').'</a></div>
                      <h4>'.esc_attr($shop_name).'</h4>
                    </li>';
      }
      $output .= '</ul></div>';
      $output.='
        <script type="text/javascript">
          (function($) {
            $(document).ready(function() {
              var owl = $("#'.$container_id.' ul.wcv_vendorslist");

              owl.owlCarousel({
              items : '.$cols_qty.',
              itemsDesktop : [1199,'.$qty_md.'],
              itemsDesktopSmall : [979,'.$qty_sm.'],
              itemsTablet: [768,'.$qty_xs.'],
              itemsMobile : [479,2],
              pagination: false,
              navigation : false,
              autoPlay   : '.$autoplay.',
              rewindNav : false,
              scrollPerPage : false,
              });

              // Custom Navigation Events
              $("#'.$container_id.'").find(".next").click(function(){
              owl.trigger("owl.next");
              })
              $("#'.$container_id.'").find(".prev").click(function(){
              owl.trigger("owl.prev");
              })

            });
          })(jQuery);
        </script>';

    } else {
      esc_html_e('No users found.', 'handy-feature-pack');
    }

		return $output;
  }
}

endif;
