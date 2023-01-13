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
    public function get_user_contry()
    {

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

    }
    new wpll_user_country();
}