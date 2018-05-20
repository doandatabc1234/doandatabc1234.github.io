<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://themes.zone/
 * @since      1.0.0
 *
 * @package    Handy_Feature_Pack
 * @subpackage Handy_Feature_Pack/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Handy_Feature_Pack
 * @subpackage Handy_Feature_Pack/includes
 * @author     Themes Zone <themes.zonehelp@gmail.com>
 */
class Handy_Feature_Pack_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'handy-feature-pack',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
