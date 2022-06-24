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

        }

    }

    new Wpll_single_product_restriction();
}