<?php
global $woocommerce;
global $product;

// Add a custom field to Admin coupon settings pages
add_action( 'woocommerce_coupon_options', 'add_coupon_text_field', 10 );
if( !function_exists('add_coupon_text_field')){
    function add_coupon_text_field() {

        global $woocommerce, $post;
        echo '<div class="options_group">';
        $countries_object  =   new WC_Countries();
        $countries         =   $countries_object->__get('countries');
        $hide_coupon_country = implode('', get_post_meta($post->ID, '_hide_country_coupon'));


        woocommerce_wp_select([
            'id'       => '_hide_country_coupon',
            'label'    => __( 'Select', 'woocommerce' ),
            'selected' => true,
            'value'    => $hide_coupon_country,
            'options' => $countries,
        ]);

        echo '</div>';

    }
}

// Save the custom field value from Admin coupon settings pages
add_action( 'woocommerce_coupon_options_save', 'save_coupon_text_field', 10, 2 );
if( ! function_exists('save_coupon_text_field')){
    function save_coupon_text_field( $post_id, $coupon ) {

        if( isset( $_POST['_hide_country_coupon'] ) ) {
            $coupon->update_meta_data( '_hide_country_coupon', sanitize_text_field( $_POST['_hide_country_coupon'] ) );
            $coupon->save();
        }
    }
}




/**
 * Extra Meta Box add on Woocommerce Product Price Below
 */
add_action( 'woocommerce_product_options_general_product_data', 'wpcl_adv_product_options');
function wpcl_adv_product_options(){

    echo '<div class="options_group">';
    woocommerce_wp_radio(array(
        'options' => array(
            "gio_location" => "Calculate prices by the exchange rate",
            "manual" => " Set prices manually"
        ),
        'name' => '_price_per_word_character',
        'value' => '',
        'id' => '_price_per_word_character',
        'label' => __('Price for.....!', 'woocommerce-price-per-word'),
        'desc_tip' => 'true',
        'description' => __('Choose whether to set ', 'woocommerce-price-per-word')
    ));
    echo '</div>';

    echo '<div class="options_group">';
    $options[''] = __( 'Select a value', 'woocommerce');
    woocommerce_wp_select( array(
        'id'      => 'super_product',
        'value'   => get_post_meta( get_the_ID(), 'super_product', true ),
        'label'   => 'This is a super product',
        'options' =>  $options,
        'desc_tip' => true,
        'description' => 'If it is not a regular WooCommerce product',
    ) );
    echo '</div>';

    echo '<div class="options_group">';
    woocommerce_wp_checkbox(array(
        'id' => '_is_web_font',
        'label' => __('Web Font?', 'ss-wc-digital-details'),
        'description' => __('Enable if this file is a Web Font.', 'ss-wc-digital-details'),
        'wrapper_class' => 'hide_if_variable'
    ));
    echo '</div>';
}


//// Custom Filed Product variation
///
add_action( 'woocommerce_product_after_variable_attributes', 'variation_settings_fields', 10, 3 );
add_action( 'woocommerce_save_product_variation', 'save_variation_settings_fields', 10, 2 );
add_filter( 'woocommerce_available_variation', 'load_variation_settings_fields' );

function variation_settings_fields( $loop, $variation_data, $variation ) {
    woocommerce_wp_textarea_input(
        array(
            'id'            => "my_text_field{$loop}",
            'name'          => "my_text_field[{$loop}]",
            'value'         => get_post_meta( $variation->ID, 'my_text_field', true ),
            'label'         => __( 'WPC Text', 'woocommerce' ),
            'desc_tip'      => true,
            'description'   => __( 'Some description.', 'woocommerce' ),
            'wrapper_class' => 'form-row form-row-full',
        )
    );
}

function save_variation_settings_fields( $variation_id, $loop ) {
    $text_field = $_POST['my_text_field'][ $loop ];

    if ( ! empty( $text_field ) ) {
        update_post_meta( $variation_id, 'my_text_field', esc_attr( $text_field ));
    }
}









// Shortcode
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
        case "PK":
            $country_name = "Pakistan!";
            break;
        default:
            $country_name = "Other Country!";
    }
    echo $country_name;

}


//// Adding Meta container to admin shop_coupon pages
//add_action( 'add_meta_boxes', 'add_custom_coupon_meta_box' );
//if ( ! function_exists( 'add_custom_coupon_meta_box' ) )
//{
//    function add_custom_coupon_meta_box()
//    {
//        add_meta_box(
//            'coupon_usage_data', __('Usage data','woocommerce'),
//            'custom_coupon_meta_box_content',
//            'shop_coupon',
//            'side',
//            'core'
//        );
//    }
//}
//
//// Displaying content in the meta container on admin shop_coupon pages
//if ( ! function_exists( 'custom_coupon_meta_box_content' ) )
//{
//    function custom_coupon_meta_box_content() {
//
//
//    }
//}



