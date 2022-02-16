<?php
/**
 * Plugin Name:       WP Location Logic
 * Plugin URI:        https://wplocationlogic.com
 * Description:
 * Version:           0.0.1
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
define( 'WP_LOCATION_LOGIC_VERSION', '0.0.1' );
defined( 'WP_LOCATION_LOGIC_PATH' ) or define( 'WP_LOCATION_LOGIC_PATH', plugin_dir_path( __FILE__ ) );
defined( 'WP_LOCATION_LOGIC_URL' ) or define( 'WP_LOCATION_LOGIC_URL', plugin_dir_url( __FILE__ ) );
defined( 'WP_LOCATION_LOGIC_BASE_FILE' ) or define( 'WP_LOCATION_LOGIC_BASE_FILE', __FILE__ );
defined( 'WP_LOCATION_LOGIC_BASE_PATH' ) or define( 'WP_LOCATION_LOGIC_BASE_PATH', plugin_basename(__FILE__) );
defined( 'WP_LOCATION_LOGIC_IMG_DIR' ) or define( 'WP_LOCATION_LOGIC_IMG_DIR', plugin_dir_url( __FILE__ ) . 'assets/img/' );
defined( 'WP_LOCATION_LOGIC_CSS_DIR' ) or define( 'WP_LOCATION_LOGIC_CSS_DIR', plugin_dir_url( __FILE__ ) . 'assets/css/' );
defined( 'WP_LOCATION_LOGIC_JS_DIR' ) or define( 'WP_LOCATION_LOGIC_JS_DIR', plugin_dir_url( __FILE__ ) . 'assets/js/' );


require_once WP_LOCATION_LOGIC_PATH . 'includes/WPLocationLogic.php';
//require_once WP_LOCATION_LOGIC_PATH . 'backend/class-twinkle-smtp-ajax.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/class-wp-location-logic-admin.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/woocommerce_setting.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/add_custom_meta_box.php';



add_shortcode('logic_help', 'my_logic_function');
function my_logic_function(){

    $geoloc = WC_Geolocation::geolocate_ip();
    $country_name = $geoloc['country'];

    
    switch ($country_name) {
        case "BD":
            $country_name = "Bangladesh!";
            break;
        case "CA":
            $country_name = "Canada!";
            break;
        case "BR":
            $country_name = "Brazil!";
            break;
        case "IN":
            $country_name = "India!";
            break;
        case "NL":
            $country_name = "Netherlands!";
            break;
        case "US":
            $country_name = "United States!";
            break;
        default:
            $country_name = "Other Country!";
    }
    echo $country_name;


}


//
//// Geolocation must be enabled @ Woo Settings
//function wpcl_use_geolocated_user_country(){
//
//    $location = WC_Geolocation::geolocate_ip();
//    $country = $location['country'];
//    $state = $location['state'];
//    $city = $location['city'];
//    $postcode = $location['postcode'];
//
//    echo '<prev>';
//    var_dump($location);
//    echo '</prev>';
//// Lets use the country to e.g. echo greetings
//
//    switch ($country) {
//        case "BD":
//            $hello = "Hello Bangladesh!";
//            break;
//        case "IN":
//            $hello = "Namaste Indea!";
//            break;
//        default:
//            $hello = "Hello!";
//    }
//    echo $hello;
//}
//
//add_action( 'init', 'wpcl_use_geolocated_user_country' );
//
//
///**
// * @snippet       Hide Product Based on IP Address
// * @how-to        Get CustomizeWoo.com FREE
// * @author        Rodolfo Melogli
// * @compatible    WooCommerce 4.0
// * @donate $9     https://businessbloomer.com/bloomer-armada/
// */
//
//add_filter( 'woocommerce_product_is_visible', 'bbloomer_hide_product_if_country', 9999, 2 );
//
//function bbloomer_hide_product_if_country( $visible, $product_id ){
//    $location = WC_Geolocation::geolocate_ip();
//    $country = $location['country'];
//    if ( $country === "IT" && $product_id === 344 ) {
//        $visible = false;
//    }
//    return $visible;
//}
//
///**
// * @snippet       Hide Product Based on IP Address
// * @how-to        Get CustomizeWoo.com FREE
// * @author        Rodolfo Melogli
// * @compatible    WooCommerce 4.0
// * @donate $9     https://businessbloomer.com/bloomer-armada/
// */
//
//add_action( 'woocommerce_product_query', 'bbloomer_hide_product_if_country_new', 9999, 2 );
//
//function bbloomer_hide_product_if_country_new( $q, $query ) {
//    if ( is_admin() ) return;
//    $location = WC_Geolocation::geolocate_ip();
//    $hide_products = array( 21, 32 );
//    $country = $location['country'];
//    if ( $country === "US" ) {
//        $q->set( 'post__not_in', $hide_products );
//    }
//}


