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




function wplc_woocommerce_remove_featured_image( $html, $attachment_id ) {

    global $post, $product;
//    // Get the IDs.
//    $attachment_ids = $product->get_gallery_image_ids();
//    // If there are none, go ahead and return early - with the featured image included in the gallery.
//    if ( ! $attachment_ids ) {
//        return $html;
//    }

    // Look for the featured image.
    $featured_image = get_post_thumbnail_id( $post->ID );
    // If there is one, exclude it from the gallery.
    if ( is_product() && $attachment_id === $featured_image ) {
        $html = '';
    }
    return $html;
}
add_filter( 'woocommerce_single_product_image_thumbnail_html', 'wplc_woocommerce_remove_featured_image', 10, 2 );

remove_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open');
add_action('woocommerce_before_shop_loop_item', 'woocommerce_add_aff_link_open', 10);


function woocommerce_add_aff_link_open(){
    $product = wc_get_product(get_the_ID());
    if ($product->is_type('external'))
        echo '<a href="' .
            $product->get_product_url() .
            '" class="woocommerce-LoopProductImage-link">';
}

function woocommerce_add_aff_link_close(){
    $product = wc_get_product(get_the_ID());
    if ($product->is_type('external'))
        echo '</a>';
}


