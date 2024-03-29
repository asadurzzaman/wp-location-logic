<?php
/**
 * Plugin Name:       WP Location Logic
 * Plugin URI:        https://wplocationlogic.com
 * Description:       Plugin Descriptions
 * Version:           1.0.0
 * Author:            Asad
 * Author URI:        https://wordpress.org/plugins/wp-location-logic
 * License:           GPL-2.0+
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       location-logic
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}
define( 'WP_LOCATION_LOGIC_VERSION', '1.0.0' );
defined( 'WP_LOCATION_LOGIC_PATH' ) or define( 'WP_LOCATION_LOGIC_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WP_LOCATION_LOGIC_URL' ) or define( 'WP_LOCATION_LOGIC_URL', plugin_dir_url( __FILE__ ) );
defined( 'WP_LOCATION_LOGIC_BASE_FILE' ) or define( 'WP_LOCATION_LOGIC_BASE_FILE', __FILE__ );
defined( 'WP_LOCATION_LOGIC_BASE_PATH' ) or define( 'WP_LOCATION_LOGIC_BASE_PATH', plugin_basename(__FILE__) );
defined( 'WP_LOCATION_LOGIC_IMG_DIR' ) or define( 'WP_LOCATION_LOGIC_IMG_DIR', plugin_dir_url( __FILE__ ) . 'assets/img/' );
defined( 'WP_LOCATION_LOGIC_CSS_DIR' ) or define( 'WP_LOCATION_LOGIC_CSS_DIR', plugin_dir_url( __FILE__ ) . 'assets/css/' );
defined( 'WP_LOCATION_LOGIC_JS_DIR' ) or define( 'WP_LOCATION_LOGIC_JS_DIR', plugin_dir_url( __FILE__ ) . 'assets/js/' );


require_once WP_LOCATION_LOGIC_PATH . 'includes/WPLocationLogic.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/class-wp-location-logic-admin.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/add_custom_coupon_meta_box.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/products_restriction_setting.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/wpll_user_country.php';
//require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/add_custom_product_meta_box.php';
//require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/WPll_Settings_Custom_Tab.php';
//require_once WP_LOCATION_LOGIC_PATH . 'frontend/inc/wpll_products_restriction.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/Wpll_Single_Product_Attributes.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/Wpll_Single_Product_Variation_Attributes.php';
//require_once WP_LOCATION_LOGIC_PATH . 'frontend/view/single_product_restriction.php';

function enqueue_select2_jquery() {
    wp_register_style( 'select2css', plugin_dir_url( __FILE__ ) . 'assets/css/select2.min.css', false, '1.0', 'all' );
    wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . 'assets/js/select2.min.js', array( 'jquery' ), '1.0', true );
    wp_register_script( 'all-dashboard', plugin_dir_url( __FILE__ ) . 'assets/js/all-dashboard.js', array( 'jquery','select2' ), '1.0', true );
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
    wp_enqueue_script( 'all-dashboard' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_select2_jquery' );


// add_action('woocommerce_after_add_to_cart_button', 'get_client_ip');

// function get_client_ip()
// {
//     global $post;
//     $selections = get_post_meta($post->ID, '_restricted_countries', true);

//     if (empty($selections) || !is_array($selections)) {
//         $selections = array();
//         echo $selections ;
//     }


//     $geoloc = WC_Geolocation::geolocate_ip();
//     foreach ($geoloc as $loc) {
//         echo $loc;
//     } 

// }


// function wpll_user_ip_address(){

//     $PublicIP = $_SERVER['REMOTE_ADDR'];

//     $url = "http://ipinfo.io/$PublicIP?token=9c4cc2f08f266b";
//     $curl = curl_init($url);
//     curl_setopt($curl, CURLOPT_URL, $url);
//     curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

//     $resp = curl_exec($curl);
//     $json     = json_decode($resp, true);
//     curl_close($curl);

//     $iptimezone =  $json['timezone'];
//     $ip =  $json['ip'];
//     $city =  $json['city'];
//     $region =  $json['region'];
//     $country =  $json['country'];
//     $postal =  $json['postal'];

//     if( $country == 'BD'){
//         echo "Hello Bangladesh! Now your time zone .$iptimezone.";
//     }else{
//         echo "Hello Other Country, Now your time zone .$iptimezone.";
//     }
//     echo $country;
// }
// add_action('wp_footer','wpll_user_ip_address');

