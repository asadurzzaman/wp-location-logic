<?php
/**
 * WPLL Setting
 *
 * @class WPLL_Product_Restriction
 * @package WooCommerce/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
exit;
}

/**
 * WPLL_Product_Restriction class
 *
 * @since 1.0.0
 */
class WPLL_Product_Restriction{

    /**
     * Get the class instance
     *
     * @since  1.0.0
     * @return WPLL_Product_Restriction
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
	* init function
	*
	* @since 1.0.0
	*/
    function init()
    {
        //callback on activate plugin
        register_activation_hook(__FILE__, array($this, 'on_activation'));
        add_filter('woocommerce_maxmind_geolocation_update_database_periodically', array($this, 'update_customer_geo_database'), 10, 1);



        add_action('woocommerce_after_add_to_cart_button', array($this, 'is_restricted_by_id'));
        
    }


    /**
     * WC_Geolocation database update hooks
     *
     * @since 1.0.0
     */
    function on_activation()
    {
        WC_Geolocation::update_local_database();
    }

    /**
     * update geo database
     *
     * @since 1.0.0
     */
    function update_customer_geo_database()
    {
        return true;
    }

    /*
	* check restricted by the product id for simple product
	*
	* @since 1.0.0
	*/
    function is_restricted_by_id()
    {
        $restriction = get_post_meta(get_the_ID(), '_wpll_country_restriction_type_role', true);

        if (
            'specific' == $restriction || 'excluded' == $restriction
        ) {
            $countries = get_post_meta(get_the_ID(), '_restricted_countries', true);
            
            if (
                empty($countries) || !is_array($countries)
            )
            $countries = array();

            $customer_country = $this->get_user_contry();
            
            if (
                'specific' == $restriction && !in_array($customer_country, $countries)
            )
            return true;

            if (
                'excluded' == $restriction && in_array($customer_country, $countries)
            )
            return true;
        }

        return false;
    }

	/*
	* get_user_contry
	*
	* @since 1.0.0
	*/
    function get_user_contry(){

        $PublicIP = $_SERVER['REMOTE_ADDR'];

        $url = "http://ipinfo.io/$PublicIP?token=9c4cc2f08f266b";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $resp = curl_exec($curl);
        $json     = json_decode($resp, true);
        curl_close($curl);
        //$country =  $json['country'];


        return true;

    }

    /*
	* check restricted by the product id for variation
	*
	* @since 1.0.0
	*/
    function is_restricted($product)
    {

        if ($product) {
            $id = $product->get_id();
        }

        if (($product) && ($product->get_type() == 'variation'  || $product->get_type() == 'variable-subscription' || $product->get_type() == 'subscription_variation')) {
            $parentid = $product->get_parent_id();
            $parentRestricted = $this->is_restricted_by_id($parentid);
            if ($parentRestricted)
            return true;
        }
        return $this->is_restricted_by_id($id);
    }

    /*
	* check product is_purchasable or not
	*
	* @since 1.0.0
	*/
    function is_purchasable($purchasable, $product)
    {

        if (
            $this->is_restricted($product) || apply_filters('cbr_is_restricted', false, $product)
        ) {
            $purchasable = false;
        }

        return $purchasable;
    }

    /*
	* check variation product filter for restriction
	*
	* @since 1.0.0
	*/
    function variation_filter($data, $product, $variation)
    {
        if (!$data['is_purchasable']) {
            $data['variation_description'] = $this->no_soup_for_you() . $data['variation_description'];
            if (get_option('wpcbr_hide_restricted_product_variation') == '1') {
                $data['variation_is_active'] = '';
            }
        }
        return $data;
    }

    /*
	* get custom message for restricted product
	*
	* @since 1.0.0
	*/
    function no_soup_for_you()
    {
        $msg = get_option('wpcbr_default_message', $this->default_message());
        if (empty($msg)) {
            $msg = $this->default_message();
        }
        return "<p class='restricted_country'>" . stripslashes($msg) . "</p>";
    }

    /*
	* get default_message for restricted product
	*
	* @since 1.0.0
	*/
    function default_message()
    {

        return    apply_filters('cbr_restricted_product_message', __('Sorry, this product is not available to purchase in your country.', 'woo-product-country-base-restrictions'));
    }

}


new WPLL_Product_Restriction();