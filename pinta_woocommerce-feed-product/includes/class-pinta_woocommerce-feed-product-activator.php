<?php

/**
 * Fired during plugin activation
 *
 * @link       pinta.com.ua
 * @since      1.0.0
 *
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/includes
 * @author     Pinta Webware <pinta@pinta.com.ua>
 */
class Pinta_woocommerce_Feed_Product_Activator {



	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

        global $wpdb;

        $table_name = $wpdb->prefix . 'pinta_feed_product_setting';
        $table_name2 = $wpdb->prefix . 'pinta_feed_product_google_category';

            $sql = "CREATE TABLE IF NOT EXISTS $table_name (
              `id` INT(11) NOT NULL AUTO_INCREMENT , 
              `category_name` TEXT NOT NULL , 
              `category-google` TEXT  , 
               `key` TEXT NOT NULL , 
               `type` VARCHAR(10) NOT NULL

              PRIMARY KEY (`id`)
              ) ENGINE = MyISAM;
   ";

            $wpdb->query($sql);
             $sql2 = "CREATE TABLE IF NOT EXISTS $table_name2 (
              `id` INT(11) NOT NULL AUTO_INCREMENT , 
              `category_name` TEXT NOT NULL , 
              `value` INT NOT NULL , 
              
              PRIMARY KEY (`id`)
              ) ENGINE = MyISAM;
   ";

            $wpdb->query($sql2);

	}



}
