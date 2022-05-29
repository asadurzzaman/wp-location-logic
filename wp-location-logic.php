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
//require_once WP_LOCATION_LOGIC_PATH . 'backend/templates/views/class-twinkle-smtp-ajax.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/class-wp-location-logic-admin.php';
//require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/add_custom_coupon_meta_box.php';
//require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/add_custom_product_meta_box.php';
//require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/WPll_Settings_Custom_Tab.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/Wpll_Single_Product_Attributes.php';
require_once WP_LOCATION_LOGIC_PATH . 'backend/inc/Wpll_Single_Product_Variation_Attributes.php';

function enqueue_select2_jquery() {
    wp_register_style( 'select2css', plugin_dir_url( __FILE__ ) . 'assets/css/select2.min.css', false, '1.0', 'all' );
    wp_register_script( 'select2', plugin_dir_url( __FILE__ ) . 'assets/js/select2.min.js', array( 'jquery' ), '1.0', true );
    wp_register_script( 'all-dashboard', plugin_dir_url( __FILE__ ) . 'assets/js/all-dashboard.js', array( 'jquery','select2' ), '1.0', true );
    wp_enqueue_style( 'select2css' );
    wp_enqueue_script( 'select2' );
    wp_enqueue_script( 'all-dashboard' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_select2_jquery' );


