<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       pinta.com.ua
 * @since      1.0.0
 *
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Pinta_woocommerce_Feed_Product
 * @subpackage Pinta_woocommerce_Feed_Product/includes
 * @author     Pinta Webware <pinta@pinta.com.ua>
 */
class Pinta_woocommerce_Feed_Product {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Pinta_woocommerce_Feed_Product_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PINTA_WOOCOMMERCE_FEED_PRODUCT_VERSION' ) ) {
			$this->version = PINTA_WOOCOMMERCE_FEED_PRODUCT_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'pinta_woocommerce-feed-product';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Pinta_woocommerce_Feed_Product_Loader. Orchestrates the hooks of the plugin.
	 * - Pinta_woocommerce_Feed_Product_i18n. Defines internationalization functionality.
	 * - Pinta_woocommerce_Feed_Product_Admin. Defines all hooks for the admin area.
	 * - Pinta_woocommerce_Feed_Product_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pinta_woocommerce-feed-product-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pinta_woocommerce-feed-product-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pinta_woocommerce-feed-product-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pinta_woocommerce-feed-product-public.php';

        /**
         * The class responsible for defining all actions that occur in the form-save
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pinta_woocommerce-feed-product-save_xml.php';

        $this->loader = new Pinta_woocommerce_Feed_Product_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Pinta_woocommerce_Feed_Product_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Pinta_woocommerce_Feed_Product_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Pinta_woocommerce_Feed_Product_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Pinta_woocommerce_Feed_Product_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		    $this->postProcess($_POST) ;
        }
       if($_GET['ajax'] == 'check') {
            $this->checkData();
            exit;
        }
        if($_GET['ajax'] == 'feed') {
            $this->save_xml();
            exit;
        }
        if($_GET['ajax'] == 'select') {
            $this->select_xml($_POST['cat']);
            exit;
        }
        if($_GET['ajax'] == 'check_cat') {
            $this->check_cat($_POST['id']);
            exit;
        }
        if($_GET['ajax'] == 'csv') {
            $this->save_csv($_POST['name']);
            exit;
        }
	}



	public function postProcess($post){

        if(isset($post['save_setting']) && ($post['save_setting'] == 'save')){
         
            if ( empty($post) || ! wp_verify_nonce( $post['setting_input'], 'save_setting') ){
               _e('Извините, проверочные данные не соответствуют.','PWFPL');
                exit;
            }
            else {

                $this->save_setting($post);
            }


        }
     if(isset($post['save_xml']) && ($post['save_xml'] == 'save')){
            if ( empty($post) || ! wp_verify_nonce( $post['save_xml_input'], 'save_xml') ){
                _e('Извините, проверочные данные не соответствуют.','PWFPL');
                exit;
            }
            else {
                $this->save_xml();
            }


        }

    }
    public function check_cat($cat){
        $obj = new pinta_woocommerce_feed_product_save_xml();
        $obj->check_cat($cat,true);
    }

    public function select_xml($cat){
    	 $obj = new pinta_woocommerce_feed_product_save_xml();
        $obj->select_xml($cat);
    }

    public function save_xml() {
        $obj = new pinta_woocommerce_feed_product_save_xml();
        $obj->save_xml();
    }
    public function save_csv() {
        $obj = new pinta_woocommerce_feed_product_save_xml();
  
        $obj->save_csv();
    }
    public function checkData() {
	    $obj = new pinta_woocommerce_feed_product_save_xml();
	     $check =$obj->get_setting_feed("on");

	     if($check[0]['category_name'] == "1"){
	         $result = $obj->get_setting_feed("url");

            print $result[0]["category_name"];
         }
	     return false;
    }
    public function save_setting($post) {
        $obj = new pinta_woocommerce_feed_product_save_xml();

        $obj->save_setting($post);
    }
	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Pinta_woocommerce_Feed_Product_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
