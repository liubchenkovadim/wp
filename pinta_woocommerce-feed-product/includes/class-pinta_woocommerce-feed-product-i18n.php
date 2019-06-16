<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       pinta.com.ua
 * @since      1.0.0
 *
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/includes
 * @author     Pinta Webware <pinta@pinta.com.ua>
 */
class Pinta_woocommerce_Feed_Product_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pinta_woocommerce-feed-product',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
