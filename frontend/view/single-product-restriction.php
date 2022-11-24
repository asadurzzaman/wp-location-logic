<?php

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
         * @since 1.0.0
         */
        private static $instance;


        /*
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
            add_action('woocommerce_before_single_product', array($this, 'wpll_product_show_hide') );
        }

        function wpll_product_show_hide( $default_data ){
            
            echo "hello";


            return $default_data;
        }

    }

    new Wpll_single_product_restriction();
}