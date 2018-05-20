<?php
if ( class_exists( 'WPBakeryShortCode' ) ) :

add_action( 'vc_before_init', 'handy_info_member' );

function handy_info_member(){

vc_map( array(
      "name" => esc_html__( 'Member Contacts', 'handy-feature-pack' ),
      "base" => "handy_info_member",
			'category' => esc_html__( 'Handy Shortcodes', 'handy-feature-pack'),
  	  "description" => esc_html__( 'Output Member Foto and social links', 'handy-feature-pack' ),
  		'icon' => HANDY_FEATURE_PACK_URL . '/public/img/vc-icon.png',

      "params" => array(
      		array(
      			'type' => 'attach_image',
      			'heading' => esc_html__( 'Member Image', 'handy-feature-pack' ),
      			'param_name' => 'member_img',
      			'description' => esc_html__( 'Add Member Image', 'handy-feature-pack' ),
      		),
      		array(
      			'type' => 'dropdown',
      			'heading' => esc_html__( 'Image size', 'handy-feature-pack' ),
      			'param_name' => 'member_img_size',
      			'value' => array(
      				'Thumbnail' => 'thumbnail',
      				'Medium' => 'medium',
      				'Large' => 'large',
      				'Full' => 'full',
      				),
      			'std'=> 'full',
      			'description' => esc_html__( "Enter image size. You can change these images' dimensions in wordpress media settings.", 'handy-feature-pack' ),
      		),
      		array(
      			'type' => 'textfield',
      			'heading' => esc_html__( 'Team Member Name', 'handy-feature-pack' ),
      			'param_name' => 'member_name',
      			'description' => esc_html__( 'Team Member Name', 'handy-feature-pack' ),
      		),
      		array(
      			'type' => 'textfield',
      			'heading' => esc_html__( 'Team Member Occupation', 'handy-feature-pack' ),
      			'param_name' => 'member_occupation',
      			'description' => esc_html__( 'Team Member Occupation', 'handy-feature-pack' ),
      		),
          array(
            'type' => 'textarea',
            'heading' => esc_html__( 'Team Member Short Biography', 'handy-feature-pack' ),
            'param_name' => 'member_biography',
            'value' => esc_html__( 'Short biography here', 'handy-feature-pack' ),
            'description' => '',
          ),
      		array(
      			'type' => 'param_group',
      			'heading' => esc_html__( 'Buttons', 'handy-feature-pack' ),
      			'param_name' => 'buttons',
      			'value' => urlencode( json_encode( array(
      				array(
      					'url_title' => esc_html__( 'Facebook', 'handy-feature-pack' ),
      					'url' => 'https://www.facebook.com/',
      				),
      				array(
      					'url_title' => esc_html__( 'Twitter', 'handy-feature-pack' ),
      					'url' => 'https://twitter.com',
      				),
      				array(
      					'url_title' =>esc_html__( 'Google Plus', 'handy-feature-pack' ),
      					'url' => 'https://plus.google.com',
      				),
      			) ) ),
      			'params' => array(
      				array(
      					'type' => 'textfield',
      					'heading' => esc_html__( 'Title', 'handy-feature-pack' ),
      					'param_name' => 'url_title',
      					'description' => esc_html__( 'Enter Title', 'handy-feature-pack' ),
      					'admin_label' => true,
      				),
      				array(
      					'type' => 'textfield',
      					'heading' => esc_html__( 'URL', 'handy-feature-pack' ),
      					'param_name' => 'url',
      					'description' => esc_html__( 'Enter URL for button', 'handy-feature-pack' ),
      					'admin_label' => true,
      				),
              array(
                'type' => 'iconpicker',
                'heading' => esc_html__( 'Icon', 'handy-feature-pack' ),
                'param_name' => 'icon',
                'value' => 'vc-mono vc-mono-fivehundredpx', // default value to backend editor admin_label
                'settings' => array(
                  'emptyIcon' => false, // default true, display an "EMPTY" icon?
                  'type' => 'monosocial',
                  'iconsPerPage' => 4000, // default 100, how many icons per/page to display
                ),
                'description' => esc_html__( 'Select icon from library.', 'handy-feature-pack' ),
              ),
      			),
      		),
          array(
            'type' => 'dropdown',
            'heading' => esc_html__( 'Predefined Styles', 'handy-feature-pack' ),
            'param_name' => 'img_pos',
            'value' => array(
              'Style 1' => 'left',
              'Style 2' => 'top',
              'Style 3' => 'center',
              ),
            'std'=> 'full',
            'description' => '',
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

class WPBakeryShortCode_handy_info_member extends WPBakeryShortCode {
	protected function content( $atts, $content = null ) {

		extract( shortcode_atts( array(
			'member_img' => '',
			'member_img_size' => 'full',
			'member_name' => '',
			'member_occupation' => '',
			'member_biography' => 'Short biography here',
      'img_pos' => 'left',
			'css' => '',
			'buttons'=> '',
			'el_class'=> '',
		), $atts ) );

		$output = '';
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'pt-member-contact wpb_content_element img-pos-' . esc_attr($img_pos) . ' ' . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

    // Get Foto
    $image_attributes = false;
    $img = '';
    $image_attributes = wp_get_attachment_image_src( $member_img, $member_img_size );
    if( $image_attributes ) {
      $img_alt = get_post_meta($member_img, '_wp_attachment_image_alt', true);
      $img = '<div class="contact-img-wrapper">
                <img alt="' . esc_attr($img_alt) . '" src="' . esc_url($image_attributes[0]) . '" width="' . esc_attr($image_attributes[1]) . '" height="' . esc_attr($image_attributes[2]) . '" />
              </div>';
    }
    // Get Social buttons
    $buttons_member = '';
    $button_attributes =  vc_param_group_parse_atts( $buttons );
    if($button_attributes){
      vc_icon_element_fonts_enqueue( 'monosocial' );
      $buttons_member .='<div class="contact-btns">';
      foreach ( $button_attributes as $data ) {
        $buttons_member.='<a href="'.esc_url($data['url']).'" target="_blank" rel="nofollow" title="'.( isset($data['url_title']) ? $data['url_title'] : esc_html__('Click here', 'handy-feature-pack') ).'"><i class="'.esc_attr($data['icon']).'"></i></a>';
      }
      $buttons_member .='</div>';
    }
    // Main Elements
    $heading = '';
    if ( $member_name ) {
      $heading = "<h3>{$member_name}</h3>";
    }
    $sub_heading = '';
    if ( $member_occupation ) {
      $sub_heading = "<span>{$member_occupation}</span>";
    }
    $short_bio = '';
    if ( $member_biography ) {
      $short_bio = "<p>{$member_biography}</p>";
    }

    // Shortcode output
    $output .= '<div class="'.$css_class.'">';

    if ( $img_pos == 'top' || $img_pos == 'center' ) { $output .= $img; }
    $output .= "<div class='text-wrapper'>";
    if ( $img_pos == 'left' ) { $output .= $img; }
    if ( $img_pos == 'center' ) {
      $output .= '<div class="vertical-wrapper">'.$heading.$sub_heading.'</div>';
    } else {
      $output .= $heading.$sub_heading.$short_bio.$buttons_member;
    }
    $output .= "</div></div>";

		return $output;
	}
}


endif;
