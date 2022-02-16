<?php
global $woocommerce;
global $product;

////Add new taxonomy meta box on Add Product Page
//add_action( 'add_meta_boxes', 'wplc_add_meta_box');
//function wplc_add_meta_box() {
//    add_meta_box(
//        'condition_id',
//        'Set Condition',
//        'wplc_custom_metabox',
//        'product' ,
//        'side',
//        'core'
//    );
//}
//// Call back function for Custom Meta Box
//function wplc_custom_metabox( $value ) {
//
//
//    $countries_object  =   new WC_Countries();
//    $countries         =   $countries_object->__get('countries');
//    echo '<div class="options_group">';
//    woocommerce_form_field(
//        'the_country_field',
//        array(
//            'type'       => 'select',
//            'class'      => array( 'select' ),
//            'label'      => __('Select a country'),
//            'placeholder'    => __('Enter something'),
//            'options'    => $countries
//        )
//    );
//    echo '</div>';
//
//}


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

function load_variation_settings_fields( $variation ) {
    $variation['my_text_field'] = get_post_meta( $variation[ 'variation_id' ], 'my_text_field', true );

    return $variation;
}


