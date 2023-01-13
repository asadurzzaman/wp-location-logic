<?php
/**
 * WPLL Single Product Restriction
 *
 * @class WPLL_Product_Restriction
 * @package WooCommerce/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists('Wpll_single_product_restriction')){
    class Wpll_single_product_restriction{
        /**
         * @since  1.0.0
         * @return Wpll_single_product_restriction
         */
        public static function get_instance() {

            if ( null === self::$instance ) {
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
        function __construct() {
            $this->init();
        }

        /*
        * function init
        * @since 1.0.0
        */
        function init(){
            add_action('woocommerce_after_add_to_cart_button', array($this, 'wpll_product_show_hide') );
        }

        function wpll_product_show_hide( $default_data ){

            $restriction = get_post_meta(get_the_ID(), '_restricted_countries', true);
            $select_country = get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true);


            // If there are saved countries, display them
            if (!empty($restriction) && is_array($restriction)) {
                echo "<p>". $select_country. "</p>";
                $countries_obj = new WC_Countries();  
                echo '<ul>'; 
                foreach ($restriction as $country_code => $country_name) {
                    echo '<li>' . esc_html($country_name) . '</li>';
                } 
                echo '</ul>';
            }

            return $default_data;
        }

    }

    new Wpll_single_product_restriction();
}