<?php // ----- Visual Composer Functions

if ( class_exists( 'Vc_Manager' ) ) {

  	/* Add new style to visual composer elements */
  	add_action( 'vc_after_init', 'add_vc_tabs_handy_style' ); /* Note: here we are using vc_after_init because WPBMap::GetParam and mutateParame are available only when default content elements are "mapped" into the system */
  	function add_vc_tabs_handy_style() {
  	  //Get current values stored in the color param in "Call to Action" element
  	  $param = WPBMap::getParam( 'vc_tta_tabs', 'style' );
  	  //Append new value to the 'value' array
  	  $param['value'][__( 'Handy Style', 'handy-feature-pack' )] = 'handy-style';
  	  //Finally "mutate" param with new values
  	  vc_update_shortcode_param( 'vc_tta_tabs', $param );
  		//Get current values stored in the color param in "Call to Action" element
  		$param = WPBMap::getParam( 'vc_tta_accordion', 'style' );
  		//Append new value to the 'value' array
  		$param['value'][__( 'Handy Style', 'handy-feature-pack' )] = 'handy-style';
  		//Finally "mutate" param with new values
  		vc_update_shortcode_param( 'vc_tta_accordion', $param );
  	}

  	/* New Param for positioning */
  	vc_add_shortcode_param( 'position', 'handy_position_settings_field' );
  	function handy_position_settings_field( $settings, $value ) {
  		return '<div class="position_block">'
  		        .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-numberinput ' .
  		        esc_attr( $settings['param_name'] ) . ' ' .
  		        esc_attr( $settings['type'] ) . '_field" type="number" value="' . esc_attr( $value ) . '" />' .
  		        '</div>'; // This is html markup that will be outputted in content elements edit form
  	}

} // end of class_exists( 'Vc_Manager' )
