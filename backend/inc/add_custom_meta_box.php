<?php
/**
 * Adds a meta box to the Product editing screen right bar
 */
function wplc_product_custom_meta() {
    add_meta_box(
            'prfx_meta', __( 'WP Location Logic', 'prfx-textdomain' ),
            'new_wplc_product_custom_meta',
            'product',
            'side',
            ''
    );
}
add_action( 'add_meta_boxes', 'wplc_product_custom_meta' );

function new_wplc_product_custom_meta() {

    $countries_object  =   new WC_Countries();
    $countries         =   $countries_object->__get('countries');
    echo '<div class="options_group">';
    woocommerce_form_field(
        'the_country_field',
        array(
            'type'       => 'select',
            'class'      => array( 'select' ),
            'label'      => __('Select a country'),
            'placeholder'    => __('Enter something'),
            'options'    => $countries
        )
    );
    echo '</div>';

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



