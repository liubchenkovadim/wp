<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              pinta.com.ua
 * @since             1.0.0
 * @package           Pinta_woocommerce_Feed_Product
 *
 * @wordpress-plugin
 * Plugin Name:       wp-woocommerce-feed-product
 * Plugin URI:        pinta.com.ua
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Pinta Webware
 * Author URI:        pinta.com.ua
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pinta_woocommerce-feed-product
 * Domain Path:       /languages
 */
if (!defined('ABSPATH')) die('No direct access allowed');

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
add_action( 'plugins_loaded', function(){
    load_plugin_textdomain( 'PWFPL', false, dirname( plugin_basename(__FILE__) ) . '/languages' );
} );
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PINTA_WOOCOMMERCE_FEED_PRODUCT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pinta_woocommerce-feed-product-activator.php
 */
function activate_pinta_woocommerce_feed_product() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pinta_woocommerce-feed-product-activator.php';
	Pinta_woocommerce_Feed_Product_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pinta_woocommerce-feed-product-deactivator.php
 */
function deactivate_pinta_woocommerce_feed_product() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pinta_woocommerce-feed-product-deactivator.php';
	Pinta_woocommerce_Feed_Product_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pinta_woocommerce_feed_product' );
register_deactivation_hook( __FILE__, 'deactivate_pinta_woocommerce_feed_product' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pinta_woocommerce-feed-product.php';
function pinta_woocommerce_feed_product_undelete()
{
    global $wpdb;
    $table_name = $wpdb->prefix.'pinta_feed_product_setting';
    $sql = "DROP TABLE IF EXISTS  $table_name";
    $wpdb->query($sql);
}
register_uninstall_hook(__FILE__,'pinta_woocommerce_feed_product_undelete');

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pinta_woocommerce_feed_product() {

	$plugin = new Pinta_woocommerce_Feed_Product();
	$plugin->run();

}
//  run_pinta_woocommerce_feed_product();
add_action("init","run_pinta_woocommerce_feed_product");
