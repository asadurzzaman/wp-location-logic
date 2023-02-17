<?php
/**
 * WPLL Product Restrictions
 *
 * @class wpll_products_restriction_setting
 * @package WooCommerce/Classes
 */

if (!defined('ABSPATH')) {
    exit;
}
global $woocommerce;
global $product;
if( !class_exists('wpll_products_restriction_setting')){
    class wpll_products_restriction_setting{
        var $wpll_user_country = "";
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
                register_activation_hook(__FILE__, array($this, 'on_activation'));

                if($this->is_valid_woocommerce_version()){ 
                add_action('admin_notices', array($this, 'woocommerce_version_notice'));
                add_action('woocommerce_after_add_to_cart_button', array($this, 'is_restricted_product_by_id'));
                add_filter('woocommerce_is_purchasable', array($this, 'is_purchasable'), 10, 2);
                add_filter('woocommerce_available_variation', array($this, 'variation_filter'), 10, 3);
                add_action('woocommerce_product_meta_start', array($this, 'wpll_meta_area_message'));
                add_filter('woocommerce_maxmind_geolocation_update_database_periodically', array($this, 'update_geo_database'), 10, 1);
                } 
        }
        
        /**
         * valid woocommerce version
         */
        function is_valid_woocommerce_version()
        {
            if (version_compare(WC_VERSION, '3.0.0', '>=')) {
                return true;
            }
            return false;
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

        /**
         * Product restriction for id
         * @since 1.0.0
         */
        function is_restricted_product_by_id($product_id)
        {
            $restriction =  get_post_meta($product_id, '_wpll_country_restriction_type_role', true);
            if ('specific' == $restriction || 'excluded' == $restriction) { 
                $countries = get_post_meta($product_id, '_wpll_restricted_countries', true);
                if (empty($countries) || !is_array($countries)){
                    $countries = array();
                } 

                $user_country = $this->get_user_country(); 

                if ('specific' == $restriction && !in_array($user_country, $countries)) {
                    return true;
                }  else if ('excluded' == $restriction && in_array($user_country, $countries)) {
                    return true;
                } 
            }

            return false;
        }

        /**
         * Product restriction
         * @since 1.0.0
         */
        function is_restricted($product_id)
        {
            $product = wc_get_product($product_id);
            if (is_numeric($product)) {
                $product_id = $product;
            } else {
                $product_id = $product->get_id();
            }
        
            if ($this->is_restricted_product_by_id($product_id)) {
                return true;
            } 
            if (($product) && ($product->get_type() == 'variation'  || $product->get_type() == 'variable-subscription' || $product->get_type() == 'subscription_variation')) {
                $variations[] = $product->get_parent_id();  
                foreach ($variations as $variation) {
                    if ($this->is_restricted_product_by_id($variation['variation_id'])) {
                        return true;
                    }
                }
            } 
            return false; 
        }
        
        /**
         * Check if product is purchasable
         * @since 1.0.0
         */
        function is_purchasable($purchasable, $product)
        { 
            if ($this->is_restricted($product)) {
                $purchasable = false;
            }
            return $purchasable;
         
        }
        /**
        * variation filter
        * @since 1.0.0
        */
        function variation_filter($data, $product, $variation)
        {  
            if ($this->is_restricted($variation)) {
                $data['is_purchasable'] = false;
                $data['price_html'] = $this->no_soup_for_you();
            }
            return $data;
        }

        /**
         * get user country
         * @since 1.0.0
         */
        function wpll_meta_area_message()
        { 
            if ($this->is_restricted(get_the_ID())) {
                echo $this->no_soup_for_you();
            } 
        }

        /**
         * default message
         * @since 1.0.0
         */
        function wpll_default_message()
        { 
            $message = _e('This product is not available in your country.', 'location-logic');
            return $message;
        }

        /**
         * no soup for you
         * @since 1.0.0
         */
        function no_soup_for_you()
        { 
            $message = $this->wpll_default_message();
            $message = apply_filters('wpll_no_soup_for_you', $message);
            return "<div class='woocommerce-variation-add-to-cart variations_button'><p class='wpll-no-soup-for-you stock out-of-stock'>" . $message . '</p></div>';
        }
 
        /*
        * get get_user_country for restricted product
        *
        * @since 1.0.0
        */
        function get_user_country()
        { 
            $user_country = WC_Geolocation::geolocate_ip();
            if (empty($user_country['country'])) {
                $user_country = WC()->customer->get_billing_country();
            } else {
                $user_country = $user_country['country'];
            }
            return $user_country;
        }
        /**
         * admin notice for woocommerce version
         * @since 1.0.0
         */ 
        function woocommerce_version_notice()
        { 
            $class = 'notice notice-error';
            $message = _e('WooCommerce Product Country Restrictions requires WooCommerce 3.0.0 or higher.', 'location-logic');

            printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
        } 
    }
    new wpll_products_restriction_setting();
    
}