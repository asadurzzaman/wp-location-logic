<?php
/**
 * WPLL Product Restricition
 *
 * @class wpll_products_restriction_setting
 * @package WooCommerce/Classes
 */

if (!defined('ABSPATH')) {
    exit;
}

if( !class_exists('wpll_products_restriction_setting')){
    class wpll_products_restriction_setting{
        /**
         * @since  1.0.0
         * @return wpll_products_restriction_setting
         */
        public static function get_instance(){

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
        function __construct(){
            $this->init();
        }

        /*
        * function init
        * @since 1.0.0
        */
        function init(){
            //callback on activate plugin
            register_activation_hook(__FILE__, array($this, 'on_activation'));

            //hook for geolocation_update_database	
            add_filter('woocommerce_maxmind_geolocation_update_database_periodically', array($this, 'update_geo_database'), 10, 1);

            add_action('woocommerce_after_add_to_cart_button', array($this, 'is_product_restricted_by_id'));
        }

        /**
         * WC_Geolocation database update hooks
         *
         * @since 1.0.0
         */
        function on_activation()
        {
            WC_Integration_MaxMind_Geolocation::update_database();
        }

        /**
         * update geo database
         *
         * @since 1.0.0
         */
        function update_geo_database()
        {
            return true;
        }

        /*
        * check restricted by the product id for simple product
        *
        * @since 1.0.0
        */
        function is_product_restricted_by_id(){
            $restriction = get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true);
            $country_obj = new wpll_user_country();
            

            if ( 'specific' == $restriction || 'excluded' == $restriction ) {
                $countries = get_post_meta(get_the_ID(), '_restricted_countries', true);

                if ( empty($countries) || !is_array($countries)  )
                    $countries = array();

                $customer_country = $this->get_user_contry();

                if ( 'specific' == $restriction && !in_array($customer_country, $countries) )
                    return true;
                if ( 'excluded' == $restriction && in_array($customer_country, $countries))
                    return true;
            }
            return false;
        }

        function get_user_contry() {
            $geoloc = WC_Geolocation::geolocate_ip();
            return $geoloc;
        }

        /*
        * restricted check by the product id for variation
        *
        * @since 1.0.0
        */
        function is_restricted_by_variation($product){

            if ($product) {
                $id = $product->get_id();
            }

            if (($product) && ($product->get_type() == 'variation'  || $product->get_type() == 'variable-subscription' || $product->get_type() == 'subscription_variation')) {
                $parentid = $product->get_parent_id();
                $parentRestricted = $this->is_product_restricted_by_id($parentid);
                if ($parentRestricted)
                    return true;
            }
            return $this->is_product_restricted_by_id($id);
        }

        /*
        * check product is_purchasable or not
        *
        * @since 1.0.0
        */
        function is_purchasable($purchasable, $product){

            if ( $this->is_restricted_by_variation($product) || apply_filters('wpll_is_restricted', false, $product) ) {
                $purchasable = false;
            }
            return $purchasable;
        }

        /*
        * check variation product filter for restriction
        *
        * @since 1.0.0
        */
        function variation_filter($data, $product, $variation){
            if (!$data['is_purchasable']) {
                $data['variation_description'] = $this->no_soup_for_you() . $data['variation_description'];
                // if (get_option('wpcbr_hide_restricted_product_variation') == '1') {
                //     $data['variation_is_active'] = '';
                // }
            }
            return $data;
        }

        /*
        * get custom message for restricted product
        *
        * @since 1.0.0
        */
        function no_soup_for_you(){
            $msg = get_option('wpcbr_default_message', $this->default_message());
            if (empty($msg)) {
                $msg = $this->default_message();
            }
            return "<p class='wpll_restricted_country'>" . stripslashes($msg) . "</p>";
        }

        /*
        * get default_message for restricted product
        *
        * @since 1.0.0
        */
        function default_message(){
            return    apply_filters('wpll_frontend_restricted_product_message', __('Sorry, this product is not available to purchase in your country.', 'woo-product-country-base-restrictions'));
        }

    }
    new wpll_products_restriction_setting();
}