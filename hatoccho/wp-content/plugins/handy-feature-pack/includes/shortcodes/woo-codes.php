<?php

if ( class_exists( 'WPBakeryShortCode' ) ) :

add_action( 'vc_before_init', 'handy_woo_codes' );

function handy_woo_codes() {
   vc_map( array(
      'name' => esc_html__( 'Woocommerce Shortcode', 'handy-feature-pack' ),
      'description' => esc_html__( 'Add shortcodes with Carousel', 'handy-feature-pack' ),
      'base' => 'handy_woo_codes',
      'category' => esc_html__( 'Handy Shortcodes', 'handy-feature-pack'),
      'icon' => HANDY_FEATURE_PACK_URL . '/public/img/vc-icon.png',

      'params' => array(
          array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Element Title', 'handy-feature-pack' ),
            'param_name' => 'title',
            'description' => esc_html__( 'Enter Element Title', 'handy-feature-pack' ),
          ),
      		array(
      			'type' => 'dropdown',
      			'heading' => esc_html__( 'Choose Woocommerce Shortcode', 'handy-feature-pack' ),
      			'param_name' => 'codeswoo',
      			'value' => array(
                      esc_html__( 'Recent Products', 'handy-feature-pack' ) => 'recent_products',
                      esc_html__( 'Featured Products', 'handy-feature-pack' ) => 'featured_products',
                      esc_html__( 'Products by category', 'handy-feature-pack' ) => 'product_category',
                      esc_html__( 'Sale Products', 'handy-feature-pack' ) => 'sale_products',
                      esc_html__( 'Best Selling Products', 'handy-feature-pack' ) => 'best_selling_products',
                      esc_html__( 'Top Rated Products', 'handy-feature-pack' ) => 'top_rated_products',
      			),
      			'description' => '',
      		),
          array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Categorie Slug', 'handy-feature-pack' ),
            'param_name' => 'cat_slug',
            'description' => esc_html__( 'Comma separated list of category slugs which products you want to output', 'handy-feature-pack' ),
            'dependency' => array(
              'element' => 'codeswoo',
              'value' => array( 'product_category' ),
            ),
          ),
          array(
            'type' => 'textfield',
            'heading' => esc_html__( 'Number of Products to show', 'handy-feature-pack' ),
      			'param_name' => 'items_number',
      			'description' => esc_html__( 'Set the number of items to show', 'handy-feature-pack' ),
            'value'=> '',
            'edit_field_class' => 'vc_col-sm-6 vc_column',
          ),
      		array(
      			'type' => 'dropdown',
      			'heading' => esc_html__( 'Order Parameter', 'handy-feature-pack' ),
      			'param_name' => 'order_param',
      			'value' => array(
                      esc_html__( 'Ascending', 'handy-feature-pack' ) => 'ASC',
                      esc_html__( 'Descending', 'handy-feature-pack' ) => 'DESC',
      			),
      			'std' => 'ASC',
      			'description' => '',
      		),
      		array(
      			'type' => 'dropdown',
      			'heading' => esc_html__( 'Sort Parameter by', 'handy-feature-pack' ),
      			'param_name' => 'order_param_by',
      			'value' => array(
      				esc_html__( 'Date', 'handy-feature-pack') => 'date',
              esc_html__( 'ID', 'handy-feature-pack') => 'id',
              esc_html__( 'The Menu Order, if set (lower numbers display first).', 'handy-feature-pack') => 'menu_order',
      				esc_html__( 'Title', 'handy-feature-pack') => 'title',
      				esc_html__( 'The number of purchases', 'handy-feature-pack') => 'popularity',
      				esc_html__( 'The average product rating.', 'handy-feature-pack') => 'rating',
      				esc_html__( 'Random', 'handy-feature-pack') => 'rand',
      			),
      			'description' => '',
            'dependency' => array(
              'element' => 'codeswoo',
              'value' => array( 'featured_products','product_category','sale_products','best_selling_products','top_rated_products' ),
            ),
      		),
      		array(
      			'type' => 'dropdown',
      			'heading' => esc_html__( 'Columns quantity', 'handy-feature-pack' ),
      			'param_name' => 'columns_number',
      			'value' => array(
                esc_html__( '2 Cols', 'handy-feature-pack' ) => '2',
                esc_html__( '3 Cols', 'handy-feature-pack' ) => '3',
                esc_html__( '4 Cols', 'handy-feature-pack' ) => '4',
                esc_html__( '5 Cols', 'handy-feature-pack' ) => '5',
                esc_html__( '6 Cols', 'handy-feature-pack' ) => '6',
      			),
      			'std' => '',
      			'description' => esc_html__( 'Set Columns quantity', 'handy-feature-pack' ),
      		),
      		array(
      			'type' => 'checkbox',
      			'heading' => esc_html__( 'Use Owl Carousel', 'handy-feature-pack' ),
      			'param_name' => 'use_slider',
      			'value' => array( esc_html__( 'Yes', 'handy-feature-pack' ) => 'true' ),
      			'std' => 'true',
      			'description' => esc_html__( 'Check to add Owl Carousel to products', 'handy-feature-pack' ),
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

class WPBakeryShortCode_handy_woo_codes extends WPBakeryShortCode {

 protected function content( $atts, $content = null ) {

   extract( shortcode_atts(array(
			'title' => '',
			'codeswoo' => 'recent_products',
      'cat_slug' => '',
			'items_number' => '',
			'use_slider' => 'true',
			'columns_number' => '',
      'order_param_by' => 'date',
			'order_param' => 'DESC',
			'el_class' => '',
			'css' => '',
		), $atts ) );

		$output = '';
    $container_id = '';
		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

		$container_class = 'pt-woo-shortcode wpb_content_element ' . $el_class . $css_class;
    if ( $columns_number=='2' && (pt_show_layout()!='layout-one-col') ) {
      $qty_sm = $qty_xs = 2;
      $qty_md = 2;
    } elseif ( $columns_number=='2' && (pt_show_layout()=='layout-one-col') ) {
      $qty_sm = 2;
      $qty_xs = 2;
      $qty_md = 2;
    } elseif ( $columns_number!='2' && (pt_show_layout()!='layout-one-col') ) {
      $qty_md = 3;
      $qty_sm = 2;
      $qty_xs = 2;
    } elseif ( $columns_number!='2' && (pt_show_layout()=='layout-one-col') ) {
      $qty_md = $columns_number;
      $qty_sm = 3;
      $qty_xs = 2;
    }
		if ( $use_slider == 'true' ) {
			$container_class = $container_class.' with-slider';
			$container_id = uniqid('owl',false);
		}

		$output = '<div class="'.esc_attr($container_class).'" id="'.esc_attr($container_id).'">';
    $output .= '<div class="title-wrapper"><h3 class="shortcode-title">'.esc_attr($title).'</h3>';
    if ( $use_slider == 'true' ) { $output .= "<div class='slider-navi'><span class='prev'></span><span class='next'></span></div>"; }
    $output .= '</div>';

    $on_sale_var = 'false';
    $best_selling_var = 'false';
    $top_rated_var = 'false';
    $visibility_var = 'visible';
    switch ($codeswoo) {
      case 'recent_products':
        $order_param_by = 'id';
      break;
      case 'featured_products':
        $visibility_var = 'featured';
      break;
      case 'sale_products':
        $on_sale_var = 'true';
      break;
      case 'best_selling_products':
        $best_selling_var = 'true';
      break;
      case 'top_rated_products':
        $top_rated_var = 'true';
      break;
    }

    $shortcode = '[products limit="'.esc_attr($items_number).'" columns="'.esc_attr($columns_number).'" orderby="'.esc_attr($order_param_by).'" order="'.esc_attr($order_param).'"';
    $shortcode .= ' category="'.esc_attr($cat_slug).'" visibility="'.esc_attr($visibility_var).'" on_sale="'.esc_attr($on_sale_var).'" best_selling="'.esc_attr($best_selling_var).'" top_rated="'.esc_attr($top_rated_var).'"';
    $shortcode .= ']';
		$output .= do_shortcode($shortcode);

		$output .= "</div>";

			if ( $use_slider == 'true' ) {
				$output.='
				<script type="text/javascript">
					(function($) {
						$(document).ready(function() {
              var owl = $("#'.esc_attr($container_id).' ul.products");

              owl.owlCarousel({
              items : '.esc_attr($columns_number).',
              itemsDesktop : [1199,'.esc_attr($qty_md).'],
              itemsDesktopSmall : [979,'.esc_attr($qty_sm).'],
              itemsTablet: [768,'.esc_attr($qty_xs).'],
              itemsMobile : [479,2],
              pagination: false,
              navigation : false,
              rewindNav : false,
              scrollPerPage : false,
              });

              // Custom Navigation Events
              $("#'.esc_attr($container_id).'").find(".next").click(function(){
              owl.trigger("owl.next");
              })
              $("#'.esc_attr($container_id).'").find(".prev").click(function(){
              owl.trigger("owl.prev");
              })
						});
					})(jQuery);
				</script>';
			}

		return $output;
	}
}

endif;
