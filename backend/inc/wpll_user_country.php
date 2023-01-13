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
            //add_action('woocommerce_after_add_to_cart_button', array($this, 'get_user_contry'));
        }
 
        // function get_user_contry() {

        //     $geoloc = WC_Geolocation::geolocate_ip();

        //     return $geoloc;
        // }

    }
    // new wpll_user_country();
}