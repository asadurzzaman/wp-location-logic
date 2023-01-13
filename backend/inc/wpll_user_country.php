<?php
/**
 * get User Country
 *
 * @class wpll_user_country
 * @package WooCommerce/Classes
 */

if (!defined('ABSPATH')) {
    exit;
}

if(!function_exists('wpll_user_country')){
    class wpll_user_country{

        /*
	* get_user_contry
	*
	* @since 1.0.0
	*/
        public static function get_instance()
        {

            if (null === self::$instance) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Instance of this class.
         *
         * @since 1.0.0
         * @var object Class Instance
         */
        private static $instance;

        /*
        * construct function
        *
        * @since 1.0.0
        */
        function __construct()
        {
            $this->init();
        }

        /*
        * function init
        * @since 1.0.0
        */
        function init()
        {
            add_action('woocommerce_after_add_to_cart_button', array($this, 'get_user_contry'));
        }
 
        function get_user_contry() {

            $PublicIP = $_SERVER['REMOTE_ADDR'];

            $url = "http://ipinfo.io/$PublicIP?token=9c4cc2f08f266b";
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $resp = curl_exec($curl);
            $json     = json_decode($resp, true);
            curl_close($curl);
            $country =  $json['country'];
            return true;
            echo $country;
        }

    }
    // new wpll_user_country();
}