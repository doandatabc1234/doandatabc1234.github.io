<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themes.zone/
 * @since      1.0.0
 *
 * @package    Handy_Feature_Pack
 * @subpackage Handy_Feature_Pack/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Handy_Feature_Pack
 * @subpackage Handy_Feature_Pack/public
 * @author     Themes Zone <themes.zonehelp@gmail.com>
 */
class Handy_Feature_Pack_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'widget-styles', plugin_dir_url( __FILE__ ) . 'css/frontend-widget-styles.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'composer-styles', plugin_dir_url( __FILE__ ) . 'css/visual-composer-styles.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'easing', plugin_dir_url( __FILE__ ) . 'js/easing.1.3.js', array('jquery'), '1.3', true );
		wp_enqueue_script( 'countdown', plugin_dir_url( __FILE__ ) . 'js/countdown.js', array('jquery'), '2.1.0', true );
		wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.js', array('jquery'), '3.3.7', true );
	}

}
